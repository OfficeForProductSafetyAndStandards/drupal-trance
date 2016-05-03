<?php

/**
 * @file
 * Contains \Drupal\trance\TranceStorageSchema.
 */

namespace Drupal\trance;

use Drupal\Core\Entity\ContentEntityTypeInterface;
use Drupal\Core\Entity\Sql\SqlContentEntityStorageSchema;
use Drupal\Core\Field\FieldStorageDefinitionInterface;

/**
 * Extends the trance schema handler.
 */
class TranceStorageSchema extends SqlContentEntityStorageSchema {

  /**
   * The id of  entity type this schema builder is responsible for.
   *
   * @var string
   */
  protected $entityTypeId;


  /**
   * {@inheritdoc}
   */
  public function __construct(\Drupal\Core\Entity\EntityManagerInterface $entity_manager, \Drupal\Core\Entity\ContentEntityTypeInterface $entity_type, \Drupal\Core\Entity\Sql\SqlContentEntityStorage $storage, \Drupal\Core\Database\Connection $database) {
    parent::__construct($entity_manager, $entity_type, $storage, $database);
    $this->entityTypeId = $entity_type->id();
  }

  /**
   * {@inheritdoc}
   */
  protected function getEntitySchema(ContentEntityTypeInterface $entity_type, $reset = FALSE) {
    $schema = parent::getEntitySchema($entity_type, $reset = FALSE);

    $schema[$this->entityTypeId . '_field_data']['indexes'] += [
      $this->entityTypeId . '_name' => ['type', 'langcode', 'name'],
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  protected function getSharedTableFieldSchema(FieldStorageDefinitionInterface $storage_definition, $table_name, array $column_mapping) {
    $schema = parent::getSharedTableFieldSchema($storage_definition, $table_name, $column_mapping);
    $field_name = $storage_definition->getName();

    if ($table_name == $this->entityTypeId . '_field_data') {

      switch ($field_name) {
        case 'status':
          // Improves the performance of the index defined in getEntitySchema().
          $schema['fields'][$field_name]['not null'] = TRUE;
          break;

        case 'name':
          $this->addSharedTableFieldIndex($storage_definition, $schema, TRUE);
          break;
      }
    }

    return $schema;
  }

}
