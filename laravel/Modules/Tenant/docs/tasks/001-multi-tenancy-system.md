# Task 001: Implement Multi-Tenancy System

## Description
Create comprehensive multi-tenancy system with tenant isolation, onboarding, resource allocation, and billing management.

## Context
The Tenant module needs robust multi-tenancy support for serving multiple customers/organizations with complete data isolation and resource management.

## Requirements

### Functional Requirements
- Tenant isolation (database, files, cache)
- Tenant onboarding workflow
- Resource allocation and limits
- Tenant billing and subscriptions
- Tenant management dashboard
- Subdomain/Domain management
- Tenant customization (logo, theme)
- Tenant analytics and monitoring
- Tenant migration and backup
- Tenant deletion and archiving

### Technical Requirements
- Use PHP 8.3 strict typing
- PHPStan Level 10 compliance
- DatabaseTransactions for tests
- Separate databases per tenant or tenant_id columns
- Middleware for tenant identification

## Implementation Steps

### 1. Database Schema
- [ ] Create `tenants` table
  - id (uuid/ulid)
  - name (string)
  - slug (string, unique)
  - subdomain (string, unique, nullable)
  - custom_domain (string, unique, nullable)
  - logo (string, nullable)
  - favicon (string, nullable)
  - primary_color (string, nullable)
  - secondary_color (string, nullable)
  - status (enum: 'pending', 'active', 'suspended', 'deleted')
  - plan_id (nullable)
  - max_users (int, nullable)
  - max_storage_mb (int, nullable)
  - features (json, nullable)
  - settings (json, nullable)
  - billing_address (json, nullable)
  - contact_email (string)
  - contact_phone (string, nullable)
  - trial_ends_at (nullable)
  - subscription_ends_at (nullable)
  - created_by
  - deleted_at (nullable)
  - timestamps

- [ ] Create `tenant_invitations` table
  - id, tenant_id, email, role, token, accepted_at, expires_at, created_at

- [ ] Create `tenant_usage_stats` table
  - id, tenant_id, stat_type (enum: 'users', 'storage', 'api_calls', 'bandwidth'), value, recorded_at

### 2. Models
- [ ] Create `Tenant` model
- [ ] Create `TenantInvitation` model
- [ ] Create `TenantUsageStat` model

### 3. Tenant Manager Service
- [ ] Create `TenantManagerService`
  - `createTenant(array $data): Tenant`
  - `updateTenant(string $tenantId, array $data): Tenant`
  - `deleteTenant(string $tenantId, bool $hardDelete = false): bool`
  - `suspendTenant(string $tenantId, string $reason): bool`
  - `activateTenant(string $tenantId): bool`
  - `getTenantBySubdomain(string $subdomain): Tenant`
  - `getTenantByDomain(string $domain): Tenant`
  - `switchTenant(string $tenantId): bool`

### 4. Tenant Isolation Middleware
- [ ] Create `TenantIdentificationMiddleware`
  - Identify tenant from subdomain/domain
  - Set tenant context
  - Validate tenant status
  - Handle tenant not found

- [ ] Create `TenantScope` middleware
  - Apply tenant scope to queries
  - Filter data by tenant_id
  - Prevent cross-tenant access

### 5. Tenant Onboarding Service
- [ ] Create `TenantOnboardingService`
  - `startOnboarding(array $data): Tenant`
  - `completeOnboarding(string $tenantId): bool`
  - `inviteUsers(string $tenantId, array $emails): array`
  - `setupTenantResources(string $tenantId): bool`
  - `createDefaultData(string $tenantId): bool`

### 6. Resource Allocation Service
- [ ] Create `ResourceAllocationService`
  - `checkUserLimit(string $tenantId): bool`
  - `checkStorageLimit(string $tenantId): bool`
  - `recordUsage(string $tenantId, string $type, int $value): void`
  - `getUsageStats(string $tenantId): array`
  - `enforceLimits(string $tenantId): array`

