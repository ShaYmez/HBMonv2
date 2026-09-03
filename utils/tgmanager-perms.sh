#!/bin/bash
# Set group-write on talkgroup_ids.json only. Owner is left unchanged.
# Usage: tgmanager-perms.sh [path-to-talkgroup_ids.json]

set -e

JSON="${1:-}"
if [ -z "$JSON" ]; then
        if [ -f /etc/hblink3/json/talkgroup_ids.json ]; then
                JSON=/etc/hblink3/json/talkgroup_ids.json
        elif [ -f /opt/HBMonv2/data/talkgroup_ids.json ]; then
                JSON=/opt/HBMonv2/data/talkgroup_ids.json
        else
                echo "talkgroup_ids.json not found"
                exit 1
        fi
fi

if [ -d "$JSON" ]; then
        echo "Refusing directory: $JSON"
        exit 1
fi
if [ ! -f "$JSON" ]; then
        echo "Not a file: $JSON"
        exit 1
fi

base=$(basename "$JSON")
if [ "$base" != "talkgroup_ids.json" ]; then
        echo "Refusing to change $JSON (talkgroup_ids.json only)"
        exit 1
fi

GRP="www-data"
if ! getent group "$GRP" >/dev/null 2>&1; then
        GRP="$(id -gn)"
fi

chgrp "$GRP" "$JSON"
chmod 664 "$JSON"
echo "Set $JSON group $GRP mode 664 (owner unchanged)"
