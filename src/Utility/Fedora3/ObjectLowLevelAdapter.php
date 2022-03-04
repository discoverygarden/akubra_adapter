<?php

namespace Drupal\akubra_adapter\Utility\Fedora3;

use Drupal\foxml\Utility\Fedora3\ObjectLowLevelAdapterInterface;

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
  public function getIterator() : \Traversable {
    $iterator = new \RecursiveDirectoryIterator(
      $this->basePath,
      \FilesystemIterator::SKIP_DOTS |
        \FilesystemIterator::CURRENT_AS_FILEINFO |
        \FilesystemIterator::KEY_AS_PATHNAME
    );

    // XXX: Paranoia: Pre-filter things.
    $files = new \RecursiveCallbackFilterIterator(
      $iterator,
      function ($file, $key, $iterator) {
        return $file->isDir() || ($file->isFile() && $file->isReadable() &&
          !$file->isWritable() && !$file->getPathInfo()->isWritable());
      }
    );

    $mapper = function ($map) {
      foreach ($map as $key => $file) {
        yield $key => explode('/', rawurldecode($file->getBasename()))[1];
      }
    };

    return $mapper(new \RecursiveIteratorIterator($files));
  }

  /**
   * {@inheritdoc}
   */
  public function getIteratorType() : int {
    return ObjectLowLevelAdapterInterface::ITERATOR_PID;
  }

}
