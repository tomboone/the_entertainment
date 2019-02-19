<?php

namespace Drupal\the_entertainment;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface EntertainmentEntityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Entertainment revision IDs for a specific Entertainment.
   *
   * @param \Drupal\the_entertainment\Entity\EntertainmentEntityInterface $entity
   *   The Entertainment entity.
   *
   * @return int[]
   *   Entertainment revision IDs (in ascending order).
   */
  public function revisionIds(EntertainmentEntityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Entertainment author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Entertainment revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\the_entertainment\Entity\EntertainmentEntityInterface $entity
   *   The Entertainment entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(EntertainmentEntityInterface $entity);

  /**
   * Unsets the language for all Entertainment with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
