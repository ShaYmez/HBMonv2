<?php

function tgmanager_session_start() {
    if (session_id() !== '') {
        return;
    }
    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && (string)$_SERVER['SERVER_PORT'] === '443')
        || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
    if (PHP_VERSION_ID >= 70300) {
        session_set_cookie_params(array(
            'lifetime' => 0,
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Lax',
            'secure' => $secure,
        ));
    } else {
        session_set_cookie_params(0, '/', '', $secure, true);
    }
    session_start();
}

function tgmanager_csrf_token() {
    tgmanager_session_start();
    if (empty($_SESSION['tg_csrf'])) {
        $_SESSION['tg_csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['tg_csrf'];
}

function tgmanager_csrf_ok() {
    tgmanager_session_start();
    return isset($_POST['csrf'], $_SESSION['tg_csrf'])
        && hash_equals($_SESSION['tg_csrf'], (string)$_POST['csrf']);
}

function tgmanager_logged_in() {
    tgmanager_session_start();
    return !empty($_SESSION['tg_user']);
}

function tgmanager_user() {
    tgmanager_session_start();
    return isset($_SESSION['tg_user']) ? (string)$_SESSION['tg_user'] : '';
}

function tgmanager_read_users($path) {
    $users = array();
    if ($path === '' || !is_readable($path)) {
        return $users;
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES);
    if ($lines === false) {
        return $users;
    }
    foreach ($lines as $line) {
        $line = trim(str_replace("\r", '', $line));
        if ($line === '' || $line[0] === '#') {
            continue;
        }
        $pos = strpos($line, ':');
        if ($pos === false || $pos === 0) {
            continue;
        }
        $name = substr($line, 0, $pos);
        $hash = substr($line, $pos + 1);
        if ($name !== '' && $hash !== '') {
            $users[$name] = $hash;
        }
    }
    return $users;
}

function tgmanager_has_users() {
    $users = tgmanager_read_users(tgid_users_path());
    return !empty($users);
}

function tgmanager_login($user, $pass) {
    $users = tgmanager_read_users(tgid_users_path());
    if ($user === '' || !isset($users[$user])) {
        return false;
    }
    if (!password_verify($pass, $users[$user])) {
        return false;
    }
    tgmanager_session_start();
    session_regenerate_id(true);
    $_SESSION['tg_user'] = $user;
    $_SESSION['tg_csrf'] = bin2hex(random_bytes(16));
    return true;
}

function tgmanager_logout() {
    tgmanager_session_start();
    $_SESSION = array();
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p['path'], isset($p['domain']) ? $p['domain'] : '', !empty($p['secure']), !empty($p['httponly']));
    }
    session_destroy();
}
