<?php

namespace Drupal\style_library_entity;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Style Library entities.
 *
 * @ingroup style_library_entity
 */
class StyleLibraryEntityListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Style Library ID');
    $header['type'] = $this->t('Type');
    $header['name'] = $this->t('Name');
    $header['status'] = $this->t('Enabled');
    $header['global'] = $this->t('Load Globally');
    $header['weight'] = $this->t('Weight');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\style_library_entity\Entity\StyleLibraryEntity $entity */
    $row['id'] = $entity->id();
    $row['type'] = $entity->bundle();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.style_library_entity.edit_form',
      ['style_library_entity' => $entity->id()]
    );
    $status_val = $entity->get('status')->getValue();
    $global_val = $entity->get('global')->getValue();
    $weight_val = $entity->get('weight')->getValue();
    
    $form = new \Drupal\style_library_entity\Form\StyleLibraryEnableCheckboxForm(array('id' => $row['id']));
    $EnableCheckbox = \Drupal::formBuilder()->getForm($form);
    $form = new \Drupal\style_library_entity\Form\StyleLibraryLoadGloballyCheckboxForm(array('id' => $row['id']));

    $LoadGloballyCheckbox = \Drupal::formBuilder()->getForm($form);
    $row['status'] = render($EnableCheckbox);
    $row['global'] = render($LoadGloballyCheckbox);
    $row['weight'] = $weight_val[0]['value'];
  
    $renderCache = \Drupal::service('cache.entity');
    $renderCache->deleteAll(); 
    return $row + parent::buildRow($entity);
  }
}
