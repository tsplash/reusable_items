<?php

namespace Drupal\reusable_items;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Reusable item entities.
 *
 * @ingroup reusable_items
 */
class ReusableItemListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Reusable item ID');
    $header['name'] = $this->t('Name');
    $header['type'] = $this->t('Type');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\reusable_items\Entity\ReusableItem */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.reusable_item.edit_form',
      ['reusable_item' => $entity->id()]
    );
    $row['type'] = $entity->getType();
    return $row + parent::buildRow($entity);
  }

}
