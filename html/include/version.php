<?php

function hbmon_read_version_file($path) {
    if ($path === '' || !is_readable($path)) {
        return '';
    }
    $raw = @file_get_contents($path);
    if ($raw === false) {
        return '';
    }
    $raw = str_replace("\r", '', $raw);
    $line = trim(strtok($raw, "\n"));
    return $line;
}

function hbmon_dashboard_version() {
    $candidates = array(
        '/opt/HBMonv2/VERSION',
    );
    $repo = dirname(__DIR__, 2).'/VERSION';
    if (!in_array($repo, $candidates, true)) {
        $candidates[] = $repo;
    }
    foreach ($candidates as $path) {
        $ver = hbmon_read_version_file($path);
        if ($ver !== '') {
            return $ver;
        }
    }
    return '2.1.1';
}

function hbmon_docker_version() {
    $compose = '/etc/hblink3/docker-compose.yml';
    $marker = '/etc/hblink3/.installer_path';
    if (!is_file($compose) && !is_file($marker)) {
        return '';
    }
    $inst = hbmon_read_version_file($marker);
    $candidates = array();
    if ($inst !== '') {
        $candidates[] = rtrim($inst, '/').'/VERSION';
    }
    $candidates[] = '/opt/hblink3-docker-install/VERSION';
    foreach ($candidates as $path) {
        $ver = hbmon_read_version_file($path);
        if ($ver !== '') {
            return $ver;
        }
    }
    return '';
}

if (!defined('DASH')) {
    define('DASH', hbmon_dashboard_version());
}
if (!defined('VERSION')) {
    define('VERSION', 'Ver '.DASH);
}
if (!defined('DOCKER_VERSION')) {
    define('DOCKER_VERSION', hbmon_docker_version());
}
