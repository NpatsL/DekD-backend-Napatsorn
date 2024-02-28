
<?php

class Config
{
    private const DB_HOST = 'sql6.freesqldatabase.com';
    private const DB_NAME = 'sql6686984';
    private const DB_USER = 'sql6686984';
    private const DB_PASSWORD = 'bgVXsDJsl3';
    private $dsn = "mysql:host=" . self::DB_HOST . ";dbname=" . self::DB_NAME;
    protected $conn = null;

    public function __construct()
    {
        try {
            $this->conn = new PDO($this->dsn, self::DB_USER, self::DB_PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}
?>
