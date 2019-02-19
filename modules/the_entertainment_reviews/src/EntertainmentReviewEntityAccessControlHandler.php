<?php

namespace Drupal\the_entertainment_reviews;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Entertainment review entity.
 *
 * @see \Drupal\the_entertainment_reviews\Entity\EntertainmentReviewEntity.
 */
class EntertainmentReviewEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\the_entertainment_reviews\Entity\EntertainmentReviewEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished entertainment review entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published entertainment review entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit entertainment review entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete entertainment review entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add entertainment review entities');
  }

}
