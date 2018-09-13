<?php

/**
 * This field handler aggregates operations that can be done on a entity
 * under a single field providing a more flexible way to present them in a view
 */

/**
 * Class style_library_entity_handler_operations_field
 */
class style_library_entity_handler_operations_field extends views_handler_field {
  function construct() {
    parent::construct();
    $this->additional_fields['slid'] = 'slid';
  }

  function query() {
    $this->ensure_my_table();
    $this->add_additional_fields();
  }

  function render($values) {
    $id = $this->get_value($values, 'slid');
    $return_path = request_path();
    $links = array ();
    
    if(user_access('view style library entity records')) {
      $links[] =  array('title' => 'View', 'href' => 'admin/appearance/style-library-entity/style-library/' . $id,);
    }
    if(user_access('edit style library entity records')) {
      $links[] =  array('title' => 'Edit', 'href' => 'admin/appearance/style-library-entity/style-library/' . $id . '/edit', 'query' => array('destination' => $return_path));
    }
    if(user_access('delete style library entity records')) {
      $links[] =  array('title' => 'Delete', 'href' => 'admin/appearance/style-library-entity/style-library/' . $id . '/delete', 'query' => array('destination' => $return_path));
    }
    
    
    if (!empty($links)) {
      return theme('links', array('links' => $links, 'attributes' => array('class' => array('links', 'inline', 'operations'))));
    }
  }
}
