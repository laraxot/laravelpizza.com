# User Moderation Strategy

## Overview
In the SaluteOra system, and across various projects utilizing the `User` module, users can have different roles or types, each potentially requiring specific verification or moderation processes before full access to platform functionalities is granted. This document analyzes the integration of a unified moderation strategy within the `User` module, ensuring it remains generic and applicable to all user types, mirroring the approach of a unified registration wizard.

## Rationale for Moderation within User Module
Given that the `User` module serves as the central hub for user management across multiple projects, it is logical to embed moderation functionalities within this module. This approach ensures:
- **Consistency**: A single point of truth for user-related logic, including state management, across all projects.
- **Reusability**: Avoids duplicating moderation logic in other modules or project-specific implementations.
- **Efficiency**: Leverages existing infrastructure for user data, roles, and permissions, reducing development overhead.

The user has noted that while moderation for certain user types might be more labor-intensive, it is feasible to manage this within the `User` module. This aligns with the principle that all user types share a common base, and thus, their moderation can follow a unified pattern similar to the registration wizard.

## Analysis of Unified Moderation Approach
### Benefits of Unified Moderation
1. **Centralized Logic (30%)**: By housing moderation logic in the `User` module, we ensure that any updates or changes to the moderation process are applied universally, reducing the risk of discrepancies across user types or projects.
2. **Simplified Integration (25%)**: Utilizing existing user data structures, authentication, and permission systems simplifies the integration of moderation features, as no new modules or complex integrations are required.
3. **Scalability with Flexibility (20%)**: The `User` module can be extended to accommodate type-specific moderation criteria through configurable workflows or additional fields, ensuring scalability while maintaining a core unified process.
4. **Maintenance Efficiency (15%)**: A single location for moderation logic means easier debugging, updates, and maintenance over time.
5. **User Experience Consistency (10%)**: Users and administrators experience a consistent process for moderation, regardless of user type, mirroring the unified registration wizard approach.

### Challenges and Mitigations
1. **Complexity for Specific User Types (40%)**:
   - **Challenge**: Certain user types may require more intricate moderation processes, which could complicate the `User` module's logic.
   - **Mitigation**: Implement a modular workflow system within the `User` module where specific moderation steps can be defined per user type via configuration or related tables. This keeps the core logic clean while allowing for customization (Estimated effort: 20% of moderation development).
2. **Overloading User Module (30%)**:
   - **Challenge**: Adding extensive moderation logic might make the `User` module overly complex.
   - **Mitigation**: Use traits or separate service classes within the `User` module to encapsulate moderation logic, ensuring the main user model remains focused on core user data (Estimated effort: 15% of moderation development).
3. **Performance Impact (20%)**:
   - **Challenge**: Moderation processes, especially if involving external API calls or heavy computations, could impact performance.
   - **Mitigation**: Implement queue systems for moderation tasks to offload processing from real-time user interactions (Estimated effort: 10% of moderation development).
4. **Diverse Requirements Across Projects (10%)**:
   - **Challenge**: Different projects might have unique moderation needs.
   - **Mitigation**: Design the moderation system to be highly configurable, allowing project-specific overrides or extensions through configuration files or events (Estimated effort: 5% of moderation development).

## Detailed Implementation Plan within User Module
To implement a unified moderation strategy within the `User` module, the following steps and structures are proposed:

### 1. Data Model Enhancements
- **State Field**: Add a `state` field to the `users` table (or a related pivot table if more complex data is needed) to track the current state of a user's moderation using the `spatie/laravel-model-states` package. Possible states could include `Pending`, `UnderReview`, `Approved`, `Rejected`. This field will be managed through a state class for proper transitions (Estimated effort: 5% of total implementation).
  ```php
  // Migration snippet
  $table->string('state')->default('pending');
  // In User model
  use Spatie\ModelStates\HasStates;
  protected $casts = [
      'state' => UserState::class,
  ];
  ```
- **Type Field for User Categorization**: Ensure a `type` field exists on the `users` table to differentiate between user categories or child models, following the `tighten/parental` approach for inheritance (Estimated effort: 5% of total implementation).
  ```php
  // Migration snippet
  $table->string('type')->nullable();
  ```
- **Moderation History Table**: Create a `user_moderation_history` table to log state transitions and comments for audit purposes. This table would link to the user and store timestamps, state changes, and admin notes (Estimated effort: 10% of total implementation).
  ```php
  // Migration for history table
  Schema::create('user_moderation_history', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->string('state_from');
      $table->string('state_to');
      $table->text('comments')->nullable();
      $table->foreignId('action_by')->constrained('users')->nullable();
      $table->timestamps();
  });
  ```
- **Type-Specific Data**: For user types requiring additional data for moderation, use a JSON field or a related table (`user_type_data`) to store type-specific information without altering the core `users` table structure (Estimated effort: 10% of total implementation).

