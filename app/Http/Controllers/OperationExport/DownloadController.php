<?php

namespace App\Http\Controllers\OperationExport;

use App\Http\Controllers\Controller;
use App\Models\CompteBancaire;
use App\Models\OperationExport;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function __invoke(Request $request)
    {
        /** @var OperationExport $export */
        $export = OperationExport::find($request->input('id'));
        $compteBancaire = auth()->user()->compteBancaires->where('id', $export->compte_bancaire_id)->first();
        if (!($compteBancaire instanceof CompteBancaire)) {
            return redirect(RouteServiceProvider::HOME);
        }

        return response()->download(Storage::disk('operationexport')->path($export->id . '.zip'));
    }
}
