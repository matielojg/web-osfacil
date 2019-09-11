<?php

namespace App\Http\Controllers\Admin;

use App\Action;
use App\Http\Controllers\Controller;
use App\Image;
use App\Order;
use App\Sector;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cargo = 'supervisor';

        switch ($cargo) {
            case ('supervisor');
                $orders = DB::table('orders')
                    ->join('users', 'orders.requester', '=', 'users.id')
                    ->join('sectors', 'orders.sector_provider', '=', 'sectors.id')
                    ->join('services', 'orders.service', '=', 'services.id')
                    ->select('orders.*', 'services.name_service', 'sectors.name_sector', 'users.first_name', 'users.last_name')
                    ->orderBy('priority', 'desc')
                    ->orderBy('created_at', 'asc')
                    ->get();
                break;
            case ('tecnico'):
                $orders = DB::table('orders')
                    ->join('users', 'orders.requester', '=', 'users.id')
                    ->join('sectors', 'orders.sector_provider', '=', 'sectors.id')
                    ->join('services', 'orders.service', '=', 'services.id')
                    ->select('orders.*', 'services.name_service', 'sectors.name_sector', 'users.first_name', 'users.last_name')
                    ->orderBy('priority', 'desc')
                    ->orderBy('created_at', 'asc')
//                  ->where('orders.responsible', '=', $cargo->id)
                    ->get();

                break;
            case ('funcionario'):
                $orders = DB::table('orders')
                    ->join('users', 'orders.requester', '=', 'users.id')
                    ->join('sectors', 'orders.sector_provider', '=', 'sectors.id')
                    ->join('services', 'orders.service', '=', 'services.id')
                    ->select('orders.*', 'services.name_service', 'sectors.name_sector', 'users.first_name', 'users.last_name')
                    ->orderBy('priority', 'desc')
                    ->orderBy('created_at', 'asc')
//                  ->where('orders.requester', '=', $cargo->id)
                    ->get();
                break;
        }

        return view('admin.orders.index')->with('orders', $orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sectors = Sector::all();
        $services = Service::all();

        if (!empty($sectors)) {
            return view('admin.orders.create', [
                'sectors' => $sectors,
                'services' => $services,
            ]);
        } else {
            return redirect()->action('Admin\OrderController@index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = [

//            'requester' => $request->requester ,
//            'sector_requester' => $request->sector_requester,
            'requester' => 1,
            'sector_requester' => 1,
            'sector_provider' => $request->sector_provider,
            'service' => $request->service,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 1,
            'type_service' => $request->type_service,
            'image' => $request->image
        ];

//        dd($order);
        Order::create($order);

        if ($request->allFiles()) {
            foreach ($request->allFiles()['files'] as $image) {
                $image = new Image();
                $image->order = $order->id;
                $image->image = $image->store('orders/' . $order->id);
                $image->save();
            }
        }

        return redirect()->route('admin.orders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('admin.orders.edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $orders = DB::table('orders AS a')
            ->select('a.*', 'e.name_service', 'c.name_sector as provider', 'd.name_sector as requester', 'b.first_name',
                'b.last_name')
            ->join('users AS b', 'a.requester', '=', 'b.id')
            ->join('sectors AS c', 'c.id', '=', 'a.sector_provider')
            ->join('sectors AS d', 'd.id', '=', 'a.sector_requester')
            ->join('services AS e', 'a.service', '=', 'e.id')
            ->where('a.id', $id)
            ->get();

        $actions = DB::table('actions AS a')
            ->latest()
            ->select('a.*', 'b.first_name', 'b.last_name')
            ->join('users AS b', 'a.user', '=', 'b.id')
            ->where('a.order', $id)
            ->get();

        //dd($orders, $actions, $id);


        if (!empty($orders)) {
            return view('admin.orders.edit', [
                'orders' => $orders,
                'actions' => $actions
            ])->with(['color' => 'green', 'message' => 'Imóvel alterado com sucesso!']);
        } else {
            return redirect()->route('admin.orders.index');
        }
    }

    /**
     * Inserir histórico de alterações
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editActions(Request $request, $id)
    {
        $action = new Action();
        $action->description = $request->description;
        $action->user = 1;
        $action->order = $id;
        $action->status = $request->status;

        //dd($action);
        $action->save();
        return redirect()->route('admin.orders.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
