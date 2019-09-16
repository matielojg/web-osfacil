<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

class DashboardController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    public function home()
    {

        $employee = User::where('function','=', 'funcionario')->count();
        $technician = User::where('function','=', 'tecnico')->count();
        $supervisor = User::where('function','=', 'supervisor')->count();
        $manager = User::where('function','=', 'gerente')->count();

        $userFunction = auth()->user()->function;

        //$json['message'] = $this->message->success('Seja Bem-Vindo!')->render();

        if($userFunction == 'funcionario'){
            return view('admin.dashboard.dashboardEmployee');
        }elseif ($userFunction == 'tecnico'){
            return view('admin.dashboard.dashboardTechnician');
        }else{
            return view('admin.dashboard', [
                'employee' => $employee,
                'technician' => $technician,
                'supervisor' => $supervisor,
                'manager' => $manager
            ]);
        }

    }
}
