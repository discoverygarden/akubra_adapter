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

    $mapper = static function (\Traversable $map) {
      foreach ($map as $key => $file) {
        // `$file->getBaseName()` is expected to be something like
        // `info%3Afedora%2Fsome%3Apid` ; however, Akubra can leave additional
        // `[...]%2Fold` or `[...]%2Fnew` files in its storage if there were I/O
        // issues (or some form of crash) while writing to storage.
        //
        // Here, we want to return the `some%3Apid` bit as `some:pid`, but also
        // to exclude those `[...]%2Fold` and `[...]%2Fnew` entries.
        $exploded = explode('/', rawurldecode($file->getBasename()));
        if (count($exploded) !== 2) {
          // Should handle excluding the `[...]%2Fold` and `[...]%2Fnew` bits,
          // as they should have 3 items when exploded, but might also deal with
          // other potential cruft in the object store.
          continue;
        }
        yield $key => $exploded[1];
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
