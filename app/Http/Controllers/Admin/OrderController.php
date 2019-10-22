<?php

namespace App\Http\Controllers\Admin;

use App\Action;
use App\Http\Controllers\Controller;
use App\Image;
use App\Order;
use App\SectorProvider;
use App\Service;
use App\Support\Cropper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idUser = auth()->user()->id;
        $function = auth()->user()->function;

        switch ($function) {
            case ('supervisor');
                $sectorProvider = SectorProvider::where('supervisor', $idUser)->first();

                if (empty($sectorProvider)) {
                    return view('admin.orders.index');
                    die;
                }

                $orders = Order::where('sector_provider', '=', $sectorProvider->id)->get();
                break;

            default;
                $orders = Order::where('requester', $idUser)->get();
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
        $sectorProviders = SectorProvider::all();
        $services = Service::all();

        if (!empty($sectorProviders)) {
            return view('admin.orders.create', [
                'sectorProviders' => $sectorProviders,
                'services' => $services
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
        $order = new Order();
        $order->sector_requester = $request->sector_requester;
        $order->requester = $request->requester;
        $order->sector_requester = auth()->user()->sector;
        $order->sector_provider = $request->sector_provider;
        $order->service = $request->service;
        $order->description = $request->description;
        $order->priority = $request->priority;
        $order->status = 1;
        $order->type_service = $request->type_service;

        $order->save();

        if ($request->allFiles()) {
            foreach ($request->allFiles()['files'] as $image) {
                $orderImage = new Image();
                $orderImage->order = $order->id;
                $orderImage->image = $image->store('orders/' . $order->id);
                $orderImage->save();
                unset($orderImage);

            }
        }

        $orderId = Order::where('orders.requester', '=', auth()->user()->id)->get()->last();
        $user = auth()->user();

        $action = [
            'description' => 'Ordem aberta pelo usuário ' . $user->first_name,
            'user' => $user->id,
            'order' => $orderId->id,
            'status' => 1,
        ];

        Action::create($action);

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
        $order = Order::where('id', $id)->first();

        //dd($order->userRequester->first_name);


//         $requester = $order->requester()->first();
//         $service = $order->service()->first();
//         $actions = $order->actions();
//         $responsible = $order->responsible()->first();


//         var_dump($order->sectorRequester()->first());
//
//        die;

        return view('admin.orders.edit', [
            'order' => $order
        ]);

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
     * View pending orders
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function pending()
    {
        $idUser = auth()->user()->id;
        $sectorProvider = SectorProvider::where('supervisor', $idUser)->first();

        if (empty($sectorProvider)) {
            return view('admin.orders.index');
            die;
        }

        $orders = Order::where('sector_provider', '=', $sectorProvider->id)
            ->where('status', '=', 'pendente')
            ->get();

        return view('admin.orders.pending')->with('orders', $orders);
    }

    /**
     * View orders requiring technician
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function assign()
    {
        $idUser = auth()->user()->id;
        $sectorProvider = SectorProvider::where('supervisor', $idUser)->first();

        if (empty($sectorProvider)) {
            return view('admin.orders.index');
            die;
        }

        $orders = Order::where('sector_provider', '=', $sectorProvider->id)
            ->where('status', '=', 'aberto')
            ->get();

        return view('admin.orders.assign')->with('orders', $orders);
    }

    /**
     * Assign technician
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function assignTechnical($id)
    {
        $order = Order::where('id', $id)->first();
        $actions = Action::where('order', $id)->get();
        $technicals = User::where('function', '=', 'tecnico')->get();

        return view('admin.orders.assignTechnical', [
            'order' => $order,
            'actions' => $actions,
            'technicals' => $technicals
        ]);
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
        dd($request);
        $order = Order::where('id', $order->id)->first();
        $order->status = $request->status;
        $order->sector_requester = $request->sector_requester;
        $order->requester = $request->requester;
        $order->sector_provider = $request->sector_provider;
        $order->service = $request->service;
        $order->description = $request->description;
        $order->priority = $request->priority;
        $order->status = $request->status;
        $order->type_service = $request->type_service;

        $order->save();

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

    public function imageRemove(Request $request)
    {
        $imageDelete = Image::where('id', $request->id)->first();

        Storage::delete($imageDelete->image);
        Cropper::flush($imageDelete->image);

        $imageDelete->delete();

        $json = [
            'success' => true
        ];
        return response()->json($json);
    }
}
