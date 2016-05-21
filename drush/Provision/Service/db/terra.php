<?php

class Provision_Service_db_terra extends Provision_Service_db {
  protected $application_name = 'terra';
  protected $has_restart_cmd = FALSE;

  function init_server() {
    parent::init_server();
    drush_log('Provision_Service_db_terra::init_server()', 'ok');
  }

  /**
   * Verifies database connection and commands
   */
  function verify_server_cmd() {
    d()->service('Process')->process('terra status', '', "Terra");
  }

  /**
   * Sync filesystem changes to the server hosting this service.
   */
  function sync($path = NULL, $additional_options = array()) {
    drush_log('Provision_Service_db_terra::sync()', 'ok');
//    return $this->server->sync($path, $additional_options);
  }
  /**
   * This method is at the core of preparing the site.
   *
   * Use this method to trigger the creation of the Rancher environments.
   *
   * @param array $creds
   * @return bool
   */
  function create_site_database($creds = array()) {
    drush_log('Provision_Service_db_terra::create_site_database()', 'ok');
    return TRUE;
  }

  function can_create_database() {
    drush_log('Provision_Service_db_terra::can_create_database()', 'ok');
    return TRUE;
  }

  function can_grant_privileges() {
    drush_log('Provision_Service_db_terra::can_grant_privileges()', 'ok');
    return TRUE;
  }
}
