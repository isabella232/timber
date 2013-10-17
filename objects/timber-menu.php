<?php

class TimberMenu extends TimberCore
{

  var $items = null;

  function __construct($slug)
  {
    //$menu = wp_get_nav_menu_object($slug);
    $locations = get_nav_menu_locations();
    if (isset($locations[$slug])) {
      $menu = wp_get_nav_menu_object($locations[$slug]);
      $menu = wp_get_nav_menu_items($menu);
      $menu = self::order_children($menu);
      $this->items = $menu;
    }
    return null;
  }

  function order_children($items)
  {
    $menu = array();

    if(is_array($items)) {
      $index = array();
      foreach($items as $item) {
        $index[$item->ID] = new TimberMenuItem($item);
      }

      foreach($index as $item) {
        if($item->menu_item_parent) {
          $index[$item->menu_item_parent]->add_child($item);
        } else {
          $menu[] = $item;
        }
      }
    }

    return $menu;
  }

  function get_items()
  {
    if (is_array($this->items)) {
      return $this->items;
    }
    return array();
  }
}

class TimberMenuItem extends TimberCore
{

  var $children;

  function __construct($data)
  {
    $this->import($data);
  }

  function get_link()
  {
    return $this->get_path();
  }

  function name()
  {
    return $this->post_title;
  }

  function slug()
  {
    return $this->post_name;
  }

  function get_path()
  {
    return $this->url_to_path($this->url);
  }

  function add_child($item)
  {
    if (!isset($this->children)) {
      $this->children = array();
    }
    $this->children[] = $item;
  }

  function get_children()
  {
    if (isset($this->children)) {
      return $this->children;
    }
    return false;
  }
}