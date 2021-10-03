<?php

namespace App\Http\Controllers\Operation;


use App\Http\Controllers\Controller;
use App\Models\CompteBancaire;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $compteBancaire = auth()->user()->compteBancaires->where('id', $request->input('compte_bancaire_id'))->first();
        if(!($compteBancaire instanceof CompteBancaire)){
            return redirect(RouteServiceProvider::HOME);
        }

        return view('app.operation.list', ['compteBancaire' => $compteBancaire]);
    }
}
