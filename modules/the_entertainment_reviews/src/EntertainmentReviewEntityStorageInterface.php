<?php

namespace Drupal\the_entertainment_reviews;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface EntertainmentReviewEntityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Entertainment review revision IDs for a specific Entertainment review.
   *
   * @param \Drupal\the_entertainment_reviews\Entity\EntertainmentReviewEntityInterface $entity
   *   The Entertainment review entity.
   *
   * @return int[]
   *   Entertainment review revision IDs (in ascending order).
   */
  public function revisionIds(EntertainmentReviewEntityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Entertainment review author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Entertainment review revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\the_entertainment_reviews\Entity\EntertainmentReviewEntityInterface $entity
   *   The Entertainment review entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(EntertainmentReviewEntityInterface $entity);

  /**
   * Unsets the language for all Entertainment review with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
