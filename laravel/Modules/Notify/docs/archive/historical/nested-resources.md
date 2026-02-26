# Notify Module - Nested Resource Implementation Guide

## Overview

The Notify module provides a comprehensive notification system for the Laraxot system, supporting multiple communication channels (email, SMS, push notifications) and template management. Nested resources in this module focus on organizing notification-related data in a hierarchical structure that connects notifications with their contexts and recipients.

## Current Relationship Structure

### NotificationTemplate Model Relationships
- `NotificationTemplate` hasMany `NotificationTemplateVersion`
- `NotificationTemplate` hasMany `NotificationLog`
- `NotificationTemplate` belongsTo `User` (created_by)
- `NotificationTemplate` hasMany `MailTemplate` (as parent)

### MailTemplate Model Relationships
- `MailTemplate` hasMany `MailTemplateVersion`
- `MailTemplate` hasMany `MailTemplateLog`
- `MailTemplate` belongsTo `NotificationTemplate` (as parent)
- `MailTemplate` belongsTo `User` (created_by)

### NotificationLog Model Relationships
- `NotificationLog` belongsTo `NotificationTemplate`
- `NotificationLog` belongsTo `User` (recipient)
- `NotificationLog` belongsTo `Tenant`

### MailTemplateLog Model Relationships
- `MailTemplateLog` belongsTo `MailTemplate`
- `MailTemplateLog` belongsTo `User` (recipient)

## Potential Nested Resource Applications

### 1. Template Versions Management
**Parent Resource:** NotificationTemplateResource
**Child Resource:** NotificationTemplateVersionResource
**Relationship:** NotificationTemplate hasMany NotificationTemplateVersions
**Justification:** Organize template versions within the template context for better version management and history tracking.

### 2. Template Logs and Analytics
**Parent Resource:** NotificationTemplateResource
**Child Resource:** NotificationLogResource
**Relationship:** NotificationTemplate hasMany NotificationLogs
**Justification:** Track and analyze notification delivery and engagement within the template context.

### 3. Mail Template Versions
**Parent Resource:** MailTemplateResource
**Child Resource:** MailTemplateVersionResource
**Relationship:** MailTemplate hasMany MailTemplateVersions
**Justification:** Manage email template versions within the email template context for better version control.

### 4. Mail Template Logs
**Parent Resource:** MailTemplateResource
**Child Resource:** MailTemplateLogResource
**Relationship:** MailTemplate hasMany MailTemplateLogs
**Justification:** Track email delivery and engagement within the email template context.

### 5. User Notification History
**Parent Resource:** UserResource (from User module)
**Child Resource:** NotificationLogResource
**Relationship:** User (as recipient) hasMany NotificationLogs
**Justification:** Organize notification history by user to track communication with specific recipients.

### 6. Tenant Notifications
**Parent Resource:** TenantResource (from Tenant module)
**Child Resource:** NotificationLogResource
**Relationship:** Tenant hasMany NotificationLogs
**Justification:** Group notification logs by tenant for multi-tenant monitoring and compliance.

### 7. Customer Communication History
**Parent Resource:** CustomerResource (from Quaeris module)
**Child Resource:** NotificationLogResource
**Relationship:** Customer-related notifications (via contacts/surveys)
**Justification:** Track all communication with customers across different channels for relationship management.

### 8. Survey Communication Logs
**Parent Resource:** SurveyPdfResource (from Quaeris module)
**Child Resource:** NotificationLogResource
**Relationship:** Survey-related notifications (via survey contacts)
**Justification:** Monitor all communication related to specific surveys for better survey management.

### 9. Template Translations
**Parent Resource:** NotificationTemplateResource
**Child Resource:** TemplateTranslationResource (if implemented)
**Relationship:** NotificationTemplate hasMany TemplateTranslations
**Justification:** Organize template translations within the template context for multi-language support.

### 10. Template Analytics
**Parent Resource:** NotificationTemplateResource
**Child Resource:** TemplateAnalyticsResource (if implemented)
**Relationship:** NotificationTemplate hasMany TemplateAnalytics
**Justification:** Track detailed analytics for specific templates within the template context.

## Implementation Approach

### Using Filament Nested Resources Package
Following the documented approach in `Modules/UI/docs/filament/nested-resource.md`:

1. **Child Resource Implementation:**
   ```php
   use SevendaysDigital\FilamentNestedResources\NestedResource;
   use SevendaysDigital\FilamentNestedResources\ResourcePages\NestedPage;

   class NotificationTemplateVersionResource extends NestedResource
   {
       public static function getParent(): string
       {
           return NotificationTemplateResource::class;
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
           ChildResourceLink::make(NotificationTemplateVersionResource::class),
       ]);
   }
   ```

3. **Page Configuration:**
   Apply the `NestedPage` trait to all nested resource pages (List, Edit, Create).

4. **For many-to-many style relationships:**
   ```php
   // In the child model, add scope for parent filtering
   public function scopeOfTemplate($query, $templateId)
   {
       return $query->where('template_id', $templateId);
   }
   
   // For polymorphic relationships
   public function scopeOfUserAsRecipient($query, $userId)
   {
       return $query->where('recipient_id', $userId);
   }
   ```

## Benefits of Nested Resource Implementation

### 1. Improved Communication Management
- Organized notification and template relationships
- Context-aware communication tracking
- Better version management for templates

### 2. Enhanced Analytics and Reporting
- Template-specific analytics
- User communication history
- Engagement tracking within contexts

### 3. Better Multi-tenancy Support
- Tenant-specific notification tracking
- Isolated communication logs
- Tenant-aware analytics

### 4. Scalability
- Modular approach to communication management
- Easy to extend with additional nested resources
- Consistent user experience across notification operations

## Considerations

### 1. Performance
- Notification logs can accumulate rapidly, requiring efficient indexing
- Ensure proper indexing on template_id, recipient_id, and tenant_id
- Consider archival strategies for old notification logs

### 2. Security
- Implement proper authorization for viewing sensitive communication logs
- Ensure tenant isolation for notification data
- Protect privacy-sensitive information in notification content

### 3. Data Volume Management
- Implement smart filtering and search for large notification datasets
- Consider time-based partitioning for notification logs
- Optimize queries for common notification log patterns

### 4. Integration with Other Modules
- Handle relationships with Quaeris module (surveys and contacts)
- Coordinate with User module for recipient management
- Integrate with Tenant module for multi-tenant operations

## Implementation Roadmap

### Phase 1: Foundation Setup
- Install and configure filament-nested-resources package
- Create base nested resource classes extending XotBaseResource
- Implement basic Template-Version relationship

### Phase 2: Core Functionality
- Implement Template-Log relationships
- Add User-Notification history
- Create tenant-specific notification organization

### Phase 3: Advanced Features
- Implement survey communication tracking
- Add customer communication history
- Create advanced analytics and reporting

## Future Enhancements

### 1. Intelligent Notification Management
- Automated personalization based on recipient history
- Predictive analytics for engagement optimization
- Machine learning-based content optimization

### 2. Advanced Communication Analytics
- Cross-channel engagement tracking
- Behavioral analytics for recipients
- Predictive delivery timing optimization

### 3. Cross-module Communication Integration
- Unified communication history across modules
- Business process notifications
- Automated communication workflows