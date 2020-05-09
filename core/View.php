<?php

namespace Core;

use App\Config\Config;

class View
{
    /**
     * Render a view file
     * 
     * @param string $view The view file
     * 
     * @return void
     */
    public static function render(string $view, array $args = []): void
    {
        extract($args, EXTR_SKIP);

        $file = "../app/views/$view"; // Relative to Core directory

        if (is_readable($file)) {
            require $file;
        } else {
            // echo "$file not found";
            throw new \Exception("$file not found");
        }
    }

    /**
     * Render a view template using Twig
     * 
     * @param string $template  The template file
     * @param array $arg  Associtive array of data to display in the view (optional)
     * 
     * @return void 
     */
    public static function renderTemplate(string $template, array $args = []): void
    {
        $loader = new \Twig\Loader\FilesystemLoader('../resources/views');
        // Twig options
        $options = [
            // Path to cache
            'cache' => '../resources/views/cache',
            // Disable cache in development
            'cache' => false,
            // Debug with Twig
            'debug', true,
        ];
        $twig = new \Twig\Environment($loader, $options);

        // Get global path
        $twig->addGlobal('BASE', Config::URL_BASE);

        echo $twig->render($template, $args);
    }
}