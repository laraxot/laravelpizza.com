# Appointment Field Naming Issues

## Overview

The Appointment model in  module defines both legacy field names (`start_time`, `end_time`) and canonical field names (`starts_at`, `ends_at`). The canonical field names `starts_at` and `ends_at` should be used consistently throughout the codebase.
The Appointment model in <nome progetto> module defines both legacy field names (`start_time`, `end_time`) and canonical field names (`starts_at`, `ends_at`). The canonical field names `starts_at` and `ends_at` should be used consistently throughout the codebase.

## Issues Detected

### SendAppointmentNotificationAction.php.old

**File Path**: `Modules/Notify/app/Actions/SendAppointmentNotificationAction.php.old`
**File Path**: `Modules/Notify/app/Actions/SendAppointmentNotificationAction.php.old`
**File Path**: `Modules/Notify/app/Actions/SendAppointmentNotificationAction.php.old`

**Line 120**:
```php
'time' => $appointment->start_time?->format('H:i'),
```

**Issue**: Using the legacy `start_time` field instead of the canonical `starts_at` field.

**Correction Needed**: Replace `start_time` with `starts_at`.

**Correct Version**:
```php
'time' => $appointment->starts_at?->format('H:i'),
```

## Implementation Notes

The Appointment model currently exposes both field naming conventions:
1. Legacy fields: `start_time`, `end_time`
2. Canonical fields: `starts_at`, `ends_at`

While both are present in the $fillable array, the canonical fields (`starts_at`, `ends_at`) should be preferred for all new code and when refactoring existing code.
# Appointment Field Naming Issues

## Overview

The Appointment model in <nome progetto> module defines both legacy field names (`start_time`, `end_time`) and canonical field names (`starts_at`, `ends_at`). The canonical field names `starts_at` and `ends_at` should be used consistently throughout the codebase.
The Appointment model in <nome progetto> module defines both legacy field names (`start_time`, `end_time`) and canonical field names (`starts_at`, `ends_at`). The canonical field names `starts_at` and `ends_at` should be used consistently throughout the codebase.

## Issues Detected

### SendAppointmentNotificationAction.php.old

**File Path**: `Modules/Notify/app/Actions/SendAppointmentNotificationAction.php.old`
**File Path**: `Modules/Notify/app/Actions/SendAppointmentNotificationAction.php.old`
**File Path**: `Modules/Notify/app/Actions/SendAppointmentNotificationAction.php.old`

**Line 120**:
```php
'time' => $appointment->start_time?->format('H:i'),
```

**Issue**: Using the legacy `start_time` field instead of the canonical `starts_at` field.

**Correction Needed**: Replace `start_time` with `starts_at`.

**Correct Version**:
```php
'time' => $appointment->starts_at?->format('H:i'),
```

## Implementation Notes

The Appointment model currently exposes both field naming conventions:
1. Legacy fields: `start_time`, `end_time`
2. Canonical fields: `starts_at`, `ends_at`

While both are present in the $fillable array, the canonical fields (`starts_at`, `ends_at`) should be preferred for all new code and when refactoring existing code.
