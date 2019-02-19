<?php

namespace Drupal\the_entertainment;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Entertainment entity.
 *
 * @see \Drupal\the_entertainment\Entity\EntertainmentEntity.
 */
class EntertainmentEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\the_entertainment\Entity\EntertainmentEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished entertainment entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published entertainment entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit entertainment entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete entertainment entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add entertainment entities');
  }

}
