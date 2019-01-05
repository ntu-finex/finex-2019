<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function showLogin(){
        return view("login.create");
    }

    public function doLogin(){

        $this->validate(request(),[
            'teamName' => 'required',
            'password' => 'required'
        ]);

        $credentials = array(
            'teamName' => request('teamName'),
            'password' => request('password')
        );


        if(auth()->attempt($credentials) == false){


            return back()->withErrors([
                'message' => 'The email or password is incorrect, please try again'
            ]);
        }


        return redirect()->to('/registration');
    }

    public function doLogout(){
        auth()->logout();

        return redirect()->to('/login');
    }
}
