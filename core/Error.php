<?php

namespace Core;

use App\Config\Config;

class Error
{

    /**
     * Error handler. Convert all errors to Exceptions by throwing an ErrorException.
     *
     * @param int $level  Error level
     * @param string $message  Error message
     * @param string $file  Filename the error was raised in
     * @param int $line  Line number in the file
     *
     * @return void
     */
    public static function errorHandler(int $level, string $message, string $file, int $line): void
    {
        if (error_reporting() !== 0) {  // to keep the @ operator working
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    public static function writeErrorLogs($exception)
    {
        $logsFolder = dirname(__DIR__) . '/logs/';

        $logsFolderExists = file_exists($logsFolder);
        if (!$logsFolderExists) return;

        // Set the error in the error log
        $log = $logsFolder . date('Y-m-d') . '.txt';
        // If Config::$SHOW_ERRORS === false than the errors are stored in the log folder
        ini_set('error_log', $log);

        $message = "\n\n-------------------------------------------";
        $message .=
            "\n\nUncaught exception: '" . get_class($exception) . "'\n";

        $message .= " with message '" . $exception->getMessage() . "'";

        $message .= "\nStack trace: " . $exception->getTraceAsString();
        $message .= "\nThrown in '" . $exception->getFile() . "' on line " . $exception->getLine();

        error_log($message);
    }

    /**
     * Exception handler.
     *
     * @param Exception $exception  The exception
     *
     * @return void
     */
    public static function exceptionHandler($exception): void
    {
        // Code is 404 (not found) or 500 (general error)
        $code = $exception->getCode();

        if ($code != 404) $code = 500;

        http_response_code($code);

        $showErrorsOnFrontEnd = Config::$SHOW_ERRORS;

        if ($showErrorsOnFrontEnd) {
            echo "<h1>Fatal error</h1>";
            echo "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
            echo "<p>Message: '" . $exception->getMessage() . "'</p>";
            echo "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
            echo "<p>Thrown in '" . $exception->getFile() . "' on line " .
                $exception->getLine() . "</p>";
                
            View::render("errors/$code.php");

            return;
        }
        
        Self::writeErrorLogs($exception);

        View::render("errors/$code.php");
    }
}
