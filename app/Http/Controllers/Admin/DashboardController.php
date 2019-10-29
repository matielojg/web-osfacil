<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use App\SectorProvider;
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

        //Dashboard Funcionário
        $ordersEmployee = Order::where('requester', auth()->user()->id)->get();

        //Dashboard Técnico
        $ordersTechnical = Order::where('responsible', '=', auth()->user()->id)
            ->whereIn('status', ['atribuido', 'em execucao'])
            ->get();

        //Dashboard Supervisor
        $sectorProviders = SectorProvider::where('supervisor', auth()->user()->id)
            ->pluck('id');
        $ordersSupervisor = Order::whereIn('sector_provider', $sectorProviders)
            ->take(5)
            ->latest()
            ->get();

        //Dashboard Gerente
        $ordersManager = Order::whereNull('closed_at')
            ->take(5)
            ->latest()
            ->get();

        $userFunction = auth()->user()->function;

        switch ($userFunction) {
            case('gerente');
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
                    'orders' => $ordersManager
                ]);
                break;
            case('supervisor');
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
            case('tecnico');
                return view('admin.dashboard.dashboardTechnician', [
                    'orders' => $ordersTechnical
                ]);
                break;
            default;
                return view('admin.dashboard.dashboardEmployee', [
                    'orders' => $ordersEmployee
                ]);
                break;
        }
    }
}
