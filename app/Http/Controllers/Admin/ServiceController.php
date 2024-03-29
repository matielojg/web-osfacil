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

//        $services = DB::table('services')
//            -where('deleted_at', null)
//            ->leftJoin('sector_providers', 'services.sector', '=', 'sector_providers.id')
//            ->select('services.*', 'sector_providers.name_sector')
//            ->get();

        $services = Service::all();
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
        return view('admin.services.create')->with('sectors', $sectors);
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
        $serviceStore->name_service = $request->name_service;
        $serviceStore->sector = $request->sector;
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::find($id);
        $sectors = SectorProvider::all();

        if (!empty($service)) {
            return view('admin.services.edit', [
                'service' => $service,
                'sectors' => $sectors
            ]);
        } else {
            return redirect()->action('Admin\ServiceController@index');
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
        $service = Service::find($id);
        $service->name_service = $request->name_service;
        $service->sector = $request->sector;
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
        Service::destroy($id);
        return redirect()->route('admin.services.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function trashed()
    {
        $services = Service::onlyTrashed()->get();
        return view('admin.services.index', ['services' => $services]);
    }
}
