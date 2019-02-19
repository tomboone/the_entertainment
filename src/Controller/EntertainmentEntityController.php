<?php

namespace Drupal\the_entertainment\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\the_entertainment\Entity\EntertainmentEntityInterface;

/**
 * Class EntertainmentEntityController.
 *
 *  Returns responses for Entertainment routes.
 */
class EntertainmentEntityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Entertainment  revision.
   *
   * @param int $entertainment_revision
   *   The Entertainment  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($entertainment_revision) {
    $entertainment = $this->entityManager()->getStorage('entertainment')->loadRevision($entertainment_revision);
    $view_builder = $this->entityManager()->getViewBuilder('entertainment');

    return $view_builder->view($entertainment);
  }

  /**
   * Page title callback for a Entertainment  revision.
   *
   * @param int $entertainment_revision
   *   The Entertainment  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($entertainment_revision) {
    $entertainment = $this->entityManager()->getStorage('entertainment')->loadRevision($entertainment_revision);
    return $this->t('Revision of %title from %date', ['%title' => $entertainment->label(), '%date' => format_date($entertainment->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Entertainment .
   *
   * @param \Drupal\the_entertainment\Entity\EntertainmentEntityInterface $entertainment
   *   A Entertainment  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(EntertainmentEntityInterface $entertainment) {
    $account = $this->currentUser();
    $langcode = $entertainment->language()->getId();
    $langname = $entertainment->language()->getName();
    $languages = $entertainment->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $entertainment_storage = $this->entityManager()->getStorage('entertainment');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $entertainment->label()]) : $this->t('Revisions for %title', ['%title' => $entertainment->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all entertainment revisions") || $account->hasPermission('administer entertainment entities')));
    $delete_permission = (($account->hasPermission("delete all entertainment revisions") || $account->hasPermission('administer entertainment entities')));

    $rows = [];

    $vids = $entertainment_storage->revisionIds($entertainment);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\the_entertainment\EntertainmentEntityInterface $revision */
      $revision = $entertainment_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $entertainment->getRevisionId()) {
          $link = $this->l($date, new Url('entity.entertainment.revision', ['entertainment' => $entertainment->id(), 'entertainment_revision' => $vid]));
        }
        else {
          $link = $entertainment->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => Url::fromRoute('entity.entertainment.revision_revert', ['entertainment' => $entertainment->id(), 'entertainment_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.entertainment.revision_delete', ['entertainment' => $entertainment->id(), 'entertainment_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['entertainment_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
