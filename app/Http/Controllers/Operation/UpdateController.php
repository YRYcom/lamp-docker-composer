<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use App\Models\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UpdateController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categorie_id' => 'bail|required|min:1',
            'designation' => 'bail|required'
        ]);

        if ($validator->fails()) {
            Session::flash('DangerAlert','Merci de corriger les erreurs dans le formulaire');
            return back()->withErrors($validator)->withInput();
        }

        try {
            $operation = Operation::find($request->input('id'))->update($request->all());
        } catch(\Exception $e) {
            Session::flash('DangerAlert','Une erreur inconnue s\'est produite : '.$e->getMessage());
            return back()->withInput();
        }

        Session::flash('SuccessAlert','L\'opération a été correctement modifiée');
        return redirect()->route('operation');
    }
}
