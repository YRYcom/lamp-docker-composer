<?php

namespace App\Http\Controllers\DocumentOperation;

use App\Http\Controllers\Controller;
use App\Models\CompteBancaire;
use App\Models\DocumentOperation;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function __invoke(Request $request)
    {

        /** @var DocumentOperation $document */
        $document = DocumentOperation::find($request->input('id'));

        $compteBancaire = auth()->user()->compteBancaires->where('id', $document->operation->compte_bancaire_id)->first();
        if(!($compteBancaire instanceof CompteBancaire)){
            return redirect(RouteServiceProvider::HOME);
        }

        return response()->download(Storage::disk('documentoperation')->path($document->filename,), $document->original_filename);

    }

}
