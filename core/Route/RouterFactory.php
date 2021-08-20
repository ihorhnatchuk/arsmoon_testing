<?php
namespace Core\Route;

use Exception;

class RouterFactory
{
    /** @var RouterInterface */
    protected RouterInterface $router;

    /**
     * Main class constructor
     *
     * @param RouterInterface $router
     * @param string $dispatcedUrl
     * @param array $routes - from yaml file
     */
    public function __construct(protected string $dispatcedUrl = '',  protected array $routes)
    {
        if (empty($routes)) {
            throw new Exception('There are one or more empty arguments. In order to continue please ensure your <code>routes.yaml</code> has your defined routes and your passing the correct $_SERVER variable ie "QUERY_STRING".');
        }
    }

    /**
     * Instantiate the router object and checks whether the object
     * implements the correct interface else throw an exception.
     *
     * @param string $routerString
     * @return self
     */
    public function create(string $routerString) : self
    {
        $this->router = new $routerString();
        if (!$this->router instanceof RouterInterface) {
            throw new Exception($routerString . ' is not a valid Router object');
        }
        return $this;

    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function buildRoutes()
    {
        if (is_array($this->routes) && !empty($this->routes)) {
            $args = [];
            foreach ($this->routes as $key => $route) {
                if (isset($route['namespace']) && $route['namespace'] !='') {
                    $args = ['namespace' => $route['namespace']];
                } elseif(isset($route['controller']) && $route['controller'] !='') {
                    $args = ['controller' => $route['controller'], 'action' => $route['action']];
                }
                if (isset($key)) {
                    $this->router->add($key, $args);
                }
            }
            $this->router->dispatch($this->dispatcedUrl);
        }
        return false;

    }

}