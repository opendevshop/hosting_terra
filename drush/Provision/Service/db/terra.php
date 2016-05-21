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
   * Verifies database connection and commands
   */
   function create_site_database($creds = array()) {
     $project = d()->project;
     $environment = d()->environment;

     $project_object =  d("@project_{$project}");
     $environment_object = (object) $project_object->project['environments'][$environment];

     $output = d()->db_server->service('Process')->process("terra status {$project}", '', "Install");
     if (strpos($output, $project_object->project->git_url) === FALSE) {
      $cmd = "terra app:add --description='Added by DevShop' {$project} {$project_object->project->git_url} ";
      d()->db_server->service('Process')->process($cmd, '', "Install");
    }

     // 2. Add environment.
     $environment_object = (object) d("@project_{$project}")->project['environments'][$environment];
     $cmd = "terra environment:add {$project} {$environment} {$environment_object->repo_root}";
     d()->db_server->service('Process')->process($cmd, '', "Terra");

     // 3. enable environment.
     $cmd = "terra environment:enable {$project_object->project->name} {$environment_object->name}";
    d()->db_server->service('Process')->process($cmd, '', "Terra");

  }

  /**
   * Sync filesystem changes to the server hosting this service.
   */
  function sync($path = NULL, $additional_options = array()) {
    drush_log('Provision_Service_db_terra::sync()', 'ok');
//    return $this->server->sync($path, $additional_options);
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
