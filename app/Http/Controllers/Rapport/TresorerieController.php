<?php

namespace App\Http\Controllers\Rapport;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\RubriqueTreso;

class TresorerieController extends Controller
{
    public function __invoke()
    {
        return view('app.rapport.tresorerie', [
            'recettes' => RubriqueTreso::isRecetteType()->get(),
            'depenses' => RubriqueTreso::isDepenseType()->get(),
            'annee' => date('Y')
        ]);
    }
}

