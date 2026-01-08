# Activity Module Documentation

## Overview
The Activity module provides comprehensive activity logging and tracking functionality for the Laraxot system. It records user actions, system events, and business operations to enable audit trails, analytics, and monitoring.

## Key Features
- **Activity Logging**: Automatic logging of user and system activities
- **Audit Trails**: Complete history of changes and actions
- **Event Tracking**: Real-time monitoring of system events
- **Reporting**: Activity reports and analytics
- **Filtering**: Advanced filtering and search capabilities

## Architecture
The module follows the Laraxot architecture principles:
- Extends Xot base classes
- Uses Filament for admin interface
- Implements proper service providers
- Follows DRY/KISS principles

## Core Components

### Models
- `Activity` - Main activity model
- `ActivityLog` - Detailed activity logging

### Resources
- `ActivityResource` - Filament resource for activity management
- `ActivityLogResource` - Resource for detailed logs

### Services
- `ActivityService` - Core activity management logic
- `ActivityLogger` - Activity logging service

## Implementation Guide

### Basic Usage
```php
// Log an activity
activity()->log('User logged in');

// Log activity with properties
activity()
    ->performedOn($user)
    ->causedBy(auth()->user())
    ->withProperties(['ip' => request()->ip()])
    ->log('User updated profile');
```

### Configuration
The module can be configured through the `config/activity.php` file:
- Log retention policies
- Activity types to track
- Database connection settings

## Best Practices
1. **Selective Logging**: Only log meaningful activities to avoid performance issues
2. **Property Management**: Store relevant context data with activities
3. **Cleanup Policies**: Implement regular cleanup of old activity logs
4. **Privacy Compliance**: Ensure activity logging complies with data protection regulations

## Related Modules
- [User Module](../User/docs/README.md) - User authentication and management
- [Notify Module](../Notify/docs/index.md) - Notification system
- [Xot Module](../Xot/docs/index.md) - Core base classes

## Troubleshooting
Common issues and solutions:
- Database performance with large activity logs
- Missing activity entries
- Configuration issues