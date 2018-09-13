<?php

/**
 * Settings Form
 *
 * @param $form
 * @param $form_state
 *
 * @return array
 */
function style_library_entity_settings_form($form, $form_state) {
  drupal_set_title(t('Style Library Entity Settings'));

  $settings = variable_get('style_library_entity_settings', array());

  $form = array();

  $form['general'] = array(
    '#type' => 'fieldset',
    '#title' => t('Style Library Entity Settings'),
    '#collapsible' => FALSE,
    '#collapsed' => FALSE,
  );

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save Configuration Settings'),
  );


  return $form;
}

/**
 * Submit callback function, save settings
 *
 * @param $form
 * @param $form_state
 */
function style_library_entity_settings_form_submit($form, $form_state) {
  $settings = array();

  variable_set('style_library_entity_settings', $settings);

  drupal_set_message('Configuration settings were saved.', 'info');
}
