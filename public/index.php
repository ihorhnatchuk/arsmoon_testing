<?php 

use Core\Aplication\Application;

defined('ROOT_PATH') or define('ROOT_PATH', realpath(dirname(__DIR__)));

require_once(ROOT_PATH."/config/config.php");

require ROOT_PATH.'/vendor/autoload.php';
require ROOT_PATH.'/router.php';


$app = new Application(ROOT_PATH);
$app->run();



