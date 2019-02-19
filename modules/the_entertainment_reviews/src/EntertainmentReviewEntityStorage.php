<?php

namespace Drupal\the_entertainment_reviews;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\the_entertainment_reviews\Entity\EntertainmentReviewEntityInterface;

/**
 * Defines the storage handler class for Entertainment review entities.
 *
 * This extends the base storage class, adding required special handling for
 * Entertainment review entities.
 *
 * @ingroup the_entertainment_reviews
 */
class EntertainmentReviewEntityStorage extends SqlContentEntityStorage implements EntertainmentReviewEntityStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(EntertainmentReviewEntityInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {entertainment_review_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {entertainment_review_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(EntertainmentReviewEntityInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {entertainment_review_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('entertainment_review_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
