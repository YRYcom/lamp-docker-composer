<?php

namespace App\Http\Controllers\OperationExport;

use App\Http\Controllers\Controller;
use App\Models\CompteBancaire;
use App\Models\DocumentOperation;
use App\Models\Operation;
use App\Models\OperationExport;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class CreateController extends Controller
{
    public function __invoke(Request $request)
    {
        $compteBancaire = auth()->user()->compteBancaires->where('id', $request->input('compte_bancaire_id'))->first();
        if(!($compteBancaire instanceof CompteBancaire)){
            return redirect(RouteServiceProvider::HOME);
        }

        $export = new OperationExport(
            [
                'designation' => 'Export éxécuté le '. date('H/i/s d/m/Y'),
                'created_by' => auth()->user()->id,
            ]
        );
        $export->save();

        $affected = Operation::where('pointe',1)->whereNull('operation_export_id')->update(['operation_export_id' => $export->id]);

        $documents = DocumentOperation::whereIn('operation_id', function($query) use ($export) {
            $query->select('id')
                ->from(with(new Operation())->getTable())
                ->where('operation_export_id', $export->id);
        })->get();

        $export->update(['nombre_operation' => $affected, 'nombre_fichier' => $documents->count()]);

        $zip = new ZipArchive();
        $tempFilename = uniqid().'.zip';
        $zip->open(Storage::disk('tmp')->path('').$tempFilename, ZipArchive::CREATE);
        foreach ($documents as $document){
            $zip->addFile(Storage::disk('documentoperation')->path($document->filename), $document->original_filename);
        }
        $zip->close();


        Storage::disk('operationexport')->put($export->id.'.zip', Storage::disk('tmp')->get($tempFilename));

        return redirect()->route('operation' , ['compte_bancaire_id' => $compteBancaire->id]);

    }
}
