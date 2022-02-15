<?php

namespace Drupal\akubra_adapter\Utilty\Fedora3;

use Drupal\foxml\Utilty\Fedora3\ObjectLowLevelAdapterInterface;

use Drupal\Core\Site\Settings;

/**
 * Object Akubra adapter.
 */
class ObjectLowLevelAdapter extends AkubraLowLevelAdapter implements ObjectLowLevelAdapterInterface {

  /**
   * Constructor.
   */
  public function __construct(Settings $settings) {
    parent::__construct(
      $settings->get('akubra_adapter_object_basepath', NULL),
      $settings->get('akubra_adapter_object_pattern', '##')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getIterator() {
    $iterator = new \RecursiveDirectoryIterator(
      $this->basePath,
      \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::CURRENT_AS_FILEINFO | \FilesystemIterator::KEY_AS_PATHNAME
    );

    $files = new \CallbackFilterIterator($iterator, function ($file, $key, $iterator) {
      return $file->isFile() && !$file->isDir() && $file->isReadable() && !$file->isWritable();
    });

    $mapper = function ($map) {
      foreach ($map as $key => $file) {
        yield $key => rawurldecode($file->getBasename());
      }
    };

    return $mapper($files);
  }

}
