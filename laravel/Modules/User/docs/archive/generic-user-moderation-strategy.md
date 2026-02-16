# Generic User Moderation Strategy in User Module

## Overview
This document outlines a comprehensive strategy for implementing a generic moderation system within the `User` module. The approach is designed to be flexible and reusable across different projects, accommodating various user types without specific references to roles such as 'dentist' or 'patient'. The goal is to create a unified moderation framework that complements the unique registration wizard used for all user types.

## Analysis and Rationale

### Understanding User Types as Variants of User
- **User as a Base Entity**: In this system, all specific roles (e.g., dentists, patients, or other specialized users) are considered variants or types of the base `User` entity. This abstraction allows the `User` module to remain agnostic to specific roles, ensuring portability across projects.
- **Commonality in Processes**: Just as the registration wizard is designed to be unique and applicable to all user types through configurable fields and steps, moderation can follow a similar pattern. A generic moderation system can handle verification and approval processes for any user type by leveraging metadata and customizable workflows.

### Why a Generic Moderation System?
- **Reusability**: The `User` module is used in multiple projects. Embedding role-specific logic (like dentist credential verification) would limit its applicability. A generic system allows each project to define its own moderation criteria without altering the core module.
- **Maintainability**: A unified moderation framework reduces code duplication and simplifies updates or bug fixes, as changes are made in one place rather than across multiple role-specific implementations.
- **Scalability**: As new user types are introduced in future projects or within the current one, the moderation system can accommodate them without requiring structural changes.
- **Consistency**: A single moderation approach ensures a consistent user experience across different user types, aligning with the unified registration wizard.

### Challenges in Generic Moderation
- **Diverse Requirements**: Different user types may have varying moderation needs (e.g., professional license verification for one type versus basic identity checks for another). This is addressed by making moderation steps configurable.
- **Complexity**: A generic system might be more abstract and complex to set up initially. However, this is mitigated by thorough documentation and clear configuration patterns.

## Proposed Strategy for Generic Moderation

### 1. Core Principles
- **Type-Agnostic Design**: The moderation system will not hard-code any specific user types. Instead, it will operate on the base `User` model with configurable attributes and workflows.
- **Metadata-Driven**: Use metadata (stored in additional tables or as JSON in user profiles) to define what moderation steps are required for different user types.
- **Extensibility**: Allow projects to extend or customize moderation logic through configuration files or service providers without modifying the core `User` module.

### 2. Data Model Enhancements
- **User Model Extensions**: Add generic fields to the `User` model to support moderation:
  - `state`: A string field to track moderation progress, managed via Spatie/Laravel-Model-States with values like `pending`, `under_review`, `approved`, `rejected`.
  - `moderation_data`: A JSON or text field to store type-specific data required for moderation (e.g., license numbers, certifications, or other credentials).
  - `type`: A field to denote the type of user, which can be used to load specific moderation rules from configuration, following Tighten/Parental for Single Table Inheritance.
- **Activity Logging**: Instead of a custom `moderation_logs` table, use `spatie/laravel-activitylog` to record actions taken during the moderation process (e.g., state changes, admin notes). Configure the `User` model to log specific events and attributes.

  Example migration snippet (following project conventions with `XotBaseMigration`):
  ```php
  $this->tableUpdate('users', function (Blueprint $table): void {
      if (!$this->hasColumn('state')) {
          $table->string('state')->default('pending');
      }
      if (!$this->hasColumn('moderation_data')) {
          $table->json('moderation_data')->nullable();
      }
      if (!$this->hasColumn('type')) {
          $table->string('type')->nullable();
      }
  });
  ```

  Example setup for activity logging in the `User` model:
  ```php
  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;
  use Spatie\Activitylog\Traits\LogsActivity;
  use Spatie\Activitylog\LogOptions;

  class User extends Model
  {
      use LogsActivity;

      public function getActivitylogOptions(): LogOptions
      {
          return LogOptions::defaults()
              ->logOnly(['state', 'type'])
              ->logOnlyDirty()
              ->useLogName('user_moderation');
      }
  }
  ```

### 3. Configuration-Driven Moderation Rules
- **Moderation Profile Configuration**: Define moderation requirements per user type in a configuration file (e.g., `config/moderation.php`). This file would map user types to required fields, validation rules, and workflow steps.
  Example configuration:
  ```php
  return [
      'user_types' => [
          'professional' => [
              'required_fields' => ['license_number', 'certification'],
              'validation_rules' => [
                  'license_number' => 'required|string|unique',
                  'certification' => 'required|file|mimes:pdf',
              ],
              'workflow' => [
                  'initial_status' => 'pending',
                  'steps' => ['document_verification', 'admin_review'],
              ],
          ],
          'standard' => [
              'required_fields' => ['identity_document'],
              'validation_rules' => [
                  'identity_document' => 'required|file|mimes:pdf,jpg,png',
              ],
              'workflow' => [
                  'initial_status' => 'pending',
                  'steps' => ['identity_check'],
              ],
          ],
      ],
  ];
  ```
- **Dynamic Application**: At runtime, based on the `type` of a registering user, the system loads the corresponding moderation profile to enforce rules and guide the workflow.

### 4. Moderation Workflow
- **Registration Integration**: After a user registers through the unified wizard, their `state` is set to 'pending', and relevant data is collected based on their `type`.
- **Moderation Queue**: Users with a `state` of 'pending' or 'under_review' appear in a moderation queue visible to admin users.
- **Admin Review Process**:
  - Admins access a Filament interface to view users pending moderation, filtered by `type` if needed.
  - The system dynamically displays required fields and validation status based on the user type's moderation profile.
  - Admins can update statuses, request additional information, or finalize moderation (approve/reject), with all actions logged automatically using `spatie/laravel-activitylog`.
