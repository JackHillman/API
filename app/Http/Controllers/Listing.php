<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Lib\API;

class Listing extends Controller
{
  private $breadcrumbs;
  private $desc;
  private $apis;

  public function get(Request $request, $route)
  {
    $path = base_path();
    $routePath = $path . '/api/' . $route . '/';
    $this->breadcrumbs = parent::create_breadcrumbs($routePath, 1);
    $this->desc = parent::create_description($routePath);
    $this->apis = $this->get_apis($routePath);

    return view('listing', [
      'title'         =>  ucfirst($route),
      'breadcrumbs'   => $this->breadcrumbs,
      'description'   => $this->desc,
      'apis'          => $this->apis,
    ]);
  }

  private function get_apis($path)
  {
    $apis;
    $paths = parent::get_subfolders($path);

    foreach ( $paths as $api_path ) {
      $apis[] = new API($api_path);
    }

    return $apis;
  }
}
