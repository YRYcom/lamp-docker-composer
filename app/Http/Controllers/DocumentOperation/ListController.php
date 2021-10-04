<?php

namespace App\Http\Controllers\DocumentOperation;

use App\Models\CompteBancaire;
use App\Models\DocumentOperation;
use App\Models\Operation;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ListController
{
    public function __invoke(Request $request)
    {
        /** @var Operation $operation */
        $operation = Operation::find($request->input('operation_id'));

        $compteBancaire = auth()->user()->compteBancaires->where('id', $operation->compteBancaire->id)->first();
        if (!($compteBancaire instanceof CompteBancaire)) {
            return redirect(RouteServiceProvider::HOME);
        }

        $json = [];
        foreach ($operation->documents as $document) {
            $object = [];
            $object['id'] = $document->id;
            $object['name'] = $document->original_filename;
            $object['size'] = Storage::disk('documentoperation')->size($document->filename);
            $object['path'] = route('documentoperation.telecharger', ['id' => $document->id]);
            $json[] = $object;
        }
        return response()->json($json);

    }
}
