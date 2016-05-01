<?php

namespace App\Lib;

class RequestType
{
  public $type;
  public $path;
  public $params;
  public $examples;
  public $endpoint;

  private static $order = array(
    'GET'     =>  0,
    'POST'    =>  1,
    'PUT'     =>  2,
    'DELETE'  =>  3,
  );

  public function __construct($path)
  {
    $this->type = strtoupper(basename($path));
    $this->path = $path.'/';
    $this->params = $this->get_params();
  }

  public function get_examples()
  {
    $path = glob($this->path . '*example*.*');
    $examples = array();

    foreach ($path as $example) {
      $filetype = new \SplFileInfo($example);
      $filetype = $filetype->getExtension();
      $ex = array();
      $ex['type'] = $filetype;
      $ex['example'] = htmlentities(file_get_contents($example));
      $examples[] = $ex;
    }
    $this->examples = $examples;
    return $examples;
  }

  protected function get_params()
  {
    if ( file_exists($this->path) ) {
      $path = file_get_contents($this->path . 'params.json');
      return json_decode($path, true)['params'];
    }
  }

  public static function sort_requests($request_array) {
    usort($request_array, function($a, $b) {
      $a_order = self::$order[$a->type];
      $b_order = self::$order[$b->type];

      return $a_order <=> $b_order;
    });
    return $request_array;
  }
}