### 2. Moderation Workflow System
#### 2.1 Workflow Definition
- **Workflow Definition**: Develop a configurable workflow system within the `User` module where moderation steps are defined as a series of actions or checks. This can be stored in a database table `moderation_workflows` with columns for `type`, `step_order`, `action_type`, and `criteria` (Estimated effort: 20% of total implementation).
  ```php
  // Example workflow table structure
  Schema::create('moderation_workflows', function (Blueprint $table) {
      $table->id();
      $table->string('type')->nullable(); // Null for generic steps
      $table->integer('step_order');
      $table->string('action_type'); // e.g., 'manual_review', 'api_check', 'email_verification'
      $table->json('criteria')->nullable(); // Conditions to pass this step
      $table->string('next_step_state')->nullable(); // State to set if passed
      $table->timestamps();
  });
  ```

#### 2.2 Action Handling with Queueable Actions
Instead of traditional service classes, we'll use [@spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action) to handle moderation actions. This approach allows us to queue actions for asynchronous processing, improving the user experience by not blocking the UI during moderation tasks.

- **State Transition Actions**: Create queueable actions for each state transition (e.g., `ApproveUserAction`, `RejectUserAction`).
- **Notification Actions**: Implement queueable actions for sending notifications to users about state changes.

### 2.3 Workflow Execution
- **Workflow Execution**: Create a workflow executor to execute workflows based on user type. This executor would iterate through defined steps, trigger actions (like sending for manual review or calling an API for credential checks), and update user state accordingly using the state management system (Estimated effort: 15% of total implementation).

### 2.4 Admin Interface with Filament
- **Moderation Dashboard**: Develop a Filament resource `ModerationResource` to allow administrators to view users by state, review details, and manually transition states (e.g., approve or reject users). This dashboard would show a list of users with filters for state and type (Estimated effort: 15% of total implementation).
  ```php
  // Filament ModerationResource example
  class ModerationResource extends Resource {
      protected static ?string $model = User::class;
      protected static ?string $navigationIcon = 'heroicon-o-check-circle';
      public static function getFormSchema(): array {
          return [
              'type' => Forms\Components\Select::make('type')
                  ->options(UserType::all()),
              'state' => Forms\Components\Select::make('state')
                  ->options(['pending', 'under_review', 'approved', 'rejected']),
              'comments' => Forms\Components\Textarea::make('comments'),
          ];
      }
      // Additional methods for table view, actions like approve/reject
  }
  ```
- **Bulk Actions**: Implement bulk actions for transitioning states of multiple users at once, especially useful for initial platform setup or high-volume periods (Estimated effort: 5% of total implementation).

### 2.5 Activity Logging with laravel-activitylog

We'll integrate [@spatie/laravel-activitylog](https://spatie.be/docs/laravel-activitylog/v4/introduction) to log all moderation activities and state changes. This replaces the concept of a custom ModerationLog, providing a robust logging system:

- **Log State Changes**: Automatically log every state transition with details like who performed the action and when.
- **Log Moderation Actions**: Record specific moderation actions taken on user accounts.
- **Admin Interface**: Display activity logs in the Filament admin panel for transparency and audit purposes.

### 3. Notification System
- **State Update Notifications**: Integrate with the existing notification system to inform users of state changes. Use configurable templates to customize messages based on user type or state outcome (Estimated effort: 10% of total implementation).
  ```php
  // Example notification
  class StateUpdateNotification extends Notification {
      public function via($notifiable) {
          return ['mail', 'database'];
      }
      public function toMail($notifiable) {
          return (new MailMessage)
              ->line('Your account state has been updated to ' . $notifiable->state)
              ->action('View Details', url('/profile'));
      }
  }
  ```

### 4. Event-Driven Architecture
- **State Transition Events**: Implement events for key state transitions (e.g., `UserStateTransitioned`) to allow other parts of the system or external integrations to react to state changes (Estimated effort: 5% of total implementation).
  ```php
  // Example event
  event(new UserStateTransitioned($user, $oldState, $newState));
  ```
- **Listeners for Automation**: Create listeners to automate certain state transitions, like moving a user to 'under_review' upon submission completion (Estimated effort: 5% of total implementation).

## Percentage Allocation for Development Efforts
- **Total Effort for Moderation Implementation**: 100%
- **Data Model Enhancements**: 25%
- **Moderation Workflow System**: 35%
- **Admin Interface with Filament**: 20%
- **Notification System**: 10%
- **Event-Driven Architecture**: 10%

## Addressing Complexity for Specific User Types
As noted, moderation for certain user types might be more labor-intensive. To handle this within the `User` module without cluttering the core logic:
- **Custom Validation Rules**: Define type-specific validation rules in a separate configuration or database table linked to the workflow system. For instance, a rule might require additional documentation for one user type but not others.
- **Pluggable Moderation Steps**: Allow for custom moderation steps to be plugged into the workflow via a service provider or event listener, ensuring that project-specific or type-specific logic can be added without modifying the core `User` module code.
- **Asynchronous Processing**: For complex moderation tasks, use Laravel's queue system to handle checks or external API calls asynchronously, preventing user experience delays during registration or state updates.

## Conclusion
Integrating a unified moderation strategy within the `User` module aligns with the principle of a centralized user management system applicable across various projects. By leveraging configurable workflows, Filament for admin interfaces, an event-driven approach, and proper state management with `spatie/laravel-model-states`, we can manage the moderation of all user types efficiently while accommodating varying levels of complexity. This approach ensures consistency with the unified registration wizard, maintains project-agnostic code, and supports scalability with an estimated effort distribution as outlined above.

**Documented on**: 2025-05-16
