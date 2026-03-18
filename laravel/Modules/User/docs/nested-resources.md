# User Module - Nested Resource Implementation Guide

## Overview

The User module handles authentication, authorization, and user profile management with multi-tenancy support. Nested resources in this module focus on organizing user-related data and relationships in a hierarchical structure.

## Current Relationship Structure

### User Model Relationships
- `User` belongsTo `Team`
- `User` belongsTo `Tenant`
- `User` hasMany `Profile`
- `User` hasMany `AuthenticationLog`
- `User` hasMany `Device`
- `User` hasMany `OauthToken`
- `User` hasMany `Client`
- `User` belongsToMany `Role`

### Team Model Relationships
- `Team` hasMany `User`
- `Team` hasMany `TeamInvitation`

### Tenant Model Relationships
- `Tenant` hasMany `User`
- `Tenant` hasMany `Domain`

## Potential Nested Resource Applications

### 1. User Profile Management
**Parent Resource:** UserResource
**Child Resource:** ProfileResource
**Relationship:** User hasOne Profile
**Justification:** Organize user profile information in a nested structure for better user management.

### 2. User Authentication Logs
**Parent Resource:** UserResource
**Child Resource:** AuthenticationLogResource
**Relationship:** User hasMany AuthenticationLogs
**Justification:** Track and manage user authentication history in a dedicated nested view.

### 3. User Devices Management
**Parent Resource:** UserResource
**Child Resource:** DeviceResource
**Relationship:** User hasMany Devices
**Justification:** Allow users to manage their connected devices from within their user context.

### 4. User OAuth Tokens
**Parent Resource:** UserResource
**Child Resource:** OauthTokenResource
**Relationship:** User hasMany OauthTokens
**Justification:** Manage OAuth tokens associated with users in a nested structure.

### 5. Team Members Management
**Parent Resource:** TeamResource
**Child Resource:** UserResource
**Relationship:** Team hasMany Users
**Justification:** Organize team members within their respective teams for better team management.

### 6. Team Invitations
**Parent Resource:** TeamResource
**Child Resource:** TeamInvitationResource
**Relationship:** Team hasMany TeamInvitations
**Justification:** Manage team invitations within the team context.

### 7. Tenant Users Management
**Parent Resource:** TenantResource
**Child Resource:** UserResource
**Relationship:** Tenant hasMany Users
**Justification:** Organize users by tenant for better multi-tenancy management.

### 8. Tenant Domains
**Parent Resource:** TenantResource
**Child Resource:** DomainResource
**Relationship:** Tenant hasMany Domains
**Justification:** Manage tenant domains within the tenant context.

### 9. User Roles Management
**Parent Resource:** UserResource
**Child Resource:** UserRoleResource (for user-specific role assignments)
**Relationship:** User belongsToMany Role
**Justification:** Manage roles assigned to specific users within the user context.

### 10. User Clients
**Parent Resource:** UserResource
**Child Resource:** ClientResource
**Relationship:** User hasMany Clients
**Justification:** Organize OAuth clients by user for better API management.

## Implementation Approach

### Using Filament Nested Resources Package
Following the documented approach in `Modules/UI/docs/filament/nested-resource.md`:

1. **Child Resource Implementation:**
   ```php
   use SevendaysDigital\FilamentNestedResources\NestedResource;
   use SevendaysDigital\FilamentNestedResources\ResourcePages\NestedPage;

   class ProfileResource extends NestedResource
   {
       public static function getParent(): string
       {
           return UserResource::class;
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
           ChildResourceLink::make(ProfileResource::class),
       ]);
   }
   ```

3. **Page Configuration:**
   Apply the `NestedPage` trait to all nested resource pages (List, Edit, Create).

4. **For many-to-many relationships (User-Role):**
   ```php
   // In the child model, add scope for parent filtering
   public function scopeOfUser($query, $userId)
   {
       return $query->whereHas('users', function($q) use($userId) {
           $q->where('user_id', $userId);
       });
   }
   ```

## Benefits of Nested Resource Implementation

### 1. Improved User Management
- Hierarchical organization of user-related data
- Context-aware management of user relationships
- Reduced navigation complexity

### 2. Enhanced Team Management
- Team members organized within team context
- Team-specific operations and permissions
- Better multi-tenancy support

### 3. Better Security and Privacy
- Role-based access control within nested contexts
- Tenant isolation in nested resources
- Audit trail for nested operations

### 4. Scalability
- Modular approach to user data management
- Easy to extend with additional nested resources
- Consistent user experience across user operations

## Considerations

### 1. Performance
- Ensure proper indexing on foreign key relationships
- Consider lazy loading for user relationships
- Optimize queries for many-to-many relationships

### 2. Security
- Implement proper authorization checks at both parent and child levels
- Ensure tenant isolation in nested operations
- Validate parent-child relationship access

### 3. User Experience
- Maintain consistent navigation patterns
- Provide clear breadcrumbs for nested contexts
- Ensure responsive design for nested interfaces

## Implementation Roadmap

### Phase 1: Foundation Setup
- Install and configure filament-nested-resources package
- Create base nested resource classes extending XotBaseResource
- Implement basic user-profile relationship

### Phase 2: Core Functionality
- Implement user authentication logs
- Add user devices management
- Create team members organization

### Phase 3: Advanced Features
- Implement OAuth token management
- Add role assignments within user context
- Create tenant-based user organization

## Future Enhancements

### 1. Dynamic Permission-based Nesting
- Programmatically show/hide nested resources based on user permissions
- Role-based access to specific nested resources

### 2. Cross-module User Integration
- Enable nested resources that span multiple modules (User-Quaeris, User-Notify)
- Implement cross-module relationship management

### 3. Advanced User Analytics
- Nested resource usage analytics
- User behavior tracking across nested resources
- Performance monitoring for nested operations