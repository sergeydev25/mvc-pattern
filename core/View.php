<?php

namespace Core;

class View
{
    /**
     * @param string $view
     * @param array $data
     * @throws \ErrorException
     */
    public static function render(string $view, array $data = [])
    {
        $path = __DIR__ . '/../app/Views/' . $view . '.php';
        if (!file_exists($path)) {
            throw new \ErrorException('view cannot be found');
         }

        require_once($path);
    }
}
