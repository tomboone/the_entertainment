<?php

namespace Drupal\the_entertainment_reviews\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class EntertainmentReviewEntityTypeForm.
 */
class EntertainmentReviewEntityTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $entertainment_review_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $entertainment_review_type->label(),
      '#description' => $this->t("Label for the Entertainment review type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $entertainment_review_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\the_entertainment_reviews\Entity\EntertainmentReviewEntityType::load',
      ],
      '#disabled' => !$entertainment_review_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entertainment_review_type = $this->entity;
    $status = $entertainment_review_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Entertainment review type.', [
          '%label' => $entertainment_review_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Entertainment review type.', [
          '%label' => $entertainment_review_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($entertainment_review_type->toUrl('collection'));
  }

}
