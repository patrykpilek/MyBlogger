<?php

class Users
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::instance();
    }

    public function emailExist($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM `users` WHERE `email` = :email");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function hash($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']) ? true : false;
    }

    public function ID()
    {
        if($this->isLoggedIn()) {
            return $_SESSION['user_id'];
        }
    }

    public function userData($user_id = null)
    {
        $user_id = ($user_id === null) ? $this->ID() : $user_id;
        $stmt = $this->db->prepare("SELECT * FROM `users` WHERE `userID` = :userID");
        $stmt->bindParam(":userID", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}