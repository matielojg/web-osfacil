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
            $users = User::all()->where('deleted_at', null);
            return view('admin.users.index')->with('users', $users);
            echo $users;
            /**
             * $users = DB::table('users')
             * ->join('contacts', 'users.id', '=', 'contacts.user_id')
             * ->join('orders', 'users.id', '=', 'orders.user_id')
             * ->select('users.*', 'contacts.phone', 'orders.price')
             * ->get();*/

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
        $user = User::where('id',$id)->first();
        $sectors = DB::table('sectors')->get();
     //   $function = DB::table('users')->get('function');
        //$function = DB::table('users')->select('function')->get();
        //$function = DB::table('users')->[function]->get();

        if (!empty($user)) {
            return view('admin.users.edit',[
                'sectors'=> $sectors,
                'user'=> $user,
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
        //var_dump($request,$id);
        $form_data = array(
            'first_name'=> $request->first_name,
            'last_name'=> $request->last_name,
            'document'=> $request->document,
            'email'=> $request->email,
            'username'=> $request->username,
            'password'=> $request->password,
            'function'=> $request->function,
            'primary_contact'=> $request->primary_contact,
            'secondary_contact'=> $request->secondary_contact,
        );
        User::whereId($id)->update($form_data);
        return redirect(route('admin.users'));

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
