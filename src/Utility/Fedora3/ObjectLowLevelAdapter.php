<?php

namespace Drupal\akubra_adapter\Utility\Fedora3;

use Drupal\Core\Site\Settings;
use Drupal\foxml\Utility\Fedora3\ObjectLowLevelAdapterInterface;

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
    $files = static::writeParanoia() ?
      new \RecursiveCallbackFilterIterator(
        $iterator,
        function ($file, $key, $iterator) {
          return $file->isDir() || ($file->isFile() && $file->isReadable() &&
            !$file->isWritable() && !$file->getPathInfo()->isWritable());
        }
      ) :
      $iterator;

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

  /**
   * Allow pre-filtering for write paranoia to be suppressed.
   *
   * @return bool
   *   TRUE if the AKUBRA_ADAPTER_WRITE_PARANOIA environment is unset or
   *   truth-y; FALSE if AKUBRA_ADAPTER_WRITE_PARANOIA is false-y.
   */
  protected static function writeParanoia() : bool {
    $env = getenv('AKUBRA_ADAPTER_WRITE_PARANOIA');
    return $env === FALSE || $env;
  }

}
