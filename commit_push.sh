#!/bin/bash
cd /Users/k.satyam/Desktop/samarth
git add Dockerfile
git commit -m "fix: Remove all php artisan cache commands that require database"
git push origin blackboxai/docker-render-deploy
