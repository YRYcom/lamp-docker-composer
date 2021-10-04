<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\CompteBancaire;
use App\Models\Operation;
use App\Models\OperationExport;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class EditController extends Controller
{
    public function __invoke(Request $request)
    {
        /** @var Operation $operation */
        $operation = Operation::find($request->input('id'));

        $compteBancaire = auth()->user()->compteBancaires->where('id', $operation->compteBancaire->id)->first();
        if (!($compteBancaire instanceof CompteBancaire)) {
            return redirect(RouteServiceProvider::HOME);
        }

        $ids = [];
        foreach ($operation->documents as $document){
            $ids[] = $document->id;
        }

        return view('app.operation.edit')
            ->with($operation->toArray())
            ->with(['categories' => Categorie::all(), 'ids' => $ids]);
    }
}
