<?php

/**
 * @file
 * Contains entertainment.page.inc.
 *
 * Page callback for Entertainment entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Entertainment templates.
 *
 * Default template: entertainment.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_entertainment(array &$variables) {
  // Fetch EntertainmentEntity Entity Object.
  $entertainment = $variables['elements']['#entertainment'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
