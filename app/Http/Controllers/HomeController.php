<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    function index(Request $request){
        $data = [
            'email' => ''
        ];
        return view('welcome', compact('data'));
    }
}
