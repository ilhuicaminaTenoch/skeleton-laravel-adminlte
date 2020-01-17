<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->valideLogin($request);
        $credencials = [
            'email' => $request->email,
            'password' => $request->password,
            'activo' => 1
        ];

        if (Auth::attempt($credencials)) {
            return redirect()->route('home');
        }

        return back()
            ->withErrors(['email' => trans('auth.failed')])
            ->withInput(\request(['email']));
    }

    protected function valideLogin(Request $request)
    {
        try {
            $this->validate($request, [
                'email' => 'required|string',
                'password' => 'required|string'
            ]);
        } catch (ValidationException $e) {
        }
    }
}
