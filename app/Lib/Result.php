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
    $path = preg_replace('/(.*)api\//', '', $path);
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
    $this->set_url();
    $this->set_result_data();
    $this->search_term = self::format_term($search_term);
  }

  /**
   * Get URL for path helper function
   *
   *  @return string $path    : URL of current result
   */
  protected function set_url() {
    $this->url = '/' . implode('/', $this->term_array) . '/';
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

  public function is_request()
  {
    return ( $this->result_type == 'request' ) ? true : false;
  }

  private function set_result_data()
  {
    $result_term;
    $array_end = count($this->term_array) - 1;
    $term_indexes = array(
      'category',
      'api',
      'request',
    );
    $result_term = $this->term_array[2] ?? $this->term_array[1] ?? $this->term_array[0];

    $this->result_term = self::format_term($result_term);
    $this->result_type  = $term_indexes[$array_end];
  }

  private static function format_term($term)
  {
    return strtolower(preg_replace('/[^A-Za-z0-9 ]/', '', $term));
  }
}
