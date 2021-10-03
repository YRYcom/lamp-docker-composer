<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use App\Models\CompteBancaire;
use App\Models\Operation;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DeleteController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            /** @var Operation $operation */
            $operation = Operation::find($request->input('id'));

            $compteBancaire = auth()->user()->compteBancaires->where('id', $operation->compteBancaire->id)->first();
            if (!($compteBancaire instanceof CompteBancaire)) {
                return redirect(RouteServiceProvider::HOME);
            }

            $operation->delete();
        } catch (\Exception $e) {
            Session::flash('DangerAlert', 'Une erreur inconnue s\'est produite : ' . $e->getMessage());
            return redirect()->route('operation', ['compte_bancaire_id' => $compteBancaire->id]);
        }

        Session::flash('SuccessAlert', 'L\'opération a été correctement supprimée');
        return redirect()->route('operation', ['compte_bancaire_id' => $compteBancaire->id]);
    }
}
