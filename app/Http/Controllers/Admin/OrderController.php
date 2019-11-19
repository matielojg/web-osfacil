<?php

namespace App\Http\Controllers\Admin;

use App\Action;
use App\Evaluation;
use App\Http\Controllers\Controller;
use App\Image;
use App\Order;
use App\SectorProvider;
use App\Service;
use App\Support\Cropper;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**********************************
     ********* REVISADO ***************
     *********************************/

    /**
     * Show the form for creating a new order
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sectorProviders = SectorProvider::all();

        if (!empty($sectorProviders)) {
            return view('admin.orders.create', [
                'sectorProviders' => $sectorProviders
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
        $order->sector_provider = $request->filter_sector_provider;   //contem requisição Ajax
        $order->service = $request->filter_service;
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

        $user = auth()->user();
        $orderId = Order::where('orders.requester', '=', auth()->user()->id)->get()->last();

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
     * view all orders where the logged in user is the requestor
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('requester', auth()->user()->id)
            ->whereNull('closed_at')
            ->latest()
            ->get();

        return view('admin.orders.index')->with('orders', $orders);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::where('id', $id)->first();
        $rate = Evaluation::where('order', $id)->first();

        if (!empty($order)) {
            return view('admin.orders.show', [
                'order' => $order,
                'rate' => $rate
            ]);
        } else {
            return redirect()->action('Admin\OrderController@index');
        }
    }

    /**
     * Edit order with open status
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editOpen($id)
    {
        $sectorProviders = SectorProvider::all();
        $services = Service::all();
        $order = Order::where('id', $id)->first();

        if ($order->requester == auth()->user()->id && $order->status == 'aberto') {
            return view('admin.orders.editOpen', [
                'sectorProviders' => $sectorProviders,
                'services' => $services,
                'order' => $order
            ]);
        } else {
            return redirect()->action('Admin\OrderController@index');
        }
    }

    /**
     * View all orders
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allOrders()
    {
        $idUser = auth()->user()->id;
        $function = auth()->user()->function;

        if ($function == 'gerente') {
            $orders = Order::all();
        } else {
            $sectorProviders = SectorProvider::where('supervisor', $idUser)
                ->pluck('id');
            if (empty($sectorProviders)) {
                return redirect()->action('Admin\OrderController@index');
                die;
            }
            $orders = Order::whereIn('sector_provider', $sectorProviders)
                ->get();
        }

        return view('admin.orders.allOrders')->with('orders', $orders);

    }

    /**
     * View orders with services to perform
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function servicesToDo()
    {
        $orders = Order::whereIn('status', ['atribuido', 'em execucao'])
            ->where(function ($responsible) {
                $idUser = auth()->user()->id;
                $responsible->where('responsible', $idUser)
                    ->orWhere('ancillary', $idUser);
            })
            ->whereNull('closed_at')
            ->orderBy('priority', 'desc')
            ->get();

        return view('admin.orders.serviceToDo')->with('orders', $orders);
    }

    /**
     * View form to edit order
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editTechnician($id)
    {
        $order = Order::where('id', $id)
            ->first();
        return view('admin.orders.editTechnician', [
            'order' => $order
        ]);

    }

    /**
     * Update orders whith pending status
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateServicesToDo(Request $request, $id)
    {
        $action = new Action();
        $action->description = $request->description;
        $action->user = auth()->user()->id;
        $action->order = $id;
        $action->status = $request->status;
        $action->save();

        Order::where('id', $id)
            ->update(['status' => $request->status]);

        return redirect()->route('admin.orders.servicesToDo');
    }

    /**
     * View orders requiring technician
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function assign()
    {
        $function = auth()->user()->function;
        $sectorProvider = SectorProvider::where('supervisor', auth()->user()->id)
            ->get()
            ->pluck('id');

        if (empty($sectorProvider)) {
            return view('admin.orders.index');
            die;
        }

        if ($function == "gerente") {
            $orders = Order::where('status', 'aberto')->get();
        } else {
            $orders = Order::whereIn('sector_provider', $sectorProvider)
                ->where('status', 'aberto')
                ->get();
        }

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
        $technicals = User::where('function', 'tecnico')->get();

        return view('admin.orders.assignTechnical', [
            'order' => $order,
            'actions' => $actions,
            'technicals' => $technicals
        ]);
    }

    /**
     * Save technical and ancillary responsible
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateTechnical(Request $request, $id)
    {
        if ($request->ancillary == 0) {
            $request->ancillary = null;
        }

        $Order = Order::find($id);
        $Order->responsible = $request->responsible;
        $Order->ancillary = $request->ancillary;
        $Order->status = 2;
        $Order->save();

        $action = [
            'description' => 'Ordem atribuida ao técnico: ' . $Order->userResponsible->first_name . " " . $Order->userResponsible->last_name,
            'user' => auth()->user()->id,
            'order' => $Order->id,
            'status' => 2,
        ];

        Action::create($action);

        return redirect(route('admin.orders.assign'));
    }

    /**
     * View all orders in progress
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function ordersInProgress()
    {
        $idUser = auth()->user()->id;
        $function = auth()->user()->function;
        $status = [
            'atribuido',
            'em execucao'
        ];

        switch ($function) {
            case ('gerente');
                $orders = Order::whereIn('status', $status)
                    ->whereNull('closed_at')
                    ->get();
                break;
            case ('supervisor');
                $sectorProviders = SectorProvider::where('supervisor', $idUser)
                    ->pluck('id');
                if (empty($sectorProviders)) {
                    return redirect()->action('Admin\OrderController@index');
                    die;
                }
                $orders = Order::whereIn('sector_provider', $sectorProviders)
                    ->whereIn('status', $status)
                    ->get();
                break;
        }

        return view('admin.orders.inProgress')->with('orders', $orders);
    }

    /**
     * View all orders where pending status
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function pending()
    {
        $function = auth()->user()->function;
        $sectorProvider = SectorProvider::where('supervisor', auth()->user()->id)
            ->get()
            ->pluck('id');

        if ($function == "gerente") {
            $orders = Order::where('status', 'pendente')->get();
        } else {
            $orders = Order::whereIn('sector_provider', $sectorProvider)
                ->where('status', 'pendente')
                ->get();
        }

        return view('admin.orders.pending')->with('orders', $orders);
    }

    /**
     * Show de form for editing the orders pending
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editPending($id)
    {
        $order = Order::where('id', $id)
            ->first();
        return view('admin.orders.editPending', [
            'order' => $order
        ]);
    }

    /**
     * Update orders whith pending status
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePending(Request $request, $id)
    {
        $action = new Action();
        $action->description = $request->description;
        $action->user = auth()->user()->id;
        $action->order = $id;
        $action->status = $request->status;
        $action->save();

        Order::where('id', $id)
            ->update(['status' => $request->status]);

        if ($request->status = 5) {
            Order::where('id', $id)
                ->update(['closed_at' => Carbon::now()]);
        }

        return redirect()->route('admin.orders.pending');
    }

    /**
     * View all orders where status executed
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ordersExecuted()
    {
        $function = auth()->user()->function;
        $sectorProvider = SectorProvider::where('supervisor', auth()->user()->id)
            ->get()
            ->pluck('id');

        if (empty($sectorProvider)) {
            return redirect()->action('Admin\OrderController@index');
            die;
        }

        if ($function == "gerente") {
            $orders = Order::where('status', 'executado')
                ->get();
        } elseif ($function == "supervisor") {
            $orders = Order::whereIn('sector_provider', $sectorProvider)
                ->where('status', 'executado')
                ->get();
        } else {
            $orders = Order::where('status', 'executado')
                ->where(function ($responsible) {
                    $idUser = auth()->user()->id;
                    $responsible->where('responsible', $idUser)
                        ->orWhere('ancillary', $idUser);
                })
                ->get();
        }

        return view('admin.orders.executed')->with('orders', $orders);
    }

    /**
     * View form to edit order where executed status
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editExecuted($id)
    {
        $order = Order::where('id', $id)
            ->first();
        return view('admin.orders.editExecuted', [
            'order' => $order
        ]);
    }

    /**
     * Update orders whith executed status
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function executedUpdate(Request $request, $id)
    {
        $action = new Action();
        $action->description = $request->description;
        $action->user = auth()->user()->id;
        $action->order = $id;
        $action->status = $request->status;
        $action->save();

        Order::where('id', $id)
            ->update(['status' => $request->status]);

        if ($request->status = 7) {
            Order::where('id', $id)
                ->update(['closed_at' => now()]);
        }

        return redirect()->route('admin.orders.executed');
    }

    /**
     * View orders rated
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function rated()
    {
        $orders = Order::where('status', 'avaliado')
            ->where('requester', auth()->user()->id)
            ->get();

        return view('admin.orders.rated')->with('orders', $orders);
    }

    /**
     * View all orders where completed status
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toEvaluate()
    {
        $orders = Order::where('status', 'concluido')
            ->where('requester', auth()->user()->id)
            ->get();

        return view('admin.orders.toEvaluate')->with('orders', $orders);
    }

    /**
     * View form to evaluate order
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editToEvaluate($id)
    {
        $order = Order::where('id', $id)
            ->first();
        return view('admin.orders.editToEvaluate', [
            'order' => $order
        ]);
    }

    /**
     * Evaluation Order
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rate(Request $request, $id)
    {
        $rate = new Evaluation();
        $rate->order = $id;
        $rate->rating = $request->rating;
        $rate->comment = $request->comment;
        $rate->save();

        $user = auth()->user();
        $action = [
            'description' => 'Nota: ' . $rate->rating . ' | Comentário: ' . $rate->comment,
            'user' => $user->id,
            'order' => $id,
            'status' => 8
        ];
        Action::create($action);

        Order::where('id', $id)
            ->update(['status' => 8]);

        return redirect()->action('Admin\OrderController@toEvaluate');
    }

    /**
     * View all orders with finished status
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finished()
    {
        $idUser = auth()->user()->id;
        $function = auth()->user()->function;

        if ($function == 'gerente') {
            $orders = Order::where('status', 'avaliado')->get();
        } elseif ($function == 'supervisor') {
            $sectorProviders = SectorProvider::where('supervisor', $idUser)
                ->pluck('id');
            if (empty($sectorProviders)) {
                return redirect()->action('Admin\OrderController@index');
                die;
            }
            $orders = Order::whereIn('sector_provider', $sectorProviders)
                ->where('status', 'avaliado')
                ->get();
        } else {
            $orders = Order::where('status', 'avaliado')
                ->where(function ($responsible) {
                    $idUser = auth()->user()->id;
                    $responsible->where('responsible', $idUser)
                        ->orWhere('ancillary', $idUser);
                })
                ->get();
        }

        return view('admin.orders.finished')->with('orders', $orders);

    }

    /**************************
     **************************
     **************************/


    /**
     * Update Technical Responsible in the assignTechnical.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function completed()
    {
        $user = auth()->user();
        $function = auth()->user()->function;

        switch ($function) {
            case 'gerente':
                $orders = Order::whereNotNull('closed_at')
                    ->where('status', 'avaliado')
                    ->get();
                break;

            case ('supervisor');

                $sectorProviders = DB::table('sector_providers')
                    ->where('supervisor', $user->id)
                    ->pluck('id'); //PLUCK TRAZ ARRAY DO ID

                if (empty($sectorProviders)) {
                    return view('admin.orders.index');
                    die;
                }

                $orders = Order::whereIn('sector_provider', $sectorProviders)
                    ->whereNotNull('closed_at')
                    ->where('status', 'avaliado')
                    ->get();

                break;
            case ('tecnico');
                $orders = Order::where('responsible', $user->id)
                    ->whereNotNull('closed_at')
                    ->where('status', 7)//status = concluido
                    ->get();
                break;

            default;

                $orders = Order::where('requester', $user->id)
                    ->whereNotNull('closed_at')
                    ->where('status', 'avaliado')
                    ->get();
                break;
        }

        if ($orders) {
            return view('admin.orders.completed')->with('orders', $orders);
        } else {
            return redirect()->route('admin.orders.index');
        }

    }

    /**
     * View all orders where status executado
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function avaliate()
    {
        $function = auth()->user()->function;
        $sectorProvider = SectorProvider::where('supervisor', auth()->user()->id)
            ->get()
            ->pluck('id');  //na situação em que um supervisor for responsável por mais de um setor

        if (empty($sectorProvider)) {
            return redirect()->action('Admin\OrderController@index');
            die;
        }

        if ($function == "gerente") {
            $orders = Order::where('status', 'executado')
                ->get();
        } else {
            $orders = Order::whereIn('sector_provider', $sectorProvider)
                ->where('status', 'executado')
                ->get();
        }

        return view('admin.orders.pending2')->with('orders', $orders);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::where('id', $id)
            ->first();
        return view('admin.orders.edit', [
            'order' => $order
        ]);

    }

    /**
     * Inserir histórico de alterações
     * Tecnico executa ordem, atualiza status e preenche o closed_at
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editActions(Request $request, $id)
    {
//        dd($request->status, $idUser->function);
        $action = new Action();
        $action->description = $request->description;
        $action->user = auth()->user()->id;
        $action->order = $id;
        $action->status = $request->status;
        $action->save();


        $order = Order::where('id', $id)
            ->update(['status' => $request->status]);


        $idUser = auth()->user();
        if (($idUser->function == 'supervisor' xor $idUser->function == 'gerente') && $request->status == '7') {
            Order::where('id', $id)
                ->update(['closed_at' => Carbon::now()]);
        } elseif (($idUser->function == 'supervisor' xor $idUser->function == 'gerente') && $request->status == '1') {
            Order::where('id', $id)
                ->update([
                    'responsible' => null,
                    'ancillary' => null
                ]);
        }

        if ($request->allFiles()) {
            foreach ($request->allFiles()['files'] as $image) {
                $orderImage = new Image();
                $orderImage->order = $id;
                $orderImage->image = $image->store('orders/' . $id);
                $orderImage->save();
                unset($orderImage);

            }
        }

//        return redirect()->route('admin.orders.index');
        return redirect()->route('admin.orders.servicesToDo');
    }

    /**********************************
     ********* REVISADO ***************
     *********************************/


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $order = Order::where('id', $id)->first();

        $order->requester = auth()->user()->id;
        $order->sector_requester = auth()->user()->sector;
        $order->sector_provider = $request->sector_provider;
        $order->priority = $request->priority;
        $order->service = $request->service;
        $order->type_service = $request->type_service;
        $order->description = $request->description;
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

        $action = [
            'description' => 'Ordem editada pelo usuário: ' . $user->first_name . $user->last_name,
            'user' => $user->id,
            'order' => $id
        ];
        Action::create($action);

        return redirect()->route('admin.orders.index');
    }

    /**
     * Remove Images
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
