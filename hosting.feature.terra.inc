<?php
/**
 * @file
 * Provide services for MySQL and Apache via Ansible.
 */

/**
 * Implements hook_hosting_feature().
 */
function hosting_terra_hosting_feature() {
    $features['terra'] = array(
        'title' => t('Terra'),
        'description' => t('Use Terra to launch services.'),
        'status' => HOSTING_FEATURE_DISABLED,
        'module' => 'hosting_terra',
        'group' => 'advanced',
    );
    return $features;
}
