<?php

namespace Drupal\the_entertainment_reviews\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Entertainment review type entity.
 *
 * @ConfigEntityType(
 *   id = "entertainment_review_type",
 *   label = @Translation("Entertainment review type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\the_entertainment_reviews\EntertainmentReviewEntityTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\the_entertainment_reviews\Form\EntertainmentReviewEntityTypeForm",
 *       "edit" = "Drupal\the_entertainment_reviews\Form\EntertainmentReviewEntityTypeForm",
 *       "delete" = "Drupal\the_entertainment_reviews\Form\EntertainmentReviewEntityTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\the_entertainment_reviews\EntertainmentReviewEntityTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "entertainment_review_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "entertainment_review",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/entertainment_review_type/{entertainment_review_type}",
 *     "add-form" = "/admin/structure/entertainment_review_type/add",
 *     "edit-form" = "/admin/structure/entertainment_review_type/{entertainment_review_type}/edit",
 *     "delete-form" = "/admin/structure/entertainment_review_type/{entertainment_review_type}/delete",
 *     "collection" = "/admin/structure/entertainment_review_type"
 *   }
 * )
 */
class EntertainmentReviewEntityType extends ConfigEntityBundleBase implements EntertainmentReviewEntityTypeInterface {

  /**
   * The Entertainment review type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Entertainment review type label.
   *
   * @var string
   */
  protected $label;

}
