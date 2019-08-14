<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.index');

    }

    public function home()
    {
        return view('admin.dashboard');
    }

    public function login(Request $request)
    {
        var_dump($request->all());
    }
}
