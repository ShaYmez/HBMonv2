#! /bin/bash

# Install the required support programs
apt-get update
apt-get install python3 python3-pip python3-dev python3-venv libffi-dev libssl-dev cargo sed -y
pip3 install --upgrade setuptools wheel --break-system-packages
pip3 install -r requirements.txt --break-system-packages
