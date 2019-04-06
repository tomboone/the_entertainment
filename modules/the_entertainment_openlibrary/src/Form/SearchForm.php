<?php

namespace Drupal\the_entertainment_openlibrary\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

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
    if ($form_state->getValue('type') == 0) {
      if (empty($form_state->getValue('keywords'))
        && empty($form_state->getValue('title'))
        && empty($form_state->getValue('author'))) {
        $form_state->setErrorByName('keywords', t('You must provide search terms in at least one of the fields below.'));
        $form_state->setErrorByName('title');
        $form_state->setErrorByName('author');
      }
    }
    elseif ($form_state->getValue('type') == 1) {
      if (empty($form_state->getValue('isbn'))) {
        $form_state->setErrorByName('isbn', t('You must provide an ISBN in the field below.'));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $route = 'the_entertainment_openlibrary.book_results_controller_book_results';
    $queryParameters = [];
    if ($form_state->getValue('type') == 0) {
      if (!empty($form_state->getValue('keywords'))) {
        $queryParameters['keywords'] = str_replace(' ', '+', $form_state->getValue('keywords'));
      }
      if (!empty($form_state->getValue('title'))) {
        $queryParameters['title'] = str_replace(' ', '+', $form_state->getValue('title'));
      }
      if (!empty($form_state->getValue('author'))) {
        $queryParameters['author'] = str_replace(' ', '+', $form_state->getValue('author'));
      }
    }
    elseif ($form_state->getValue('type') == 1) {
      if (!empty($form_state->getValue('isbn'))) {
        $queryParameters['isbn'] = str_replace(['-', ' '], '', $form_state->getValue('isbn'));
      }
    }
    if (count($queryParameters > 0)) {
      $form_state->setRedirect($route, $queryParameters);
    }
    return;
  }
}