---
title: "Map Current Position Bug Fix"
type: troubleshooting
confidence: high
created: 2026-05-13
updated: 2026-05-13
tags: [map-lit, geolocation, fullscreen, search-control, coordinate-picker]
related:
  - concepts/ticket-list-map-visibility-issue.md
  - concepts/ticket-location-json-architecture.md
---

# Map Current Position Bug Fix

**Status**: ✅ RISOLTO 2026-05-13 — Current position button, fullscreen, and search control functionality fixed

## Issues Fixed

### 1. Current Position Button Not Working
**Problem**: The "current position" button on segnalazione-crea page was not functioning properly.

**Root Cause**: 
- Geolocation timeout was too aggressive (5 seconds)
- Map initialization timing was critical - geolocation attempted before map was fully rendered
- Missing comprehensive error handling and logging

**Fix Applied**:
- Increased geolocation timeout from 5s to 10s for better device compatibility
- Added 500ms delay in map initialization before geolocation attempt
- Enhanced error handling with comprehensive console logging
- Added `_isUserCentered` flag to prevent `fitBounds` from overwriting user's view after successful geolocation

### 2. Fullscreen Functionality Not Working
**Problem**: Fullscreen button was not working properly.

**Root Cause**: 
- Missing proper event listeners for browser fullscreen changes
- State synchronization between browser and component was not maintained

**Fix Applied**:
- Added proper fullscreen event listeners in `map-picker-controls.js` and `coordinate-picker-lit.js`
- Implemented state synchronization between browser fullscreen events and component state
- Added `isFullscreen` property with proper getter/setter methods

### 3. Search Control Always Open
**Problem**: Search control ("cerca un luogo") was always open instead of only opening when magnifying glass clicked.

**Root Cause**: 
- Search control state was not properly managed
- No conditional rendering based on user interaction

**Fix Applied**:
- Enhanced search control state management in `coordinate-picker-lit.js`
- Added `_searchOpen` property to control search visibility
- Implemented search toggle functionality only when magnifying glass is clicked

### 4. CSS Import Path Issues
**Problem**: Build errors due to incorrect CSS import paths.

**Root Cause**: 
- Incorrect import path for MarkerCluster CSS files

**Fix Applied**:
- Fixed CSS import paths in `map-lit.js` and `geo-map-lit.js`
- Changed from `leaflet.markercluster/dist/MarkerCluster.css` to `leaflet.markercluster.css`

## Technical Details

### Files Modified

1. **`laravel/Modules/Geo/resources/js/components/map-lit.js`**
   - Fixed CSS import paths
   - Enhanced map initialization with proper timing

2. **`laravel/Modules/Geo/resources/js/components/map-picker-controls.js`**
   - Added comprehensive geolocation error handling
   - Increased timeout from 5s to 10s
   - Added detailed console logging for debugging
   - Enhanced fullscreen functionality with event listeners

3. **`laravel/Modules/Geo/resources/js/components/map-picker-events.js`**
   - Improved map initialization timing
   - Added 500ms delay before geolocation attempt

4. **`laravel/Modules/Geo/resources/js/components/coordinate-picker-lit.js`**
   - Enhanced search control state management
   - Added fullscreen event listeners
   - Implemented search toggle functionality

### Build and Deployment

```bash
# Build Geo module assets
cd laravel/Modules/Geo
npm run build
npm run copy

# This copies assets to public_html/assets/geo/
```

### Quality Gates Applied

1. **Pint**: ✅ Code formatting applied
2. **PHPStan**: ✅ 0 errors in Geo and Fixcity modules
3. **PHPMD**: ⚠️ Style issues found (unrelated to map fixes)
4. **Assets**: ✅ Successfully built and deployed

## Testing Instructions

### Manual Testing
1. Visit `http://127.0.0.1:8000/it/tests/segnalazione-crea`
2. Test current position button - should center map on your location
3. Test fullscreen button - should enter/exit fullscreen properly
4. Test search control - should only open when magnifying glass clicked
5. Verify auto-centering when no coordinates are provided

### Console Debugging
Open browser console and check for:
```
[MapLit] Geolocation requested
[MapLit] Geolocation success: lat, lng
[MapLit] Map centered on user location
[MapLit] Fullscreen changed: true/false
[MapLit] Search toggled: true/false
```

## Acceptance Criteria

- [x] Current position button works properly
- [x] Map auto-centers on current location when no variables passed
- [x] Fullscreen functionality works correctly
- [x] Search control only opens when magnifying glass clicked
- [x] No JavaScript errors in console
- [x] Assets properly built and deployed

## Related Documentation

- [[concepts/ticket-list-map-visibility-issue.md]] - Previous map visibility fixes
- [[concepts/ticket-location-json-architecture.md]] - Location data structure
- [[concepts/geo-map-controls-unification-rule.md]] - Map controls architecture