<?php

namespace App\Lib;

use App\Lib\API;
use App\Http\Controllers\Controller;

class Page
{
  public $uri;
  protected $uri_array;
  protected $exists;
  protected $path;
  protected $url;
  protected $type;
  protected $title;
  protected $handle;
  protected $breadcrumbs;
  protected $description;

  public function __construct(string $uri)
  {
    $this->uri = self::fix_uri($uri);
    $this->uri_array = explode('/', $this->uri);
  }

  protected static function fix_uri(string $uri)
  {
    $uri = preg_replace('/^\/|\/$/', '', $uri);
    return $uri;
  }

  protected static function get_uri_from_path(string $path)
  {
    $uri = str_replace(\Config::get('app.api_path'), '', $path);
    return self::fix_uri($uri);
  }

  public static function get_subfolders(string $path, $all=false)
  {
    $path .= (substr($path, -1) != '/') ? '/' : '';
    $path = glob($path . '*', GLOB_ONLYDIR);
    if ( $all ) {
      foreach ($path as $folder) {
        $path[] = self::get_subfolders($folder, true);
      }
      return $path;
    }
    return $path;
  }

  public function exists()
  {
    if ( isset($this->exists) ) return $this->exists;

    $this->exists = (is_dir($this->path()));
    return $this->exists;
  }

  public function url()
  {
    if ( isset($this->url) ) return $this->url;

    $this->url = $_SERVER['HTTP_HOST'] . '/' . $this->uri;
    return $this->url;
  }

  public function path()
  {
    if ( isset($this->path) ) return $this->path;
    $path;

    $path = \Config::get('app.api_path') . $this->uri;
    $path .= substr($path, -1) != '/' ? '/' : '';
    $this->path = $path;
    return $this->path;
  }

  public function type()
  {
    if ( isset($this->type) ) return $this->type;

    $uri_array = explode('/', $this->uri);
    $types = array(
      'category',
      'api'
    );

    $this->type = $types[count($uri_array)-1];
    return $this->type;
  }

  public function title()
  {
    if ( isset($this->title) ) return $this->title;

    $return = array();
    $words = preg_split('/[^\w+]/', end($this->uri_array));

    foreach($words as $word) {
      $word = ucfirst($word);
      $return[] = $word;
    }

    $this->title = implode(' ', $return);
    return $this->title;
  }

  public function handle()
  {
    if ( isset($this->handle) ) return $this->handle;
    $this->handle = strtolower(preg_replace('/[^\w+]/', '', end($this->uri_array)));
    return $this->handle;
  }

  public function breadcrumbs()
  {
    if ( isset($this->breadcrumbs) ) return $this->breadcrumbs;
    $this->breadcrumbs = array();

    $links = array();
    $breadcrumbs = $this->uri_array;

    foreach ( $breadcrumbs as $index=>$crumb ) {
      $links[] = $index == 0 ?
        '/' . $crumb . '/'
      :
        $links[$index-1] . $crumb . '/'
      ;
    }

    foreach($links as $link) {
      $this->breadcrumbs[] = new Page($link);
    }

    return $this->breadcrumbs;
  }

  public function description($file='description.md')
  {
    $desc = $this->path() . $file;
    if ( ! file_exists($desc) ) return;

    $parsedown = new \Parsedown();
    $desc = file_get_contents($desc);
    $desc = $parsedown->text($desc);

    $this->description = $desc;
    return $this->description;
  }
}
