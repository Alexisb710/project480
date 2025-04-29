#!/bin/bash
set -e
LOG_FILE="/var/log/start_server.log"
exec > >(tee -a "$LOG_FILE") 2>&1

echo "Attempting to restart Apache server..."
systemctl restart apache2
echo "Apache restart command executed."
