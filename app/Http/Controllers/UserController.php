<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

	/**
	 * Navigagte to the login form
	 */
    public function showLogin()
    {

    	return view('auth.login');
    }

    /**
	 * Navigagte to the login form
	 */
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt(array_merge($credentials))) {
            $url = 'calendar-modified';

            return ['success' => true, 'url' => $url];
        }

        return ['success' => false];
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->doLogout($request);

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    /**
     * Logout user
     */
    private function doLogout(Request $request)
    {
        Auth::logout();;

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }

    /**
     * Override default column to validate. 
     * This will indicate to use the username column instead of email. 
     */
    public function username()
	{
	    return 'username';
	}
}
