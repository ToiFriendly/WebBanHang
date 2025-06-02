<?php
class OrderModel
{
    private $conn;
    private $table_name = "orders";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createOrder($name, $phone, $address, $gmail = null, $time = null, $note = null)
    {
        $query = "INSERT INTO " . $this->table_name . " (name, phone, address, gmail, time, note, created_at) VALUES (:name, :phone, :address, :gmail, :time, :note, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':gmail', $gmail);
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':note', $note);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }
}
