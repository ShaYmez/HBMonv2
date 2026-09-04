# HBMonv2

HBMonv2 is a PHP dashboard and Python WebSocket monitor for HBlink. It is
based on HBMonitor by N0MJS, hbmonitor3 by KC1AWV, and HBMonv2 by SP2ONG.

The dashboard provides condensed live activity on its main page and dedicated
views for masters, peers, OpenBridge systems, bridges, LastHeard, talkgroups,
and system information.

Current dashboard version: see [`VERSION`](VERSION).

## Requirements

- Debian 10–13 or a comparable Linux distribution
- Python 3
- A PHP-capable web server such as Apache, nginx, or lighttpd
- Access to the HBlink TCP reporting socket
- TCP port 9000 available to dashboard clients or a WebSocket reverse proxy

On Debian 12+/Ubuntu 23.04+, `install.sh` avoids PEP 668 conflicts by
installing Python dependencies into `/opt/HBMonv2/.venv`.

## Standalone installation

Run the installer from the repository root:

```sh
cd /opt
git clone https://github.com/ShaYmez/HBMonv2.git
cd HBMonv2
chmod +x install.sh
./install.sh
cp config_SAMPLE.py config.py
```

Edit `config.py`, then create the initial talkgroup file if required:

```sh
test -f data/talkgroup_ids.json ||
  printf '{"count":0,"results":[]}\n' > data/talkgroup_ids.json
```

For an initial web installation, copy `html/` to the desired document root:

```sh
mkdir -p /var/www/html/hbmon
cp -a html/. /var/www/html/hbmon/
```

The dashboard will then be available at `http://HOST/hbmon/`. A virtual host
can instead point directly at the deployed directory.

Do not overwrite a configured Docker dashboard with a raw `html/` copy.
The hblink3 Docker installer provides `hblink-dashboard-upgrade`, which keeps
`html/include/config.php`, `html/buttons.html`, and custom images.

### systemd service

The supplied unit uses the virtual environment created by `install.sh`:

```sh
cp utils/hbmon.service /lib/systemd/system/
systemctl daemon-reload
systemctl enable --now hbmon
systemctl status hbmon
```

## Python configuration

Use the sample appropriate to the deployment:

- Standalone: copy `config_SAMPLE.py` to `config.py`.
- Docker/hblink3 stack: mount `hbmon-config.py` as `/hbmon/config.py`.

The Docker sample uses the hblink3 network address; the standalone sample uses
`127.0.0.1`. Both use `PATH = './data/'` and a 28-day RadioID.net refresh.

Important settings:

- `HOMEBREW_INC`: include Homebrew peer status.
- `LASTHEARD_INC`: show LastHeard on the main dashboard.
- `BRIDGES_INC`: generate bridge status; disabled by default.
- `EMPTY_MASTERS`: include masters without connected peers.
- `HBLINK_IP` / `HBLINK_PORT`: HBlink reporting socket.
- `FREQUENCY`: seconds between dashboard updates.
- `CLIENT_TIMEOUT`: disconnect stale web clients after N seconds; `0` disables it.
- `OPB_FILTER`: comma-separated OpenBridge network IDs excluded from LastHeard.
- `PATH`: directory containing alias JSON files; it must end in `/`.
- `LOCAL_SUB_FILE`, `LOCAL_PEER_FILE`, `LOCAL_TGID_FILE`: optional local aliases.
- `PEER_URL`, `SUBSCRIBER_URL`, `FILE_RELOAD`: RadioID.net sources and refresh.
- `LOG_PATH` / `LOG_NAME`: monitor log location and filename.

Unused optional local alias settings should remain empty.

## Dashboard configuration

Edit `html/include/config.php` to configure:

- `REPORT_NAME`: dashboard heading.
- `HEIGHT_ACTIVITY`: `45px` for one row, `60px` for two, or `80px` for three.
- `THEME_COLOR`: CSS declaration used by the supplied theme presets.
- `TGID_JSON`: explicit talkgroup JSON path; empty enables auto-detection.
- `TGMANAGER_USERS`: explicit manager users file; empty enables auto-detection.
- `LASTHEARD_LOG`: explicit LastHeard log path; empty enables auto-detection.
- `TGID_PUBLIC_URL`: public partner API URL; empty generates it automatically.
- `SEO_INDEX`: public indexing switch; defaults to `true`.

Talkgroup Manager is always marked `noindex`. Set `SEO_INDEX` to `false` for
private dashboards.

The dashboard version comes from `/opt/HBMonv2/VERSION` or the repository
`VERSION` file. The footer adds the hblink3 Docker installer version only when
that stack is detected.

## Docker image

The CI workflow publishes `shaymez/hbmonv2:latest` for amd64 and arm64:

