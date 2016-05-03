<?php

/**
 * @file
 * Contains \Drupal\trance\TranceType.
 */

namespace Drupal\trance;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;
use Drupal\trance\TranceTypeInterface;

/**
 * Defines the trance type entity.
 */
abstract class TranceType extends ConfigEntityBundleBase implements TranceTypeInterface {

  /**
   * The trance type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The trance type label.
   *
   * @var string
   */
  protected $label;

  /**
   * A brief description of this cms_content type.
   *
   * @var string
   */
  protected $description;

  /**
   * Help information shown to the user when creating a CmsContent entity.
   *
   * @var string
   */
  protected $help;

  /**
   * {@inheritdoc}
   */
  public function getHelp() {
    return $this->help;
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * {@inheritdoc}
   */
  public function shouldCreateNewRevision() {
    return $this->revision;
  }

}
