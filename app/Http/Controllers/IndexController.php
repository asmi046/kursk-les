<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('test') && in_array($request->input('test'), ['0', '1'], true)) {
            Cookie::queue('testmode', $request->input('test'), 60 * 24 * 30);
        }

        $testmode = $request->cookie('testmode');

        if ($testmode === '1') {
            return view('index');
        }

        return view('index_z');
    }
}
