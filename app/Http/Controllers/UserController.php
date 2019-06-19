<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use Redirect;
use Auth;

class UserController extends Controller
{
    public function create(Request $request)
    {

    	$rules = [
        	'email' => 'email|required|unique:users',
            'name'=>'required',
            'password'=>'required|max:8|min:6',
            'confirm_password'=>'required|same:password'     
   		];        
      	$validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('/register')->withErrors($validator->errors())->withInput();
        }
    	$user = new User();
    	$user->name = $request->name;		
		$user->email = $request->email;
		$user->password = bcrypt($request->password);
		$user->save();
    	return $user;
	}
	public function doLogin(Request $request)
	{	
		$rules = [
        	'email' => 'email|required',
            'password'=>'required|min:6',    
   		];     
   		$user = [
            'email' => $request->email,
            'password' => $request->password,
        ];   
      	$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
            return redirect('/login')->withErrors($validator->errors())->withInput();
        }
        if (Auth::attempt($user)) {
	        return redirect('/home');

	    }      
	}
	public function doLogout()
    {
        Auth::logout();
        return Redirect::to('login');
    }
}
