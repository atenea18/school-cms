<?php

namespace App\Http\Controllers\InstitutionAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\ResetsPasswords;

//Auth Facade
use Illuminate\Support\Facades\Auth;

//Password Broker Facade
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{	
	//Seller redirect path
    protected $redirectTo = '/institution/home';

    //trait for handling reset Password
    use ResetsPasswords;

    //Show form to institution where they can reset password
    public function showResetForm(Request $request, $token = null)
    {
        return view('institution.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    //returns Password broker of institution
    public function broker()
    {
        return Password::broker('institutions');
    }

    //returns authentication guard of institution
    protected function guard()
    {
        return Auth::guard('web_institution');
    }
}
