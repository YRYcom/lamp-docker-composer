<?php

namespace App\Http\Controllers\DocumentOperation;

use App\Models\DocumentOperation;
use App\Models\Operation;
use Illuminate\Http\Request;

class ListController
{
    public function __invoke(Request $request)
    {
        $json = [];
        foreach (Operation::find($request->input('operation_id'))->documentoperation as $document) {
            $object = [];
            $object['name'] = $file;
            $file_path = public_path('uploads/gallery/').$file;
            $object['size'] = filesize($file_path);
            $object['path'] = url('public/uploads/gallery/'.$file);
            $json[] = $object;
        }
        return response()->json($json);

        $images = Gallery::all()->toArray();
        foreach($images as $image){
            $tableImages[] = $image['filename'];
        }
        $storeFolder = public_path('uploads/gallery');
        $file_path = public_path('uploads/gallery/');
        $files = scandir($storeFolder);
        foreach ( $files as $file ) {
            if ($file !='.' && $file !='..' && in_array($file,$tableImages)) {
                $obj['name'] = $file;
                $file_path = public_path('uploads/gallery/').$file;
                $obj['size'] = filesize($file_path);
                $obj['path'] = url('public/uploads/gallery/'.$file);
                $data[] = $obj;
            }

        }
        return response()->json($data);
    }
}
