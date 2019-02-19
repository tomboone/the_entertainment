<?php

namespace Drupal\the_entertainment_reviews\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\the_entertainment_reviews\Entity\EntertainmentReviewEntityInterface;

/**
 * Class EntertainmentReviewEntityController.
 *
 *  Returns responses for Entertainment review routes.
 */
class EntertainmentReviewEntityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Entertainment review  revision.
   *
   * @param int $entertainment_review_revision
   *   The Entertainment review  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($entertainment_review_revision) {
    $entertainment_review = $this->entityManager()->getStorage('entertainment_review')->loadRevision($entertainment_review_revision);
    $view_builder = $this->entityManager()->getViewBuilder('entertainment_review');

    return $view_builder->view($entertainment_review);
  }

  /**
   * Page title callback for a Entertainment review  revision.
   *
   * @param int $entertainment_review_revision
   *   The Entertainment review  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($entertainment_review_revision) {
    $entertainment_review = $this->entityManager()->getStorage('entertainment_review')->loadRevision($entertainment_review_revision);
    return $this->t('Revision of %title from %date', ['%title' => $entertainment_review->label(), '%date' => format_date($entertainment_review->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Entertainment review .
   *
   * @param \Drupal\the_entertainment_reviews\Entity\EntertainmentReviewEntityInterface $entertainment_review
   *   A Entertainment review  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(EntertainmentReviewEntityInterface $entertainment_review) {
    $account = $this->currentUser();
    $langcode = $entertainment_review->language()->getId();
    $langname = $entertainment_review->language()->getName();
    $languages = $entertainment_review->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $entertainment_review_storage = $this->entityManager()->getStorage('entertainment_review');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $entertainment_review->label()]) : $this->t('Revisions for %title', ['%title' => $entertainment_review->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all entertainment review revisions") || $account->hasPermission('administer entertainment review entities')));
    $delete_permission = (($account->hasPermission("delete all entertainment review revisions") || $account->hasPermission('administer entertainment review entities')));

    $rows = [];

    $vids = $entertainment_review_storage->revisionIds($entertainment_review);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\the_entertainment_reviews\EntertainmentReviewEntityInterface $revision */
      $revision = $entertainment_review_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $entertainment_review->getRevisionId()) {
          $link = $this->l($date, new Url('entity.entertainment_review.revision', ['entertainment_review' => $entertainment_review->id(), 'entertainment_review_revision' => $vid]));
        }
        else {
          $link = $entertainment_review->link($date);
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
              'url' => $has_translations ?
              Url::fromRoute('entity.entertainment_review.translation_revert', ['entertainment_review' => $entertainment_review->id(), 'entertainment_review_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.entertainment_review.revision_revert', ['entertainment_review' => $entertainment_review->id(), 'entertainment_review_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.entertainment_review.revision_delete', ['entertainment_review' => $entertainment_review->id(), 'entertainment_review_revision' => $vid]),
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

    $build['entertainment_review_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
