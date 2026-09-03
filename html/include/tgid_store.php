<?php

function tgid_json_candidates() {
    return array(
        '/etc/hblink3/json/talkgroup_ids.json',
        '/opt/HBMonv2/data/talkgroup_ids.json',
    );
}

function tgid_users_candidates() {
    return array(
        '/etc/hblink3/tgmanager.users',
        '/opt/HBMonv2/tgmanager.users',
    );
}

function tgid_json_path() {
    if (defined('TGID_JSON') && TGID_JSON !== '') {
        return TGID_JSON;
    }
    foreach (tgid_json_candidates() as $path) {
        if (is_file($path)) {
            return $path;
        }
    }
    if (is_dir('/etc/hblink3/json')) {
        return '/etc/hblink3/json/talkgroup_ids.json';
    }
    return '/opt/HBMonv2/data/talkgroup_ids.json';
}

function tgid_users_path() {
    if (defined('TGMANAGER_USERS') && TGMANAGER_USERS !== '') {
        return TGMANAGER_USERS;
    }
    foreach (tgid_users_candidates() as $path) {
        if (is_file($path)) {
            return $path;
        }
    }
    if (is_dir('/etc/hblink3')) {
        return '/etc/hblink3/tgmanager.users';
    }
    return '/opt/HBMonv2/tgmanager.users';
}

function tgid_http_url() {
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && (string)$_SERVER['SERVER_PORT'] === '443')
        || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
    $scheme = $https ? 'https' : 'http';
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '127.0.0.1';
    return $scheme.'://'.$host.'/json/talkgroup_ids.json';
}

function tgid_record_id($record) {
    if (!is_array($record)) {
        return 0;
    }
    if (isset($record['id']) && $record['id'] !== '') {
        return intval($record['id']);
    }
    if (isset($record['tgid']) && $record['tgid'] !== '') {
        return intval($record['tgid']);
    }
    return 0;
}

function tgid_record_callsign($record) {
    if (is_array($record) && isset($record['callsign'])) {
        return (string)$record['callsign'];
    }
    return '';
}

function tgid_sort_records($records) {
    usort($records, function ($a, $b) {
        $aid = tgid_record_id($a);
        $bid = tgid_record_id($b);
        if ($aid === $bid) {
            return 0;
        }
        return ($aid < $bid) ? -1 : 1;
    });
    return $records;
}

function tgid_parse($data) {
    $meta = array(
        'list_key' => 'results',
        'had_count' => false,
        'extra' => array(),
        'records' => array(),
    );
    if (!is_array($data)) {
        return $meta;
    }
    if (array_key_exists('count', $data)) {
        $meta['had_count'] = true;
        unset($data['count']);
    }
    $list_key = null;
    foreach ($data as $key => $value) {
        if (is_array($value) && $list_key === null) {
            $list_key = $key;
            $meta['records'] = array_values($value);
        } else {
            $meta['extra'][$key] = $value;
        }
    }
    if ($list_key !== null) {
        $meta['list_key'] = $list_key;
    }
    $meta['records'] = tgid_sort_records($meta['records']);
    return $meta;
}

function tgid_decode_json($raw) {
    $data = json_decode($raw, true);
    if (!is_array($data)) {
        return null;
    }
    return tgid_parse($data);
}

function tgid_fetch_http() {
    if (empty($_SERVER['HTTP_HOST'])) {
        return null;
    }
    $url = tgid_http_url();
    $ctx = stream_context_create(array(
        'http' => array(
            'method' => 'GET',
            'timeout' => 3,
            'ignore_errors' => true,
            'header' => "Accept: application/json\r\n",
        ),
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
        ),
    ));
    $raw = @file_get_contents($url, false, $ctx);
    if ($raw === false || $raw === '') {
        return null;
    }
    return tgid_decode_json($raw);
}

function tgid_load($allow_http = true) {
    $path = tgid_json_path();
    $result = array(
        'path' => $path,
        'readable' => false,
        'source' => '',
        'list_key' => 'results',
        'had_count' => true,
        'extra' => array(),
        'records' => array(),
        'raw' => '',
    );
    if (is_readable($path)) {
        $raw = @file_get_contents($path);
        if ($raw !== false && $raw !== '') {
            $parsed = tgid_decode_json($raw);
            if ($parsed !== null) {
                $result['readable'] = true;
                $result['source'] = 'file';
                $result['raw'] = $raw;
                return array_merge($result, $parsed);
            }
        }
    }
    if ($allow_http) {
        $parsed = tgid_fetch_http();
        if ($parsed !== null) {
            $result['readable'] = true;
            $result['source'] = 'http';
            return array_merge($result, $parsed);
        }
    }
    return $result;
}

function tgid_build_payload($records, $meta) {
    $list_key = isset($meta['list_key']) ? $meta['list_key'] : 'results';
    $records = tgid_sort_records($records);
    $payload = array();
    if (!isset($meta['had_count']) || $meta['had_count']) {
        $payload['count'] = count($records);
    }
    $payload[$list_key] = array_values($records);
    if (!empty($meta['extra']) && is_array($meta['extra'])) {
        foreach ($meta['extra'] as $key => $value) {
            if ($key === $list_key || $key === 'count') {
                continue;
            }
            $payload[$key] = $value;
        }
    }
    return $payload;
}

function tgid_new_record($id, $callsign) {
    return array(
        'id' => $id,
        'tgid' => $id,
        'callsign' => $callsign,
    );
}

function tgid_apply_record($record, $id, $callsign) {
    if (!is_array($record)) {
        $record = array();
    }
    $record['id'] = $id;
    $record['tgid'] = $id;
    $record['callsign'] = $callsign;
    return $record;
}

function tgid_save($records, $meta = array()) {
    $path = tgid_json_path();
    $dir = dirname($path);
    if (!is_dir($dir)) {
        return false;
    }
    $payload = tgid_build_payload($records, $meta);
    $json = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        return false;
    }
    $json .= "\n";
    $exists = is_file($path);
    $fp = @fopen($path, $exists ? 'c+' : 'w');
    if ($fp === false) {
        return false;
    }
    if (!flock($fp, LOCK_EX)) {
        fclose($fp);
        return false;
    }
    if ($exists) {
        ftruncate($fp, 0);
        rewind($fp);
    }
    $ok = fwrite($fp, $json) !== false;
    fflush($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
    return $ok;
}

function tgid_csv_field($value) {
    $value = (string)$value;
    if (strpos($value, ',') !== false || strpos($value, '"') !== false || strpos($value, "\n") !== false) {
        return '"'.str_replace('"', '""', $value).'"';
    }
    return $value;
}

function tgid_csv_export($records) {
    $out = "id,tgid,callsign\n";
    foreach (tgid_sort_records($records) as $record) {
        $id = tgid_record_id($record);
        if ($id < 1) {
            continue;
        }
        $tgid = (isset($record['tgid']) && $record['tgid'] !== '') ? intval($record['tgid']) : $id;
        $out .= $id.','.$tgid.','.tgid_csv_field(tgid_record_callsign($record))."\n";
    }
    return $out;
}
