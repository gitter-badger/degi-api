<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
ini_set('display_errors', true); 
ini_set('date.timezone','Asia/Taipei');

chdir(dirname(__DIR__));
define('PUBLIC_PATH', __DIR__ );


// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
