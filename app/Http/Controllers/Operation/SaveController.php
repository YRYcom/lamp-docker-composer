<?php

namespace App\Http\Controllers\Operation;

use App\Models\CompteBancaire;
use App\Models\DocumentOperation;
use App\Models\Operation;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SaveController
{
    public function __invoke(Request $request)
    {
        $compteBancaire = auth()->user()->compteBancaires->where('id', $request->input('compte_bancaire_id'))->first();
        if(!($compteBancaire instanceof CompteBancaire)){
            return redirect(RouteServiceProvider::HOME);
        }

        $validator = Validator::make($request->all(), [
            'categorie_id' => 'bail|required|min:1',
            'designation' => 'bail|required'
        ]);

        if ($validator->fails()) {
            Session::flash('DangerAlert','Merci de corriger les erreurs dans le formulaire');
            return back()->withErrors($validator)->withInput();
        }

        try {
            $operation = new Operation($request->all());
            $operation->save();
        } catch(\Exception $e) {
            Session::flash('DangerAlert','Une erreur inconnue s\'est produite : '.$e->getMessage());
            return back()->withInput();
        }

        $ids = json_decode($request->input('documentoperations_id'));
        if (!is_array($ids)){
            $ids = [];
        }
        DocumentOperation::whereIn('id', $ids)->update(['operation_id' => $operation->id]);


        Session::flash('SuccessAlert','L\'opération a été correctement créée');
        return redirect()->route('operation', ['compte_bancaire_id' => $compteBancaire->id]);

    }
}
