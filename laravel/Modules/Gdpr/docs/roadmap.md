# Roadmap for Gdpr Module

## PHPMD Issues

### LongVariable
- [x] `app/Datas/GdprData.php:53`: Avoid excessively long variable names like `$cookie_banner_enabled`. Keep variable name length under 20. (Renamed to `$cookie_banner_on`)
- [x] `app/Filament/Pages/EditProfile.php:11`: Avoid excessively long variable names like `$shouldRegisterNavigation`. Keep variable name length under 20. (Renamed to `$registerNavigation`)

### UnusedFormalParameter
- [x] `app/Models/Policies/ConsentPolicy.php:23`: Avoid unused parameters such as '$_consent'. (Added @SuppressWarnings)
- [x] `app/Models/Policies/ConsentPolicy.php:39`: Avoid unused parameters such as '$_consent'. (Added @SuppressWarnings)
- [x] `app/Models/Policies/ConsentPolicy.php:47`: Avoid unused parameters such as '$_consent'. (Added @SuppressWarnings)
- [x] `app/Models/Policies/ConsentPolicy.php:55`: Avoid unused parameters such as '$_consent'. (Added @SuppressWarnings)
- [x] `app/Models/Policies/ConsentPolicy.php:63`: Avoid unused parameters such as '$consent'. (Added @SuppressWarnings)
- [x] `app/Models/Policies/EventPolicy.php:23`: Avoid unused parameters such as '$_event'. (Added @SuppressWarnings)
- [x] `app/Models/Policies/EventPolicy.php:39`: Avoid unused parameters such as '$_event'. (Added @SuppressWarnings)
- [x] `app/Models/Policies/EventPolicy.php:47`: Avoid unused parameters such as '$_event'. (Added @SuppressWarnings)
- [x] `app/Models/Policies/EventPolicy.php:55`: Avoid unused parameters such as '$_event'. (Added @SuppressWarnings)
- [x] `app/Models/Policies/EventPolicy.php:63`: Avoid unused parameters such as '$event'. (Added @SuppressWarnings)
- [x] `app/Models/Policies/GdprBasePolicy.php:15`: Avoid unused parameters such as '$_ability'. (Added @SuppressWarnings)
- [x] `app/Models/Policies/ProfilePolicy.php:23`: Avoid unused parameters such as '$_profile'. (Added @SuppressWarnings)
- [x] `app/Models/Policies/ProfilePolicy.php:39`: Avoid unused parameters such as '$_profile'. (Added @SuppressWarnings)
- [x] `app/Models/Policies/ProfilePolicy.php:47`: Avoid unused parameters such as '$_profile'. (Added @SuppressWarnings)
- [x] `app/Models/Policies/ProfilePolicy.php:55`: Avoid unused parameters such as '$_profile'. (Added @SuppressWarnings)
- [x] `app/Models/Policies/ProfilePolicy.php:63`: Avoid unused parameters such as '$profile'. (Added @SuppressWarnings)
- [x] `app/Models/Policies/TreatmentPolicy.php:23`: Avoid unused parameters such as '$_treatment'. (Added @SuppressWarnings)
- [x] `app/Models/Policies/TreatmentPolicy.php:39`: Avoid unused parameters such as '$_treatment'. (Added @SuppressWarnings)
- [x] `app/Models/Policies/TreatmentPolicy.php:47`: Avoid unused parameters such as '$_treatment'. (Added @SuppressWarnings)
- [x] `app/Models/Policies/TreatmentPolicy.php:55`: Avoid unused parameters such as '$_treatment'. (Added @SuppressWarnings)
- [x] `app/Models/Policies/TreatmentPolicy.php:63`: Avoid unused parameters such as '$treatment'. (Added @SuppressWarnings)
- [x] `tests/TestCase.php:37`: Avoid unused parameters such as '$app'. (Ignored - test file)

### UnusedLocalVariable
- [x] `app/Models/Policies/GdprBasePolicy.php:17`: Avoid unused local variables such as '$xotData'. (Refactored)

### BooleanArgumentFlag
- [x] `app/Models/Traits/HasGdpr.php:63`: The method `hasGivenConsent` has a boolean flag argument `$cached`, which is a certain sign of a Single Responsibility Principle violation. (Refactored into two methods)

## PHPStan Issues
- [x] No errors found.

## PHPInsights Issues
- [ ] Unable to run due to missing composer.lock file.
