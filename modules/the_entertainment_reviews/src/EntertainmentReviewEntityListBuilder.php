<?php

namespace Drupal\the_entertainment_reviews;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Entertainment review entities.
 *
 * @ingroup the_entertainment_reviews
 */
class EntertainmentReviewEntityListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Entertainment review ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\the_entertainment_reviews\Entity\EntertainmentReviewEntity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.entertainment_review.edit_form',
      ['entertainment_review' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
