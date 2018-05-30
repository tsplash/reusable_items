<?php

namespace Drupal\reusable_items;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
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
class ReusableItemStorage extends SqlContentEntityStorage implements ReusableItemStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(ReusableItemInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {reusable_item_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {reusable_item_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(ReusableItemInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {reusable_item_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('reusable_item_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
