<?php

namespace Drupal\reusable_items;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\reusable_items\Entity\ReusableItemInterface;

/**
 * Defines the storage handler class for Reusable item entities.
 *
 * This extends the base storage class, adding required special handling for
 * Reusable item entities.
 *
 * @ingroup reusable_items
 */
interface ReusableItemStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Reusable item revision IDs for a specific Reusable item.
   *
   * @param \Drupal\reusable_items\Entity\ReusableItemInterface $entity
   *   The Reusable item entity.
   *
   * @return int[]
   *   Reusable item revision IDs (in ascending order).
   */
  public function revisionIds(ReusableItemInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Reusable item author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Reusable item revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\reusable_items\Entity\ReusableItemInterface $entity
   *   The Reusable item entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(ReusableItemInterface $entity);

  /**
   * Unsets the language for all Reusable item with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
