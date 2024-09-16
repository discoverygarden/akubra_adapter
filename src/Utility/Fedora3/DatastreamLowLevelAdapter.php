<?php

namespace Drupal\akubra_adapter\Utility\Fedora3;

use Drupal\Core\Site\Settings;
use Drupal\foxml\Utility\Fedora3\DatastreamLowLevelAdapterInterface;

/**
 * Datastream Akubra adapter.
 */
class DatastreamLowLevelAdapter extends AkubraLowLevelAdapter implements DatastreamLowLevelAdapterInterface {

  /**
   * Constructor.
   */
  public function __construct(Settings $settings) {
    parent::__construct(
      $settings->get('akubra_adapter_datastream_basepath', NULL),
      $settings->get('akubra_adapter_datastream_pattern', '##')
    );
  }

}
