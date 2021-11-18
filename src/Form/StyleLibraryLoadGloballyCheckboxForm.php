<?php

namespace Drupal\style_library_entity\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

/**
 * Implements the StyleLibraryLoadGloballyCheckboxForm form controller.
 *
 * This example demonstrates a simple form with a single text input element. We
 * extend FormBase which is the simplest form base class used in Drupal.
 *
 * @see \Drupal\Core\Form\FormBase
 */
class StyleLibraryLoadGloballyCheckboxForm extends FormBase {

  protected $data;

  public function __construct($data)
  {
	  $this->data = $data;
  }

  public function buildForm(array $form, FormStateInterface $form_state, $id = NULL) {  
	  
	$query = \Drupal::database()->select('style_library_entity', 'sle');
	$query->fields('sle', ['id','global']);
	$query->condition('sle.id', $this->data['id']);
	$query = $query->execute();
	$style_library_entity = $query->fetchAll();
    
	$global = '';
	foreach ($style_library_entity as $data) {
    $professional_roles = array();
    $global = $data->global;
	}

	$form['rowid'] = [
    '#type' => 'hidden',
    '#value' => $this->data['id'],      
	];

  $form['globallycheckbox'] = [
    '#type' => 'checkbox',
    '#title' => 'Enable',
    '#title_display' => 'invisible',	
    '#default_value' => $global,
    '#ajax' => [
		    'callback' => '::setGloballyCheckbox',
     ],
  ];

  return $form;
  }

    /**
   * {@inheritdoc}
   */

  public function getFormId(){
    return 'style_library_load_globally_checkbox_'. $this->data['id'];
  }

 public function setGloballyCheckbox(array $form, FormStateInterface $form_state) {
    $response = new AjaxResponse(); 
    $data = $form_state->getValues();

	  \Drupal::database()->update('style_library_entity')
      ->fields(
          [
            'global' => $data['globallycheckbox'],
          ]
      )
      ->condition('id', $data['rowid'])
      ->execute();
      $renderCache = \Drupal::service('cache.entity');
      $renderCache->deleteAll(); 

    return $response;
 }


  public function validateForm(array &$form, FormStateInterface $form_state) {
    
  }


  public function submitForm(array &$form, FormStateInterface $form_state) {
    /*
     * This would normally be replaced by code that actually does something
     * with the title.
     */
  }

}
