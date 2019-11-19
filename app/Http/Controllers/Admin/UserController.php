<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User as UserRequest;
use App\Sector;
use App\Support\Cropper;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = DB::table('users')
            ->leftJoin('sectors', 'users.sector', '=', 'sectors.id')
            ->select('users.*', 'sectors.name_sector')
            ->whereNull('users.deleted_at')
            ->get();

        return view('admin.users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $sectors = Sector::all();
        return view('admin.users.create')->with('sectors', $sectors);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(UserRequest $request)
    {
        $this->authorize('create', User::class);
        $userCreate = User::create($request->all());

        if (!empty($request->file('photo'))) {
            $userCreate->photo = $request->file('photo')->store('user');
            $userCreate->save();
        }

        return redirect()->route('admin.users.edit', [
            'users' => $userCreate->id
        ])->with(['color' => 'green', 'message' => 'Usuário cadastrado com sucesso!']);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $idd
     * @return Response
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
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::where('id', $id)->first();

        if (!empty($request->file('photo'))) {
            Storage::delete($user->photo);
            Cropper::flush($user->photo);
            $user->photo = '';
        }

        $user->fill($request->all());

        if (!empty($request->file('photo'))) {
            $user->photo = $request->file('photo')->store('user');
        }

        if (!$user->save()) {
            return redirect()->back()->withInput()->withErrors();
        }

        return redirect()->route('admin.users.edit', [
            'users' => $user->id
        ])->with(['color' => 'green', 'message' => 'Usuário atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect()->route('admin.users.index');
    }

    /**
     * Restaura usuários excluídos
     * @param $id
     * @return RedirectResponse
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
     * @return Factory|View
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
