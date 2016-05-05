<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lib\Page;

use App\Http\Requests;

class Home extends Controller
{
    public function get(Request $request)
    {
      $page = new Page($request->path());
      return view('index', [
        'page'    => $page
      ]);
    }
}
