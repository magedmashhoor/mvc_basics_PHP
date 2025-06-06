<?php
/**
 * USER MODEL CLASS
 * Responsibilities:
 * 1. Handles all database operations for users
 * 2. Extends base Model class for core functionality
 * 3. Maintains compatibility with existing views
 */
namespace App\Models;

// Import required classes
use Core\Model;     // Base model class
use PDO;           // PHP Database Objects
use PDOException;   // Database exceptions

class Users extends Model
{
    /**
     * TABLE CONFIGURATION
     * - Overrides parent Model's empty table name
     * - Matches your 'UserData' database table
     */
    protected string $table = 'doctor_info';

    /**
     * PRIMARY KEY FIELD
     * - Specifies 'ID' column as primary key
     * - Different from parent Model's default 'id'
     */
    protected string $primaryKey = 'ID';

    /**
     * GET USERS METHOD
     * - Retrieves all users from database
     * - Formats data for home.php view compatibility
     * - Falls back to dummy data if database fails
     * 
     * @return array - Formatted user data
     */
    public function GetDoctorInfo()
    {
        try {
            /**
             * DATABASE QUERY EXECUTION
             * 1. Creates SQL query using PDO
             * 2. Fetches all results as associative arrays
             * 3. Formats results to match view expectations
             */
            $stmt = self::$pdo->query("SELECT doctor_name, GenSpec, SpeSpec, Hospital, Gove, District, Shift_Period, Phone FROM {$this->table}");
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            /**
             * DATA TRANSFORMATION
             * - Uses array_map to reformat each user record
             * - Maintains exact structure expected by home.php:
             *   [
             *     ['Name' => ..., 'Age' => ..., 'Details' => ...],
             *     ...
             *   ]
             */
            return array_map(function($user) {
                return [
                    'doctor_name' => $user['doctor_name'],        // Maps to Name column
                    'GenSpec' => $user['GenSpec'],          // Maps to Age column
                    'SpeSpec' => $user['SpeSpec'],   // Maps to Details column
                    'Hospital' => $user['Hospital'],   // Maps to Details column
                    'Gove' => $user['Gove'],   // Maps to Details column
                    'District' => $user['District'],   // Maps to Details column
                    'Shift_Period' => $user['Shift_Period'],   // Maps to Details column
                    'Phone' => $user['Phone'],   // Maps to Details column
                    
                    
                ];
            }, $users);
            
        } catch (PDOException $e) {
            /**
             * ERROR HANDLING
             * - Returns fallback data if database fails
             * - Maintains application functionality
             * - Should log errors in production:
             *   error_log("Database error: " . $e->getMessage());
             */
            return [
                ['Name' => 'Maged Mashhoor', 'Age' => 40, 'Details' => 'Solutions Architect'],
                ['Name' => 'Husam', 'Age' => 39, 'Details' => 'Full stack'],
                ['Name' => 'Nagd', 'Age' => 40, 'Details' => 'Flutter dev']
            ];
        }
    }

    /**
     * ADD DOCTOR METHOD
     * - Inserts new doctor into database
     * 
     * @param array $data - Doctor information
     * @return bool - Success status
     */
    public function addDoctor($data)
    {
        try {
            $sql = "INSERT INTO {$this->table} (doctor_name, GenSpec, SpeSpec, Hospital, Gove, District, Shift_Period, Phone) 
                    VALUES (:doctor_name, :GenSpec, :SpeSpec, :Hospital, :Gove, :District, :Shift_Period, :Phone)";
            
            $stmt = self::$pdo->prepare($sql);
            
            return $stmt->execute([
                ':doctor_name' => $data['doctor_name'],
                ':GenSpec' => $data['GenSpec'],
                ':SpeSpec' => $data['SpeSpec'] ?? '',
                ':Hospital' => $data['Hospital'],
                ':Gove' => $data['Gove'],
                ':District' => $data['District'],
                ':Shift_Period' => $data['Shift_Period'],
                ':Phone' => $data['Phone']
            ]);
            
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * SEARCH DOCTORS METHOD
     * - Searches doctors by name with LIKE query
     * 
     * @param string $query - Search term
     * @return array - Matching doctors
     */
    public function searchDoctors($query)
    {
        try {
            $sql = "SELECT ID, doctor_name, GenSpec, SpeSpec, Hospital, Gove, District, Shift_Period, Phone 
                    FROM {$this->table} 
                    WHERE doctor_name LIKE :query 
                    ORDER BY doctor_name 
                    LIMIT 10";
            
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute([':query' => '%' . $query . '%']);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Search error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * DELETE DOCTOR METHOD
     * - Deletes doctor by ID
     * 
     * @param int $doctorId - Doctor ID to delete
     * @return bool - Success status
     */
    public function deleteDoctor($doctorId)
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE ID = :id";
            $stmt = self::$pdo->prepare($sql);
            
            return $stmt->execute([':id' => $doctorId]);
            
        } catch (PDOException $e) {
            error_log("Delete error: " . $e->getMessage());
            return false;
        }
    }
}