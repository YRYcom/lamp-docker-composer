<?php

namespace App\Http\Controllers\Rapport;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\CompteBancaire;
use App\Models\RubriqueTreso;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class TresorerieController extends Controller
{
    public function __invoke(Request $request)
    {
        $compteBancaireId = $request->input('compte_bancaire_id');

        $compteBancaire = auth()->user()->compteBancaires->where('id', $compteBancaireId)->first();
        if(!($compteBancaire instanceof CompteBancaire)){
            return redirect(RouteServiceProvider::HOME);
        }

        return view('app.rapport.tresorerie', [
            'compteBancaire' => $compteBancaire,
            'recettes' => RubriqueTreso::where('compte_bancaire_id', $compteBancaireId)->isRecetteType()->get(),
            'depenses' => RubriqueTreso::where('compte_bancaire_id', $compteBancaireId)->isDepenseType()->get(),
            'annee' => $request->input('annee', date('Y'))
        ]);
    }
}

