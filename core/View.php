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
        $args['BASE'] = Config::URL_BASE;
        $BASE = Config::URL_BASE;
        extract($args, EXTR_SKIP);

        // $file = "$BASE/resources/views/$view"; // Relative to Core directory
        $file = "../resources/views/$view"; // Relative to Core directory
        if (is_readable($file)) {
            require_once "../resources/views/base/header.php";
            require $file;
            require_once "../resources/views/base/footer.php";
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
        $twig->addGlobal('USER_STATUS', $_SESSION['user_status'] ?? false);
        $twig->addGlobal('SESSION_ID', $_SESSION['user_id'] ?? false);
        $twig->addGlobal('ADM_ID', $_SESSION['adm_id'] ?? false);
        $twig->addGlobal('SESSION_USER_NAME', $_SESSION['user_name'] ?? false);

        echo $twig->render($template, $args);
    }
}
