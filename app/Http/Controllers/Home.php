<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Home extends Controller
{
    public function get()
    {
      return view('index', [
        'title' => 'Home',
        'documentation' => false
      ]);
    }
}
