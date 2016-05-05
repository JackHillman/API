<?php

namespace App\Lib;

use App\Lib\Page;
use App\Lib\API;

class Listing extends Page
{
  private $apis;

  public function __construct(string $uri)
  {
    parent::__construct($uri);
  }

  public function apis()
  {
    if ( isset($this->apis) ) return $this->apis;
    $this->apis = array();

    $subfolders = self::get_subfolders($this->path());
    foreach ( $subfolders as $folder ) {
      $uri = self::get_uri_from_path($folder);
      $this->apis[] = new API($uri);
    }

    return $this->apis;
  }
}
