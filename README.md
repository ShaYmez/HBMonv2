**HBMonv2 - Adapted - Dockerised**

**HBmonitor is a "web dashboard" for HBlink by N0MJS. Further developed by Steve KC1AWV**

***Version - HBMonV2 by SP2ONG 2019-2022***
***Dashboard version: VERSION file in this repository***
***Docker version (footer): VERSION from hblink3-docker-install, only when that stack is installed***

The main difference between HBMonitor v1 and v2 is the layout, i.e. the main page shows condensed 
information and on the subpages, you can see the individual content that was shown on v1

HBMonv2 is tested on Debian v10, v11, v12 & v13

**Note for Debian 12+/Ubuntu 23.04+**: The install.sh script has been updated to handle 
PEP 668 externally-managed-environment restrictions using the --break-system-packages flag.

This version of HBMonv2 requires a web server like apache2, lighttpd and 
php support running on the server. 


    cd /opt
    git clone https://github.com/sp2ong/HBMonv2.git
    cd HBMonv2
    chmod +x install.sh
    ./install.sh
    cp config_SAMPLE.py config.py
    edit config.py and change what you necessary

    You need to copy the contents of the /opt/HBMonv2/html directory to 
    the web server directory. Suppose your web server is available 
    as http://dmrserver.org, copy the file to for example /var/www/html

    If you copy files to /var/www/html/hbmon, HBMonitor will be 
    accessible from http://dmrserver.org/hbmon

    You can copy to /var/www/hbmon and start HBMonitor access by configuring 
    virtual the web server for subdomains e.g. hbmon.dmrserver.org 
    the access will then be http://hbmon.dmrserver.org 

    In the html/include/ directory there is a config.php file in which you 
    set the color theme and name for your Dashboard.

    Dashboard Version (top of each page) is the VERSION file in this
    repository (/opt/HBMonv2/VERSION). The footer still shows SP2ONG
    as the dashboard author. The Docker Version line is shown only when
    this host was installed with hblink3-docker-install (compose file or
    .installer_path present) and is read from that repo's VERSION.

    In the html/include/config.php you can defined height of Server Activity 
    window: 45px; 1 row, 60px 2 rows, 80px 3 rows:
    define("HEIGHT_ACTIVITY","45px");

    Talkgroups: set PATH = './data/' and TGID_FILE = 'talkgroup_ids.json' in
    config.py (standalone: /opt/HBMonv2/data/talkgroup_ids.json). Do not
    hardcode /etc/hblink3/json/. Docker (hblink3-docker-install) bind-mounts
    that directory as /hbmon/data; Apache already publishes
    /json/talkgroup_ids.json. Standalone can use /json.php.

    Talkgroup list for other apps (Z3DMR, VoxDMR, QSO 1, other HBlink
    servers): GET the JSON. CORS is open. Cache-Control: no-cache.

        Docker stack:  https://<host>/json/talkgroup_ids.json
        All installs:  https://<host>/json.php
                       (subfolder: https://<host>/hbmon/json.php)

        {
          "count": 2,
          "results": [
            { "id": 9, "tgid": 9, "callsign": "Local" }
          ]
        }

    id and tgid are the talkgroup number (same value). callsign is the
    name. Sort by numeric id. CSV download: /json.php?format=csv
    (columns id,tgid,callsign). Talkgroup Info also has Download JSON
    and Download CSV under the table.

    Auto-detect prefers the Docker host files when they exist
    (/etc/hblink3/json/talkgroup_ids.json, /etc/hblink3/tgmanager.users),
    then falls back to /opt/HBMonv2. Optional overrides in
    html/include/config.php:
    define("TGID_JSON", "");
    define("TGMANAGER_USERS", "");

    Talkgroup Manager (info.php Login, or /tgmanager.php):
    php /opt/HBMonv2/utils/tgmanager-passwd admin
    bash /opt/HBMonv2/utils/tgmanager-perms.sh
    The perms script sets 664 + www-data group on talkgroup_ids.json only
    (owner unchanged; never chown -R data/). Users file:
    /etc/hblink3/tgmanager.users when /etc/hblink3 exists, otherwise
    /opt/HBMonv2/tgmanager.users.
    The web server must be able to read the users file and write
    talkgroup_ids.json.

    Docker installer: do not copy html/ over a live dashboard. Use
    hblink-dashboard-upgrade. That keeps include/config.php (name/theme),
    buttons.html (menu), and existing img/ logos. Pages, css/styles.php,
    and footer come from this repo. Compose migrate uses --keep-pages.

    In the html directory there is a buttons.html file that you can tune to menu keys 
    
    The logo image you can replace with file image in html directory  img/logo.png
    cp utils/lastheard /etc/cron.daily/
    chmod +x /etc/cron.daily/lastheard
    cp utils/hbmon.service /lib/systemd/system/
    systemctl enable hbmon
    systemctl start hbmon
    systemctl status hbmon
    forward TCP port 9000 and web server port in firewall
    
    Please setup your SYSTEM INFO subpage with the following instruction:
    
    https://github.com/sp2ong/HBMonv2/tree/main/sysinfo
    
    Please remember the table lastheard displays only station transmissions 
    that are longer than 2 sec.
    use >=0 instead of >2 if you want to record all activities in line:
    
       if int(float(p[9])) > 2:  

    If you want to have more than the last 15 entries in the Lastheard table
    change in the monitor.py file line from:
    
       # maximum number of lists in lastheard on the main page 
       if n == 15:
    to for example:
       if n == 25:
    
    
    I recommend that you do not use the BRIDGE_INC = True option to display bridge information 
    (if you have multiple bridges displaying this information will increase the CPU load, 
    try to use BRIDGES_INC = False in config.py) 
    
    
    ***************************************************************************************
    
    The HBMonv2 version without use external web server like apache2 etc is still available:
    
    cd /opt
    git clone https://github.com/sp2ong/HBMonv2.git
    cd HBMonv2
    git checkout webserver-python
    chmod +x install.sh
    ./install.sh
    cp config_SAMPLE.py config.py
    edit config.py and change what you necessary
    cp utils/hbmon.service /lib/systemd/system/
    systemctl enable hbmon
    systemctl start hbmon
    systemctl status hbmon
    forward TCP port 9000 and web server port 8080 in firewall
    
    *****************************************************************************************
---

**hbmonitor3 by KC1AWV**

Python 3 implementation of N0MJS HBmonitor for HBlink https://github.com/kc1awv/hbmonitor3 

---

Copyright (C) 2013-2018  Cortney T. Buffington, N0MJS <n0mjs@me.com>

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 3 of 
the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the 
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 
02110-1301  USA

---

<img src="https://github.com/sp2ong/HBMonv2/raw/main/html/img/hbmon.png">

