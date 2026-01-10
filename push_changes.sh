#!/bin/bash
cd /Users/k.satyam/Desktop/samarth
git add Dockerfile
git commit -m "fix: Remove database migration step from Dockerfile (JSON storage)"
git push origin blackboxai/docker-render-deploy
