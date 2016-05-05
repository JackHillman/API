<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Lib\RequestType;
use App\Lib\Page;
use App\Http\Requests;

class Documentation extends Controller
{

  private static function get_requests($path)
  {
    $paths = Page::get_subfolders($path);
    $requests = array();
    foreach ($paths as $path) {
      $request = new RequestType($path);
      $requests[] = $request;
    }
    return RequestType::sort_requests($requests);
  }

  private static function create_subnav($links)
  {
    $formatted_links = array();

    foreach($links as $link) {
      $formatted_links[] = strtoupper($link['title']);
    }

    return $formatted_links;
  }

  private static function get_subnav($requests)
  {
    $temp_array = array();
    foreach($requests as $request) {
      $temp['link'] = $request->path;
      $temp['title'] = $request->type;
      $temp_array[] = $temp;
    }
    return self::create_subnav($temp_array);
  }

  public function get(Request $request, $route, $api, $param=null)
  {
    $page = new Page($request->path());
    $requests = array();
    $requests = self::get_requests($page->path());
    $subnav = self::get_subnav($requests);

    return view('documentation', [
      'page'          => $page,
      'subnav'        => $subnav,
      'requests'      => $requests,
    ]);
  }
}
