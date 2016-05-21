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
     $project_name = d()->project;
     $environment_name = d()->environment;

     $project = (object) d("@project_{$project_name}")->project;
     $environment = (object) $project->environments[$environment_name];

     $output = d()->db_server->service('Process')->process("terra status {$project_name}", '', "Install");
     if (strpos($output, $project->git_url) === FALSE) {
       $web_server = d()->platform->web_server->remote_host;

      $cmd = "terra app:add {$project_name} {$project->git_url} --host='$web_server' --description='Added by DevShop'";
      d()->db_server->service('Process')->process($cmd, '', "Install");
    }

     // 2. Add environment.
     $environment = (object) d("@project_{$project_name}")->project['environments'][$environment_name];
     $cmd = "terra environment:add {$project_name} {$environment_name} {$environment->repo_root}";
     d()->db_server->service('Process')->process($cmd, '', "Terra");

     // 3. enable environment.
     $cmd = "terra environment:enable {$project->project->name} {$environment->name}";
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
