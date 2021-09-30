<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use App\Models\Operation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ListController extends Controller
{
    public function __invoke(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['status' => 'KO']);
        }

        return Datatables::of(Operation::latest()->get())
            ->rawColumns(['action'])
            ->make(true);

    }
}
