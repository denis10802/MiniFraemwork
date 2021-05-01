<?php


class Router
{
    private static $routes = [];

    private function __construct()
    {
      return self::$routes = include 'src.php';
    }

    public static function run($errorRoute){
        $route = $_SERVER['REQUEST_URI'];

        $routes = new Router();
        $routes = $routes->getRoutes();

        if(array_key_exists($route, $routes)){
            include $routes[$route];
            exit( );
        }else{
            include $errorRoute;
        }
    }

    private function getRoutes()
    {
        return self::$routes;
    }

}