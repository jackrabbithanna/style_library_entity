<?php

/**
 * @file
 * Contains a Views field handler to take care of displaying edit links
 * as fields
 */

/**
 * Class style_library_entity_handler_edit_link_field
 */
class style_library_entity_handler_edit_link_field extends style_library_entity_handler_link_field {
  function construct() {
    parent::construct();

  }


  function render($values) {
    if (!style_library_entity_entity_access('edit')) {
      return '';
    }
    
    $text = !empty($this->options['text']) ? $this->options['text'] : t('edit');
    $id = $values->{$this->aliases['slid']};
    
    return l($text, 'admin/appearance/style-library-entity/style-library/' . $id . '/edit');
  }
}
