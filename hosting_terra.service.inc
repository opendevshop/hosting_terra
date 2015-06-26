<?php

module_load_include('service.inc', 'hosting_web_server');
module_load_include('service.inc', 'hosting_db_server');

/**
 * Class hostingService_rancher
 *
 * Base class for rancher server and agent.
 */
class hostingService_terra extends hostingService {
  public $service = 'terra';
}

/**
 * Class hostingService_rancher_server
 *
 * Class for handling Rancher Server.
 */
class hostingService_db_terra extends hostingService_db {
  public $type = 'terra';
}

/**
 * Class hostingService_rancher_server
 *
 * Class for handling Rancher Server.
 */
class hostingService_http_terra extends hostingService_http {
  public $type = 'terra';
}