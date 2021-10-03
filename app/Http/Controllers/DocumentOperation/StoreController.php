<?php

namespace App\Http\Controllers\DocumentOperation;

use App\Http\Controllers\Controller;
use App\Models\DocumentOperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    public function __invoke(Request $request)
    {
        if(!$request->hasFile('file')) {
            return response()->json(['message' => "Il n'y a pas de fichier"], 500);
        }

        $extension = $request->file('file')->getClientOriginalExtension();
        if(!in_array(strtolower($extension), ["jpeg","jpg","png","pdf", "xls", "xlsx"])){
            return response()->json(['message' => "L'extension du fichier n'est pas reconnue"], 500);
        }

        $fileName = $request->file('file')->getClientOriginalName().time() .'.' . $extension;

        try {
            $documentOperation = new DocumentOperation([
                'original_filename' => $request->file('file')->getClientOriginalName(),
                'filename' => $fileName,
            ]);
            $documentOperation->save();
        } catch(\Exception $e) {
            return response()->json(['message' => "Erreur lors de la création du document : " . $e->getMessage()], 500);
        }
        Storage::disk('documentoperation')->put($fileName, $request->file('file')->getContent());


        return response()->json(['id' => $documentOperation->id]);

    }
}
