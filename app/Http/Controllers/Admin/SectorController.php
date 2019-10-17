<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $sectors = Sector::all();

//        var_dump($sectors);
//        die;
//        $sectors = DB::table('sectors')
//            ->leftJoin('users', 'users.id', 'sectors.responsible')
//            ->select('sectors.*', 'users.first_name', 'users.last_name')
//            ->whereNull('sectors.deleted_at')
//            ->where('users.function', '=', 'supervisor')
//            ->orWhereNull('sectors.responsible')
//            ->get();

        return view('admin.sectors.index')->with('sectors', $sectors);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.sectors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sectorStore = new Sector();
        $sectorStore->name_sector = $request->get('name_sector');
        $sectorStore->save();
        return redirect(route('admin.sector.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return redirect(route('admin.sector.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sectorEdit = DB::table('sectors')->find($id);
        if (!empty($sectorEdit)) {
            return view('admin.sectors.edit')->with('sectorEdit', $sectorEdit);
        } else {
            return redirect()->action('SectorController@index');
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
        $sector = Sector::find($id);
        $sector->name_sector = $request->name_sector;
        $sector->save();

        return redirect(route('admin.sector.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Sector::destroy($id);
        return redirect()->route('admin.sector.index');
    }

    /**
     * retorna apenas setores excluidos
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function trashed()
    {
        $sectors = Sector::onlyTrashed()->get();
        return view('admin.sectors/index', ['sectors' => $sectors]);
    }
}
