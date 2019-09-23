<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Cache\Repository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;


class AuthController extends Controller
{

    public function showLoginForm()
    {
        if(Auth::check() === true) {
            return redirect()->route('admin.home');
        }

        return view('admin.index');
    }

    public function login(Request $request)
    {

        if (in_array('', $request->only('username', 'password'))) {
            $json['message'] = $this->message->warning('Informe todos os dados para efetuar o login')->render();
            return response()->json($json);
        }

        /**
         * USAR ESSE IF CASO FORMA DE LOGIN FOR EMAIL
         *
        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $json['message'] = $this->message->error('Informe um e-mail válido')->render();
            return response()->json($json);
        }
         */

        $credentials = [
            //'email' => $request->email,
            'username' => $request->username,
            'password' => $request->password
        ];

        if(!Auth::attempt($credentials)){
            $json['message'] = $this->message->error('Usuário e senha não conferem')->render();
            return response()->json($json);
        }

        //PEGAR O IP DO USUÁRIO
        $this->authenticated($request->getClientIp());

        $json['redirect'] = route('admin.home');
        return response()->json($json);

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    /*
     * Salvar último login e ip do usuário
     */
    private function authenticated(string $ip)
    {
        $user = User::where('id', Auth::user()->id);
        $user->update([
            'last_login_at' => date('Y-m-d H:i:s'),
            'last_login_ip' => $ip
        ]);
    }

}
