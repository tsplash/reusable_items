<?php

namespace Drupal\reusable_items\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Reusable item entities.
 */
class ReusableItemViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
