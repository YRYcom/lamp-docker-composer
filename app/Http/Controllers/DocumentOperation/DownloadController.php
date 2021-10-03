<?php

namespace App\Http\Controllers\DocumentOperation;

use App\Http\Controllers\Controller;
use App\Models\DocumentOperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function __invoke(Request $request)
    {

        /** @var DocumentOperation $document */
        $document = DocumentOperation::find($request->input('id'));

        return Storage::disk('documentoperation')->download($document->filename, $document->original_filename);

    }

}
