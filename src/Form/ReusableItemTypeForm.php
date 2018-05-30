<?php

namespace Drupal\reusable_items\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ReusableItemTypeForm.
 */
class ReusableItemTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $reusable_item_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $reusable_item_type->label(),
      '#description' => $this->t("Label for the Reusable item type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $reusable_item_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\reusable_items\Entity\ReusableItemType::load',
      ],
      '#disabled' => !$reusable_item_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $reusable_item_type = $this->entity;
    $status = $reusable_item_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Reusable item type.', [
          '%label' => $reusable_item_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Reusable item type.', [
          '%label' => $reusable_item_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($reusable_item_type->toUrl('collection'));
  }

}
