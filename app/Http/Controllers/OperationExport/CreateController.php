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
use Spatie\SimpleExcel\SimpleExcelWriter;

class CreateController extends Controller
{
    public function __invoke(Request $request)
    {
        $compteBancaire = auth()->user()->compteBancaires->where('id', $request->input('compte_bancaire_id'))->first();
        if (!($compteBancaire instanceof CompteBancaire)) {
            return redirect(RouteServiceProvider::HOME);
        }
        try {
            $export = new OperationExport(
                [
                    'designation' => 'Export éxécuté le ' . date('H/i/s d/m/Y'),
                    'compte_bancaire_id' => $request->input('compte_bancaire_id'),
                    'created_by' => auth()->user()->id,
                ]
            );
            $export->save();
        } catch (\Exception $e) {
            return response()->jsonError('Erreur inconnue lors de la création de l\'export');
        }

        try {
            $affected = Operation::where('pointe', 1)->whereNull('operation_export_id')->update(['operation_export_id' => $export->id]);
            $documentsCount = 0;

            if($affected === 0){
                $export->delete();
                return response()->jsonError("Il n'y a pas d'opération à exporter");
            }

            $tempZipFilename = uniqid() . '.zip';
            $tempCsvFilename = uniqid() . '.csv';

            $zip = new ZipArchive();
            $zip->open(Storage::disk('tmp')->path('') . $tempZipFilename, ZipArchive::CREATE);
            $listing = SimpleExcelWriter::create(Storage::disk('tmp')->path('') . $tempCsvFilename);

            /** @var Operation $operation */
            foreach (Operation::where('operation_export_id', $export->id)->get() as $operation) {
                $originalFilenames = [];
                foreach ($operation->documents as $document) {
                    $zip->addFile(Storage::disk('documentoperation')->path($document->filename), $document->original_filename);
                    $documentsCount++;
                    $originalFilenames[] = $document->original_filename;
                }
                $listing->addRow([
                    'id' => $operation->id,
                    'date_realisation' => $operation->date_realisation,
                    'designation' => $operation->designation,
                    'debit' => $operation->debit,
                    'credit' => $operation->credit,
                    'jusitificatif' => count($originalFilenames) == 0 ? 'Aucune' : count($originalFilenames) . ' : '.implode(',', $originalFilenames)
                ]);
            }

            $zip->addFile(Storage::disk('tmp')->path($tempCsvFilename), 'detail_operation.csv');
            $zip->close();
            Storage::disk('operationexport')->put($export->id . '.zip', Storage::disk('tmp')->get($tempZipFilename));

            $export->update(['nombre_operation' => $affected, 'nombre_fichier' => $documentsCount]);

            Storage::disk('tmp')->delete($tempCsvFilename);
            Storage::disk('tmp')->delete($tempZipFilename);
        } catch (\Exception $e) {
            $export->delete();
            return response()->jsonError('Erreur inconnue lors de la création de l\'export');
        }

        return response()->jsonSuccess("L'export a été correctement généré, le téléchargement va débuter",['id'=>$export->id]);

    }
}
