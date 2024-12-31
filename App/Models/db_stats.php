<?php
namespace App\DatabaseStats;
use App\Database\Database;

class DatabaseStats {
    private $pdo;
    
    public function __construct($conn) {
        $this->pdo = $conn->conn();
    }

    public function getStats() {
        $stats = [];
        
        // Get total users
        $stmt = $this->pdo->query("SELECT COUNT(*) as count FROM T_User");
        $stats['userCount'] = $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
        
       // Get database size
        $stmt = $this->pdo->query("			SELECT top 1 
    d.name AS Store,
    ROUND(SUM(CAST(mf.size AS BIGINT) * 8.0 / 1024), 2) AS size ,
    ROUND(SUM(CAST(mf.size AS BIGINT) * 8.0 / 1024 / 1024), 2) AS SizeInGB
FROM sys.master_files mf
INNER JOIN sys.databases d ON d.database_id = mf.database_id
GROUP BY d.name
ORDER BY size DESC");
        $stats['dbSize'] = $stmt->fetch(\PDO::FETCH_ASSOC)['size'];
        
        // Get total tables
        $stmt = $this->pdo->query("
SELECT 
    s.name AS SchemaName,
    COUNT(*) AS count
FROM sys.tables t
JOIN sys.schemas s ON t.schema_id = s.schema_id
GROUP BY s.name
ORDER BY SchemaName");
        $stats['tableCount'] = $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
      
        return $stats;
    }
}

// Usage
// $config = [
//     'host' => 'localhost',
//     'dbname' => 'your_database',
//     'username' => 'your_username',
//     'password' => 'your_password'
// ];

$dbStats = new DatabaseStats(new Database());
echo json_encode($dbStats->getStats());
