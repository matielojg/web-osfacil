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
        // $sectors = Sector::all()->where('deleted_at', null);


        $sectors = DB::table('users')
            ->join('sectors', 'sectors.responsible', 'users.id')
            ->select('sectors.*', 'users.first_name', 'users.last_name')
            ->where('sectors.deleted_at', null)
            ->where('users.function', '=', 'supervisor')
            ->get();
        // var_dump($sectors);
        return view('admin.sectors/index')->with('sectors', $sectors);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $sectors = Sector::all();
        //        return view('admin.users.create')->with('sectors', $sectors);
        $responsibles = DB::table('users')
            ->select('users.*')
            ->where('users.function', '=', 'supervisor')
            ->get();
        //  var_dump($responsibles);
        return view('admin.sectors.create')->with('responsibles', $responsibles);
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
        $sectorStore->responsible = $request->get('responsible');
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
        Sector::destroy($sector->id);
        return redirect()->action('Admin\SectorController@index');
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
