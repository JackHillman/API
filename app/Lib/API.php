<?php

namespace App\Lib;

use App\Lib\Page;
use App\Lib\RequestType;

class API extends Page
{
  private $requests;

  public function __construct(string $uri)
  {
    parent::__construct($uri);
  }

  public function requests()
  {
    if ( isset($this->requests) ) return $this->requests;
    $this->requests = array();

    $requests = array();
    $paths = parent::get_subfolders($this->path());
    foreach ($paths as $path) {
      $requests[] = new RequestType($path);
    }

    $this->requests = RequestType::sort_requests($requests);
    return $this->requests;
  }
}
