#!/bin/bash
# Create Pull Request script
# Make sure to run: gh auth login before this script

gh pr create \
  --base main \
  --head blackboxai/docker-render-deploy \
  --title "fix: Remove database migration step from Dockerfile" \
  --body "This PR fixes the Docker build error by removing the database migration step. The app now uses JSON file storage included in the repository instead of requiring a PostgreSQL database connection during build time.

## Changes
- Removed \`php artisan migrate --force --seed\` from Dockerfile
- App now works with JSON files included in \`storage/data/\` directory

## Build Status
The Docker build should now complete successfully without requiring a database connection during the build phase."

