<?php

namespace App\Http\Controllers\InstitutionAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//Validator facade used in validator method
use Illuminate\Support\Facades\Validator;

//Institution Model
use App\Institution;

//Auth Facade used in guard
use Auth;

class RegisterController extends Controller
{	

	protected $redirectPath = '/home';

    //shows registration form to institution
	public function showRegistrationForm()
	{
	    return view('institution.auth.register');
	}

	//Handles registration request for institution
    public function register(Request $request)
    {

       //Validates data
        $this->validator($request->all())->validate();

       //Create institution
        $institution = $this->create($request->all());

        //Authenticates institution
        $this->guard()->login($institution);

       //Redirects institutions
        return redirect($this->redirectPath);
    }

    //Validates user's Input
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:institution',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    //Create a new institution instance after a validation.
    protected function create(array $data)
    {
        return Institution::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    //Get the guard to authenticate institution
   	protected function guard()
   	{
       return Auth::guard('web_institution');
   	}
}
