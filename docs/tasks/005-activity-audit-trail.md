# Task 005: Implement Activity Audit Trail with Compliance Features

## Description
Create a comprehensive audit trail system for activities with compliance features, retention policies, and immutable logging for regulatory requirements.

## Context
For GDPR compliance and regulatory requirements, activities must be logged with complete audit trails, immutability guarantees, and defined retention policies. Current implementation lacks these features.

## Requirements

### Functional Requirements
- Immutable activity logging (cannot be modified or deleted)
- Complete audit trail with before/after state
- Digital signatures for tamper evidence
- Retention policies with automatic archival
- Compliance reports generation
- Audit trail export for regulators
- Chain of custody tracking
- Activity verification and validation

### Technical Requirements
- Use PHP 8.3 strict typing
- PHPStan Level 10 compliance
- Cryptographic signatures
- Append-only database pattern
- Secure archival storage
- Hash chaining for integrity

## Implementation Steps

### 1. Database Schema
- [ ] Create `activity_audit_logs` table
  - id (uuid/ulid)
  - activity_id (reference to immutable activity)
  - user_id (who performed the action)
  - action_type (enum: 'create', 'update', 'delete', 'read', 'export')
  - table_name (string)
  - record_id (string)
  - before_state (json, nullable)
  - after_state (json, nullable)
  - changed_fields (json)
  - ip_address (string, nullable)
  - user_agent (string, nullable)
  - request_id (string, nullable)
  - signature (string, hash of activity + timestamp)
  - previous_hash (string, for chain of custody)
  - is_verified (boolean, default false)
  - archived_at (nullable)
  - retention_date (nullable)
  - created_at (immutable)

- [ ] Create `activity_retention_policies` table
  - id (uuid/ulid)
  - name (string)
  - category_id (nullable)
  - tag_id (nullable)
  - activity_type (nullable)
  - retention_days (int)
  - archival_storage (string, nullable)
  - is_active (boolean, default true)
  - timestamps

### 2. Immutable Storage Pattern
- [ ] Implement append-only activity storage
  - No UPDATE or DELETE on activity records
  - Soft deletes only for non-audit activities
  - Separate table for mutable activity metadata

- [ ] Create `ImmutableActivity` trait
  - Prevent model updates/deletes
  - Add signature on creation
  - Validate signature on read

### 3. Digital Signatures
- [ ] Create `ActivitySignatureService`
  - `signActivity(Activity $activity): string`
  - `verifyActivity(Activity $activity): bool`
  - `verifyChainOfCustody(Activity $activity): bool`
  - `generateHashChain(array $activities): array`

- [ ] Implement hash chaining
  - Each activity includes hash of previous activity
  - Creates tamper-evident chain
  - Detects any modifications in history

### 4. Audit Trail Middleware
- [ ] Create `AuditTrailMiddleware`
  - Capture all model changes
  - Log before/after states
  - Track changed fields
  - Capture request metadata

- [ ] Create `ModelObserver` for automatic logging
  - `created()` - log new records
  - `updated()` - log changes
  - `deleted()` - log deletions
  - `restored()` - log restores

### 5. Retention Policies
- [ ] Create `ActivityRetentionService`
  - `applyRetentionPolicy(Activity $activity): void`
  - `archiveOldActivities(): int`
  - `deleteExpiredActivities(): int`
  - `getRetentionDate(Activity $activity): Carbon`
  - `checkCompliance(): array`

- [ ] Create scheduled jobs
  - `ArchiveActivitiesJob` (daily)
  - `DeleteExpiredActivitiesJob` (daily)
  - `GenerateComplianceReportJob` (weekly)

### 6. Archival System
- [ ] Create `ActivityArchivalService`
  - `archiveActivity(Activity $activity): bool`
  - `archiveBatch(Collection $activities): int`
  - `restoreActivity(string $archiveId): bool`
  - `verifyArchiveIntegrity(string $archiveId): bool`

- [ ] Implement archival storage options
  - Compressed JSON files
  - Database archival table
  - Cloud storage (S3-compatible)
  - Encrypted archival

