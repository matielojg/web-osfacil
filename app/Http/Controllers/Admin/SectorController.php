<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Sector;


class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $sectors = Sector::all()->where('active', 1);
        return view('admin.sectors/index')->with('sectors', $sectors);
        //$sectors = DB::select('select * from sectors where active = 1');
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
        return redirect(route('admin.sector'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return redirect(route('admin.sector'));
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
        $form_data = array(
            'name_sector' => $request->name_sector
        );
        Sector::whereId($id)->update($form_data);

        //var_dump($id , $request);

        return redirect(route('admin.sector'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sector $sector)
    {

        Sector::find($id)->delete();
        return redirect(route('admin.sector'));
    }

    /**
     * Função para desabilitar setor
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function disable($id)
    {
        $sector = Sector::find($id);
        $sector->active = 0;
        $sector->deleted_at = now();
        $sector->save();

        return redirect(route('admin.sector'));

    }

    public function trashed()
    {
        $sectors = Sector::onlyTrashed()->get();
        return view('admin.sectors/index', ['sectors' => $sectors]);
    }
}
