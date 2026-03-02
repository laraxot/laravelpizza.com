# Dentist Moderation Approach in User Module

## Overview
This document outlines the strategy for implementing dentist moderation within the existing `User` module. While a separate `Moderation` module was initially considered, the decision has been made to integrate this functionality into the `User` module to streamline development and leverage existing user management infrastructure.

## Rationale for Using User Module
- **Centralized User Management**: The `User` module already handles user data, authentication, and roles. Integrating moderation here keeps related functionality together.
- **Efficiency**: Utilizing existing structures reduces development time compared to creating a new module.
- **Complexity Management**: Although dentist moderation is more intricate, the `User` module can be extended to accommodate these requirements without significant overhead.

## Implementation Strategy

### 1. Data Model Extensions
- **User Profile Enhancements**: Add fields to the `User` model specific to dentists such as `professional_license_number`, `license_verification_status`, and `moderation_status`.
- **Status Tracking**: Use an enum for `moderation_status` with values like `pending`, `under_review`, `approved`, `rejected`, to track the moderation process.

### 2. Role and Permission Structure
- **Dentist Role**: Create a specific role for dentists within the existing Spatie Laravel-permission system.
- **Moderation Permissions**: Define permissions such as `review_dentist_profile`, `approve_dentist`, `reject_dentist` for admin users who will handle moderation tasks.

### 3. Moderation Workflow
- **Registration**: When a user registers as a dentist, they are assigned the 'dentist' role with an initial `moderation_status` of 'pending'.
- **Submission for Review**: Dentists complete a detailed profile including professional credentials, triggering a status change to 'under_review'.
- **Admin Review Process**:
  - Admin users with appropriate permissions access a dedicated interface to view pending reviews.
  - Review involves verifying credentials (e.g., license numbers against official databases if API available).
  - Admins can request additional information, approve, or reject the application, updating the `moderation_status` accordingly.
- **Notification System**: Automated notifications to dentists about status changes or requests for more information, integrated with Laravel's notification system.

### 4. Filament Integration
- **Admin Interface**: Extend the Filament admin panel within the `User` module to include moderation queues.
- **Custom Resources**: Create a `DentistModerationResource` extending `XotBaseResource` for managing the moderation process:
  ```php
  class DentistModerationResource extends XotBaseResource
  {
      protected static ?string $model = User::class;

      public static function getFormSchema(): array
      {
          return [
              'moderation_status' => Forms\Components\Select::make('moderation_status')
                  ->options([
                      'pending' => 'Pending',
                      'under_review' => 'Under Review',
                      'approved' => 'Approved',
                      'rejected' => 'Rejected',
                  ]),
              'professional_license_number' => Forms\Components\TextInput::make('professional_license_number'),
              'license_verification_status' => Forms\Components\TextInput::make('license_verification_status'),
          ];
      }
  }
  ```
- **Filters**: Implement filters to view dentists by moderation status.

### 5. Business Logic Layer
- **Services**: Develop a `DentistModerationService` class within the `User` module to encapsulate moderation logic, including validation of credentials and status transitions.
- **Events and Listeners**: Use Laravel events (`DentistProfileSubmitted`, `DentistStatusUpdated`) to trigger actions like notifications or logging.

### 6. Database Considerations
- **Migration Updates**: Create migrations in the `User` module to add necessary fields for dentist moderation. Ensure these extend `XotBaseMigration` and check for table existence:
  ```php
  $this->tableUpdate('users', function (Blueprint $table): void {
      if (!Schema::hasColumn('users', 'professional_license_number')) {
          $table->string('professional_license_number')->nullable();
      }
      if (!Schema::hasColumn('users', 'license_verification_status')) {
          $table->string('license_verification_status')->nullable();
      }
      if (!Schema::hasColumn('users', 'moderation_status')) {
          $table->enum('moderation_status', ['pending', 'under_review', 'approved', 'rejected'])->default('pending');
      }
  });
  ```

### 7. Security and Compliance
- **Data Protection**: Ensure sensitive data like license numbers are encrypted in storage.
- **Audit Trail**: Implement logging for all moderation actions to maintain accountability.
- **GDPR Compliance**: Allow dentists to request data deletion or correction as per GDPR guidelines.

### 8. Testing
- **Unit Tests**: Test service classes for validation and status transition logic.
- **Feature Tests**: Test the full moderation workflow from registration to approval/rejection.
- **UI Tests**: Verify Filament interfaces display data correctly and handle user interactions as expected.

## Challenges and Mitigations
- **Complexity of Dentist Moderation**: The process is more labor-intensive due to credential verification. Mitigation involves clear documentation and potentially integrating with external APIs for license validation if available.
- **Scalability**: As the number of dentists grows, the moderation queue could become cumbersome. Implement pagination and efficient filtering in Filament.
- **User Experience**: Ensure the process is transparent for dentists with clear communication. Use automated notifications and status tracking.

## Future Considerations
- **External API Integration**: Explore APIs for automated license verification to reduce manual workload.
- **Separate Module Option**: Revisit the possibility of a dedicated `Moderation` module if the process becomes too complex within `User` or if patient moderation is added with similar complexity.

## Conclusion
Integrating dentist moderation into the `User` module leverages existing infrastructure for efficiency while addressing the unique requirements of dentist verification. This approach maintains a cohesive system architecture while providing a structured process for managing professional credentials.
