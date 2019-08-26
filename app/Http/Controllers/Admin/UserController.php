<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Sector;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $users = DB::table('sectors')
                ->join('users', 'users.sector_id', 'sectors.id')
                ->select('users.*', 'sectors.name_sector')
                ->where('users.deleted_at', null)
                ->get();
            return view('admin.users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sectors = Sector::all();
        return view('admin.users.create')->with('sectors', $sectors);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'document' => $request->document,
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->password,
            'primary_contact' => $request->primary_contact,
            'secondary_contact' => $request->secondary_contact,
            'photo' => $request->photo,
            'function' => $request->function,
            //'sector' => $request->sector,
        ];

        //var_dump($user);
        User::create($user);
        return redirect()->action('Admin\UserController@index');
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
        $sectors = Sector::all();

        if (!empty($user)) {
            return view('admin.users.edit', [
                'sectors' => $sectors,
                'user' => $user,
            ]);
        } else {
            return redirect()->action('Admin\UserController@index');
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
        $user->primary_contact = $request->primary_contact;
        $user->secondary_contact = $request->secondary_contact;
        $user->photo = $request->photo;
        $user->function = $request->function;

        $user->save();

        return redirect()->action('Admin\UserController@index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect()->action('Admin\UserController@index');
    }

    public function trashed()
    {
        $users = User::onlyTrashed()->get();
        $sector = Sector::all();

        return view('admin.users.index', [
            'users' => $users,
            'sector' => $sector
        ]);

    }
}
