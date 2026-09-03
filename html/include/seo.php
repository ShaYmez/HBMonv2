<?php

if (!defined('SEO_INDEX')) {
    define('SEO_INDEX', true);
}

function hbmon_request_https() {
    return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && (string)$_SERVER['SERVER_PORT'] === '443')
        || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
}

function hbmon_canonical_url() {
    $host = isset($_SERVER['HTTP_HOST']) ? preg_replace('/[^A-Za-z0-9\.\-\:\[\]]/', '', (string)$_SERVER['HTTP_HOST']) : '';
    if ($host === '') {
        return '';
    }
    $scheme = hbmon_request_https() ? 'https' : 'http';
    $uri = isset($_SERVER['REQUEST_URI']) ? (string)$_SERVER['REQUEST_URI'] : '/';
    $path = strtok($uri, '?');
    if ($path === false || $path === '') {
        $path = '/';
    }
    return $scheme.'://'.$host.$path;
}

function hbmon_seo_head($page, $opts = array()) {
    $report = defined('REPORT_NAME') ? REPORT_NAME : 'HBlink 3 Master Server';
    $dash = defined('DASH') ? DASH : '';
    $page = (string)$page;
    $title = $report.' – '.$page.' – HBMonv2';
    $description = $report.' is an HBMonv2 DMR dashboard (version '.$dash.').';
    $canonical = hbmon_canonical_url();
    $noindex = !empty($opts['noindex']) || !SEO_INDEX;
    $robots = $noindex ? 'noindex,nofollow' : 'index,follow';
    $og_image = $canonical !== '' ? dirname($canonical).'/img/HBLINK_logoV2.png' : 'img/HBLINK_logoV2.png';
    if (substr($canonical, -1) === '/') {
        $og_image = $canonical.'img/HBLINK_logoV2.png';
    }
    $software = array(
        '@context' => 'https://schema.org',
        '@type' => 'SoftwareApplication',
        'name' => 'HBMonv2',
        'applicationCategory' => 'UtilitiesApplication',
        'operatingSystem' => 'Linux',
        'softwareVersion' => $dash,
        'url' => 'https://github.com/ShaYmez/HBMonv2',
        'isBasedOn' => 'https://github.com/sp2ong/HBMonv2',
    );
    $ld = $software;
    if (!empty($opts['item_list']) && is_array($opts['item_list'])) {
        $elements = array();
        $pos = 1;
        foreach ($opts['item_list'] as $item) {
            $elements[] = array(
                '@type' => 'ListItem',
                'position' => $pos,
                'name' => $item['name'],
                'identifier' => $item['id'],
            );
            $pos++;
        }
        $ld = array(
            '@context' => 'https://schema.org',
            '@graph' => array(
                array(
                    '@type' => 'SoftwareApplication',
                    'name' => 'HBMonv2',
                    'applicationCategory' => 'UtilitiesApplication',
                    'operatingSystem' => 'Linux',
                    'softwareVersion' => $dash,
                    'url' => 'https://github.com/ShaYmez/HBMonv2',
                    'isBasedOn' => 'https://github.com/sp2ong/HBMonv2',
                ),
                array(
                    '@type' => 'ItemList',
                    'name' => $report.' talkgroups',
                    'numberOfItems' => count($elements),
                    'itemListElement' => $elements,
                ),
            ),
        );
    }
    echo '  <title>'.htmlspecialchars($title)."</title>\n";
    echo '  <meta name="description" content="'.htmlspecialchars($description).'" />'."\n";
    echo '  <meta name="robots" content="'.$robots.'" />'."\n";
    echo '  <meta name="generator" content="'.htmlspecialchars('HBMonv2 '.$dash).'" />'."\n";
    if ($canonical !== '') {
        echo '  <link rel="canonical" href="'.htmlspecialchars($canonical).'" />'."\n";
        echo '  <meta property="og:url" content="'.htmlspecialchars($canonical).'" />'."\n";
    }
    echo '  <meta property="og:type" content="website" />'."\n";
    echo '  <meta property="og:title" content="'.htmlspecialchars($title).'" />'."\n";
    echo '  <meta property="og:description" content="'.htmlspecialchars($description).'" />'."\n";
    echo '  <meta property="og:image" content="'.htmlspecialchars($og_image).'" />'."\n";
    echo '  <script type="application/ld+json">'.json_encode($ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)."</script>\n";
}
