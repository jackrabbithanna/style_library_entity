<?php

/**
 * @file
 * Contains a Views field handler to take care of displaying deletes links
 * as fields
 */


class style_library_entity_handler_delete_link_field extends style_library_entity_handler_link_field {
  function construct() {
    parent::construct();
  }


  function render($values) {

    if (!style_library_entity_entity_access('delete')) {
      return '';
    }
    
    $text = !empty($this->options['text']) ? $this->options['text'] : t('delete');
    $id = $values->{$this->aliases['slid']};
    
    return l($text, 'admin/appearance/style-library-entity/style-library/' . $id . '/delete');
  }
}
