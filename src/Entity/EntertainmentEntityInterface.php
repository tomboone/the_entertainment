<?php

namespace Drupal\the_entertainment\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Entertainment entities.
 *
 * @ingroup the_entertainment
 */
interface EntertainmentEntityInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Entertainment name.
   *
   * @return string
   *   Name of the Entertainment.
   */
  public function getName();

  /**
   * Sets the Entertainment name.
   *
   * @param string $name
   *   The Entertainment name.
   *
   * @return \Drupal\the_entertainment\Entity\EntertainmentEntityInterface
   *   The called Entertainment entity.
   */
  public function setName($name);

  /**
   * Gets the Entertainment creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Entertainment.
   */
  public function getCreatedTime();

  /**
   * Sets the Entertainment creation timestamp.
   *
   * @param int $timestamp
   *   The Entertainment creation timestamp.
   *
   * @return \Drupal\the_entertainment\Entity\EntertainmentEntityInterface
   *   The called Entertainment entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Entertainment published status indicator.
   *
   * Unpublished Entertainment are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Entertainment is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Entertainment.
   *
   * @param bool $published
   *   TRUE to set this Entertainment to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\the_entertainment\Entity\EntertainmentEntityInterface
   *   The called Entertainment entity.
   */
  public function setPublished($published);

  /**
   * Gets the Entertainment revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Entertainment revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\the_entertainment\Entity\EntertainmentEntityInterface
   *   The called Entertainment entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Entertainment revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Entertainment revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\the_entertainment\Entity\EntertainmentEntityInterface
   *   The called Entertainment entity.
   */
  public function setRevisionUserId($uid);

}
