<?php

/**
 * @file
 * Contains \Drupal\trance\TranceListBuilder.
 */

namespace Drupal\trance;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of trance entities.
 *
 * @ingroup trance
 */
class TranceListBuilder extends EntityListBuilder {
  use LinkGeneratorTrait;

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Id');
    $header['type'] = $this->t('Type');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\trance\Trance */
    $entity_type = $entity->getEntityType()->id();
    $row['id'] = $entity->id();
    $row['type'] = $entity->getType();
    $row['name'] = $this->l(
      $entity->label(),
      new Url(
        'entity.' . $entity_type . '.edit_form', [
          $entity_type => $entity->id(),
        ]
      )
    );
    return $row + parent::buildRow($entity);
  }

}