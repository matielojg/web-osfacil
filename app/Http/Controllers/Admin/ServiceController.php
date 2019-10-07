<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SectorProvider;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $services = DB::table('services')
            ->leftJoin('sector_providers', 'services.sector', '=', 'sector_providers.id')
            ->select('services.*', 'sector_providers.name_sector')
            ->get();


//        var_dump($services);
//        die;
        return view('admin.services.index')->with('services', $services);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sectors = SectorProvider::all();
        return view('admin.services.create')->with('sectors',$sectors);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $serviceStore = new Service();
        $serviceStore->name_service = $request->get('name_service');
        $serviceStore->sector = $request->get('sector');
        $serviceStore->save();
        return redirect()->route('admin.services.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect(route('admin.service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $service = Service::find($id);
        $sectors = SectorProvider::all();

        if (!empty($service)) {
            return view('admin.services.edit', ['service' => $service, 'sectors' => $sectors
            ]);
        } else {
            return redirect()->action('ServiceController@index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        //var_dump($request,$id);
        $service = Service::find($id);
        $service->name_service = $request->name_service;
        $service->save();
        return redirect()->route('admin.services.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Service::destroy($id);
        return redirect()->route('admin.service');
    }

    public function trashed()
    {
        $services = Service::onlyTrashed()->get();
        return view('admin.services/index', ['services' => $services]);
    }

}
