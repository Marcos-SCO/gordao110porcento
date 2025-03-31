<?php

namespace App\Config;

use Dotenv\Dotenv;

class Config
{
    public static function loadEnv()
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();
    }

    /**
     * Server running the application
     * @var bool
     */
    public static bool $IS_APACHE_SERVER;

    /**
     * Database host
     * @var string
     */
    public static string $DB_HOST;

    /**
     * Database name
     * @var string
     */
    public static string $DB_NAME;

    /**
     * Database user
     * @var string
     */
    public static string $DB_USER;

    /**
     * Database password
     * @var string
     */
    public static string $DB_PASS;

    /**
     * Database port
     * @var int
     */
    public static int $DB_PORT;

    /**
     * Database charset
     * @var string
     */
    public static string $DB_CHARSET = 'utf8mb4';

    /**
     * Base URL
     * @var string
     */
    public static string $URL_BASE;

    /**
     * Resources Path
     * @var string
     */
    public static string $RESOURCES_PATH;

    /**
     * Show or hide error messages
     * @var boolean
     */
    public static bool $SHOW_ERRORS = true;

    // Static method to initialize variables
    public static function init()
    {
        self::loadEnv();
        self::$IS_APACHE_SERVER = isset($_ENV['IS_APACHE_SERVER']) && $_ENV['IS_APACHE_SERVER'] === 'true';
        self::$DB_HOST = $_ENV['DOCKER_DB_HOST'] ?? 'localhost';
        self::$DB_NAME = $_ENV['DOCKER_MYSQL_DATABASE'] ?? 'fallback_db_name';
        self::$DB_USER = $_ENV['DOCKER_MYSQL_USER'] ?? 'root';
        self::$DB_PASS = $_ENV['DOCKER_MYSQL_PASSWORD'] ?? '';
        self::$DB_PORT = isset($_ENV['DOCKER_MYSQL_PORT']) ? (int) $_ENV['DOCKER_MYSQL_PORT'] : 3306;

        self::$URL_BASE = $_ENV['URL_BASE'] ?? 'http://localhost';

        self::$RESOURCES_PATH = self::$URL_BASE . $_ENV['RESOURCES_PATH'] ?? '/public/resources';
    }
}

// Load environment variables when the class is used
Config::init();
