<?php


/**
 * Generates the style_library_entity type editing form.
 */
function style_library_entity_type_form($form, &$form_state, $style_library_entity_type, $op = 'edit') {

  if ($op == 'clone') {
    $style_library_entity_type->label .= ' (cloned)';
    $style_library_entity_type->type = '';
  }

  $form['label'] = array(
    '#title' => t('Label'),
    '#type' => 'textfield',
    '#default_value' => $style_library_entity_type->label,
    '#description' => t('The human-readable name of this Style Library type.'),
    '#required' => TRUE,
    '#size' => 30,
  );
  // Machine-readable type name.
  $form['type'] = array(
    '#type' => 'machine_name',
    '#default_value' => isset($style_library_entity_type->type) ? $style_library_entity_type->type : '',
    '#maxlength' => 32,
//    '#disabled' => $style_library_entity_type->isLocked() && $op != 'clone',
    '#machine_name' => array(
      'exists' => 'style_library_entity_get_types',
      'source' => array('label'),
    ),
    '#description' => t('A unique machine-readable name for this Style Library type. It must only contain lowercase letters, numbers, and underscores.'),
  );

  $form['data']['#tree'] = TRUE;

  $form['actions'] = array('#type' => 'actions');
  $form['actions']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save Style Library type'),
    '#weight' => 40,
  );


  return $form;
}

/**
 * Form API submit callback for the type form.
 */
function style_library_entity_type_form_submit(&$form, &$form_state) {
  $style_library_entity_type = entity_ui_form_submit_build_entity($form, $form_state);
  $style_library_entity_type->save();
  $form_state['redirect'] = 'admin/appearance/style-library-entity/types';
}

/**
 * Form API submit callback for the delete button.
 */
function style_library_entity_type_form_submit_delete(&$form, &$form_state) {
  $form_state['redirect'] = 'admin/appearance/style-library-entity/types/manage/' . $form_state['style_library_entity_type']->type . '/delete';
}
