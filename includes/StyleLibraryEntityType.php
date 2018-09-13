<?php

/**
 * @file
 * Defines StyleLibraryEntityType entity object as well as all the associated controller objects
 */

/**
 * Represents a Style Library Entity Type
 */
class StyleLibraryEntityType extends Entity {
  public $type;
  public $label;

  /**
   * Constructs a StyleLibraryEntityType entity
   */
  public function __construct($values = array()) {
    parent::__construct($values, 'style_library_entity_type');
  }

  /**
   * Returns the default label for the entity
   *
   * @return string
   *   Returns the label for the entity
   */
  protected function defaultLabel() {
    return $this->label;
  }

  /**
   * Returns the label for the entity
   *
   * @return string
   *   Returns the label for the entity
   */
  function label() {
    return $this->defaultLabel();
  }

}

/**
 * Provides StyleLibraryEntityController for StyleLibraryEntity entities
 */
class StyleLibraryEntityTypeController extends EntityAPIControllerExportable {
  /**
   * {@inheritdoc}
   */
  public function __construct($entityType) {
    parent::__construct($entityType);
  }

  /**
   * Creates a StyleLibraryEntityType entity
   *
   * @return object StyleLibraryEntityType
   *   A StyleLibraryEntityType entity object with default fields initialized.
   */
  public function create(array $values = array()) {
    $values += array(
      'id' => '',
      'is_new' => TRUE,
      'data' => '',
    );

    $style_library_entity_type = parent::create($values);
    return $style_library_entity_type;
  }
}

/**
 * StyleLibraryEntityType UI controller.
 */
class StyleLibraryEntityTypeUIController extends EntityDefaultUIController {

  /**
   * Overrides hook_menu() defaults.
   */
  public function hook_menu() {
    $items = parent::hook_menu();
    $items[$this->path]['description'] = 'Manage Style Library Entity types, including adding and removing fields and the display of fields.';
    return $items;
  }
}