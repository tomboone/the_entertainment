<?php

/**
 * @file
 * Contains entertainment_review.page.inc.
 *
 * Page callback for Entertainment review entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Entertainment review templates.
 *
 * Default template: entertainment_review.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_entertainment_review(array &$variables) {
  // Fetch EntertainmentReviewEntity Entity Object.
  $entertainment_review = $variables['elements']['#entertainment_review'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
