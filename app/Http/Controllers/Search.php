<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lib\Result;
use App\Http\Requests;

class Search
{
  protected $search_path;
  public $search_term;
  public $results = array();

  /**
   * @param string $term              : Search term
   * @param string $path (Optional)   : Custom path to search
   *
   * @todo implement custom path search
   */
  public function __construct($term, $path=null)
  {
    $this->search_term = $term;
    $this->search_path = $path ?? base_path() . '/api/';
    $listing = $this->get_listing();
    $this->results = $this->get_results($listing);
    $this->order_results();
  }

  /**
   * Get listing of potential search results as path strings
   *
   * @return array $listing   : Array of path strings
   */
  protected function get_listing()
  {
    $listing = array();
    $cats = array_diff(scandir($this->search_path), array('.', '..'));

    foreach ( $cats as $cat ) {
      $path = '/' . $cat . '/';
      $listing[] = $path;

      $apis = array_diff(scandir($this->search_path . $path), array('.', '..'));

      foreach ( $apis as $api ) {
        $path = '/' . $cat . '/' . $api . '/';
        $listing[] = $path;
      }
    }

    return $listing;
  }

  /**
   * Sort results in descending order based on weight
   */
  protected function order_results()
  {
    usort($this->results, function($a, $b) {
      if ( $a->weights->entire == $b->weights->entire ) {
        if ( $a->weights->words == $b->weights->words ) {
          if ( $a->weights->characters == $b->weights->characters ) {
            return 0; // Return 0 if exactly the same
          } else {
            return ( $a->weights->characters > $b->weights->characters ) ? -1 : 1;
          }
        } else {
          return ( $a->weights->words > $b->weights->words ) ? -1 : 1;
        }
      } else {
        return ( $a->weights->entire > $b->weights->entire ) ? -1 : 1;
      }
    });
  }

  protected function get_results($listing)
  {
    $results = array();
    foreach ($listing as $result) {
      $result = new Result($result, $this->search_term);
      $results[] = $result;
    }
    return $results;
  }
}
