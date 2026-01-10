# TODO: Integrate External Resource Hyperlinks

## Task Overview
Integrate the following hyperlinks into the education module views:
- **Video Lectures**: https://infyspringboard.onwingspan.com
- **PDF Notes**: https://ndl.education.gov.in/home
- **Mock Tests**: https://vidya.cequ.in

## Files Modified

### 1. resources/views/education/index.blade.php ✅
**Changes:**
- Updated "Video Guides" card to link to InfySpringBoard with target="_blank"
- Updated "PDF Notes" card to link to NDL Education with target="_blank"
- Updated "Mock Tests" card to link to Vidya with target="_blank"
- Added hover effects and source labels (InfySpringBoard, NDL Education, Vidya Platform)

### 2. resources/views/education/plan.blade.php ✅
**Changes:**
- Added new "External Resources" section with three cards
- Linked Video Lectures to InfySpringBoard
- Linked PDF Notes to NDL Education
- Linked Mock Tests to Vidya Platform
- Added hover animation effects

### 3. resources/views/education/exams.blade.php ✅
**Changes:**
- Updated the resources section with proper hyperlinks
- Made resource cards clickable with target="_blank"
- Added external link icons and source attributions

### 4. resources/views/videos/index.blade.php ✅
**Changes:**
- Added prominent gradient banner at the top with external resource links
- Linked Video Lectures to InfySpringBoard
- Linked PDF Notes to NDL Education
- Linked Mock Tests to Vidya Platform
- Added descriptive text for each resource

## Status
- [x] education/index.blade.php
- [x] education/plan.blade.php
- [x] education/exams.blade.php
- [x] videos/index.blade.php

All hyperlinks are configured to open in new tabs (target="_blank") for better user experience.

