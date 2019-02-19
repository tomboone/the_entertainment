<?php

namespace Drupal\the_entertainment\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Entertainment entities.
 */
class EntertainmentEntityViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
