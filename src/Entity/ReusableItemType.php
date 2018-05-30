<?php

namespace Drupal\reusable_items\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Reusable item type entity.
 *
 * @ConfigEntityType(
 *   id = "reusable_item_type",
 *   label = @Translation("Reusable item type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\reusable_items\ReusableItemTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\reusable_items\Form\ReusableItemTypeForm",
 *       "edit" = "Drupal\reusable_items\Form\ReusableItemTypeForm",
 *       "delete" = "Drupal\reusable_items\Form\ReusableItemTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\reusable_items\ReusableItemTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "reusable_item_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "reusable_item",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/reusable_item_type/{reusable_item_type}",
 *     "add-form" = "/admin/structure/reusable_item_type/add",
 *     "edit-form" = "/admin/structure/reusable_item_type/{reusable_item_type}/edit",
 *     "delete-form" = "/admin/structure/reusable_item_type/{reusable_item_type}/delete",
 *     "collection" = "/admin/structure/reusable_item_type"
 *   }
 * )
 */
class ReusableItemType extends ConfigEntityBundleBase implements ReusableItemTypeInterface {

  /**
   * The Reusable item type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Reusable item type label.
   *
   * @var string
   */
  protected $label;

}
