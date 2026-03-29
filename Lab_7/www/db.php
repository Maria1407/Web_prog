<?php
class Database {
    private $pdo;

    public function __construct() {
        $host = 'mysql';
        $dbname = 'lab7';
        $user = 'root';
        $pass = 'root';

        try {
            $this->pdo = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                $user,
                $pass
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
        }
    }

    public function saveMessage($data) {
        if (!$this->pdo) return false;

        $sql = "INSERT INTO messages (message_id, name, email, action, data, created_at)
                VALUES (:message_id, :name, :email, :action, :data, NOW())";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':message_id' => $data['id'],
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':action' => $data['action'],
            ':data' => json_encode($data)
        ]);
    }
}