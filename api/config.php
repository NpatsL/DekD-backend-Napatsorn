
<?php

require_once 'dotenv.php';

$env = parse_ini_file('.env');
class Config
{
    protected $conn = null;

    public function __construct()
    {
        try {
            $path = dirname(dirname(__FILE__)) . '/.env';
            $DotEnv = new DotEnv($path);

            $DB_HOST = $_ENV['DB_HOST'];
            $DB_NAME = $_ENV['DB_NAME'];
            $DB_USER = $_ENV['DB_USER'];
            $DB_PASSWORD = $_ENV['DB_PASSWORD'];

            $dsn = 'mysql:host=' . $DB_HOST . ';dbname=' . $DB_NAME;

            $this->conn = new PDO($dsn, $DB_USER, $DB_PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}
?>
