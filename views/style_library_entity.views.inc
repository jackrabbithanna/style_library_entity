<?php

/**
 * Implements hook_views_default_views().
 */
function style_library_entity_views_default_views() {
  $view = new view();
  $view->name = 'style_library_entity_overview';
  $view->description = '';
  $view->tag = 'default';
  $view->base_table = 'style_library_entity';
  $view->human_name = 'Style Library Entities';
  $view->core = 7;
  $view->api_version = '3.0';
  $view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */

  /* Display: Master */
  $handler = $view->new_display('default', 'Master', 'default');
  $handler->display->display_options['use_more_always'] = FALSE;
  $handler->display->display_options['access']['type'] = 'perm';
  $handler->display->display_options['access']['perm'] = 'administer style library entity';
  $handler->display->display_options['cache']['type'] = 'none';
  $handler->display->display_options['query']['type'] = 'views_query';
  $handler->display->display_options['exposed_form']['type'] = 'basic';
  $handler->display->display_options['pager']['type'] = 'full';
  $handler->display->display_options['style_plugin'] = 'table';
  $handler->display->display_options['style_options']['columns'] = array(
    'slid' => 'slid',
  );
  $handler->display->display_options['style_options']['default'] = '-1';
  $handler->display->display_options['style_options']['info'] = array(
    'slid' => array(
      'sortable' => 0,
      'default_sort_order' => 'asc',
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
  );
  /* Field: Style Library Entity: slid */
  $handler->display->display_options['fields']['slid']['id'] = 'slid';
  $handler->display->display_options['fields']['slid']['table'] = 'style_library_entity';
  $handler->display->display_options['fields']['slid']['field'] = 'slid';
  /* Field: Style Library Entity: Name */
  $handler->display->display_options['fields']['name']['id'] = 'name';
  $handler->display->display_options['fields']['name']['table'] = 'style_library_entity';
  $handler->display->display_options['fields']['name']['field'] = 'name';
  /* Field: Style Library Entity: Extension Type */
  $handler->display->display_options['fields']['extension_type']['id'] = 'extension_type';
  $handler->display->display_options['fields']['extension_type']['table'] = 'style_library_entity';
  $handler->display->display_options['fields']['extension_type']['field'] = 'extension_type';
  /* Field: Style Library Entity: Enabled */
  $handler->display->display_options['fields']['enabled']['id'] = 'enabled';
  $handler->display->display_options['fields']['enabled']['table'] = 'style_library_entity';
  $handler->display->display_options['fields']['enabled']['field'] = 'enabled';
  $handler->display->display_options['fields']['enabled']['separator'] = '';
  /* Field: Style Library Entity: Operations links */
  $handler->display->display_options['fields']['operations']['id'] = 'operations';
  $handler->display->display_options['fields']['operations']['table'] = 'style_library_entity';
  $handler->display->display_options['fields']['operations']['field'] = 'operations';


  $views[$view->name] = $view;
  return $views;
}
