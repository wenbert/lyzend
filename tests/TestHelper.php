<?php
require_once 'TestConfig.php';

/*
 * Start output buffering
 */
ob_start();
 
/*
 * Set error reporting to the level to which Zend Framework code must comply.
 */
error_reporting( E_ALL | E_STRICT );
 
/*
 * Set default timezone
 */
date_default_timezone_set('GMT');
 
/*
 * Determine the root, library, tests, and models directories
 */
$root        = realpath(dirname(__FILE__) . '/../');
$library     = $root . '/library';
$tests       = $root . '/tests';
$models      = $root . '/application/models';
$controllers = $root . '/application/controllers';
 
/*
 * Prepend the library/, tests/, and models/ directories to the
 * include_path. This allows the tests to run out of the box.
 */
$path = array(
    $models,
    $library,
    $tests,
    get_include_path()
    );
set_include_path(implode(PATH_SEPARATOR, $path));
 
/**
 * Register autoloader
 */
require_once 'Zend/Loader/Autoloader.php';
//Zend_Loader::registerAutoload();
Zend_Loader_Autoloader::getInstance();
 
/*
 * Add library/ and models/ directory to the PHPUnit code coverage
 * whitelist. This has the effect that only production code source files appear
 * in the code coverage report and that all production code source files, even
 * those that are not covered by a test yet, are processed.
 */
if (defined('TESTS_GENERATE_REPORT') && TESTS_GENERATE_REPORT === true &&
    version_compare(PHPUnit_Runner_Version::id(), '3.1.6', '>=')) {
    PHPUnit_Util_Filter::addDirectoryToWhitelist($library);
    PHPUnit_Util_Filter::addDirectoryToWhitelist($models);
    PHPUnit_Util_Filter::addDirectoryToWhitelist($controllers);
}
 
 
/**
 * Setup default DB adapter
 */
/*
$db = Zend_Db::factory('pdo_sqlite', array(
    'dbname' => $root . '/data/db/bugs.db',
));
Zend_Db_Table_Abstract::setDefaultAdapter($db);
*/


/*
 * Unset global variables that are no longer needed.
 */
unset($root, $library, $models, $controllers, $tests, $path);