<?php

namespace Core\Aplication;

use Core\Route\Router;
use Core\Route\RouterFactory;

class Application
{
    protected array $options = [];

    /**
     * Main class constructor
     *
     * @param string $appRoot
     */
    public function __construct(protected string $appRoot)
    {
    }

    /**
     * Execute at application level
     *
     * @return self
     */
    public function run() : self
    {
        $this->constants();
        if (version_compare($phpVersion = PHP_VERSION, $coreVersion = Config::MIN_VERSION, '<')) {
            die(sprintf('You are runninig PHP %s, but the core framework requires at least PHP %s', $phpVersion, $coreVersion));
        }
        $this->environment();
        $this->errorHandler();
        return $this;
    }

    /**
     * Define framework and application directory constants
     *
     * @return void
     */
    private function constants() : void
    {
        defined('DS') or define('DS', '/');
        defined('APP_ROOT') or define('APP_ROOT', $this->appRoot);
        defined('CONFIG_PATH') or define('CONFIG_PATH', APP_ROOT . DS . 'Config');
        defined('TEMPLATE_PATH') or define('TEMPLATE_PATH', APP_ROOT . DS . 'App/');
        defined('LOG_DIR') or define('LOG_DIR', APP_ROOT . DS . 'tmp/log');

    }

    /**
     * Set default framework and application settings
     *
     * @return void
     */
    private function environment()
    {
        ini_set('default_charset', 'UTF-8');
    }

    /**
     * Convert PHP errors to exception and set a custom exception
     * handler. Which allows us to take control or error handling 
     * so we can display errors in a customizable way
     *
     * @return void
     */
    private function errorHandler() : void
    {
        error_reporting(E_ALL | E_STRICT);
        // set_error_handler('Magma\ErrorHandling\ErrorHandling::errorHandler');
        // set_exception_handler('Magma\ErrorHandling\ErrorHandling::exceptionHandler');
    }

    /**
     * Undocumented function
     *
     * @param string $url
     * @param array $routes
     * @return self
     */
    public function setRouteHandler(string $url = null, array $routes = []) : self
    {
        $url = ($url) ? $url : $_SERVER['QUERY_STRING'];

        print_r($url);
        
        $factory = new RouterFactory($url, $routes);
        $factory->create(Router::class)->buildRoutes();
        return $this;
    }

}