### 7. Compliance Reports
- [ ] Create `ActivityComplianceReportService`
  - `generateAuditTrailReport(Carbon $from, Carbon $to): Report`
  - `generateAccessLogReport(Carbon $from, Carbon $to): Report`
  - `generateDataModificationReport(Carbon $from, Carbon $to): Report`
  - `generateChainOfCustodyReport(Activity $activity): Report`
  - `verifySystemIntegrity(): array`

- [ ] Create report formats
  - PDF with signature
  - JSON with hash verification
  - CSV for data analysis
  - XML for regulatory submission

### 8. Filament Resources
- [ ] Create `ActivityAuditLogResource`
  - Read-only list view
  - Detail view with before/after comparison
  - Chain of custody visualization
  - Signature verification status

- [ ] Create `ActivityRetentionPolicyResource`
  - Policy management
  - Create/Edit/Delete policies
  - Policy testing and preview

- [ ] Create `ActivityComplianceResource`
  - Compliance dashboard
  - Integrity verification
  - Retention status
  - Export compliance reports

- [ ] Update `ActivityResource`
  - Add audit trail tab
  - Show signature status
  - Link to chain of custody

### 9. API Endpoints
- [ ] `GET /api/activities/{id}/audit-trail` - Get audit trail
- [ ] `GET /api/activities/{id}/verify` - Verify integrity
- [ ] `GET /api/activities/compliance-report` - Generate report
- [ ] `GET /api/activities/chain-of-custody/{id}` - Get chain
- [ ] `POST /api/activities/export-audit` - Export for regulators

### 10. Security Features
- [ ] Implement role-based access to audit logs
- [ ] Add audit trail for audit trail access
- [ ] Encrypt archived activities
- [ ] Secure key management for signatures
- [ ] Tamper detection alerts

### 11. Actions
- [ ] Create `VerifyActivityIntegrityAction`
- [ ] Create `GenerateComplianceReportAction`
- [ ] Create `ArchiveActivitiesAction`
- [ ] Create `ExportAuditTrailAction`

### 12. Tests
- [ ] Create `ActivityAuditLogTest`
  - Test audit log creation
  - Test before/after state capture
  - Test changed fields tracking

- [ ] Create `ActivitySignatureTest`
  - Test signature generation
  - Test signature verification
  - Test hash chaining

- [ ] Create `ActivityRetentionTest`
  - Test retention policy application
  - Test archival process
  - Test deletion of expired activities

- [ ] Create `ActivityComplianceTest`
  - Test compliance report generation
  - Test integrity verification
  - Test chain of custody

### 13. Documentation
- [ ] Create audit trail guide
- [ ] Document retention policies
- [ ] Create compliance report documentation
- [ ] Add security documentation
- [ ] Create regulatory submission guide

## Acceptance Criteria
- [ ] All activities are immutable after creation
- [ ] Digital signatures prevent tampering
- [ ] Chain of custody is verifiable
- [ ] Retention policies are automatically applied
- [ ] Compliance reports meet regulatory requirements
- [ ] Archive integrity is verifiable
- [ ] All tests pass with 85%+ coverage
- [ ] PHPStan Level 10 compliant

## Dependencies
- Xot module (base classes)
- Gdpr module (compliance features)
- Filament 5.x (admin UI)
- Laravel Encryption (archival)
- CloudStorage module (archival storage)

## Estimated Time
- Database schema: 3 hours
- Immutable storage: 3 hours
- Digital signatures: 4 hours
- Audit trail middleware: 4 hours
- Retention policies: 4 hours
- Archival system: 5 hours
- Compliance reports: 5 hours
- Filament resources: 5 hours
- API endpoints: 2 hours
- Security features: 3 hours
- Actions: 2 hours
- Tests: 8 hours
- Documentation: 3 hours

**Total: 51 hours (6-7 days)**

## Priority
**High** - Critical for regulatory compliance

## Related Tasks
- Task 001: Activity Categorization System
- Task 002: Advanced Activity Filtering
- Task 003: Activity Analytics Dashboard

## Notes
- Use cryptographic hashing (SHA-256 or better)
- Implement secure key rotation for signatures
- Consider using blockchain for enhanced immutability
- Archive to cold storage for cost efficiency
- Generate compliance reports in formats required by regulators (GDPR, HIPAA, etc.)
- Regular integrity verification scheduled jobs

---

**Status**: Pending
**Assignee**: TBD