---
title: "plan"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "plan"
issues: []
discussions: []
---

# Appointment Field Naming Correction Plan

## Overview

This plan outlines the approach to correct field naming issues in the Notify module, specifically for the Appointment model which uses both legacy field names (`start_time`, `end_time`) and canonical field names (`starts_at`, `ends_at`).

## Detection Strategy

1. Scan all files in the Notify module for references to `start_time` and `end_time` fields
2. Identify which references relate to the Appointment model
3. Document each occurrence and required changes

## Files to Be Corrected

### 1. SendAppointmentNotificationAction.php.old

- **Status**: ⏳ Pending
- **Issue**: Uses `start_time` instead of `starts_at` (line 120)
- **Correction**: Replace `$appointment->start_time` with `$appointment->starts_at`

## Implementation Strategy

For each affected file:

1. Create a backup if necessary
2. Update the field references from legacy (`start_time`, `end_time`) to canonical (`starts_at`, `ends_at`)
3. Test the functionality to ensure no regression
4. Update this plan.md file to mark the correction as complete

## Progress Tracking

| File | Status | Date | Notes |
|------|--------|------|-------|
| SendAppointmentNotificationAction.php.old | ⏳ Pending | | |

## Verification Process

After all corrections:

1. Run automated tests if available
2. Manually verify critical notification functionality
3. Update documentation to reflect the changes
4. Final review of all corrected code

## Legend

- ⏳ Pending: Issue identified, correction pending
- 🔄 In Progress: Correction being implemented
- ✅ Complete: Issue corrected and verified
- ⚠️ Blocked: Correction blocked by dependency or issue
