# Geo Module - PHPStan Error Resolution Roadmap

This document outlines the steps to resolve the PHPStan errors found in the Geo module.

## Error Summary

The errors in the Geo module are primarily related to incorrect return type declarations.

1.  **`GetAddressFromBingMapsAction.php`**: `extractLocationFromResponse` should return `array<string, mixed>` but returns `array`.
2.  **`UpdateCoordinatesResult.php`**: `getErrorMessages` should return `array<int, string>` but returns `array<mixed>`.
3.  **`ComuneJson.php`**:
    *   `byRegion` should return `Illuminate\Support\Collection<int, array{...}>` but returns `mixed`.
    *   `byProvince` should return `Illuminate\Support\Collection<int, array{...}>` but returns `mixed`.
    *   `searchByName` should return `Illuminate\Support\Collection<int, array{...}>` but returns `mixed`.
    *   `getGerarchia` should return `array{...}|null` but returns `mixed`.
4.  **`GeoDataService.php`**: `loadData` should return `Illuminate\Support\Collection<int, array<string, mixed>>` but returns `Illuminate\Support\Collection<int, mixed>`.
5.  **`GeoDataValidator.php`**: `getErrors` should return `array<string, array<int, string>>` but returns `array`.

## Resolution Plan

I will address these errors by correcting the return type hints in each file.

1.  **`GetAddressFromBingMapsAction.php`**: Update the return type of `extractLocationFromResponse`.
2.  **`UpdateCoordinatesResult.php`**: Update the return type of `getErrorMessages`.
3.  **`ComuneJson.php`**: Update the return types for `byRegion`, `byProvince`, `searchByName`, and `getGerarchia`.
4.  **`GeoDataService.php`**: Update the return type for `loadData`.
5.  **`GeoDataValidator.php`**: Update the return type for `getErrors`.

After each fix, I will run `phpstan analyse Modules/Geo` to ensure the error is resolved.
