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

    if ($user && password_verify($password, $user['password'])) {
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
    $role = 'user'; // role default

    $stmt = $this->conn->prepare("INSERT INTO user (email, password, role) VALUES (:email, :password, :role)");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':role', $role);

    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Pendaftaran berhasil'];
    } else {
        return ['success' => false, 'message' => 'Terjadi kesalahan saat mendaftar'];
    }
}
}