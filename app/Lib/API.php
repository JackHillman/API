<?php

namespace App\Lib;

use App\Http\Controllers\Controller;

class API
{
  private $path;
  public $url;
  public $title;
  public $description;
  public $requests;

  public function __construct($path)
  {
    $this->path = $path;
    $this->set_details();
  }

  private function set_details()
  {
    $this->set_description();
    $this->set_title();
    $this->set_url();
    $this->set_requests();
  }

  private function set_description()
  {
    $this->description = Controller::create_description($this->path);
  }

  private function set_title()
  {
    $path_array = Controller::create_breadcrumbs($this->path);
    $this->title = end($path_array)['title'];
  }

  private function set_url()
  {
    $url = Controller::get_url($this->path);
    $this->url = '/' . implode('/', $url);
  }

  private function set_requests()
  {
    $requests = array();
    $paths = Controller::get_subfolders($this->path);
    foreach ($paths as $path) {
      $requests[] = new RequestType($path);
    }
    $this->requests = RequestType::sort_requests($requests);
  }
}
