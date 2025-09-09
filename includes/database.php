<?php
/**
 * Database Configuration and Connection
 * 
 * This file contains the database connection configuration for the PHP website.
 * It uses PDO (PHP Data Objects) for secure database operations.
 */

// Database configuration constants
define('DB_HOST', 'localhost');
define('DB_NAME', 'php_website_basic');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('DB_CHARSET', 'utf8mb4');

/**
 * Database Connection Class
 */
class Database {
    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;
    private $charset = DB_CHARSET;
    private $pdo;
    private $error;

    /**
     * Create database connection
     */
    public function __construct() {
        $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}";
        
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Database Connection Error: " . $e->getMessage());
        }
    }

    /**
     * Get PDO connection instance
     * 
     * @return PDO|null
     */
    public function getConnection() {
        return $this->pdo;
    }

    /**
     * Get connection error if any
     * 
     * @return string|null
     */
    public function getError() {
        return $this->error;
    }

    /**
     * Execute a prepared statement
     * 
     * @param string $sql SQL query
     * @param array $params Parameters to bind
     * @return PDOStatement|false
     */
    public function query($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log("Query Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get single record
     * 
     * @param string $sql SQL query
     * @param array $params Parameters to bind
     * @return array|false
     */
    public function single($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetch() : false;
    }

    /**
     * Get multiple records
     * 
     * @param string $sql SQL query
     * @param array $params Parameters to bind
     * @return array
     */
    public function resultSet($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetchAll() : [];
    }

    /**
     * Get row count
     * 
     * @return int
     */
    public function rowCount() {
        return $this->pdo->rowCount();
    }

    /**
     * Get last inserted ID
     * 
     * @return string
     */
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
}

// Create a global database instance
$database = new Database();

// Check for connection errors
if ($database->getError()) {
    // In production, you might want to handle this more gracefully
    die("Database connection failed. Please try again later.");
}

/**
 * SQL for creating the users table (run this manually in your MySQL database)
 * 
 * CREATE TABLE users (
 *     id INT AUTO_INCREMENT PRIMARY KEY,
 *     full_name VARCHAR(100) NOT NULL,
 *     email VARCHAR(150) UNIQUE NOT NULL,
 *     password_hash VARCHAR(255) NOT NULL,
 *     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 *     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
 * );
 */
?>
