<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Sector;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\User as UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


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
            ->join('users', 'users.sector', 'sectors.id')
            ->select('users.*', 'sectors.name_sector')
            ->whereNull('users.deleted_at')
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
    public function store(UserRequest $request)
    {
        $user = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'document' => $request->document,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->newPassword),
            'primary_contact' => $request->primary_contact,
            'secondary_contact' => $request->secondary_contact,
            'photo' => $request->photo,
            'function' => $request->function,
            'sector' => $request->sector,
        ];

        User::create($user);
        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


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
        $user->password = bcrypt($request->password);
        $user->primary_contact = $request->primary_contact;
        $user->secondary_contact = $request->secondary_contact;
        $user->photo = $request->photo;
        $user->function = $request->function;
        $user->sector= $request->sector;

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
        return redirect()->route('admin.users.index');
    }

    /**
     * Restaura usuários excluídos
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->where('id', $id)->first();

        if ($user->trashed()) {
            $user->restore();
        }

        return redirect()->route('admin.users.index');
    }

    /**
     * Exibe apenas os usuários excluídos
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function trashed()
    {
        $users = DB::table('sectors')
            ->join('users', 'users.sector', 'sectors.id')
            ->select('users.*', 'sectors.name_sector')
            ->where('users.deleted_at', '!=', null)
            ->get();
        return view('admin.users.indextrashed')->with('users', $users);
    }

}
