<?php

namespace Drupal\reusable_items\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Reusable item entities.
 *
 * @ingroup reusable_items
 */
interface ReusableItemInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Reusable item name.
   *
   * @return string
   *   Name of the Reusable item.
   */
  public function getName();

  /**
   * Sets the Reusable item name.
   *
   * @param string $name
   *   The Reusable item name.
   *
   * @return \Drupal\reusable_items\Entity\ReusableItemInterface
   *   The called Reusable item entity.
   */
  public function setName($name);

  /**
   * Gets the Reusable item creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Reusable item.
   */
  public function getCreatedTime();

  /**
   * Sets the Reusable item creation timestamp.
   *
   * @param int $timestamp
   *   The Reusable item creation timestamp.
   *
   * @return \Drupal\reusable_items\Entity\ReusableItemInterface
   *   The called Reusable item entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Reusable item published status indicator.
   *
   * Unpublished Reusable item are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Reusable item is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Reusable item.
   *
   * @param bool $published
   *   TRUE to set this Reusable item to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\reusable_items\Entity\ReusableItemInterface
   *   The called Reusable item entity.
   */
  public function setPublished($published);

  /**
   * Gets the Reusable item revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Reusable item revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\reusable_items\Entity\ReusableItemInterface
   *   The called Reusable item entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Reusable item revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Reusable item revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\reusable_items\Entity\ReusableItemInterface
   *   The called Reusable item entity.
   */
  public function setRevisionUserId($uid);

}
