# Leaflet Wizard Flicker Rule

## descrizione
Flicker during navigation in wizard steps caused by improper timing of Leaflet invalidations.

## root cause
- Multiple overlapping timeouts in `_refreshMapSize()`
- Insufficient debouncing of coordinate refreshes
- Missing visibility checks before map operations

## solution
1. **Single Timeout Mechanism**
   - Replace multiple timeouts with a single debounced refresh
2. **Explicit Visibility Check**
   - Only refresh map when container is visible
3. **Proper Coordinate Handling**
   - Auto-center on current location when coordinates are null

## verification
- No flickering during step navigation
- Map auto-centers when coordinates missing
- Fullscreen mode works without artifacts

## files
- leaflet-wizard-flicker.md
- coordinate-picker-lit.js (updated)
- header-footer-colors.css (updated if needed)