<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function registration(){
      $title = "Welcome to Financial Expedition.";
      //return view("pages.registration", compact('title')); either way are fine!
      return view("pages.registration")->with('title',$title);
    }
}
