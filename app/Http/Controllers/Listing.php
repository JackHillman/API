<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Listing extends Controller
{
  public function get(Request $request, $route)
  {
    $path = base_path();
    $routePath = $path . '/api/' . $route . '/';
    $breadcrumbs = parent::create_breadcrumbs($routePath, 1);
    $desc = parent::create_description($routePath);

    return view('listing', [
      'title'         =>  ucfirst($route),
      'breadcrumbs'   => $breadcrumbs,
      'description'   => $desc
    ]);
  }
}
