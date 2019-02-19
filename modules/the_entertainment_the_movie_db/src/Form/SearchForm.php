<?php

namespace Drupal\the_entertainment_the_movie_db\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SearchForm.
 */
class SearchForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'the_movie_db_search_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Movie Title'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '-2',
    ];
    $form['release_year'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Release Year'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '-1',
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Find Movie'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    foreach ($form_state->getValues() as $key => $value) {
      drupal_set_message($key . ': ' . $value);
    }

  }

}
