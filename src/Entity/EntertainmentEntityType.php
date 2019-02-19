<?php

namespace Drupal\the_entertainment\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Entertainment type entity.
 *
 * @ConfigEntityType(
 *   id = "entertainment_type",
 *   label = @Translation("Entertainment type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\the_entertainment\EntertainmentEntityTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\the_entertainment\Form\EntertainmentEntityTypeForm",
 *       "edit" = "Drupal\the_entertainment\Form\EntertainmentEntityTypeForm",
 *       "delete" = "Drupal\the_entertainment\Form\EntertainmentEntityTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\the_entertainment\EntertainmentEntityTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "entertainment_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "entertainment",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/entertainment_type/{entertainment_type}",
 *     "add-form" = "/admin/structure/entertainment_type/add",
 *     "edit-form" = "/admin/structure/entertainment_type/{entertainment_type}/edit",
 *     "delete-form" = "/admin/structure/entertainment_type/{entertainment_type}/delete",
 *     "collection" = "/admin/structure/entertainment_type"
 *   }
 * )
 */
class EntertainmentEntityType extends ConfigEntityBundleBase implements EntertainmentEntityTypeInterface {

  /**
   * The Entertainment type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Entertainment type label.
   *
   * @var string
   */
  protected $label;

}
