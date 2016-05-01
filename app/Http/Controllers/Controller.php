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

    private static function fix_path($path)
    {
      $path .= (substr($path, -1) != '/') ? '/' : '';
      return $path;
    }

    public static function get_title($string)
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

    public static function get_handle($string)
    {
      return strtolower(preg_replace('/[^\w+]/', '', $string));
    }

    public static function get_url($path, $items=2)
    {
      $path = preg_split('/[\/\\\]/', $path);
      foreach ( $path as $key=>$item ) {
        if ( ! $item ) {
          unset($path[$key]);
        }
      }
      $path = array_splice($path, -$items, $items);

      return $path;
    }

    public static function create_breadcrumbs($links, $items=2)
    {
      $formatted_links = array();
      $temp_array = array();
      $len;
      $links = self::get_url($links, $items);

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

    public static function create_subnav($links)
    {
      $formatted_links = array();

      foreach($links as $link) {
        $formatted_links[] = strtoupper($link['title']);
      }

      return $formatted_links;
    }

    public static function create_description($path, $file='description.md')
    {
      $path = self::fix_path($path);

      $desc = $path . $file;
      if (file_exists($desc)) {
        $parsedown = new \Parsedown();
        $desc = file_get_contents($desc);
        $desc = $parsedown->text($desc);
      } else { return null; }
      return $desc;
    }

    public static function get_subfolders($path)
    {
      $path = self::fix_path($path);
      return glob($path . '*', GLOB_ONLYDIR);
    }

    public static function get_all_subfolders($path)
    {
      $folders = self::get_subfolders($path);
      foreach ($folders as $folder) {
        $folders[] = self::get_all_subfolders($folder);
      }
      return $folders;
    }
}
