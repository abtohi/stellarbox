<?php

class Login extends Dbh
{
    private $email;
    private $pwd;

    public function __construct($email, $pwd)
    {
        $this->email = $email;
        $this->pwd = $pwd;
    }

    private function getUser()
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->connect()->prepare($sql);

        if (!$stmt->execute([
            "email" => $this->email
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
            $_SESSION["useruid"] = $user["email"]; // Using email as useruid
            $_SESSION["role"] = $user["role"];

            $stmt = null;
        }
    }

    public function loginUser()
    {
        $this->getUser();
    }
}
