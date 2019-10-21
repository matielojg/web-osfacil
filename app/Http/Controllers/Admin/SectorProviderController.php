<?php


namespace App\Http\Controllers\Admin;


use App\SectorProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SectorProviderController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $sectorProviders = DB::table('sector_providers as a')
//            ->leftJoin('users', 'users.id', '=', 'a.supervisor')
//            ->select('a.*', 'users.first_name', 'users.last_name')
//            ->whereNull('a.deleted_at')
//            ->where('users.function', '=', 'supervisor')
//            ->get();

        $sectorProviders = SectorProvider::all();

        return view('admin.sectorProviders.index')->with('sectorProviders', $sectorProviders);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $sectorEdit = DB::table('sector_providers')->find($id);
        $supervisores = DB::table('users')
            ->select('users.*')
            ->where('users.function', '=', 'supervisor')
            ->get();
        //var_dump($responsibles, $sectorEdit);
        if (!empty($sectorEdit)) {
            return view('admin.sectorProviders.edit', [
                'supervisores' => $supervisores,
                'sectorEdit' => $sectorEdit,
            ]);
        } else {
            return redirect()->action('SectorProviderController@index');
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
        $sectorProvider = SectorProvider::find($id);
        $sectorProvider->supervisor = $request->supervisor;
        $sectorProvider->save();

        return redirect(route('admin.sectorsProvider.index'));
    }

}
