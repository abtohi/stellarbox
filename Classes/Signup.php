<?php

class Signup extends Dbh
{
    private $email;
    private $pwd;
    private $role;

    public function __construct($email, $pwd, $role)
    {
        $this->email = $email;
        $this->pwd = $pwd;
        $this->role = $role;
    }

    private function insertUser()
    {
        $sql = "INSERT INTO users (email, pwd, role) VALUES (:email, :pwd, :role)";
        $stmt = $this->connect()->prepare($sql);
        $hashedPwd = password_hash($this->pwd, PASSWORD_BCRYPT);
        $stmt->execute([
            "email" => $this->email,
            "pwd" => $hashedPwd,
            "role" => $this->role
        ]);
    }

    private function checkEmpty()
    {
        if (empty($this->email) || empty($this->pwd)) {
            return false;
        }
        return true;
    }

    private function checkUser()
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([
            "email" => $this->email
        ]);
        $result = $stmt->fetch();
        return $result;
    }

    public function signupUser()
    {
        if ($this->checkEmpty() == false) {
            header("Location: ../signup.php?error=emptyinput");
            exit();
        }
        if ($this->checkUser() == true) {
            header("Location: ../signup.php?error=useroremailtaken");
            exit();
        }

        $this->insertUser();
        header("Location: ../signup.php?error=none");
    }
}
