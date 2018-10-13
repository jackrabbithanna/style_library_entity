<?php

/**
 * @file
 * Defines StyleLibraryEntity entity object as well as all the associated controller objects
 */

/**
 * Represents a Style Library Entity
 */
class StyleLibraryEntity extends Entity {
  public $name;
  public $type;

  /**
   * Constructs a StyleLibraryEntity entity
   */
  public function __construct($values = array()) {
    parent::__construct($values, 'style_library_entity');
  }

  /**
   * Returns the default label for the entity
   *
   * @return string
   *   Returns the label for the entity
   */
  protected function defaultLabel() {
    return $this->name;
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

  /**
   * Returns the default URI for the entity
   *
   * @return array
   *   Returns the URI for the entity
   */
  protected function defaultUri() {
    return array('path' => 'admin/appearance/style-library-entity/style-library' . $this->slid);
  }


}

/**
 * Provides StyleLibraryEntityController for StyleLibraryEntity entities
 */
class StyleLibraryEntityController extends EntityAPIController {
  /**
   * {@inheritdoc}
   */
  public function __construct($entityType) {
    parent::__construct($entityType);
  }

  /**
   * Creates a StyleLibraryEntity entity
   *
   * @return object StyleLibraryEntity
   *   A StyleLibraryEntity entity object with default fields initialized.
   */
  public function create(array $values = array()) {
    $values += array(
      'slid' => '',
    );
    if (empty($values['is_new'])) {
      $values['is_new'] = TRUE;
    }

    $style_library_entity = parent::create($values);
    return $style_library_entity;
  }

  public function save($entity, DatabaseTransaction $transaction = NULL) {
    if (isset($entity->is_new)) {
      $entity->created = REQUEST_TIME;
    }
    $entity->updated = REQUEST_TIME;

    return parent::save($entity, $transaction);
  }


  /**
   * {@inheritdoc}
   */
  public function buildContent($entity, $view_mode = 'default', $langcode = NULL, $content = array()) {
    global $base_url;

    $entity->content = $content;
    $build = parent::buildContent($entity,$view_mode,$langcode,$content);

    // Because we're handling entity properties as display suite fields (with settings and formatter options)
    // entity properties get treated as fields!
    // we need to replace the default renderable array with the field values....

    // get the field array
    if (!empty($this->entityInfo['fieldable'])) {
      // Perform the preparation tasks if they have not been performed yet.
      // An internal flag prevents the operation from running twice.
      $key = isset($entity->{$this->idKey}) ? $entity->{$this->idKey} : NULL;
      field_attach_prepare_view($this->entityType, array($key => $entity), $view_mode);
      $entity->content = field_attach_view($this->entityType, $entity, $view_mode, $langcode);
    }
    // place the fields only content array in a temp varaible
    $temp_build = $entity->content;
    unset($entity->content);
    // now replace the default entity property theme variable arrays, with the field ones
    if (!empty($temp_build) && is_array($temp_build)) {
      foreach ($temp_build as $key => $value) {
        $build[$key] = $value;
      }
    }

    //load display suite css if layout is enabled for view mode
    static $loaded_css = array();
    if (module_exists('ds')) {
      $layout = ds_get_layout('style_library_entity', 'style_library_entity', $view_mode);

      // Add path to css file for this layout and disable block regions if necessary.
      if (isset($layout['css']) && !isset($loaded_css[$layout['path'] . '/' . $layout['layout'] . '.css'])) {
        // Register css file.
        $loaded_css[$layout['path'] . '/' . $layout['layout'] . '.css'] = TRUE;
        // Add css file.
        if (isset($layout['module']) && $layout['module'] == 'panels') {
          $build['#attached']['css'][] = $layout['path'] . '/' . $layout['panels']['css'];
        }
        else {
          $build['#attached']['css'][] = $layout['path'] . '/' . $layout['layout'] . '.css';
        }
      }
    }
    return $build;
  }
}

/**
 * Provides StyleLibraryEntityMetadataController for StyleLibraryEntity entities
 */
class StyleLibraryEntityMetadataController extends EntityDefaultMetadataController {
  /**
   * Sets property metadata information for StyleLibraryEntity entities
   * @return array $info
   *   Array of StyleLibraryEntity property metadata information
   */
  public function entityPropertyInfo() {
    $info = parent::entityPropertyInfo();
    $info[$this->type]['properties']['slid'] = array(
      'label' => t("slid"),
      'type' => 'integer',
      'description' => t("Drupal Identifier for a Style Library Entity."),
      'schema field' => 'slid',
      'widget' => 'hidden',
    );
    $info[$this->type]['properties']['type'] = array(
      'label' => t("Type"),
      'type' => 'text',
      'description' => t("Type"),
      'schema field' => 'type',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'hidden',
      'required' => TRUE,
    );
    $info[$this->type]['properties']['name'] = array(
      'label' => t("Name"),
      'type' => 'text',
      'description' => t("Name of the style library."),
      'schema field' => 'name',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'textfield',
      'required' => TRUE,
    );
    $info[$this->type]['properties']['enabled'] = array(
      'label' => t("Enabled"),
      'type' => 'integer',
      'description' => t("Check to enable the style library. Only enabled style libraries will appear in theme extension lists, and have their style applied to the theme."),
      'schema field' => 'enabled',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'checkbox',
      'required' => FALSE,
    );
    $info[$this->type]['properties']['created'] = array(
      'label' => t("Created"),
      'type' => 'date',
      'description' => t("The Unix timestamp when the entity was created."),
      'schema field' => 'created',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'hidden',
    );
    $info[$this->type]['properties']['updated'] = array(
      'label' => t("Updated"),
      'type' => 'date',
      'description' => t("The Unix timestamp when the entity was most recently saved."),
      'schema field' => 'updated',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'hidden',
    );

    return $info;
  }
}

/**
 * Provides StyleLibraryEntityUIController for StyleLibraryEntity entity
 */
class StyleLibraryEntityUIController extends EntityContentUIController {
  /**
   * Implements hook_forms().
   */
  public function hook_forms() {
    $forms = parent::hook_forms();


    return $forms;
  }