- **Notification System**: Implement notifications (via Laravel's notification system) to inform users of status changes or requests for additional information. Notifications are generic but can be customized per project.

### 5. Filament Admin Interface
- **Generic Moderation Resource**: Create a `UserModerationResource` in Filament, extending `XotBaseResource`, to manage the moderation process for all user types.
  ```php
  class UserModerationResource extends XotBaseResource
  {
      protected static ?string $model = User::class;

      public static function getFormSchema(): array
      {
          return [
              'type' => Forms\Components\TextInput::make('type')
                  ->disabled(),
              'state' => Forms\Components\Select::make('state')
                  ->options([
                      'pending' => 'Pending',
                      'under_review' => 'Under Review',
                      'approved' => 'Approved',
                      'rejected' => 'Rejected',
                  ]),
              'moderation_data' => Forms\Components\KeyValue::make('moderation_data')
                  ->label('Moderation Data')
                  ->helperText('Data specific to user type moderation requirements'),
          ];
      }

      public static function table(Table $table): Table
      {
          return $table
              ->columns([
                  Tables\Columns\TextColumn::make('email'),
                  Tables\Columns\TextColumn::make('type'),
                  Tables\Columns\TextColumn::make('state'),
              ])
              ->filters([
                  Tables\Filters\SelectFilter::make('type')
                      ->options(config('moderation.user_types')),
                  Tables\Filters\SelectFilter::make('state')
                      ->options([
                          'pending' => 'Pending',
                          'under_review' => 'Under Review',
                          'approved' => 'Approved',
                          'rejected' => 'Rejected',
                      ]),
              ]);
      }
  }
  ```
- **Dynamic Fields**: The interface can dynamically adjust to show relevant fields from `moderation_data` based on `type`, ensuring admins see only pertinent information.

### 6. Business Logic Layer
- **Moderation Action**: Develop a `UserModerationAction` class using `spatie/laravel-queueable-action` to handle core moderation logic, including:
  - Loading moderation profiles based on user type.
  - Validating submitted data against configured rules.
  - Managing state transitions and logging actions.
  Example:
  ```php
  namespace App\Actions;

  use Spatie\QueueableAction\QueueableAction;

  class UserModerationAction
  {
      use QueueableAction;

      public function execute(User $user, string $newState): void
      {
          $user->state = $newState;
          $user->save();
          // Log the action using activitylog
          activity()
              ->causedBy(auth()->user())
              ->performedOn($user)
              ->withProperties(['new_state' => $newState])
              ->log('User state updated');
      }
  }
  ```
- **Events and Listeners**: Use Laravel events like `UserSubmittedForModeration` and `ModerationStateUpdated` to trigger notifications or other actions. These events remain generic and reusable.

### 7. Security and Compliance
- **Data Protection**: Encrypt sensitive data within `moderation_data` to protect user information.
- **Auditability**: Ensure all moderation actions are logged with timestamps and responsible admin IDs using `spatie/laravel-activitylog` for accountability.
- **GDPR Compliance**: Provide mechanisms for users to review, update, or delete their moderation data as per GDPR requirements.

### 8. Testing Strategy
- **Unit Tests**: Test the `UserModerationAction` for validation logic, state transitions, and configuration loading.
- **Feature Tests**: Test the full moderation workflow from registration to final status update for multiple user types.
- **UI Tests**: Verify that the Filament interface correctly displays and updates moderation data based on user type configurations.

## Implementation Steps
1. **Database Migrations**: Add necessary fields to the `users` table using `XotBaseMigration`. No need for a separate `moderation_logs` table as logging is handled by `spatie/laravel-activitylog`.
2. **Configuration Setup**: Define moderation profiles in `config/moderation.php` for different user types.
3. **Action Development**: Implement `UserModerationAction` to handle business logic using `spatie/laravel-queueable-action`.
4. **Filament Resource**: Create `UserModerationResource` for admin interaction.
5. **Event and Notification Setup**: Configure events and notifications for user communication.
6. **Testing**: Develop comprehensive tests to ensure reliability across user types.
7. **Documentation**: Update module documentation to guide project-specific customizations.

## Addressing Specific Needs Without Hardcoding
- **Project-Specific Customizations**: Projects using the `User` module can override or extend moderation profiles via their own configuration files or by registering custom validation rules or workflow steps in a service provider.
- **Example for SaluteOra**: In the context of the SaluteOra project, a user type of 'dentist' can be configured with specific moderation requirements (like license verification) in the project's configuration, without altering the `User` module's generic approach. Similarly, other user types can have their own rules.

## Benefits of This Approach
- **Unified System**: Aligns with the philosophy of a unique registration wizard by providing a unique moderation system adaptable to all user types.
- **Portability**: Ensures the `User` module remains usable across different projects without modification.
- **Flexibility**: Configuration-driven design allows for easy adaptation to varying moderation needs.

## Potential Future Enhancements
- **Workflow Engine**: Introduce a more advanced workflow engine if moderation processes become highly complex, allowing for custom step definitions and branching logic.
- **API Integrations**: For user types requiring external validation (e.g., license checks), provide hooks for API integrations that can be configured per project.
- **Moderation Dashboard**: Enhance the Filament interface with analytics and reporting on moderation activities.

## Conclusion
By implementing a generic, configuration-driven moderation system within the `User` module, we achieve a reusable, maintainable, and scalable solution that aligns with the unified registration approach. This strategy ensures the module remains agnostic to specific user types, making it suitable for diverse projects while allowing individual applications to define their moderation requirements through configuration.
