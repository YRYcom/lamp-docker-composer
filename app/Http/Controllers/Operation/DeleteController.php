<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use App\Models\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DeleteController extends Controller
{
    public function __invoke(Request $request)
    {
        try{
            $operation = Operation::find($request->input('id'));
            $operation->delete();
        } catch(\Exception $e) {
            Session::flash('DangerAlert','Une erreur inconnue s\'est produite : '.$e->getMessage());
            return redirect()->route('operation');
        }

        Session::flash('SuccessAlert','L\'opération a été correctement supprimée');
        return redirect()->route('operation');
    }
}
