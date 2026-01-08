# GDPR Module - Filament v4 Upgrade

## Overview

The GDPR module manages privacy compliance and consent tracking. This document outlines the specific upgrade considerations for Filament v4.

## Key Components Affected

### Resources
- `ConsentResource` - Privacy consent management
- `ProfileResource` - User profile privacy settings
- `EventResource` - Privacy event logging
- `TreatmentResource` - Data processing treatment records

### Forms & Tables
- Multi-language consent forms
- Privacy dashboard widgets
- Event logging tables
- Complex relationship handling

## Upgrade Checklist

### 1. Dashboard Updates
- ✅ Dashboard now extends `XotBaseDashboard`
- ✅ Compatible `$navigationIcon` type declaration

### 2. Resource Form Updates
```php
// Before (v3)
Forms\Components\Select::make('consent_type')
    ->options(ConsentType::getSelectOptions())

// After (v4)
Forms\Components\Select::make('consent_type')
    ->relationship('consentType')
    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
```

### 3. Table Column Updates
- Verify column rendering for privacy-sensitive data
- Update action button configurations
- Check bulk action implementations

### 4. Policy Integration
- Ensure `GdprBasePolicy` compatibility
- Verify consent management permissions
- Test data access controls

## Business Logic Preservation

### Critical Functions
1. **Consent Collection**: Multi-step form workflows must remain intact
2. **Data Processing**: Treatment logging cannot be interrupted
3. **Privacy Rights**: GDPR compliance features must function correctly
4. **Multi-language**: Consent forms in multiple languages

### Testing Requirements
- Test consent form submission flows
- Verify data export functionality
- Check privacy dashboard rendering
- Validate policy enforcement

## Migration Notes

### Database Considerations
- No schema changes required for Filament upgrade
- Existing consent records remain valid
- Privacy event logs maintain integrity

### Configuration Updates
- Review panel provider settings
- Update widget configurations
- Verify navigation permissions

## Rollback Plan

If issues arise with privacy-critical functions:
1. Immediate rollback to previous Filament version
2. Verify all consent collection continues working
3. Check data processing treatment logs
4. Validate privacy dashboard functionality

---

**Priority**: HIGH - Privacy compliance cannot be compromised during upgrade