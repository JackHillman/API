<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class Documentation extends Controller
{

  public function get_requests($path)
  {
    $paths = glob($path.'*', GLOB_ONLYDIR);
    $requests = array();
    foreach ($paths as $path) {
      $request = new RequestType($path, basename($path));
      $requests[] = $request;
    }
    return $requests;
  }

  public function get_apis($path)
  {
    $path = glob($path . '*', GLOB_ONLYDIR);
    if ($path) {
      $apis = array();
      foreach ($path as $dir) {
        $apis[] = $dir;
      }
      return $apis;
    }
    return false;
  }

  public function get(Request $request, $route, $api=null, $param=null)
  {
    $path = base_path();
    $routePath = $path . '/api/' . $route . '/';
    $apiPath = ($api) ? $routePath . $api . '/' : null;
    $thisPath = ($api) ? $apiPath : $routePath;

    $requests = array();

    if ($api) {
      $requests = $this->get_requests($apiPath);
    }

    $desc = $thisPath . 'description.md';
    if (file_exists($desc)) {
      $parsedown = new \Parsedown();
      $desc = file_get_contents($desc);
      $desc = $parsedown->text($desc);
    }

    $api_list = $this->get_apis($routePath);
    $apis = array();
    foreach ( $api_list as $api_ ) {
      $new_api = array();
      $new_api['path'] = $api_;
      $new_api['title'] = ucfirst(basename($api_));
      $new_api['link'] = $route . '/' . basename($api_);
      $apis[] = $new_api;
    }

    return view('documentation', [
      'title'         => ucfirst(($api) ?: $route),
      'documentation' => true,
      'isapi'         => ($api) ? true : false,
      'route'         => ucfirst($route),
      'listing'       => ($api) ? false : true,

      'content'       => $desc,
      'api_list'      => $apis,

      'requests'      => $requests

    ]);
  }
}
