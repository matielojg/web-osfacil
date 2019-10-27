<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function home()

    {
        //Users
        $employee = User::where('function', '=', 'funcionario')->count();
        $technician = User::where('function', '=', 'tecnico')->count();
        $supervisor = User::where('function', '=', 'supervisor')->count();
        $manager = User::where('function', '=', 'gerente')->count();

        //Orders
        $orderOpen = Order::where('status', '=', 'aberto')->count();
        $orderAssign = Order::where('status', '=', 'atribuido')->count();
        $orderPending = Order::where('status', '=', 'pendente')->count();
        $orderInExecution = Order::where('status', '=', 'em execucao')->count();
        $orderExecution = Order::where('status', '=', 'executado')->count();

        //Priority
        $orderCritical = Order::where('priority', '=', 'critica')->count();
        $orderHigh = Order::where('priority', '=', 'alta')->count();
        $orderMedium = Order::where('priority', '=', 'media')->count();
        $orderLow = Order::where('priority', '=', 'baixa')->count();


//        $ordersSupervisor = DB::table('orders')
//            ->join('users', 'orders.requester', '=', 'users.id')
//            ->join('sectors', 'orders.sector_provider', '=', 'sectors.id')
//            ->join('services', 'orders.service', '=', 'services.id')
//            ->select('orders.*', 'services.name_service', 'sectors.name_sector', 'users.first_name',
//                'users.last_name')
//            ->orderBy('priority', 'desc')
//            ->orderBy('created_at', 'asc')
//            ->get();
//
//        $ordersTechnical = DB::table('orders')
//            ->join('users', 'orders.requester', '=', 'users.id')
//            ->join('sectors', 'orders.sector_provider', '=', 'sectors.id')
//            ->join('services', 'orders.service', '=', 'services.id')
//            ->select('orders.*', 'services.name_service', 'sectors.name_sector', 'users.first_name',
//                'users.last_name')
//            ->orderBy('priority', 'desc')
//            ->orderBy('created_at', 'asc')
//            ->where('orders.responsible', '=', auth()->user()->id)  //view técnico
//            ->get();
//
//        $ordersEmployee = DB::table('orders')
//            ->join('users', 'orders.requester', '=', 'users.id')
//            ->join('sectors', 'orders.sector_provider', '=', 'sectors.id')
//            ->join('services', 'orders.service', '=', 'services.id')
//            ->select('orders.*', 'services.name_service', 'sectors.name_sector', 'users.first_name',
//                'users.last_name')
//            ->orderBy('priority', 'desc')
//            ->orderBy('created_at', 'asc')
//            ->where('orders.requester', '=', auth()->user()->id)
//            ->get();

        $ordersEmployee = Order::where('requester','=', auth()->user()->id);
        $ordersTechnical = Order::where('responsible','=', auth()->user()->id);
        $ordersSupervisor = Order::all();
        $userFunction = auth()->user()->function;

        //$json['message'] = $this->message->success('Seja Bem-Vindo!')->render();

        if ($userFunction == 'funcionario') {
            return view('admin.dashboard.dashboardEmployee', [
                'orders' => $ordersEmployee
            ]);
        } elseif ($userFunction == 'tecnico') {
            return view('admin.dashboard.dashboardTechnician', [
                'orders' => $ordersTechnical
            ]);
        } else {

            return view('admin.dashboard', [
                'employee' => $employee,
                'technician' => $technician,
                'supervisor' => $supervisor,
                'manager' => $manager,
                'orderOpen' => $orderOpen,
                'orderAssign' => $orderAssign,
                'orderPending' => $orderPending,
                'orderInExecution' => $orderInExecution,
                'orderExecution' => $orderExecution,
                'orderCritical' => $orderCritical,
                'orderHigh' => $orderHigh,
                'orderMedium' => $orderMedium,
                'orderLow' => $orderLow,
                'orders' => $ordersSupervisor

            ]);
        }

    }
}
