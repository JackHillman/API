<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Documentation extends Controller
{

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

  public function get_params($path)
  {
    $path = ($path) ? file_get_contents($path . '/params.json') : null;
    if ($path) {
      return json_decode($path, true)['params'];
    }
    return false;
  }

  public function get_examples($path)
  {
    $path = ($path) ? glob($path . '*example*.*') : null;
    $examples = array();
    if ($path) {
      foreach ($path as $example) {
        $filetype = new \SplFileInfo($example);
        $filetype = $filetype->getExtension();
        $ex = array();
        $ex['type'] = $filetype;
        $ex['example'] = htmlentities(file_get_contents($example));
        $examples[] = $ex;
      }
      return $examples;
    }
    return false;
  }

  public function get(Request $request, $route, $api=null, $param=null)
  {
    $path = base_path();
    $routePath = $path . '/api/' . $route . '/';
    $apiPath = ($api) ? $routePath . $api . '/' : null;
    $thisPath = ($api) ? $apiPath : $routePath;

    $desc = $thisPath . '/description.md';
    if (file_exists($desc)) {
      $parsedown = new \Parsedown();
      $desc = file_get_contents($desc);
      $desc = $parsedown->text($desc);
    }
    $examples = $this->get_examples($apiPath);
    $params = $this->get_params($apiPath);
    $api_list = $this->get_apis($routePath);

    $apis = array();
    foreach ( $api_list as $api_ ) {
      $new_api = array();
      $new_api['path'] = $api_;
      $new_api['title'] = ucfirst(basename($api_));
      $new_api['link'] = $route . '/' . basename($api_);
      $apis[] = $new_api;
    }

    $endpoint = '/'.$route;
    if ($api) {
      $endpoint .= '/'.$api;
      if ($params) {
        $endpoint .= '/{';
        foreach ($params as $key=>$param) {
          $endpoint .= ($key > 0) ? '/' : '';
          $endpoint .= $param['id'];
        }
        $endpoint .= '}';
      }
    }

    return view('documentation', [
      'title'         => ucfirst(($api) ?: $route),
      'documentation' => true,
      'isapi'         => ($api) ? true : false,
      'route'         => $route,
      'listing'       => ($api) ? false : true,

      'content'       => $desc,
      'request'       => strtoupper('GET'),
      'endpoint'      => strtoupper($endpoint),

      'parameters'    => $params,
      'api_list'  => $apis,
      'examples' => $examples,

    ]);
  }
}
