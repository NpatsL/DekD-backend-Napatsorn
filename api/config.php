
<?php

require_once 'dotenv.php';

class Config
{
    protected $conn = null;

    public function __construct()
    {
        try {
            // For local development, you can use the dotenv package to load environment variables from a .env file
            // $path = dirname(dirname(__FILE__)) . '/.env';
            // $DotEnv = new DotEnv($path);

            $DB_HOST = getenv('DB_HOST');
            $DB_NAME = getenv('DB_NAME');
            $DB_USER = getenv('DB_USER');
            $DB_PASSWORD = getenv('DB_PASSWORD');

            $dsn = 'mysql:host=' . $DB_HOST . ';dbname=' . $DB_NAME;

            $this->conn = new PDO($dsn, $DB_USER, $DB_PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}
?>
