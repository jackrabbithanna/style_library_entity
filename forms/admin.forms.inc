<?php

/**
 * Generates Overview pages for Style Library Entities
 *
 * Callback for hook_menu().
 *
 * @param integer id
 *
 * @return array $content
 *
 * @see includes/StyleLibraryEntity.php
 *
 * @ingroup callbacks
 */
function style_library_entity_overview_page() {
  drupal_set_title('Style Library Entities');
  $content = views_embed_view('style_library_entity_overview','default');
  return $content;
}
