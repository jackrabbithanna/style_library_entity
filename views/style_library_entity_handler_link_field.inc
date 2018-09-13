<?php

/**
 * @file
 * Contains a Views field handler to take care of displaying links to style library entities
 */

/**
 * Class style_library_entity_handler_link_field
 */
class style_library_entity_handler_link_field extends views_handler_field {
  function construct() {
    parent::construct();
    $this->additional_fields['slid'] = 'slid';
  }

  function option_definition() {
    $options = parent::option_definition();

    $options['text'] = array('default' => '', 'translatable' => TRUE);

    return $options;
  }

  function options_form(&$form, &$form_state) {
    parent::options_form($form, $form_state);

    $form['text'] = array(
      '#type' => 'textfield',
      '#title' => t('Text to display'),
      '#default_value' => $this->options['text'],
    );
  }
  
  function query() {
    $this->ensure_my_table();
    $this->add_additional_fields();
  }

  function render($values) {
    $text = !empty($this->options['text']) ? $this->options['text'] : t('view');
    $id = $values->{$this->aliases['slid']};
    if(user_access('view style library entity records')) {
      return l($text, 'admin/appearance/style-library-entity/style-library/' . $id);
    }
    else {
      return '';
    }
  }
}
