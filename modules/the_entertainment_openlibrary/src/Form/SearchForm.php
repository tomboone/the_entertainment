<?php

namespace Drupal\the_entertainment_openlibrary\Form;

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
    return 'openlibrary_search_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['type'] = [
      '#type' => 'radios',
      '#title' => $this->t('Search Type'),
      '#default_value' => 0,
      '#options' => [
        0 => $this->t('Keywords/Title/Author'),
        1 => $this->t('ISBN'),
      ],
      '#required' => TRUE,
      '#weight' => '-5',
    ];
    $form['keywords'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Keywords'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '-4',
      '#states' => [
        'visible' => [
          ':input[name="type"]' => [
            'value' => 0,
          ],
        ],
      ],
    ];
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Book Title'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '-3',
      '#states' => [
        'visible' => [
          ':input[name="type"]' => [
            'value' => 0,
          ],
        ],
      ],
    ];
    $form['author'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Author'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '-2',
      '#states' => [
        'visible' => [
          ':input[name="type"]' => [
            'value' => 0,
          ],
        ],
      ],
    ];
    $form['isbn'] = [
      '#type' => 'textfield',
      '#title' => 'ISBN',
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '-1',
      '#states' => [
        'visible' => [
          ':input[name="type"]' => [
            'value' => 1,
          ],
        ],
        'required' => [
          ':input[name="type"]' => [
            'value' => 1,
          ],
        ],
      ],
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Find Book'),
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
