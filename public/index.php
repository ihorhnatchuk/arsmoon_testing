<?php 

use Core\Aplication\Application;

defined('ROOT_PATH') or define('ROOT_PATH', realpath(dirname(__FILE__)));


require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../router.php';


$app = new Application(ROOT_PATH);
$app->run();



