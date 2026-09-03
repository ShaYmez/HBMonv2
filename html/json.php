<?php
include_once 'include/config.php';
include_once 'include/tgid_store.php';

$path = tgid_json_path();
$raw = '';
if (is_readable($path)) {
    $raw = @file_get_contents($path);
}

if ($raw === false || $raw === '') {
    $tg = tgid_load(false);
    $raw = json_encode(tgid_build_payload($tg['records'], $tg), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)."\n";
}

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache');
header('Access-Control-Allow-Origin: *');
echo $raw;
