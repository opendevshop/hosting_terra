<?php

class Provision_Service_http_terra extends Provision_Service_http {
  protected $application_name = 'terra';

  /**
   * Sync filesystem changes to the server hosting this service.
   */
  function sync($path = NULL, $additional_options = array()) {
    drush_log('Provision_Service_http_terra::sync()', 'ok');
    return $this->server->sync($path, $additional_options);
  }
}
