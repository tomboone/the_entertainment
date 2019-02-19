<?php

namespace Drupal\the_entertainment_reviews\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Entertainment review entities.
 *
 * @ingroup the_entertainment_reviews
 */
interface EntertainmentReviewEntityInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Entertainment review name.
   *
   * @return string
   *   Name of the Entertainment review.
   */
  public function getName();

  /**
   * Sets the Entertainment review name.
   *
   * @param string $name
   *   The Entertainment review name.
   *
   * @return \Drupal\the_entertainment_reviews\Entity\EntertainmentReviewEntityInterface
   *   The called Entertainment review entity.
   */
  public function setName($name);

  /**
   * Gets the Entertainment review creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Entertainment review.
   */
  public function getCreatedTime();

  /**
   * Sets the Entertainment review creation timestamp.
   *
   * @param int $timestamp
   *   The Entertainment review creation timestamp.
   *
   * @return \Drupal\the_entertainment_reviews\Entity\EntertainmentReviewEntityInterface
   *   The called Entertainment review entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Entertainment review published status indicator.
   *
   * Unpublished Entertainment review are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Entertainment review is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Entertainment review.
   *
   * @param bool $published
   *   TRUE to set this Entertainment review to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\the_entertainment_reviews\Entity\EntertainmentReviewEntityInterface
   *   The called Entertainment review entity.
   */
  public function setPublished($published);

  /**
   * Gets the Entertainment review revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Entertainment review revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\the_entertainment_reviews\Entity\EntertainmentReviewEntityInterface
   *   The called Entertainment review entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Entertainment review revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Entertainment review revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\the_entertainment_reviews\Entity\EntertainmentReviewEntityInterface
   *   The called Entertainment review entity.
   */
  public function setRevisionUserId($uid);

}
