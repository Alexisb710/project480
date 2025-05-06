#!/bin/bash
set -e
LOG_FILE="/var/log/validate_service.log"
exec > >(tee -a "$LOG_FILE") 2>&1

echo "Validating service status..."

# Check if Apache is listening on port 80
if ! netstat -tulnp | grep ':80 ' | grep -q 'apache2'; then
  echo "ERROR: Apache does not appear to be listening on port 80."
  exit 1
fi
echo "Apache process found listening on port 80."

# Check if the homepage loads locally (adjust URL if needed)
# The '-f' flag makes curl fail fast on server errors (HTTP >= 400)
if ! curl -f http://localhost/; then
  echo "ERROR: curl failed to retrieve http://localhost/"
  exit 1
fi
echo "Successfully retrieved http://localhost/."

echo "Service validation successful."
exit 0