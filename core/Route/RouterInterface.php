<?php
namespace Core\Route;

interface RouterInterface
{
    public function get(string $path, $handler): void;


    public function post(string $path, $handler): void;

    /**
     * Dispatch route and create controller objects and execute the default method 
     * on that controller object
     * 
     * @param string $url
     * @return void
     */
    public function dispatch() : void;
}