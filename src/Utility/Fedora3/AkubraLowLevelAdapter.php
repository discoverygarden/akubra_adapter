<?php

namespace Drupal\akubra_adapter\Utility\Fedora3;

use Drupal\foxml\Utility\Fedora3\LowLevelAdapterInterface;

/**
 * Abstract Akubra low-level adapter.
 */
abstract class AkubraLowLevelAdapter implements LowLevelAdapterInterface {

  /**
   * The storage path.
   *
   * @var string
   */
  protected $basePath;

  /**
   * The pattern used in Akubra of hash content in the path.
   *
   * @var string
   */
  protected $pattern;

  /**
   * Constructor.
   */
  public function __construct($base_path, $pattern = '##') {
    $this->basePath = $base_path;
    $this->pattern = $pattern;
  }

  /**
   * {@inheritdoc}
   */
  public function dereference($id) : string {
    // Structure like: "the:pid+DSID+DSID.0"
    // Need: "{base_path}/{hash_pattern}/{id}".
    // @see https://github.com/fcrepo3/fcrepo/blob/37df51b9b857fd12c6ab8269820d406c3c4ad774/fcrepo-server/src/main/java/org/fcrepo/server/storage/lowlevel/akubra/HashPathIdMapper.java#L17-L68
    $slashed = str_replace('+', '/', $id);
    $full = "info:fedora/$slashed";
    $hash = md5($full);

    $pattern_offset = 0;
    $hash_offset = 0;
    $subbed = $this->pattern;

    while (($pattern_offset = strpos($subbed, '#', $pattern_offset)) !== FALSE) {
      $subbed[$pattern_offset] = $hash[$hash_offset++];
    }

    $encoded = strtr(rawurlencode($full), [
      '_' => '%5F',
    ]);

    return "{$this->basePath}/$subbed/$encoded";
  }

  /**
   * {@inheritdoc}
   */
  public function valid() : bool {
    return $this->basePath && $this->pattern && is_dir($this->basePath);
  }

}
