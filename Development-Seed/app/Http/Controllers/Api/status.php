<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class status extends Controller
{
    public function index()
    {
        return response()->json(['status' => 'API is running']);
    }

    
}
