<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use App\Models\CompteBancaire;
use App\Models\DocumentOperation;
use App\Models\Operation;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ListController extends Controller
{
    public function __invoke(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['status' => 'KO']);
        }

        $compteBancaire = auth()->user()->compteBancaires->where('id', $request->input('compte_bancaire_id'))->first();
        if(!($compteBancaire instanceof CompteBancaire)){
            return redirect(RouteServiceProvider::HOME);
        }

        $requestOperation = Operation::where('compte_bancaire_id', $request->input('compte_bancaire_id'));

        switch($request->input('pointee','tous')) {
            case 'oui':
                $requestOperation->where('pointe',1);
                break;
            case 'non':
                $requestOperation->where('pointe',0);
                break;
        }

        switch($request->input('avec_piece','tous')) {
            case 'oui':
                $requestOperation->whereIn('id', function($query){
                    $query->select('operation_id')
                        ->from(with(new DocumentOperation())->getTable());
                });
                break;
            case 'non':
                $requestOperation->whereNotIn('id', function($query){
                    $query->select('operation_id')
                        ->from(with(new DocumentOperation())->getTable());
                });
                break;
        }

        return Datatables::of($requestOperation->latest()->get())
            ->rawColumns(['action'])
            ->make(true);

    }
}