  /**
   * Implements hook_menu()
   */
  public function hook_menu() {
    $wildcard = isset($this->entityInfo['admin ui']['menu wildcard']) ? $this->entityInfo['admin ui']['menu wildcard'] : '%' . $this->entityType;

    $items['admin/appearance/style-library-entity'] = array(
      'title' => 'Style Library Entities',
      'description' => 'Provides style library entities for theme extensions',
      'page callback' => 'style_library_entity_overview_page',
      'page arguments' => array(),
      'access callback' => 'style_library_entity_entity_access',
      'access arguments' => array('admin'),
      'file' => 'admin.forms.inc',
      'file path' => drupal_get_path('module','style_library_entity') . '/forms',
      'type' => MENU_NORMAL_ITEM,
      'weight' => -11,
    );
    $items['admin/appearance/style-library-entity/overview'] = array(
      'title' => 'Overview',
      'page callback' => 'style_library_entity_overview_page',
      'page arguments' => array(),
      'access callback' => 'style_library_entity_entity_access',
      'access arguments' => array('admin'),
      'file' => 'admin.forms.inc',
      'file path' => drupal_get_path('module','style_library_entity') . '/forms',
      'type' => MENU_DEFAULT_LOCAL_TASK,
      'weight' => -11,
    );

    foreach (style_library_entity_get_types() as $type) {
      $items['admin/appearance/style-library-entity/add/' . $type->type] = [
        'title'            => 'Add ' . $type->label . ' Style Library',
        'page callback'    => 'style_library_entity_form_wrapper',
        'page arguments'   => [[], 'create', $type->type],
        'access callback'  => 'style_library_entity_entity_access',
        'access arguments' => ['create'],
        'file'             => 'crud.forms.inc',
        'file path'        => drupal_get_path('module', 'style_library_entity') . '/forms',
        'type'             => MENU_LOCAL_ACTION,
        'weight'           => -8,
      ];
    }

    $items['admin/appearance/style-library-entity/style-library/%style_library_entity_loader'] = array(
      'page callback' => 'style_library_entity_package_view',
      'page arguments' => array(4),
      'access callback' => 'style_library_entity_entity_access',
      'access arguments' => array('view', 4),
      'file' => 'crud.forms.inc',
      'file path' => drupal_get_path('module','style_library_entity') . '/forms',
    );

    $items['admin/appearance/style-library-entity/style-library/%style_library_entity_loader/view'] = array(
      'title' => 'View',
      'type' => MENU_DEFAULT_LOCAL_TASK,
      'weight' => -10,
    );

    $items['admin/appearance/style-library-entity/style-library/%/edit'] = array(
      'title' => 'Edit',
      'page callback' => 'style_library_entity_form_wrapper',
      'page arguments' => array(4,'update'),
      'access callback' => 'style_library_entity_entity_access',
      'access arguments' => array('update'),
      'type' => MENU_LOCAL_TASK,
      'context' => MENU_CONTEXT_PAGE | MENU_CONTEXT_INLINE,
      'file' => 'crud.forms.inc',
      'file path' => drupal_get_path('module','style_library_entity') . '/forms',
      'weight' => 8,
    );
    $items['admin/appearance/style-library-entity/style-library/%style_library_entity_loader/delete'] = array(
      'title' => 'Delete',
      'page callback' => 'style_library_entity_form_wrapper',
      'page arguments' => array(4, 'delete'),
      'access callback' => 'style_library_entity_entity_access',
      'access arguments' => array('delete', 1),
      'type' => MENU_LOCAL_TASK,
      'context' => MENU_CONTEXT_PAGE | MENU_CONTEXT_INLINE,
      'weight' => 11,
      'file' => 'crud.forms.inc',
      'file path' => drupal_get_path('module','style_library_entity') . '/forms',
    );

    return $items;
  }
}

/**
 * Provides StyleLibraryEntityExtraFieldsController for StyleLibraryEntity entity
 */
class StyleLibraryEntityExtraFieldsController extends EntityDefaultExtraFieldsController {
  protected $propertyInfo;

