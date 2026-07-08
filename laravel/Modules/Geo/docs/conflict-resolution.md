# Conflict Resolution — Module Geo

## Summary
- **Files resolved**: 11
- **Strategy**: Keep HEAD/local (ours) side
- **Root cause**: Nested stash-on-merge conflicts

## PHP Files
- tests/Unit/Actions/GoogleMaps/GetAddressFromGoogleMapsActionTest.php
- tests/Unit/Actions/GoogleMaps/GetCoordinatesFromGoogleMapsActionTest.php
- tests/Unit/Actions/GoogleMaps/GetGeocodingDataActionTest.php
- tests/Unit/Actions/GoogleMaps/OptimizeRouteActionTest.php
- tests/Unit/Actions/Here/GetAddressFromHereMapsActionTest.php
- tests/Unit/Actions/IPGeolocation/FetchIPLocationActionTest.php
- tests/Unit/Actions/IPGeolocation/GetLocationFromIPActionTest.php
- tests/Unit/Actions/LocationIQ/GetAddressFromLocationIQActionTest.php
- tests/Unit/Actions/Mapbox/GetAddressFromMapboxActionTest.php
- tests/Unit/Actions/Mapbox/GetAddressFromMapboxLatLngActionTest.php

## Documentation Files
- docs/nestedset-migration-best-practices.md

## Backlinks
- [Root conflict resolution report](../../../../docs/conflict-resolution-report.md)
