<?php
include_once 'include/config.php';
include_once 'include/tgid_store.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Accept');
header('Cache-Control: no-cache');

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$format = isset($_GET['format']) ? strtolower(trim((string)$_GET['format'])) : 'json';
$download = isset($_GET['download']) && (string)$_GET['download'] !== '' && (string)$_GET['download'] !== '0';

$tg = tgid_load(false);
$path = tgid_json_path();
$raw = '';
if (is_readable($path)) {
    $raw = @file_get_contents($path);
}
if ($raw === false || $raw === '') {
    $raw = json_encode(tgid_build_payload($tg['records'], $tg), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)."\n";
}

if ($format === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    if ($download) {
        header('Content-Disposition: attachment; filename="talkgroup_ids.csv"');
    }
    echo tgid_csv_export($tg['records']);
    exit;
}

header('Content-Type: application/json; charset=utf-8');
if ($download) {
    header('Content-Disposition: attachment; filename="talkgroup_ids.json"');
}
echo $raw;
