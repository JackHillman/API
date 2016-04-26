<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    private static function get_title($string)
    {
      $temp = array();
      $return = array();
      $temp = preg_split('/[^\w+]/', $string);
      foreach($temp as $string) {
        $string = ucfirst($string);
        $return[] = $string;
      }

      return implode(' ', $return);
    }

    private static function get_handle($string)
    {
      return strtolower(preg_replace('/[^\w+]/', '', $string));
    }

    protected static function create_breadcrumbs($links, $items=2)
    {
      $formatted_links = array();
      $temp_array = array();
      $len;
      $links = preg_split('/[\/\\\]/', $links);
      foreach ( $links as $key=>$item ) {
        if ( ! $item ) {
          unset($links[$key]);
        }
      }
      $links = array_splice($links, -$items, $items);

      foreach ( $links as $index=>$crumb ) {
        if ($index == 0) {
          $temp_array[] = [
            'link'  => '/' . $crumb . '/',
            'title' => $crumb,
          ];
        } else {
          $temp_array[] = [
            'link'  => $temp_array[$index-1]['link'] . $crumb . '/',
            'title' => $crumb,
          ];
        }
      }

      foreach($temp_array as $link) {
        $temp = array();
        $temp['link'] = $link['link'];
        $temp['class'] = self::get_handle($link['title']);
        $temp['title'] = self::get_title($link['title']);

        $formatted_links[] = $temp;
      }

      return $formatted_links;
    }

    protected static function create_subnav($links)
    {
      $formatted_links = array();

      foreach($links as $link) {
        $formatted_links[] = strtoupper($link['title']);
      }

      return $formatted_links;
    }
}
