<?php
class Order {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function add($name, $passengers, $tariff, $luggage, $payment) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO orders (name, passengers, tariff, luggage, payment) VALUES (?, ?, ?, ?, ?)"
        );
        $luggage_flag = ($luggage === "Да") ? 1 : 0;
        $stmt->execute([$name, $passengers, $tariff, $luggage_flag, $payment]);
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM orders ORDER BY id DESC");
        return $stmt->fetchAll();
    }
}
?>