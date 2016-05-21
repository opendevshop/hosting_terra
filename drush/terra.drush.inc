<?php

/**
 * Implements hook_drush_init()
 */
function terra_drush_init(){
  terra_provision_register_autoload();
}

/**
 * Register our directory as a place to find Provision classes.
 *
 * This allows Provision to autoload our classes, so that we don't need to
 * specifically include the files before we use the class.
 */
function terra_provision_register_autoload() {
  static $loaded = FALSE;
  if (!$loaded) {
    $loaded = TRUE;
    provision_autoload_register_prefix('Provision_', dirname(__FILE__));
  }
}

/**
 * Implements hook_provision_services()
 *
 * @TODO: This is needed to run the autoloader properly.  What's the point of using hook_drush_init() then!?
 */
function terra_provision_services() {
  terra_provision_register_autoload();
}

/**
 * Implements drush_HOOK_pre_COMMAND()
 *
 * This runs for each task during the command
 *    drush @hostmaster hosting-tasks
 *
 * NOTE: This ONLY runs when being called from a hostmaster task.
 * This hook should ONLY be used to pass options from a hostmaster task form to
 * the $task object, or if you don't need this functionality from the command
 * line.
 */
function drush_terra_pre_hosting_task() {

  drush_log(dt("[DEVSHOP] Hello. Pre-Task check..."));

  $task =& drush_get_context('HOSTING_TASK');

  if ($task->ref->type == 'site' && $task->task_type == 'install') {

    $site = $task->ref;
    $project = $task->ref->project;
    $environment = $task->ref->environment;

    // 1. If app does not yet exist, `terra app:add`
    // @TODO: Fix terra app:status to exit 1 if the app doesn't exist.
    d()->server->shell_exec("terra app:status {$project->name}");
    $output = implode("\n", drush_shell_exec_output());

    // If app was not found
    if (strpos($output, $project->git_url) === FALSE) {
      drush_log("[TERRA] App {$project->name} not found.  Creating...", 'devshop_log');

      $cmd = "terra app:add {$project->name} {$project->git_url} --description='Added by DevShop'";
      d()->server->service('Process')->process($cmd, '', "Terra");
    }

    // 2. Add environment.
    $cmd = "terra environment:add {$project->name} {$environment->name} {$environment->repo_root} /{$project->drupal_path}";
    d()->server->service('Process')->process($cmd, '', "Terra");

    // 3. enable environment.
    $cmd = "terra environment:enable {$project->name} {$environment->name}";
    d()->server->service('Process')->process($cmd, '', "Terra");

    // 4. Figure out how to install drupal automatically


  }
}
