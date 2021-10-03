<?php

namespace App\Http\Controllers\DocumentOperation;

use App\Http\Controllers\Controller;
use App\Models\DocumentOperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RemoveController extends Controller
{
    public function __invoke(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['status' => 'KO']);
        }

        /** @var DocumentOperation $document */
        $document = DocumentOperation::find($request->input('id'));

        try {
            Storage::disk('documentoperation')->delete($document->filename);
        } catch(\Exception $e) {
            return response()->json(['message' => "Erreur lors de la suppression du fichier : " . $e->getMessage()], 500);
        }

        try {
            $document->delete();
        } catch(\Exception $e) {
            return response()->json(['message' => "Erreur lors de la suppression du document : " . $e->getMessage()], 500);
        }

        return response()->json(['status' => 'OK ']);

    }
}