### 7. Billing Integration Service
- [ ] Create `TenantBillingService`
  - `createSubscription(string $tenantId, string $planId): bool`
  - `updateSubscription(string $tenantId, string $planId): bool`
  - `cancelSubscription(string $tenantId): bool`
  - `getBillingInfo(string $tenantId): array`
  - `generateInvoice(string $tenantId, Carbon $period): string`
  - `processPayment(string $tenantId, array $paymentData): bool`

### 8. Domain Management Service
- [ ] Create `DomainManagementService`
  - `addCustomDomain(string $tenantId, string $domain): bool`
  - `removeCustomDomain(string $tenantId, string $domain): bool`
  - `verifyDomain(string $domain): bool`
  - `configureDNS(string $domain): array`
  - `getSSL(string $domain): bool`

### 9. Tenant Customization Service
- [ ] Create `TenantCustomizationService`
  - `uploadLogo(string $tenantId, UploadedFile $logo): string`
  - `updateBranding(string $tenantId, array $branding): bool`
  - `getTenantSettings(string $tenantId): array`
  - `updateSettings(string $tenantId, array $settings): bool`

### 10. Tenant Analytics Service
- [ ] Create `TenantAnalyticsService`
  - `getTenantStats(string $tenantId): array`
  - `getActivityMetrics(string $tenantId, Carbon $from, Carbon $to): array`
  - `getUsageTrends(string $tenantId, int $days): array`
  - `compareTenants(array $tenantIds): array`

### 11. Filament Resources
- [ ] Create `TenantResource`
  - Tenant list with filters
  - Create/Edit tenant
  - Tenant details
  - Resource usage

- [ ] Create `TenantInvitationResource`
  - Invitation management
  - Send invitations
  - Track acceptance

- [ ] Create `TenantAnalyticsWidget`
  - Tenant stats
  - Usage metrics
  - Active tenants
  - New tenants

### 12. API Endpoints
- [ ] `POST /api/tenants` - Create tenant
- [ ] `GET /api/tenants/{id}` - Get tenant
- [ ] `PUT /api/tenants/{id}` - Update tenant
- [ ] `DELETE /api/tenants/{id}` - Delete tenant
- [ ] `GET /api/tenants/{id}/usage` - Get usage stats

### 13. Actions
- [ ] Create `ActivateTenantAction`
- [ ] Create `SuspendTenantAction`
- [ ] Create `InviteUsersAction`
- [ ] Create `UpgradeTenantAction`

### 14. Tests
- [ ] Create `TenantManagerServiceTest`
- [ ] Create `TenantIsolationTest`
- [ ] Create `ResourceAllocationTest`
- [ ] Create `BillingServiceTest`

### 15. Documentation
- [ ] Create multi-tenancy guide
- [ ] Document tenant isolation
- [ ] Create onboarding guide
- [ ] Add billing guide

## Acceptance Criteria
- [ ] Tenants are completely isolated
- [ ] Subdomain/domain routing works
- [ ] Resource limits are enforced
- [ ] Billing integration functions
- [ ] Onboarding is smooth
- [ ] Customization works
- [ ] Analytics provide insights
- [ ] All tests pass with 85%+ coverage
- [ ] PHPStan Level 10 compliant

## Dependencies
- Xot module (base classes)
- User module (tenant users)
- Billing module (payments)
- Filament 5.x (admin UI)

## Estimated Time
- Database schema: 3 hours
- Models: 3 hours
- Tenant manager: 5 hours
- Isolation middleware: 4 hours
- Onboarding: 4 hours
- Resource allocation: 4 hours
- Billing: 5 hours
- Domain management: 4 hours
- Customization: 3 hours
- Analytics: 4 hours
- Filament integration: 5 hours
- API endpoints: 3 hours
- Actions: 2 hours
- Tests: 8 hours
- Documentation: 3 hours

**Total: 60 hours (~8 days)**

## Priority
**High** - Core multi-tenancy

## Related Tasks
- Task 002: Advanced Tenant Features

## Notes
- Use tenant_id columns for shared database
- Consider separate databases for large tenants
- Implement tenant caching strategy
- Use queues for tenant operations
- Monitor tenant performance
- Implement backup per tenant
- Handle tenant deletion carefully

---

**Status**: Pending
**Assignee**: TBD