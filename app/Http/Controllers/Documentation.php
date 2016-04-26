<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Lib\RequestType;
use App\Http\Requests;

class Documentation extends Controller
{

  private static function get_requests($path)
  {
    $paths = glob($path.'*', GLOB_ONLYDIR);
    $requests = array();
    foreach ($paths as $path) {
      $request = new RequestType($path, basename($path));
      $requests[] = $request;
    }
    return $requests;
  }

  private static function get_subnav($requests)
  {
    $temp_array = array();
    foreach($requests as $request) {
      $temp['link'] = $request->path;
      $temp['title'] = $request->type;
      $temp_array[] = $temp;
    }
    return parent::create_subnav($temp_array);
  }

  public function get(Request $request, $route, $api, $param=null)
  {
    $path = base_path();
    $routePath = $path . '/api/' . $route . '/';
    $apiPath = $routePath . $api . '/';

    $requests = array();
    $requests = self::get_requests($apiPath);

    $desc = $apiPath . 'description.md';
    if (file_exists($desc)) {
      $parsedown = new \Parsedown();
      $desc = file_get_contents($desc);
      $desc = $parsedown->text($desc);
    }

    $subnav = self::get_subnav($requests);
    $breadcrumbs = parent::create_breadcrumbs($apiPath);

    return view('documentation', [
      'title'         => ucfirst($api),
      'documentation' => true,
      'route'         => ucfirst($route),
      'description'   => $desc,
      'requests'      => $requests,
      'subnav'        => $subnav,
      'breadcrumbs'   => $breadcrumbs,
    ]);
  }
}
