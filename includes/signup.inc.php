<?php

require_once '../Classes/Dbh.php';
require_once '../Classes/Signup.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $role = $_POST['role'];

    $signup = new Signup($email, $pwd, $role);
    $signup->signupUser();
}
