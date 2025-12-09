<?php

require_once '../Classes/Dbh.php';
require_once '../Classes/Signup.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $role = $_POST['role'];

    $signup = new Signup($username, $email, $pwd, $role);
    $signup->signupUser();
}
