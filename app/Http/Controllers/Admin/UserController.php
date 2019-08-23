<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Sector;
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
//        $user = DB::table('users')->find($id);
//        //var_dump($user);
////        $contact= DB::table('contacts')->where( $user->contact)->get();
////        var_dump($contact);
///

          $userEdit = DB::table('users')->find($id);
        if (!empty($userEdit)) {
            $contact = DB::table('users')
                ->join('contacts', 'users.id', '=', 'contacts.id')
                ->select('contacts.primary_contact', 'contacts.secondary_contact')
                ->get();
            //return view('admin.users.edit')->with('contact', $contact);
            //var_dump($userEdit, $contact);
           // var_dump($userEdit);
            return view('admin.users.edit', [
                'contacts'=> $contact,
                'user'=> $userEdit
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
        //
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
