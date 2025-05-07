#!/bin/bash
set -e
LOG_FILE="/var/log/validate_service.log"
exec > >(tee -a "$LOG_FILE") 2>&1

echo "Validating service status..."

# Check if Apache is listening on port 80 using `ss`
if ! ss -tuln | grep -q ':80'; then
  echo "ERROR: Apache does not appear to be listening on port 80."
  exit 1
fi
echo "Apache appears to be listening on port 80."

# Check if the apache2 process is running
if ! pgrep -x apache2 > /dev/null; then
  echo "ERROR: apache2 process not running."
  exit 1
fi
echo "apache2 process is running."

# Check if the homepage loads
if ! curl -f http://localhost/; then
  echo "ERROR: curl failed to retrieve http://localhost/"
  exit 1
fi
echo "Successfully retrieved http://localhost/."

echo "Service validation successful."
exit 0
