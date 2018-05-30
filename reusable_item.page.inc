<?php

/**
 * @file
 * Contains reusable_item.page.inc.
 *
 * Page callback for Reusable item entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Reusable item templates.
 *
 * Default template: reusable_item.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_reusable_item(array &$variables) {
  // Fetch ReusableItem Entity Object.
  $reusable_item = $variables['elements']['#reusable_item'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
