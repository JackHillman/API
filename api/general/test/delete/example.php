<?php

namespace App\Lib;

class Result
{
  public $search_term;
  public $result_term;
  public $url;
  public $weights;
  public $result_type;
  protected $term_array = array();

  /**
   * @param string $path    : Define path of potential search result
   * @param string $term    : Define search term
   */
  public function __construct($path, $search_term)
  {
    $path = str_replace('\\', '/', $path);
    $path = explode('/', $path);
    $this->term_array = self::clear_empty_array_elements($path);
    $this->build_terms($search_term);
    $this->weights = new Weights($this->search_term, $this->result_term);
  }

  /**
   * Build terms related to search result, also
   * build type of search, name of result, category &
   * url.
   *
   * @param string $term    : Search term (from constructor)
   *
   * @todo Return description from file.
   */
  protected function build_terms($search_term)
  {
    $array_end = count($this->term_array);
    $api;
    $category;
    $path;

    if ($array_end > 1) {
      $category = $this->term_array[$array_end - 1];
      $api = $this->term_array[$array_end];
      $this->result_type = 'api';
    } else {
      $category = $this->term_array[$array_end];
      $this->result_type = 'category';
    }

    $this->result_term = $api ?? $category;
    $this->url = $this->get_url();
    $this->result_term = strtolower(preg_replace('/[^A-Za-z0-9 ]/', '', $this->result_term));
    $this->search_term = strtolower(preg_replace('/[^A-Za-z0-9 ]/', '', $search_term));
  }



  /**
   * Get URL for path helper function
   *
   *  @return string $path    : URL of current result
   */
  protected function get_url() {
    $array_end = count($this->term_array);

    if ( $this->result_type == 'api' ) {
      $path = '/' . $this->term_array[$array_end-1] . '/' . $this->term_array[$array_end] . '/';
    } elseif ( $this->result_type == 'category' ) {
      $path = '/' . $this->term_array[$array_end] . '/';
    }
    return $path;
  }

  private static function clear_empty_array_elements($array)
  {
    foreach ( $array as $key=>$item ) {
      if ( ! $item ) {
        unset($array[$key]);
      }
    }
    return $array;
  }
}
