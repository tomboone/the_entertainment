<?php

namespace Drupal\the_entertainment_the_movie_db\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class TheMovieDbApiKeyForm.
 */
class TheMovieDbApiKeyForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'the_entertainment_the_movie_db.themoviedbapikey',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'the_movie_db_api_key_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('the_entertainment_the_movie_db.themoviedbapikey');
    $form['the_movie_database_api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('The Movie Database API Key'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('the_movie_database_api_key'),
    ];
    return parent::buildForm($form, $form_state);
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
    parent::submitForm($form, $form_state);

    $this->config('the_entertainment_the_movie_db.themoviedbapikey')
      ->set('the_movie_database_api_key', $form_state->getValue('the_movie_database_api_key'))
      ->save();
  }

}
