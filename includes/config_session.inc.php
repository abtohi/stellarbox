<?php

ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

$secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';

session_set_cookie_params([
    'lifetime' => 1800,
    'path' => '/',
    'domain' => 'localhost',
    'secure' => $secure,
    'httponly' => true
]);

session_start();

if (isset($_SESSION['userid'])) {
    if (!isset($_SESSION['last_regeneration'])) {
        regenerate_session_id_loggedin();
    } else {
        $interval = 60 * 30;
        if (time() - $_SESSION['last_regeneration'] >= $interval) {
            regenerate_session_id_loggedin();
        }
    }
} else {
    if (!isset($_SESSION['last_regeneration'])) {
        regenerate_session_id();
    } else {
        $interval = 60 * 30;
        if (time() - $_SESSION['last_regeneration'] >= $interval) {
            regenerate_session_id();
        }
    }
}

function regenerate_session_id()
{
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

function regenerate_session_id_loggedin()
{
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}
