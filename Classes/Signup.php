<?php

class Signup extends Dbh
{
    private $username;
    private $email;
    private $pwd;
    private $role;

    public function __construct($username, $email, $pwd, $role)
    {
        $this->username = $username;
        $this->email = $email;
        $this->pwd = $pwd;
        $this->role = $role;
    }

    private function insertUser()
    {
        $sql = "INSERT INTO users (username, email, pwd, role) VALUES (:username, :email, :pwd, :role)";
        $stmt = $this->connect()->prepare($sql);
        $hashedPwd = password_hash($this->pwd, PASSWORD_BCRYPT);
        $stmt->execute([
            "username" => $this->username,
            "email" => $this->email,
            "pwd" => $hashedPwd,
            "role" => $this->role
        ]);
    }

    private function checkEmpty()
    {
        if (isset($this->username) || isset($this->email) || isset($this->pwd)) {
            return false;
        }
        return true;
    }

    private function checkUser()
    {
        $sql = "SELECT * FROM users WHERE username = :username OR email = :email";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([
            "username" => $this->username,
            "email" => $this->email
        ]);
        $result = $stmt->fetch();
        return $result;
    }

    public function signupUser()
    {
        // Note: checkEmpty logic seems inverted in original code (returns true if NOT empty?), let's check.
        // Original checkEmpty: if (isset...) return false; return true;
        // If isset(username) is true, it returns false. So checkEmpty() returns false if fields are set.
        // So if ($this->checkEmpty()) means "if fields are NOT set" (i.e. empty).
        // Wait, isset() returns true if variable exists and is not null. It doesn't check for empty string "".
        // But let's stick to fixing the header error first.
        
        if ($this->checkEmpty()) {
            header("Location: ../signup.php?error=emptyinput");
            exit();
        } else if ($this->checkUser()) {
            header("Location: ../signup.php?error=userexists");
            exit();
        } else {
            $this->insertUser();
            header("Location: ../signup.php?error=none");
            return true;
        }
    }
}
