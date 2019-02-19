<?php

namespace Drupal\the_entertainment;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\the_entertainment\Entity\EntertainmentEntityInterface;

/**
 * Defines the storage handler class for Entertainment entities.
 *
 * This extends the base storage class, adding required special handling for
 * Entertainment entities.
 *
 * @ingroup the_entertainment
 */
class EntertainmentEntityStorage extends SqlContentEntityStorage implements EntertainmentEntityStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(EntertainmentEntityInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {entertainment_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {entertainment_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(EntertainmentEntityInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {entertainment_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('entertainment_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
