<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Documentation extends Controller
{
    public function get(Request $request, $route, $api=null)
    {
      $path = base_path();
      $thisPath = $path . '/api/' . $request . '/';
      $thisPath .= ($api) ? $api . '/' : '';

      $desc = $thisPath . '/description.html';
      $example = glob($thisPath . '/example.*')[0];

      $desc = (file_exists($desc)) ? file_get_contents($desc) : null;
      $example = (file_exists($example)) ? file_get_contents($example) : null;

      $listing = false;
      $endpoint = ($api) ? '/'.$route.'/'.$api : null;
      $example = array(
            'return' => ''
      );

      return view('documentation', [
        'title'         => ucfirst(($api) ?: $route),
        'documentation' => true,
        'isapi'         => ($api) ? true : false,
        'route'         => $route,
        'listing'       => ($api) ? false : true,

        'content'       => 'Test content',
        'request'       => strtoupper('GET'),
        'endpoint'      => strtoupper($endpoint),

        'parameters'    => array(
          [
            'optional'  => true,
            'title'     =>  'Item One',
            'desc'      =>  'This is a description',
            'type'      =>  'String'
          ]
        ),

        'api_list'  => array(
          [
            'link'  => '/',
            'title' => 'Test'
          ]
        ),

        'example' => $example

      ]);
    }
}
