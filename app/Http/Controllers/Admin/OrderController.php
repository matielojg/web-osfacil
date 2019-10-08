<?php

namespace App\Http\Controllers\Admin;

use App\Action;
use App\Http\Controllers\Controller;
use App\Order;
use App\Sector;
use App\SectorProvider;
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
        $cargo = auth()->user()->function;

        switch ($cargo) {
            case ('supervisor');
                $orders = DB::table('orders')
                    ->join('users', 'orders.requester',  'users.id')
                    ->join('sectors', 'orders.sector_requester',  'sectors.id')
                    ->join('services', 'orders.service', 'services.id')
                    ->select('orders.*', 'services.name_service', 'sectors.name_sector', 'users.first_name',
                        'users.last_name')
                    ->orderBy('priority', 'desc')
                    ->orderBy('created_at', 'asc')
                    ->get();
                break;
            case ('tecnico'):
                $orders = DB::table('orders')
                    ->join('users', 'orders.requester', '=', 'users.id')
                    ->join('sectors', 'orders.sector_provider', '=', 'sectors.id')
                    ->join('services', 'orders.service', '=', 'services.id')
                    ->select('orders.*', 'services.name_service', 'sectors.name_sector', 'users.first_name',
                        'users.last_name')
                    ->orderBy('priority', 'desc')
                    ->orderBy('created_at', 'asc')
                    ->where('orders.responsible', '=', auth()->user()->id)
                    ->get();

                break;
            case ('funcionario'):
                $orders = DB::table('orders')
                    ->join('users', 'orders.requester', '=', 'users.id')
                    ->join('sectors', 'orders.sector_provider', '=', 'sectors.id')
                    ->join('services', 'orders.service', '=', 'services.id')
                    ->select('orders.*', 'services.name_service', 'sectors.name_sector', 'users.first_name',
                        'users.last_name')
                    ->orderBy('priority', 'desc')
                    ->orderBy('created_at', 'asc')
                    ->where('orders.requester', '=', auth()->user()->id)
                    ->get();
                break;
        }
//var_dump($orders);
//        die;
        return view('admin.orders.index')->with('orders', $orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sectorProviders = SectorProvider::all();
      //  $services = DB::table('services')->where('sector',  $sectorProviders)->get();

       $services = Service::all();

        if (!empty($sectorProviders)) {
            return view('admin.orders.create', [
                'sectorProviders' => $sectorProviders,
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
            'sector_requester' => $request->sector_requester,
            'requester' => $request->requester,
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

        $orderId = Order::where('orders.requester', '=', auth()->user()->id)->get()->last();
        $user = auth()->user();

        $action = [
            'description' => 'Ordem aberta pelo usuário ' . $user->first_name,
            'user' => $user->id,
            'order' => $orderId->id,
            'status' => 1,
        ];

        Action::create($action);


//        if ($request->allFiles()) {
//            foreach ($request->allFiles()['files'] as $image) {
//                $image = new Image();
//                $image->order = $order->id;
//                $image->image = $image->store('orders/' . $order->id);
//                $image->save();
//            }
//        }

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
                'b.last_name', 'f.first_name as responsible_first', 'f.last_name as responsible_last')
            ->join('users AS b', 'a.requester', '=', 'b.id')
            ->leftJoin('users AS f', 'a.responsible', '=', 'f.id')
            ->join('sector_providers AS c', 'c.id', '=', 'a.sector_provider')
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

//        var_dump($orders);
//        die;
        //dd($orders, $actions, $id);
        if (!empty($orders)) {
            return view('admin.orders.edit', [
                'orders' => $orders,
                'actions' => $actions,

            ])->with(['color' => 'green', 'message' => 'Imóvel alterado com sucesso!']);
        } else {
            return redirect()->route('admin.orders.index');
        }
    }

    /**
     * Visualizar ordens pendentes e devolver ao técnico após solução
     */
    public function pending()
    {
        $assigns = DB::table('orders')
            ->join('users as a', 'orders.requester', '=', 'a.id')
            ->leftJoin('users as b', 'orders.responsible', '=', 'b.id')
            ->join('sectors', 'orders.sector_provider', '=', 'sectors.id')
            ->join('services', 'orders.service', '=', 'services.id')
            ->select('orders.*', 'services.name_service', 'sectors.name_sector', 'a.first_name', 'a.last_name',
                'b.first_name as responsible_first', 'b.last_name as responsible_last')
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'asc')
            ->whereIn('orders.status', ['suspenso', 'pendente'])
            ->get();

        return view('admin.orders.assign')->with('assigns', $assigns);
    }

    /**
     * Atribuir técnicos as ordens abertas no sistema
     *
     */
    public function assign()
    {
        $assigns = DB::table('orders')
            ->join('users as a', 'orders.requester', '=', 'a.id')
            ->leftJoin('users as b', 'orders.responsible', '=', 'b.id')
            ->join('sectors', 'orders.sector_provider', '=', 'sectors.id')
            ->join('services', 'orders.service', '=', 'services.id')
            ->select('orders.*', 'services.name_service', 'sectors.name_sector', 'a.first_name', 'a.last_name',
                'b.first_name as responsible_first', 'b.last_name as responsible_last')
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'asc')
            ->where('orders.status', '=', 'aberto')
            ->get();

        return view('admin.orders.assign')->with('assigns', $assigns);

    }

    public function assignTechnical($id)
    {

        $assigns = DB::table('orders AS a')
            ->join('users AS b', 'a.requester', '=', 'b.id')
            ->leftJoin('users AS f', 'a.responsible', '=', 'f.id')
            ->join('sectors AS c', 'c.id', '=', 'a.sector_provider')
            ->join('sectors AS d', 'd.id', '=', 'a.sector_requester')
            ->join('services AS e', 'a.service', '=', 'e.id')
            ->select('a.*', 'e.name_service', 'c.name_sector as provider', 'd.name_sector as requester', 'b.first_name',
                'b.last_name', 'f.first_name as responsible_first', 'f.last_name as responsible_last')
            ->where('a.id', $id)
            ->get();

//        var_dump($assigns);
//        die;
        $actions = DB::table('actions AS a')
            ->latest()
            ->select('a.*', 'b.first_name', 'b.last_name')
            ->join('users AS b', 'a.user', '=', 'b.id')
            ->where('a.order', $id)
            ->get();

        $technicals = DB::table('users')
            ->whereNull('users.deleted_at')
            ->where('users.function', '=', 'tecnico')
            ->get();

//        var_dump($technicals);
//        die;
//        dd($orders, $actions, $id);
        if (!empty($assigns)) {
            return view('admin.orders.assignTechnical', [
                'assigns' => $assigns,
                'actions' => $actions,
                'technicals' => $technicals
            ])->with(['color' => 'green', 'message' => 'Tecnico atribuido com sucesso!']);
        } else {
            return redirect()->route('admin.orders.assign');
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
        $action->user = auth()->user()->id;
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
     * Update Technical Responsible in the assignTechnical.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */

    public function updateTechnical(Request $request, $id)
    {
        $technical = Order::find($id);
        $technical->responsible = $request->responsible;
        $technical->status = $request->status;
        $technical->save();

        return redirect(route('admin.orders.assign'));
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

    public function trashed()
    {
        //
    }
}
