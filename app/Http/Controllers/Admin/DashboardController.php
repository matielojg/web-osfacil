<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    public function home()
    {
        return view('admin.dashboard');
    }
}
