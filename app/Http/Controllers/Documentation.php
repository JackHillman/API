<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Lib\RequestType;
use App\Http\Requests;

class Documentation extends Controller
{

  private static function get_requests($path)
  {
    $paths = parent::get_subfolders($path);
    $requests = array();
    foreach ($paths as $path) {
      $request = new RequestType($path);
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
    $desc = parent::create_description($apiPath);
    $subnav = self::get_subnav($requests);
    $breadcrumbs = parent::create_breadcrumbs($apiPath);

    return view('documentation', [
      'title'         => ucfirst($api),
      'description'   => $desc,
      'subnav'        => $subnav,
      'breadcrumbs'   => $breadcrumbs,
      'requests'      => $requests,
    ]);
  }
}
