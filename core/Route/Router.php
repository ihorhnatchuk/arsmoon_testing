<?php

namespace Core\Route;

use Exception;

class Router implements RouterInterface
{

    private array $handlers;
    private $notFoundHandler;

    private const METHOD_GET  = 'GET';
    private const METHOD_POST = 'POST';

    public function get(string $path, $handler): void
    {
        $this->addHandler(self::METHOD_GET, $path, $handler);
    }

    public function post(string $path, $handler): void
    {
        $this->addHandler(self::METHOD_POST, $path, $handler);
    }

    public function addNotFoundHandler($handler): void
    {
        $this->notFoundHandler = $handler;
    }

    private function addHandler(string $method, string $path, $handler): void
    {
        $this->handlers[$method . $path] = [
            'path' => $path,
            'method' => $method,
            'handler' => $handler,
        ];
    }

    public function dispatch() : void
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $requestPath = $requestUri['path'];
        $method = $_SERVER['REQUEST_METHOD'];

        $callback = null;
        foreach ($this->handlers as $key => $handler) {
            if($handler['path'] === $requestPath && $handler['method'] === $method)
            {
                $callback = $handler['handler'];
            }
        }

        if(is_array($callback)) {
            $path = $callback;
            $className = array_shift($path);
            $handler = new $className;

            $method = array_shift($path);

            $callback = [$handler , $method];
        }

        if(is_string($callback)) {
            $path = $callback;
            $handler = new $path;
            $method = '__invoke';

            $callback = [$handler, $method];
        }


        if(!$callback) {
            header('HTTP/1.0 404 NOT FOUND');
            if(!empty($this->notFoundHandler)) {
                $callback = $this->notFoundHandler;
            }
        }

        call_user_func_array($callback ,[
            array_merge($_GET, $_POST)
        ]);
    }
}