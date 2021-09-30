<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke()
    {
        return view('app.operation.list');
    }
}
