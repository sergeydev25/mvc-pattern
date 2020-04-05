<?php

namespace Core;

class App
{
    /**
     * @param string $uri
     * @return string
     */
    public static function getUriPath(string $uri) :string
    {
        $data = parse_url($uri);

        return $data['path'];
    }

    public static function run() :void
    {
        $uri = rtrim(substr(self::getUriPath($_SERVER['REQUEST_URI']), 1), '/');
        $uriParts = explode('/', $uri);

        $controllerName = 'task';
        $actionName = 'index';
        $param = '';
        if (isset($uriParts[0]) && !empty($uriParts[0])) {
            $controllerName = $uriParts[0];
        }

        if (isset($uriParts[1]) && !empty($uriParts[1])) {
            $actionName = $uriParts[1];
        }

        if (isset($uriParts[2]) && !empty($uriParts[2])) {
            $param = $uriParts[2];
        }

        $controller = 'App\Controllers\\' . ucfirst($controllerName) . 'Controller';

        if (!class_exists($controller)) {
            self::errorPage();
        }

        $object = new $controller;
        if (!method_exists($object, $actionName)) {
            self::errorPage();
        }

        $object->$actionName($param);
    }

    public static function errorPage() :void
    {
        http_response_code(404);
        require __DIR__ . '/../public/404.php';
        die();
    }
}
