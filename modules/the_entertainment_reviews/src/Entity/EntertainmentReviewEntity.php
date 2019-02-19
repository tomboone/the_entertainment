<?php

namespace Drupal\the_entertainment_reviews\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\RevisionableContentEntityBase;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Entertainment review entity.
 *
 * @ingroup the_entertainment_reviews
 *
 * @ContentEntityType(
 *   id = "entertainment_review",
 *   label = @Translation("Entertainment review"),
 *   bundle_label = @Translation("Entertainment review type"),
 *   handlers = {
 *     "storage" = "Drupal\the_entertainment_reviews\EntertainmentReviewEntityStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\the_entertainment_reviews\EntertainmentReviewEntityListBuilder",
 *     "views_data" = "Drupal\the_entertainment_reviews\Entity\EntertainmentReviewEntityViewsData",
 *     "translation" = "Drupal\the_entertainment_reviews\EntertainmentReviewEntityTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\the_entertainment_reviews\Form\EntertainmentReviewEntityForm",
 *       "add" = "Drupal\the_entertainment_reviews\Form\EntertainmentReviewEntityForm",
 *       "edit" = "Drupal\the_entertainment_reviews\Form\EntertainmentReviewEntityForm",
 *       "delete" = "Drupal\the_entertainment_reviews\Form\EntertainmentReviewEntityDeleteForm",
 *     },
 *     "access" = "Drupal\the_entertainment_reviews\EntertainmentReviewEntityAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\the_entertainment_reviews\EntertainmentReviewEntityHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "entertainment_review",
 *   data_table = "entertainment_review_field_data",
 *   revision_table = "entertainment_review_revision",
 *   revision_data_table = "entertainment_review_field_revision",
 *   translatable = TRUE,
 *   admin_permission = "administer entertainment review entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "revision" = "vid",
 *     "bundle" = "type",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/entertainment_review/{entertainment_review}",
 *     "add-page" = "/admin/structure/entertainment_review/add",
 *     "add-form" = "/admin/structure/entertainment_review/add/{entertainment_review_type}",
 *     "edit-form" = "/admin/structure/entertainment_review/{entertainment_review}/edit",
 *     "delete-form" = "/admin/structure/entertainment_review/{entertainment_review}/delete",
 *     "version-history" = "/admin/structure/entertainment_review/{entertainment_review}/revisions",
 *     "revision" = "/admin/structure/entertainment_review/{entertainment_review}/revisions/{entertainment_review_revision}/view",
 *     "revision_revert" = "/admin/structure/entertainment_review/{entertainment_review}/revisions/{entertainment_review_revision}/revert",
 *     "revision_delete" = "/admin/structure/entertainment_review/{entertainment_review}/revisions/{entertainment_review_revision}/delete",
 *     "translation_revert" = "/admin/structure/entertainment_review/{entertainment_review}/revisions/{entertainment_review_revision}/revert/{langcode}",
 *     "collection" = "/admin/structure/entertainment_review",
 *   },
 *   bundle_entity_type = "entertainment_review_type",
 *   field_ui_base_route = "entity.entertainment_review_type.edit_form"
 * )
 */
class EntertainmentReviewEntity extends RevisionableContentEntityBase implements EntertainmentReviewEntityInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function urlRouteParameters($rel) {
    $uri_route_parameters = parent::urlRouteParameters($rel);

    if ($rel === 'revision_revert' && $this instanceof RevisionableInterface) {
      $uri_route_parameters[$this->getEntityTypeId() . '_revision'] = $this->getRevisionId();
    }
    elseif ($rel === 'revision_delete' && $this instanceof RevisionableInterface) {
      $uri_route_parameters[$this->getEntityTypeId() . '_revision'] = $this->getRevisionId();
    }

    return $uri_route_parameters;
  }

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage) {
    parent::preSave($storage);

    foreach (array_keys($this->getTranslationLanguages()) as $langcode) {
      $translation = $this->getTranslation($langcode);

      // If no owner has been set explicitly, make the anonymous user the owner.
      if (!$translation->getOwner()) {
        $translation->setOwnerId(0);
      }
    }

    // If no revision author has been set explicitly, make the entertainment_review owner the
    // revision author.
    if (!$this->getRevisionUser()) {
      $this->setRevisionUserId($this->getOwnerId());
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Entertainment review entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Entertainment review entity.'))
      ->setRevisionable(TRUE)
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Entertainment review is published.'))
      ->setRevisionable(TRUE)
      ->setDefaultValue(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'weight' => -3,
      ]);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    $fields['revision_translation_affected'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Revision translation affected'))
      ->setDescription(t('Indicates if the last edit of a translation belongs to current revision.'))
      ->setReadOnly(TRUE)
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE);

    return $fields;
  }

}
