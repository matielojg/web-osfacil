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

        return view('admin.orders.index')->with('orders', $orders);

    }


    /**
     *
     * View orders with services to perform
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function servicesToDo()
    {
        $idUser = auth()->user()->id;

        $orders = Order::where('responsible', $idUser)
//            ->orWhere('ancillary', $idUser)
            ->whereIn('status', ['atribuido', 'em execucao'])
            ->whereNull('closed_at')
            ->orderBy('priority', 'desc')//CONFIRMAR ESSA REGRA DE NEGÓCIO
            ->get();

        return view('admin.orders.serviceToDo')->with('orders', $orders);
    }

    /**
     * Show the form for creating a new resource.
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

    public function editTechnician($id)
    {
        $order = Order::where('id', $id)
            ->first();
        return view('admin.orders.editTechnician', [
            'order' => $order
        ]);

    }

    public function editExecuted($id)
    {
        $order = Order::where('id', $id)
            ->first();
        return view('admin.orders.editExecuted', [
            'order' => $order
        ]);

    }

    public function editToEvaluate($id)
    {
        $order = Order::where('id', $id)
            ->first();
        return view('admin.orders.editToEvaluate', [
            'order' => $order
        ]);

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
     * View pending orders
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
     * View all orders where status executado
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ordersExecuted()
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

        return view('admin.orders.executed')->with('orders', $orders);
    }

    /**
     * View all orders where status executado
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

        //ENVIAR PARA VIEW SOMENTE SUPERVISORES DO SETOR PROVIDER DA ORDEM
        $technicals = User::where('function', 'tecnico')->get();

        return view('admin.orders.assignTechnical', [
            'order' => $order,
            'actions' => $actions,
            'technicals' => $technicals
        ]);
    }

    /**
     * Save technical responsible
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

        //REVER QUESTÃO DE ADICIONAR O NOME DO AUXILIAR NA ACTION, CASO SEJA ATRIBUÍDO
        $action = [
            'description' => 'Atribuido pelo gestor ' . auth()->user()->first_name . auth()->user()->last_name . ' ao técnico: '
                . $Order->userResponsible->first_name . $Order->userResponsible->last_name,
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
                    ->pluck('id'); //PLUCK TRAZ ARRAY DO ID
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
            'description' => 'Ordem Editada pelo usuário ' . $user->first_name . $user->last_name,
            'user' => $user->id,
            'order' => $id
        ];
        Action::create($action);

        return redirect()->route('admin.orders.index');
    }

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
     * Remove the specified resource from storage.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    /**
     * View deleted orders
     */
    public function trashed()
    {
        //
    }


    public function rate(Request $request, $id)
    {
        $rate = new Evaluation();
        $rate->order = $id;
        $rate->rating = $request->rating;
        $rate->comment = $request->comment;
        $rate->save();

        $user = auth()->user();
        $action = [
            'description' => 'Avaliado com nota ' . $rate->rating . ' pelo usuário ' . $user->first_name . ' ' . $user->last_name . ', com comentário: ' . $rate->comment,
            'user' => $user->id,
            'order' => $id,
            'status' => 8
        ];
        Action::create($action);

        Order::where('id', $id)
            ->update(['status' => 8]);

        return redirect()->action('Admin\OrderController@completed');
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
