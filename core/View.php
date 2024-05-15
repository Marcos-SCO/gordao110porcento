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

        // $file = "$BASE/public/resources/views/$view"; // Relative to Core directory
        $file = "../public/resources/views/$view"; // Relative to Core directory

        if (!is_readable($file)) {
            // echo "$file not found";
            // throw new \Exception("$file not found");
            header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
            http_response_code(404);

            require_once "../public/resources/views/errors/404.php";

            return;
        }

        ob_start("htmlMinifier");
        
        require_once "../public/resources/views/base/header.php";
        require $file;
        require_once "../public/resources/views/base/footer.php";

        ob_end_flush();
    }
    
}
