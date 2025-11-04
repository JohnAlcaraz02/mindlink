<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function index()
    {
        return view('resources.index');
    }

    public function show($id)
    {
        return view('resources.show');
    }
}