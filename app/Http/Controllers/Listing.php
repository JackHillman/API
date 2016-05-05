<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Lib\Listing;
use App\Lib\Page;

class Listing extends Controller
{
  private $breadcrumbs;
  private $desc;
  private $apis;

  public function get(Request $request, $route)
  {
    $page = new Listing($request->path());

    return view('listing', [
      'page'          => $page,
    ]);
  }
}
