<?php

namespace Drupal\reusable_items\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\reusable_items\Entity\ReusableItemInterface;

/**
 * Class ReusableItemController.
 *
 *  Returns responses for Reusable item routes.
 */
class ReusableItemController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Reusable item  revision.
   *
   * @param int $reusable_item_revision
   *   The Reusable item  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($reusable_item_revision) {
    $reusable_item = $this->entityManager()->getStorage('reusable_item')->loadRevision($reusable_item_revision);
    $view_builder = $this->entityManager()->getViewBuilder('reusable_item');

    return $view_builder->view($reusable_item);
  }

  /**
   * Page title callback for a Reusable item  revision.
   *
   * @param int $reusable_item_revision
   *   The Reusable item  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($reusable_item_revision) {
    $reusable_item = $this->entityManager()->getStorage('reusable_item')->loadRevision($reusable_item_revision);
    return $this->t('Revision of %title from %date', ['%title' => $reusable_item->label(), '%date' => format_date($reusable_item->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Reusable item .
   *
   * @param \Drupal\reusable_items\Entity\ReusableItemInterface $reusable_item
   *   A Reusable item  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(ReusableItemInterface $reusable_item) {
    $account = $this->currentUser();
    $langcode = $reusable_item->language()->getId();
    $langname = $reusable_item->language()->getName();
    $languages = $reusable_item->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $reusable_item_storage = $this->entityManager()->getStorage('reusable_item');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $reusable_item->label()]) : $this->t('Revisions for %title', ['%title' => $reusable_item->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all reusable item revisions") || $account->hasPermission('administer reusable item entities')));
    $delete_permission = (($account->hasPermission("delete all reusable item revisions") || $account->hasPermission('administer reusable item entities')));

    $rows = [];

    $vids = $reusable_item_storage->revisionIds($reusable_item);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\reusable_items\ReusableItemInterface $revision */
      $revision = $reusable_item_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $reusable_item->getRevisionId()) {
          $link = $this->l($date, new Url('entity.reusable_item.revision', ['reusable_item' => $reusable_item->id(), 'reusable_item_revision' => $vid]));
        }
        else {
          $link = $reusable_item->link($date);
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
              'url' => Url::fromRoute('entity.reusable_item.revision_revert', ['reusable_item' => $reusable_item->id(), 'reusable_item_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.reusable_item.revision_delete', ['reusable_item' => $reusable_item->id(), 'reusable_item_revision' => $vid]),
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

    $build['reusable_item_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
