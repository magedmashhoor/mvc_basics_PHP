<?php
/**
 * CORE MODEL CLASS
 * Responsibilities:
 * 1. Manages database connection (PDO singleton)
 * 2. Provides base functionality for all models
 * 3. Handles connection errors
 */
namespace Core;

// Import required database classes
use PDO;           // PHP Data Objects (database interface)
use PDOException;  // PDO-specific exceptions

class Model
{
    /**
     * SHARED DATABASE CONNECTION
     * - Static: Single connection shared across all models
     * - Nullable: ?PDO means it can be null before first connection
     * - Protected: Only accessible within this class and child classes
     */
    protected static ?PDO $pdo = null;

    /**
     * TABLE CONFIGURATION
     * - Default empty table name (must be overridden in child models)
     * - Example in User model: protected string $table = 'users';
     */
    protected string $table = '';

    /**
     * PRIMARY KEY FIELD
     * - Default 'id' column (commonly used)
     * - Override in child models if different (e.g. 'user_id')
     */
    protected string $primaryKey = 'id';

    /**
     * CONSTRUCTOR
     * - Automatically called when new model instance is created
     * - Ensures database connection exists
     */
    public function __construct()
    {
        // Check if connection doesn't exist
        if (!self::$pdo) {
            $this->connect(); // Establish new connection
        }
    }

    /**
     * DATABASE CONNECTION METHOD
     * - Sets up PDO with proper configuration
     * - Handles connection errors
     */
    protected function connect()
    {
        // Database configuration (move to config file in production)
        $config = [
            'host' => 'localhost',    // Database server address
            'dbname' => 'doctor_infor',   // Database name
            'username' => 'root',     // Database username
            'password' => null,       // Database password (null for empty)
            'charset' => 'utf8mb4'    // Character encoding (supports full Unicode)
        ];

        /**
         * DATA SOURCE NAME (DSN)
         * - Connection string for PDO
         * - Format: "mysql:host=HOST;dbname=DBNAME;charset=CHARSET"
         */
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
        
        try {
            /**
             * CREATE PDO INSTANCE
             * Parameters:
             * 1. DSN string
             * 2. Username
             * 3. Password
             * 4. Options array
             */
            self::$pdo = new PDO($dsn, $config['username'], $config['password']);
             /*[
                // Throw exceptions for errors (better than silent failures)
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                
                // Return associative arrays by default (no numeric indexes)
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                
                // Other recommended options:
                PDO::ATTR_EMULATE_PREPARES => false,  // Use real prepared statements
                PDO::ATTR_STRINGIFY_FETCHES => false  // Preserve data types
            ]);*/
            
        } catch (PDOException $e) {
            /**
             * CONNECTION ERROR HANDLING
             * - die() stops execution and shows error (for development)
             * - In production, log this and show user-friendly message
             */
            die("Database connection failed: " . $e->getMessage());
        }
    }
}