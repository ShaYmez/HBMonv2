#!/bin/bash
set -e

# Check if apt-get is available
if ! command -v apt-get >/dev/null; then
    echo "apt-get not found. Please install dependencies manually for your OS."
    exit 1
fi

# Ensure requirements.txt exists to prevent running in wrong directory
if [ ! -f requirements.txt ]; then
    echo "requirements.txt not found! Run this script from the repository root."
    exit 1
fi

# Install system dependencies
apt-get update
apt-get install -y python3 python3-pip python3-venv python3-dev libffi-dev libssl-dev cargo sed

# Set up Python virtual environment if not exists
if [ ! -d ".venv" ]; then
    python3 -m venv .venv
fi

# Upgrade pip and tools, then install requirements in venv
. .venv/bin/activate
pip install --upgrade pip setuptools wheel
pip install --no-cache-dir -r requirements.txt

echo ""
echo "=============================================="
echo "Setup complete! To activate, run:"
echo "  source .venv/bin/activate"
echo ""
echo "Then run your app as usual (e.g., python monitor.py/bridge.py)"
echo "=============================================="