```sh
docker pull shaymez/hbmonv2:latest
docker run -d --name hbmon --restart unless-stopped \
  --network YOUR_HBLINK_NETWORK \
  -p 9000:9000 \
  -v /path/to/hbmon-config.py:/hbmon/config.py:ro \
  -v /path/to/json:/hbmon/data \
  -v /path/to/log:/hbmon/log \
  shaymez/hbmonv2:latest
```

Set `HBLINK_IP` in the mounted configuration to the HBlink address on the
selected Docker network. Mounted data and log directories must be writable by
container UID 54000. The image runs the Python monitor; serve `html/`
separately with a PHP-capable web server.

## Talkgroups and partner API

Python reads `PATH + TGID_FILE`. For standalone installations this is
`/opt/HBMonv2/data/talkgroup_ids.json`. PHP checks these locations:

1. `/etc/hblink3/json/talkgroup_ids.json`
2. `/opt/HBMonv2/data/talkgroup_ids.json`

Keep the Python and PHP paths pointed at the same file.

Partner applications such as Z3DMR, VoxDMR, QSO 1, and other HBlink servers
can fetch:

- Docker stack: `https://HOST/json/talkgroup_ids.json`
- Any installation: `https://HOST/json.php`
- Subdirectory deployment: `https://HOST/hbmon/json.php`
- CSV: `https://HOST/json.php?format=csv`

The endpoint enables CORS, uses `Cache-Control: no-cache`, and returns:

```json
{
  "count": 1,
  "results": [
    {
      "id": 9,
      "tgid": 9,
      "callsign": "Local"
    }
  ]
}
```

`id` and `tgid` contain the same numeric talkgroup ID. Records are sorted by
ID. Talkgroup Info displays the live API URL and provides Copy, Open, JSON,
and CSV actions.

Override the generated public URL when needed:

```php
define("TGID_PUBLIC_URL", "https://example.com/json/talkgroup_ids.json");
```

## Talkgroup Manager

Create or update a manager account:

```sh
php /opt/HBMonv2/utils/tgmanager-passwd admin
bash /opt/HBMonv2/utils/tgmanager-perms.sh
```

Additional account operations:

```sh
php /opt/HBMonv2/utils/tgmanager-passwd --delete admin
php /opt/HBMonv2/utils/tgmanager-passwd --file /path/to/users admin
```

Avoid `--password` in interactive shells because its value can enter shell
history. The web server must be able to read the users file and write
`talkgroup_ids.json`. The permissions helper changes only that JSON file to
group-writable mode; it never recursively changes the data directory.

Default users-file locations:

- Docker: `/etc/hblink3/tgmanager.users`
- Standalone: `/opt/HBMonv2/tgmanager.users`

## LastHeard

LastHeard records completed transmissions longer than two seconds. To record
all transmissions, change this condition in `monitor.py`:

```python
if int(float(p[9])) > 2:
```

The main dashboard shows 15 unique entries. Change `if n == 15:` in
`write_lastheard_html()` to adjust that limit.

`log.php` checks `/var/log/hbmon/lastheard.log`, then
`/opt/HBMonv2/log/lastheard.log`. `LASTHEARD_LOG` overrides this order.

Install the optional daily 250-line rotation:

```sh
cp utils/lastheard /etc/cron.daily/lastheard
chmod +x /etc/cron.daily/lastheard
```

Set `LASTHEARD_LOG` in the cron environment when rotating a non-default path.

## HTTPS and WebSockets

The monitor listens for plain WebSocket connections on port 9000. HTTP pages
connect to `ws://HOST:9000`; HTTPS pages connect to `wss://HOST:9000`.

For HTTPS, configure Apache or nginx to terminate TLS and proxy WSS to
`ws://127.0.0.1:9000`. The Python monitor does not terminate TLS itself.

## Dashboard customization

- Customize links in `html/buttons.html`.
- Keep custom links inside `#hbmon-nav-links` so they use the mobile menu.
- Uncomment the Bridges link when `BRIDGES_INC` is enabled.
- Pages expect the custom logo at `html/img/HBLINK_logoV2.png`.
- Desktop keeps the 1100px presentation at 1120px and wider.
- Tablets use fluid contained tables; below 768px, operational tables use cards.

System Info setup instructions are in [`sysinfo/Readme.txt`](sysinfo/Readme.txt).

## Legacy Python web-server branch

The original upstream maintains a separate
[`webserver-python`](https://github.com/sp2ong/HBMonv2/tree/webserver-python)
branch. It is not part of this release and may require different installation
steps.

## Credits and license

- Original HBMonitor: Cortney T. Buffington, N0MJS
- hbmonitor3: Steve, KC1AWV
- HBMonv2: SP2ONG
- Docker adaptation and current repository: ShaYmez, M0VUB

HBMonv2 is distributed under the
[GNU General Public License version 3 or later](https://www.gnu.org/licenses/gpl-3.0.html),
without warranty.

![HBlink logo](html/img/HBlink.svg)
