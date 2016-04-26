<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Listing extends Controller
{
  public function get(Request $request, $route)
  {


    return view('listing', [
      
    ]);
  }
}
