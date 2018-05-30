<?php

namespace Drupal\reusable_items;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Reusable item entity.
 *
 * @see \Drupal\reusable_items\Entity\ReusableItem.
 */
class ReusableItemAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\reusable_items\Entity\ReusableItemInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished reusable item entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published reusable item entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit reusable item entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete reusable item entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add reusable item entities');
  }

}