  /**
   * Implements EntityExtraFieldsControllerInterface::fieldExtraFields().
   */
  public function fieldExtraFields() {
    $extra = array();
    $this->propertyInfo = entity_get_property_info($this->entityType);
    if (isset($this->propertyInfo['properties'])) {
      foreach ($this->propertyInfo['properties'] as $name => $property_info) {
        // Skip adding the ID or bundle.
        if ($this->entityInfo['entity keys']['id'] == $name || $this->entityInfo['entity keys']['bundle'] == $name) {
          continue;
        }
        $extra[$this->entityType][$this->entityType]['display'][$name] = $this->generateExtraFieldInfo($name, $property_info);
      }
    }
    // Handle bundle properties.
    $this->propertyInfo += array('bundles' => array());
    if (isset($this->propertyInfo['bundles'])) {
      foreach ($this->propertyInfo['bundles'] as $bundle_name => $info) {
        foreach ($info['properties'] as $name => $property_info) {
          if (empty($property_info['field'])) {
            $extra[$this->entityType][$bundle_name]['display'][$name] = $this->generateExtraFieldInfo($name, $property_info);
          }
        }
      }
    }
    return $extra;
  }
}

/**
 * Provides StyleLibraryEntityDefaultViewsController for StyleLibraryEntity entities
 */
class StyleLibraryEntityDefaultViewsController extends EntityDefaultViewsController {
  /**
   * {@inheritdoc}
   */
  public function views_data() {
    $data = parent::views_data();

    $data['style_library_entity']['link'] = array(
      'field' => array(
        'title' => t('Link'),
        'help' => t('Provide a link to the style library.'),
        'handler' => 'style_library_entity_handler_link_field',
      ),
    );
    $data['style_library_entity']['edit_link'] = array(
      'field' => array(
        'title' => t('Edit Link'),
        'help' => t('Provide a link to the edit form for the style library.'),
        'handler' => 'style_library_entity_handler_edit_link_field',
      ),
    );
    $data['style_library_entity']['delete_link'] = array(
      'field' => array(
        'title' => t('Delete Link'),
        'help' => t('Provide a link to delete the style library.'),
        'handler' => 'style_library_entity_handler_delete_link_field',
      ),
    );

    // This content of this field are decided based on the menu structure that
    $data['style_library_entity']['operations'] = array(
      'field' => array(
        'title' => t('Operations links'),
        'help' => t('Display all operations available for this style library.'),
        'handler' => 'style_library_entity_handler_operations_field',
      ),
    );

    return $data;
  }

  /**
   * {@inheritdoc}
   */
  function schema_fields() {
    $data = parent::schema_fields();
    return $data;
  }

  /**
   * {@inheritdoc}
   */
  function map_from_schema_info($property_name, $schema_field_info, $property_info) {
    $return = parent::map_from_schema_info($property_name, $schema_field_info, $property_info);
    return $return;
  }
}


