<?php

// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);


// Name of the monitored Dashboard
define("REPORT_NAME","HBlink 3 Master Server");

// Height of Server Activity window: 45px; 1 row, 60px 2 rows, 80px 3 rows
define("HEIGHT_ACTIVITY","45px");

//
// Theme colors define
//
// Green 
//define("THEME_COLOR","background-color:#4a8f3c;color:white;");

// Blue 1
//define("THEME_COLOR","background-color:#2A659A;color:white;");

// Blue 2
//define("THEME_COLOR","background-color:#43A6DF;color:white;");

// Blue Gradient 1
define("THEME_COLOR","background-image: linear-gradient(to bottom, #337ab7 0%, #265a88 100%);color:white;");

// Blue Gradient 2
//define("THEME_COLOR","background-image: linear-gradient(to bottom, #3333cc 0%, #265a88 100%);color:white;");

// Red Gradient
//define("THEME_COLOR","background-image:linear-gradient(0deg, rgba(251,0,0,1) 0%, rgba(255,131,131,1) 50%, rgba(255,255,255,1) 100%);color:black;");

// Grey Gradient 
//define("THEME_COLOR","background-image: linear-gradient(to bottom, #3b3b3b 10%, #808080 100%);color:white;");

// Green Gradient 
//define("THEME_COLOR","background-image:linear-gradient(to bottom right,#d0e98d, #4e6b00);color:black;");
//

// Talkgroup file. Empty = auto-detect (prefers Docker host path when present).
// Docker: /etc/hblink3/json/talkgroup_ids.json
// Standalone: /opt/HBMonv2/data/talkgroup_ids.json
define("TGID_JSON", "");

// Talkgroup Manager users file. Empty = auto-detect (prefers Docker host path).
// Docker: /etc/hblink3/tgmanager.users
// Standalone: /opt/HBMonv2/tgmanager.users
define("TGMANAGER_USERS", "");

// Lastheard log. Empty = auto-detect Docker then standalone.
// Docker: /var/log/hbmon/lastheard.log
// Standalone: /opt/HBMonv2/log/lastheard.log
define("LASTHEARD_LOG", "");

// Public talkgroup JSON URL for apps (DVRef, Z3DMR, VoxDMR, other MMDVM). Empty = auto
// (Docker: https://<host>/json/talkgroup_ids.json, else this site's json.php).
define("TGID_PUBLIC_URL", "");

// Public dashboards are indexable by default (titles, description, generator).
// Private servers: define("SEO_INDEX", false);
define("SEO_INDEX", true);

?>
