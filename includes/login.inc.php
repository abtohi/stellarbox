<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];

    require_once "../Classes/Dbh.php";
    require_once "../Classes/Login.php";

    $login = new Login($email, $pwd);
    $login->loginUser();

    // Redirect ke dashboard utama
    header("Location: ../dashboard.php?login=success");
} else {
    header("Location: ../index.php");
    exit();
}
