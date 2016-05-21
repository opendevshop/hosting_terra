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
