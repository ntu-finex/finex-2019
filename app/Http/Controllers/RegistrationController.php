<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function create(){
        return view("registration.create");
    }

    public function store(){
        $this->validate(request(),[
            'teamName' => 'required|between:3,20|unique:users,teamName',
            'emailOne' => 'required|email|unique:users,emailOne',
            'emailTwo' => 'nullable|email',
            'emailThree'=> 'nullable|email',
            'contactNumber'=>'required|numeric|unique:users,contactNumber',
            'password' => 'required|alphaNum|min:8|confirmed'
        ]);

        try{
            User::create(request(['teamName','emailOne','emailTwo','emailThree','contactNumber','password']));
        }catch(\Exception $e){
            return $e->getMessage();
        }

        //auth()->login($user);
        return redirect()->to('/login');
    }
}
