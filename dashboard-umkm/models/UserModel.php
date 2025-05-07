<?php

class UserModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function login($email, $password): mixed
    {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return $user;
        }

        return false;
    }

    public function register($email, $password)
    {
        $check = $this->conn->prepare("SELECT COUNT(*) FROM user WHERE email = :email");
        $check->bindParam(':email', $email);
        $check->execute();
        if ($check->fetchColumn() > 0) {
            return ['success' => false, 'message' => 'Email sudah terdaftar'];
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("INSERT INTO user (email, password) VALUES (:email, :password)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Pendaftaran berhasil'];
        } else {
            return ['success' => false, 'message' => 'Terjadi kesalahan saat mendaftar'];
        }
    }

    // ✅ Tambahan fungsi getById
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
