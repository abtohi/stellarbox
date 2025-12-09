<?php

class Login extends Dbh
{
    private $username;
    private $pwd;

    public function __construct($username, $pwd)
    {
        $this->username = $username;
        $this->pwd = $pwd;
    }

    private function getUser()
    {
        $sql = "SELECT * FROM users WHERE username = :username OR email = :email";
        $stmt = $this->connect()->prepare($sql);

        if (!$stmt->execute([
            "username" => $this->username,
            "email" => $this->username
        ])) {
            $stmt = null;
            header("Location: ../index.php?error=stmtfailed");
            exit();
        }

        if ($stmt->rowCount() == 0) {
            $stmt = null;
            header("Location: ../index.php?error=usernotfound");
            exit();
        }

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $checkPwd = password_verify($this->pwd, $user["pwd"]);

        if ($checkPwd == false) {
            $stmt = null;
            header("Location: ../index.php?error=wrongpassword");
            exit();
        } elseif ($checkPwd == true) {
            session_start();
            $_SESSION["userid"] = $user["id"];
            $_SESSION["useruid"] = $user["username"];
            $_SESSION["role"] = $user["role"];

            $stmt = null;
        }
    }

    private function checkEmpty()
    {
        if (empty($this->username) || empty($this->pwd)) {
            return false;
        }
        return true;
    }

    public function loginUser()
    {
        if ($this->checkEmpty() == false) {
            header("Location: ../index.php?error=emptyinput");
            exit();
        }

        $this->getUser();
    }
}
