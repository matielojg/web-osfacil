<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        {
            $users = DB::table('sectors')
                ->join('users', 'users.sector_id', 'sectors.id')
                ->select('users.*', 'sectors.name_sector')
                ->where('users.deleted_at', null)
                ->get();
            return view('admin.users.index')->with('users', $users);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        var_dump($request->all());
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
     * @param int $idd
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        $sectors = DB::table('sectors')->get();

        if (!empty($user)) {
            return view('admin.users.edit', [
                'sectors' => $sectors,
                'user' => $user,
            ]);
        } else {
            return redirect()->action('userController@index');
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

        $user = User::find($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->document = $request->document;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = $request->password;
        $user->function = $request->function;
        $user->primary_contact = $request->primary_contact;
        $user->secondary_contact = $request->secondary_contact;

        $user->save();
        return redirect()->action('Admin\UserController@index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
