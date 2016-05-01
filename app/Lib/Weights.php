<?php

namespace App\Lib;

class Weights
{
  public $entire = 0;
  public $words = 0;
  public $characters = 0;
  public $search_term;
  public $result_term;

  public function __construct($search_term, $result_term)
  {
    $this->search_term = $search_term;
    $this->result_term = $result_term;
    $this->get_weights();
  }

  /**
   * Gets search ranking (weight) from search term.
   */
  protected function get_weights()
  {
    $char_array = array_diff(str_split($this->search_term), array(' '));
    $word_array = explode(' ', $this->search_term);

    $this->characters = $this->get_array_weight($char_array);
    $this->words = $this->get_array_weight($word_array);
    $this->entire = ($this->search_term == $this->result_term) ? 1 : 0 ;
  }

  /**
   * Helper function to get count of occurances of $string in $array
   *
   * @param array $array   : Array to use to search (Search Result)
   *
   * @return int $count    : Integer number of occurences
   */
  protected function get_array_weight($array) {
    $count = 0;
    foreach ($array as $term) {
      if ( strlen($term) > 1 ) {
        if ( $term == $this->search_term ) {
          $count++;
        }
      } else {
        $count += substr_count($this->search_term, $term) ?? 0;
      }
    }
    return $count;
  }
}
