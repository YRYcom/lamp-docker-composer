<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Operation;
use Illuminate\Http\Request;

class EditController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('app.operation.edit')
            ->with(Operation::find($request->input('id'))->toArray())
            ->with(['categories' => Categorie::all()]);
    }
}
