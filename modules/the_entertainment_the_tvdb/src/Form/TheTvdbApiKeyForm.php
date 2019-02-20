<?php

namespace Drupal\the_entertainment_the_tvdb\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class TheTvdbApiKeyForm.
 */
class TheTvdbApiKeyForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'the_entertainment_the_tvdb.thetvdbapikey',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'the_tvdb_api_key_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('the_entertainment_the_tvdb.thetvdbapikey');
    $form['the_tvdb_api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('The TVDB API Key'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('the_tvdb_api_key'),
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

    $this->config('the_entertainment_the_tvdb.thetvdbapikey')
      ->set('the_tvdb_api_key', $form_state->getValue('the_tvdb_api_key'))
      ->save();
  }

}
