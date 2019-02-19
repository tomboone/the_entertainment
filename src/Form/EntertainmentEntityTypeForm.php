<?php

namespace Drupal\the_entertainment\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class EntertainmentEntityTypeForm.
 */
class EntertainmentEntityTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $entertainment_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $entertainment_type->label(),
      '#description' => $this->t("Label for the Entertainment type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $entertainment_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\the_entertainment\Entity\EntertainmentEntityType::load',
      ],
      '#disabled' => !$entertainment_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entertainment_type = $this->entity;
    $status = $entertainment_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Entertainment type.', [
          '%label' => $entertainment_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Entertainment type.', [
          '%label' => $entertainment_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($entertainment_type->toUrl('collection'));
  }

}
