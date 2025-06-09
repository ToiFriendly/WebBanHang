<?php
class AccountModel
{
    private $conn;
    private $table_name = "account";
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAccountByUsername($username)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    public function save($username, $fullName, $password, $role, $gmail, $phone, $image, $isDeleted = false)
    {
        if ($this->getAccountByUsername($username)) {
            return false;
        }
        $query = "INSERT INTO " . $this->table_name . " SET username=:username, fullname=:fullname, password=:password, role=:role, gmail=:gmail, phone=:phone, image=:image,isDeleted=:isDeleted";
        $isDeleted = $isDeleted ? 1 : 0; //false la mac dinh
        if (empty($image)) {
            $image = 'default-avt.jpg'; // Set a default image if none is provided
        }
        $stmt = $this->conn->prepare($query);
        $username = htmlspecialchars(strip_tags($username));
        $fullName = htmlspecialchars(strip_tags($fullName));
        $password = password_hash($password, PASSWORD_BCRYPT);
        $role = htmlspecialchars(strip_tags($role));
        $gmail = htmlspecialchars(strip_tags($gmail));
        $phone = htmlspecialchars(strip_tags($phone));
        $image = htmlspecialchars(strip_tags($image));
        $isDeleted = htmlspecialchars(strip_tags($isDeleted));

        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":fullname", $fullName);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":role", $role);
        $stmt->bindParam(":gmail", $gmail);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":image", $image);
        $stmt->bindParam(":isDeleted", $isDeleted);
        return $stmt->execute();
    }
    //xoa mem
    public function softDeleteAccount($id)
    {
        $query = "UPDATE " . $this->table_name . " SET isDeleted = :isDeleted WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $isDeleted = 1; // Đánh dấu là đã xóa mềm
        $stmt->bindParam(":isDeleted", $isDeleted);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
    //lay danh sach tai khoan
    public function getAllAccounts()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE isDeleted = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function getAccountById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    //cap nhat tai khoan
    public function updateAccount($id, $username, $fullName, $password, $role, $gmail, $phone, $image)
    {
        $query = "UPDATE " . $this->table_name . " SET username=:username, fullname=:fullname, password=:password, role=:role, gmail=:gmail, phone=:phone, image=:image WHERE id = :id";
        if (empty($image)) {
            $image = 'default-avt.jpg'; // Set a default image if none is provided
        }
        $stmt = $this->conn->prepare($query);
        $username = htmlspecialchars(strip_tags($username));
        $fullName = htmlspecialchars(strip_tags($fullName));
        $password = password_hash($password, PASSWORD_BCRYPT);
        $role = htmlspecialchars(strip_tags($role));
        $gmail = htmlspecialchars(strip_tags($gmail));
        $phone = htmlspecialchars(strip_tags($phone));
        $image = htmlspecialchars(strip_tags($image));

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":fullname", $fullName);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":role", $role);
        $stmt->bindParam(":gmail", $gmail);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":image", $image);
        return $stmt->execute();
    }
    public function addUser($username, $fullName, $password, $role, $gmail, $phone, $image)
    {
        return $this->save($username, $fullName, $password, $role, $gmail, $phone, $image);
    }
}
