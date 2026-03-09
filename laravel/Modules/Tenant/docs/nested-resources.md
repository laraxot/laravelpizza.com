# Tenant Module - Nested Resource Implementation Guide

## Overview

The Tenant module implements comprehensive multi-tenancy functionality with database isolation, providing the foundation for multi-client support in the Laraxot system. Nested resources in this module focus on organizing tenant-related data and relationships in a hierarchical structure that supports multi-tenant operations.

## Current Relationship Structure

### Tenant Model Relationships
- `Tenant` hasMany `User` (via tenant_user relationship)
- `Tenant` hasMany `Domain`
- `Tenant` hasMany `Customer` (via customer-tenant relationship)
- `Tenant` hasMany `SurveyPdf` (via customer-tenant relationship)
- `Tenant` hasMany `ActivityLog` (tenant-specific logs)

### Domain Model Relationships
- `Domain` belongsTo `Tenant`

### User Model Relationships (from User module)
- `User` belongsTo `Tenant`

## Potential Nested Resource Applications

### 1. Tenant Domains Management
**Parent Resource:** TenantResource
**Child Resource:** DomainResource
**Relationship:** Tenant hasMany Domains
**Justification:** Organize tenant domains within the tenant context for better domain management and multi-tenancy configuration.

### 2. Tenant Users Management
**Parent Resource:** TenantResource
**Child Resource:** UserResource
**Relationship:** Tenant hasMany Users
**Justification:** Manage users by tenant for better multi-tenancy administration and access control.

### 3. Tenant Customers
**Parent Resource:** TenantResource
**Child Resource:** CustomerResource (from Quaeris module)
**Relationship:** Tenant hasMany Customers (via tenant-customer relationship)
**Justification:** Organize customers by tenant for better client management in multi-tenant environments.

### 4. Tenant Surveys
**Parent Resource:** TenantResource
**Child Resource:** SurveyPdfResource (from Quaeris module)
**Relationship:** Tenant hasMany SurveyPdfs (via customer-tenant relationship)
**Justification:** Group surveys by tenant for comprehensive tenant-level reporting and management.

### 5. Tenant Activity Logs
**Parent Resource:** TenantResource
**Child Resource:** ActivityLogResource (from Activity module)
**Relationship:** Tenant hasMany ActivityLogs
**Justification:** Track and manage activity logs within the tenant context for security and compliance.

### 6. Tenant Notifications
**Parent Resource:** TenantResource
**Child Resource:** NotificationTemplateResource (from Notify module)
**Relationship:** Tenant hasMany NotificationTemplates
**Justification:** Manage tenant-specific notification templates and communications.

### 7. Tenant Configuration Settings
**Parent Resource:** TenantResource
**Child Resource:** TenantSettingResource
**Relationship:** Tenant hasMany TenantSettings
**Justification:** Organize tenant-specific configuration options within the tenant context.

### 8. Tenant Teams
**Parent Resource:** TenantResource
**Child Resource:** TeamResource (from User module)
**Relationship:** Tenant hasMany Teams (via tenant-team relationship)
**Justification:** Group teams by tenant for better organizational management.

## Implementation Approach

### Using Filament Nested Resources Package
Following the documented approach in `Modules/UI/docs/filament/nested-resource.md`:

1. **Child Resource Implementation:**
   ```php
   use SevendaysDigital\FilamentNestedResources\NestedResource;
   use SevendaysDigital\FilamentNestedResources\ResourcePages\NestedPage;

   class DomainResource extends NestedResource
   {
       public static function getParent(): string
       {
           return TenantResource::class;
       }
   }
   ```

2. **Parent Resource Enhancement:**
   ```php
   use SevendaysDigital\FilamentNestedResources\Columns\ChildResourceLink;
   
   public static function table(Table $table): Table
   {
       return $table->columns([
           TextColumn::make('name'),
           ChildResourceLink::make(DomainResource::class),
       ]);
   }
   ```

3. **Page Configuration:**
   Apply the `NestedPage` trait to all nested resource pages (List, Edit, Create).

4. **For cross-module relationships:**
   ```php
   // In the child model, add scope for parent filtering
   public function scopeOfTenant($query, $tenantId)
   {
       // For relationships that span modules
       return $query->where('tenant_id', $tenantId);
   }
   ```

## Benefits of Nested Resource Implementation

### 1. Improved Multi-tenancy Management
- Hierarchical organization of tenant-related data
- Context-aware tenant operations
- Clear separation between tenants

### 2. Enhanced Data Isolation
- Automatic filtering by tenant in nested contexts
- Improved data privacy and security
- Reduced risk of cross-tenant data access

### 3. Better Administrative Experience
- Tenant-specific views and operations
- Reduced navigation complexity
- Context-aware permissions and access control

### 4. Scalability
- Modular approach to tenant management
- Easy to extend with additional nested resources
- Consistent user experience across tenant operations

## Considerations

### 1. Performance
- Ensure proper indexing on tenant_id foreign keys
- Optimize queries for multi-tenant data access
- Consider caching strategies for tenant-specific data

### 2. Security
- Implement robust tenant isolation in nested operations
- Ensure proper authorization checks at both parent and child levels
- Validate tenant access for cross-module nested resources

### 3. Cross-module Integration
- Handle relationships that span multiple modules
- Ensure consistency in tenant identification across modules
- Maintain data integrity in cross-module operations

### 4. User Experience
- Maintain clear tenant context in nested interfaces
- Provide tenant-switching capabilities
- Ensure responsive design for nested tenant interfaces

## Implementation Roadmap

### Phase 1: Foundation Setup
- Install and configure filament-nested-resources package
- Create base nested resource classes extending XotBaseResource
- Implement basic Tenant-Domain relationship

### Phase 2: Core Functionality
- Implement Tenant-User management
- Add Tenant-Customer organization
- Create tenant-specific configuration management

### Phase 3: Advanced Features
- Implement cross-module tenant relationships
- Add tenant activity monitoring
- Create advanced tenant analytics

## Future Enhancements

### 1. Dynamic Tenant Configuration
- Programmatically generate nested resources based on tenant needs
- Allow runtime definition of tenant-specific relationships

### 2. Advanced Multi-tenancy Features
- Nested resource templates for new tenants
- Automated tenant onboarding with nested resources
- Tenant-specific access control policies

### 3. Cross-module Tenant Analytics
- Nested resource usage analytics across modules
- Tenant performance metrics
- Predictive analytics for tenant growth and needs