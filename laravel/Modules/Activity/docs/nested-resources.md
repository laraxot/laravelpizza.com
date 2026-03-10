# Activity Module - Nested Resource Implementation Guide

## Overview

The Activity module provides comprehensive activity logging and audit trail functionality using the spatie/laravel-activitylog package. Nested resources in this module focus on organizing activity logs by context and subject, enabling better audit trails and system monitoring.

## Current Relationship Structure

### Activity Model Relationships (from spatie/laravel-activitylog)
- `Activity` belongsTo `Subject` (morphTo - any model that was affected)
- `Activity` belongsTo `Causer` (morphTo - user or model that caused the activity)
- `Activity` belongsTo `Team` (for multi-tenancy support)

### Subject Relationships (any model that can be logged)
- Models that use `LogsActivity` trait have many activities as subject
- User activities (user as causer)
- System component activities (as subjects)

## Potential Nested Resource Applications

### 1. User Activity Logs
**Parent Resource:** UserResource (from User module)
**Child Resource:** ActivityResource
**Relationship:** User (as causer) hasMany Activities
**Justification:** Organize activity logs by user to track individual user actions and behavior for security and compliance.

### 2. Model-Specific Activity Logs
**Parent Resource:** Any model resource (e.g., SurveyPdfResource, CustomerResource)
**Child Resource:** ActivityResource
**Relationship:** Model (as subject) hasMany Activities
**Justification:** Track all activities related to a specific model instance for audit trails and change tracking.

### 3. Team Activity Logs
**Parent Resource:** TeamResource (from User module)
**Child Resource:** ActivityResource
**Relationship:** Team hasMany Activities
**Justification:** Group activity logs by team for organizational monitoring and reporting.

### 4. Tenant Activity Logs
**Parent Resource:** TenantResource (from Tenant module)
**Child Resource:** ActivityResource
**Relationship:** Tenant hasMany Activities
**Justification:** Organize activity logs by tenant for multi-tenant audit and compliance requirements.

### 5. Customer Activity Tracking
<<<<<<< .merge_file_bcLZR7
**Parent Resource:** CustomerResource (from healthcare_app module)
=======
**Parent Resource:** CustomerResource (from ModuloEsempio module)
>>>>>>> .merge_file_8MhXh4
**Child Resource:** ActivityResource
**Relationship:** Customer (as subject) hasMany Activities
**Justification:** Track all activities related to customer records for business audit trails.

### 6. Survey Activity Logs
<<<<<<< .merge_file_bcLZR7
**Parent Resource:** SurveyPdfResource (from healthcare_app module)
=======
**Parent Resource:** SurveyPdfResource (from ModuloEsempio module)
>>>>>>> .merge_file_8MhXh4
**Child Resource:** ActivityResource
**Relationship:** SurveyPdf (as subject) hasMany Activities
**Justification:** Monitor all activities related to specific surveys for compliance and tracking.

### 7. System Component Activity
**Parent Resource:** SystemComponentResource (if implemented)
**Child Resource:** ActivityResource
**Relationship:** System component hasMany Activities
**Justification:** Track activities related to system components for monitoring and debugging.

### 8. Role Activity Monitoring
**Parent Resource:** RoleResource (from User module)
**Child Resource:** ActivityResource
**Relationship:** Role-related user activities
**Justification:** Monitor activities performed by users with specific roles for security auditing.

## Implementation Approach

### Filament v5 native nesting (obbligatorio)

In questo progetto le nested resources sono **native** in Filament v5.

Riferimenti:

- `Modules/UI/docs/filament/nested-resource.md`
- https://filamentphp.com/docs/5.x/resources/nesting
- `Modules/Xot/docs/filament-nesting-best-practices.md`

Note: per questo modulo (ActivityLog) molte relazioni sono **polimorfiche** (`morphTo`). Prima di introdurre nested resources, verificare che esista una relazione Eloquent “stabile” da usare come `relationship()` nel parent, oppure mantenere l’approccio con relation manager / page dedicata.

Pattern minimo (quando applicabile):

1. **Child Resource**: dichiarare il parent.

   ```php
   protected static ?string $parentResource = UserResource::class;
   ```

2. **Parent RelationManager / ManageRelatedRecords page**: puntare alla nested resource.

   ```php
   protected static ?string $relatedResource = ActivityResource::class;
   ```

3. **URL correctness**: se ci sono più relation managers sulla stessa pagina, registrare in `getRelations()` con **chiave = nome relazione**.

## Benefits of Nested Resource Implementation

### 1. Improved Audit Trail Management
- Organized activity logs by context and subject
- Context-aware activity monitoring
- Better compliance reporting capabilities

### 2. Enhanced Security Monitoring
- User-specific activity tracking
- Role-based activity monitoring
- Suspicious activity identification

### 3. Better System Visibility
- Component-specific activity tracking
- Change history for all model instances
- Event correlation within contexts

### 4. Scalability
- Modular approach to activity management
- Easy to extend with additional nested resources
- Consistent user experience across audit operations

## Considerations

### 1. Performance
- Activities can accumulate rapidly, requiring pagination and filtering
- Ensure proper indexing on causer_id, subject_id, and subject_type
- Consider archiving strategies for old activity logs

### 2. Security
- Implement proper authorization for viewing sensitive activity logs
- Ensure tenant isolation for activity logs
- Protect privacy-sensitive information in activity descriptions

### 3. Data Volume Management
- Implement smart filtering and search for large activity datasets
- Consider time-based partitioning for activity logs
- Optimize queries for common activity log patterns

### 4. User Experience
- Provide meaningful activity descriptions for non-technical users
- Implement efficient search and filtering capabilities
- Ensure responsive design for large activity datasets

## Implementation Roadmap

### Phase 1: Foundation Setup
- Install and configure filament-nested-resources package
- Create base nested resource classes extending XotBaseResource
- Implement basic User-Activity relationship

### Phase 2: Core Functionality
- Implement Model-Activity relationships
- Add Tenant-Activity organization
- Create activity filtering and search capabilities

### Phase 3: Advanced Features
- Implement role-based activity monitoring
- Add system component activity tracking
- Create advanced audit reporting tools

## Future Enhancements

### 1. Intelligent Activity Analysis
- Automated anomaly detection in activity patterns
- <nome progetto>ive analytics for security threats
- Machine learning-based activity categorization

### 2. Advanced Compliance Features
- Automated compliance reporting
- Regulatory requirement tracking
- Activity-based compliance monitoring

### 3. Cross-module Activity Correlation
- Activity correlation across different modules
- System-wide activity analytics
- Business process tracking through activities