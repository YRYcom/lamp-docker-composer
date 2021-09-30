<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use App\Models\Categorie;

class CreateController extends Controller
{
    public function __invoke(){
        return view('app.operation.create', [
            'categories' => Categorie::all()
        ]);
    }
}
