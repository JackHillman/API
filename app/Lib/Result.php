<?php

namespace App\Lib;

class Result
{
  public $name;
  public $url;
  public $term;
  public $weight = array();
  public $result_type;
  protected $term_array = array();

  /**
   * @param string $path    : Define path of potential search result
   * @param string $term    : Define search term
   */
  public function __construct($path, $term)
  {
    $path = str_replace('\\', '/', $path);
    $path = explode('/', $path);

    foreach ( $path as $key=>$item ) {
      if ( ! $item ) {
        unset($path[$key]);
      }
    }

    $this->term_array = $path;

    $this->build_terms($term);
    $this->get_weight();

    // var_dump($this);
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
  protected function build_terms($term)
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

    $this->name = $api ?: $category;
    $this->url = $this->get_url();
    $this->name = strtolower(preg_replace('/[^A-Za-z0-9 ]/', '', $this->name));
    $this->term = strtolower(preg_replace('/[^A-Za-z0-9 ]/', '', $term));
  }

  /**
   * Gets search ranking (weight) from search term.
   *
   * Search weights are returned as array. As follows:
   * [
   *  ['entire'] => int           : Is term exactly result
   *  ['string'] => int           : Occurances of complete words
   *  ['character'] => int        : Occurances of charaters in string
   * ]
   */
  protected function get_weight()
  {
    $char_array = array_diff(str_split($this->term), array(' '));
    $string_array = explode(' ', $this->term);
    $this->weight = $this->get_weights($this->term, $this->name, $string_array, $char_array);
  }

  /**
   * Helper function to get count of occurances of $string in $array
   *
   * @param array $array   : Array to use to search (Search Result)
   * @param string $string : String to search through (Search Term)
   *
   * @return int $count    : Integer of number of occurences
   */
  protected function get_array_weight($array, $string) {
    $count = 0;
    foreach ($array as $term) {
      if ( strlen($term) > 1 ) {
        if ( $term == $string ) {
          $count++;
        }
      } else {
        $count += substr_count($string, $term) ?? 0;
      }
    }
    return $count;
  }

  /**
   * Get weights from search term/result combo
   *
   * Search weights are returned as follows:
   * [
   *  ['entire'] => int           : Is term exactly result
   *  ['string'] => int           : Occurances of complete words
   *  ['character'] => int        : Occurances of charaters in string
   * ]
   *
   * @param string $search_term           : Term being search for
   * @param string $search_string         : Search result term
   * @param array $search_string_array    : Array of string in search
   * @param array $search_char_array      : Array of chars in search
   *
   * @return Array $weights
   */
  protected function get_weights($search_term, $search_string, $search_string_array, $search_char_array)
  {
    $weights = array();

    $weights['character'] = $this->get_array_weight($search_char_array, $search_string);
    $weights['string'] = $this->get_array_weight($search_string_array, $search_string);
    $weights['entire'] = ($search_term == $search_string) ? 1 : 0 ;

    return $weights;
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
}
