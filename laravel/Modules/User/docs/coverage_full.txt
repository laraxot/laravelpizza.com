
   FAIL  Modules\User\tests\Feature\AuthComponentsTest
  ⨯ Auth Components Tests → auth components exist and work correctly     0.41s  
  ⨯ Auth Components Tests → auth layout components exist and work corre… 0.23s  
  ⨯ Auth Components Tests → login page loads correctly                   1.14s  
  ⨯ Auth Components Tests → register page loads correctly                0.73s  
  ⨯ Auth Components Tests → auth-session-status component renders corre… 0.23s  
  ⨯ Auth Components Tests → auth header component exists and renders     0.23s  
  ⨯ Authentication Flow with Reorganized Components → login form compon… 0.75s  
  ⨯ Authentication Flow with Reorganized Components → password confirma… 0.50s  
  ⨯ User Profile Components Tests → profile pages use reorganized compo… 0.81s  

   FAIL  Modules\User\tests\Feature\Authentication\UserAuthenticationTest
  ✓ User Authentication → it can authenticate with valid credentials     0.53s  
  ✓ User Authentication → it cannot authenticate with invalid password   0.58s  
  ✓ User Authentication → it cannot authenticate with non-existent emai… 0.57s  
  ✓ User Authentication → it cannot authenticate inactive user           0.71s  
  ✓ User Authentication → it can logout user                             0.56s  
  ✓ User Password Management → it can hash password on creation          0.68s  
  ✓ User Password Management → it can change password                    0.77s  
  ✓ User Password Management → it can check password expiration          0.37s  
  ✓ User Password Management → it can set password expiration            0.37s  
  ✓ User Remember Token → it can generate remember token                 0.38s  
  ✓ User Remember Token → it can authenticate using remember token       0.50s  
  ✓ User Email Verification → it can mark email as verified              0.49s  
  ✓ User Email Verification → it can check if email is verified          0.38s  
  ✓ User Email Verification → it can send email verification notificati… 0.37s  
  ✓ User Authorization → it can assign and check roles                   0.38s  
  ⨯ User Authorization → it can assign and check permissions             0.38s  
  ⨯ User Authorization → it can inherit permissions from roles           0.37s  
  ⨯ User Authorization → it can check multiple permissions               0.37s  
  ⨯ User Authorization → it can remove roles and permissions             0.38s  
  ✓ User OAuth Authentication → it can have oauth clients                0.37s  
  ✓ User OAuth Authentication → it can have oauth tokens                 0.37s  
  ✓ User OAuth Authentication → it can find user for passport            0.38s  
  ✓ User OAuth Authentication → it can validate password for passport    0.50s  
  ✓ User Authentication Logging → it can log authentication attempts     0.37s  
  ✓ User Authentication Logging → it can get latest authentication log   0.38s  
  ✓ User Session Management → it can store user in session               0.38s  
  ✓ User Session Management → it can remember user across sessions       0.37s  
  ✓ User Session Management → it can clear user session on logout        0.39s  
  ✓ User Two Factor Authentication → it can enable two factor authentic… 0.36s  
  ✓ User Two Factor Authentication → it can disable two factor authenti… 0.37s  
  ✓ User Two Factor Authentication → it handles otp authentication work… 0.65s  

   FAIL  Modules\User\tests\Feature\ChangeProfilePasswordTest
  ⨯ can change profile password                                          0.44s  
  ⨯ cannot change password with wrong current password                   0.38s  

   FAIL  Modules\User\tests\Feature\Filament\Actions\ChangePasswordActionTest
  ✓ change password action has correct default name                      0.37s  
  ✓ change password action extends correct base class                    0.38s  
  ⨯ change password action has correct icon                              0.37s  
  ⨯ change password action form has required fields                      0.37s  
  ⨯ change password action can be executed                               0.37s  
  ⨯ change password action uses password data component                  0.38s  
  ⨯ change password action has confirmation field                        0.37s  
  ⨯ change password action shows success notification                    0.36s  
  ⨯ change password action validates password confirmation               0.38s  
  ⨯ change password action uses translation keys                         0.37s  
  ⨯ change password action has correct setup method                      0.36s  

   PASS  Modules\User\tests\Feature\Filament\Clusters\AppearanceClusterTest
  ✓ Appearance cluster extends XotBaseCluster                            0.27s  
  ✓ all cluster pages extend XotBasePage                                 0.24s  
  ✓ all cluster pages have cluster property set                          0.23s  
  ✓ cluster pages do not extend Filament classes directly                0.24s  
  ✓ cluster does not extend Filament directly                            0.24s  
  ✓ cluster pages are accessible                                         0.24s  

   PASS  Modules\User\tests\Feature\Filament\Pages\CreateUserTest
  ✓ create user page has correct resource                                0.25s  
  ✓ create user page extends correct base class                          0.23s  
  ✓ create user page can be instantiated                                 0.23s  
  ✓ create user page has correct navigation label                        0.25s  
  ✓ create user page has correct title                                   0.23s  
  ✓ create user page has correct breadcrumbs structure                   0.23s  
  ✓ create user page can be accessed                                     0.24s  
  ✓ create user page can create user with valid data                     0.23s  
  ✓ create user page handles form submission structure                   0.23s  
  ✓ create user page follows filament conventions                        0.24s  

   FAIL  Modules\User\tests\Feature\Filament\Pages\ListUsersTest
  ✓ list users page has correct resource                                 0.26s  
  ⨯ list users page extends correct base class
  ✓ list users page can be instantiated                                  0.24s  
  ✓ list users page has correct table columns                            0.24s  
  ✓ list users page has correct table filters                            0.25s  
  ✓ list users page has correct table actions                            0.24s  
  ✓ list users page has correct header widgets                           0.25s  
  ✓ list users page has correct bulk actions                             0.26s  
  ✓ list users page can display users                                    0.24s  
  ✓ list users page has correct navigation label                         0.24s  
  ✓ list users page has correct title                                    0.25s  
  ✓ list users page has correct breadcrumbs                              0.24s  
  ✓ list users page can handle search                                    0.24s  

   FAIL  Modules\User\tests\Feature\Filament\Resources\UserResourceTest
  ✓ user resource has correct navigation icon                            0.41s  
  ✓ user resource has correct widgets                                    0.37s  
  ✓ user resource has correct form schema                                0.38s  
  ✓ user resource has combined relation manager tabs                     0.38s  
  ✓ user resource extends correct base class                             0.37s  
  ✓ user resource form schema has correct column spans                   0.37s  
  ✓ user resource name field is required                                 0.38s  
  ✓ user resource email field is required                                0.37s  
  ⨯ user resource password field is required only on create              0.37s  
  ✓ user resource password field has correct type                        0.38s  
  ⨯ user resource email field has unique validation                      0.67s  
  ⨯ user resource created_at field shows diff for humans                 0.37s  
  ✓ user resource can be instantiated                                    0.38s  
  ✓ user resource has correct model                                      0.37s  

   FAIL  Modules\User\tests\Feature\Filament\UserResourceTest
  ⨯ UserResource Configuration → it has correct model class
  ⨯ UserResource Configuration → it has correct slug
  ⨯ UserResource Configuration → it has navigation configuration
  ⨯ UserResource Configuration → it can get navigation items
  ⨯ ListUsers Page → it can render list page
  ⨯ ListUsers Page → it can search users by name
  ⨯ ListUsers Page → it can search users by email
  ⨯ ListUsers Page → it can filter users by active status
  ⨯ ListUsers Page → it can filter users by verified status
  ⨯ ListUsers Page → it can sort users by created date
  ⨯ CreateUser Page → it can render create page
  ⨯ CreateUser Page → it can create a user
  ⨯ CreateUser Page → it validates required fields on create
  ⨯ CreateUser Page → it validates email uniqueness
  ⨯ CreateUser Page → it validates password confirmation
  ⨯ CreateUser Page → it can assign roles during creation
  ⨯ EditUser Page → it can render edit page
  ⨯ EditUser Page → it can retrieve user data for editing
  ⨯ EditUser Page → it can save edited user
  ⨯ EditUser Page → it can activate and deactivate user
  ⨯ EditUser Page → it can change user language
  ⨯ EditUser Page → it can update user roles
  ⨯ EditUser Page → it can update user password
  ⨯ ViewUser Page → it can render view page
  ⨯ ViewUser Page → it displays user information
  ⨯ ViewUser Page → it can view user with roles
  ⨯ ViewUser Page → it can view user with permissions
  ⨯ UserResource Bulk Actions → it can bulk activate users
  ⨯ UserResource Bulk Actions → it can bulk deactivate users
  ⨯ UserResource Bulk Actions → it can bulk delete users
  ⨯ UserResource Bulk Actions → it can bulk assign roles
  ⨯ UserResource Security → it prevents editing super admin user
  ⨯ UserResource Security → it validates email format
  ⨯ UserResource Security → it enforces minimum password length

   FAIL  Modules\User\tests\Feature\Filament\Widgets\LoginWidgetTest
  ⨯ it can render widget                                                 0.25s  
  ✓ it has correct form schema                                           0.24s  
  - it can authenticate user → Database not available for testing        0.28s  
  ✓ it validates credentials                                             0.49s  
  ✓ it requires email and password                                       0.24s  

   PASS  Modules\User\tests\Feature\Filament\Widgets\UserOverviewTest
  ✓ user overview widget extends correct base class                      0.52s  
  ✓ user overview widget has correct view                                0.26s  
  ✓ user overview widget has record property                             0.24s  
  ✓ user overview widget can set record                                  0.23s  
  ✓ user overview widget record property is nullable                     0.25s  
  ✓ user overview widget has correct namespace                           0.24s  
  ✓ user overview widget can be instantiated                             0.24s  
  ✓ user overview widget has correct static properties                   0.25s  
  ✓ user overview widget view path is correct                            0.24s  

   FAIL  Modules\User\tests\Feature\MigrateDbTest
  ⨯ it migrates the test database                                        1.14s  

   FAIL  Modules\User\tests\Feature\PasswordDataLabelsTest
  ✓ password data labels are translated                                  0.24s  
  ⨯ login form labels are translated                                     0.28s  

   FAIL  Modules\User\tests\Feature\TeamManagementBusinessLogicTest
  ✓ it can create team                                                   0.24s  
  ✓ it can add user to team                                              0.28s  
  ✓ it can remove user from team                                         0.26s  
  ✓ it can assign team role to user                                      0.25s  
  ⨯ it can assign team permissions to user                               0.25s  
  ⨯ it can check user team permissions                                   0.26s  
  ✓ it can create team invitation                                        0.25s  
  ✓ it can accept team invitation                                        0.27s  
  ✓ it can decline team invitation                                       0.24s  
  ✓ it can check team user role                                          0.25s  
  ⨯ it can get team members                                              0.31s  
  ⨯ it can get team admins                                               0.28s  
  ⨯ it can get team members by role                                      0.29s  
  ✓ it can check team is personal                                        0.24s  
  ⨯ it can check team has user with permission                           0.25s  
  ✓ it can get team invitations                                          0.24s  
  ✓ it can get pending team invitations                                  0.24s  
  ⨯ it can get team statistics                                           0.25s  
  ✓ it can handle team soft delete                                       0.27s  
  ✓ it can restore soft deleted team                                     0.24s  
  ⨯ it can force delete team                                             0.26s  

   FAIL  Modules\User\tests\Feature\TeamManagementTest
  ✓ Team Creation and Management → it can create a team                  0.26s  
  ✓ Team Creation and Management → it belongs to an owner                0.24s  
  ✓ Team Creation and Management → it can have multiple teams per user   0.24s  
  ✓ Team Creation and Management → it can update team information        0.25s  
  ✓ Team Creation and Management → it can delete a team                  0.24s  
  ✓ Team Membership → it can add members to team                         0.27s  
  ✓ Team Membership → it can remove members from team                    0.27s  
  ⨯ Team Membership → it can have multiple members                       0.29s  
  ✓ Team Membership → it can check if user is team member                0.29s  
  ⨯ Team Membership → it can get team membership with pivot data         0.26s  
  ⨯ User Team Relationship → it user can belong to multiple teams        0.25s  
  ✓ User Team Relationship → it user can switch current team             0.24s  
  ✓ User Team Relationship → it user can leave a team                    0.26s  
  ⨯ User Team Relationship → it can get all team users for a user        0.46s  
  ✓ Team Invitations → it can validate team slug uniqueness              0.25s  
  ✓ Team Invitations → it can create team invitations                    0.25s  
  ✓ Team Invitations → it can accept team invitations                    0.26s  
  ✓ Team Invitations → it can cancel team invitations                    0.25s  
  ✓ Team Invitations → it prevents duplicate invitations                 0.24s  
  ✓ Team Permissions → it can have team-specific permissions             0.25s  
  ✓ Team Permissions → it can assign permissions to team members         0.25s  
  ⨯ Team Permissions → it can check team member permissions              0.24s  
  ✓ Team Scopes and Queries → it can filter teams by owner               0.24s  
  ✓ Team Scopes and Queries → it can find teams by slug                  0.24s  
  ⨯ Team Scopes and Queries → it can get teams with member count         0.28s  
  ✓ Team Features → it can have team settings                            0.24s  
  ✓ Team Features → it can have team avatar                              0.25s  
  ✓ Team Features → it can check if team is full                         0.25s  
  ✓ Team Events and Notifications → it can notify team members of chang… 0.25s  
  ✓ Team Events and Notifications → it can log team activities           0.26s  

   FAIL  Modules\User\tests\Feature\TenantScopeConsoleTest
  ✓ TenantScope Console Context Behavior → User Creation in Console Con… 0.41s  
  ✓ TenantScope Console Context Behavior → User Creation in Console Con… 0.40s  
  ⨯ TenantScope Console Context Behavior → User Creation in Console Con… 0.27s  
  ✓ TenantScope Console Context Behavior → User Creation in HTTP Contex… 0.38s  
  ⨯ TenantScope Console Context Behavior → User Creation in HTTP Contex… 0.24s  
  ✓ TenantScope Console Context Behavior → TenantScope Exception Handli… 0.27s  
  ✓ TenantScope Console Context Behavior → TenantScope Exception Handli… 0.38s  
  ⨯ TenantScope Console Context Behavior → Manual Tenant Assignment in…  0.38s  
  ⨯ TenantScope Console Context Behavior → Manual Tenant Assignment in…  0.25s  
  ✓ InteractsWithTenant Trait Behavior → it does not crash when booting… 0.37s  
  ✓ InteractsWithTenant Trait Behavior → it skips tenant assignment in…  0.37s  

   FAIL  Modules\User\tests\Feature\TwoFactorServiceTest
  ⨯ enable generates secret and qr code
  ⨯ enable stores encrypted secret
  ⨯ enable generates 10 recovery codes
  ⨯ confirm enables 2fa with valid code
  ⨯ confirm fails with invalid code
  ⨯ disable removes all 2fa data
  ⨯ verify validates correct code
  ⨯ verify rejects incorrect code
  ⨯ verify returns false if no secret
  ⨯ verify recovery code works once
  ⨯ verify recovery code fails if already used
  ⨯ verify recovery code fails with invalid code
  ⨯ regenerate recovery codes creates new set
  ⨯ regenerate recovery codes invalidates old ones
  ⨯ qr code contains user email
  ⨯ qr code is valid svg
  ⨯ secret is properly encrypted in database
  ⨯ recovery codes are properly encrypted in database
  ⨯ enable can be called multiple times
  ⨯ confirm sets confirmed_at timestamp

   FAIL  Modules\User\tests\Feature\UserAuthenticationTest
  ⨯ User Authentication → it can authenticate user with correct credent… 0.01s  
  ⨯ User Authentication → it cannot authenticate inactive user
  ⨯ User Authentication → it logs authentication attempts
  ⨯ User Authentication → it handles password expiration
  ⨯ User Authentication → it supports OTP authentication

   FAIL  Modules\User\tests\Feature\UserBusinessLogicTest
  ⨯ User Business Logic Integration → User Authentication Business Rules → it enforces password complexity requirements
  ⨯ User Business Logic Integration → User Authentication Business Rules → it enforces email uniqueness across the system
  ⨯ User Business Logic Integration → User Authentication Business Rules → it enforces username uniqueness when required
  ⨯ User Business Logic Integration → User Profile Business Rules → it enforces profile completion requirements
  ⨯ User Business Logic Integration → User Profile Business Rules → it enforces data validation rules
  ⨯ User Business Logic Integration → User Profile Business Rules → it enforces age restrictions for certain operations
  ⨯ User Business Logic Integration → Team Management Business Rules → it enforces team membership limits
  ⨯ User Business Logic Integration → Team Management Business Rules → it enforces team role hierarchy
  ⨯ User Business Logic Integration → Team Management Business Rules → it enforces team ownership rules
  ⨯ User Business Logic Integration → Permission and Role Business Rules → it enforces permission inheritance
  ⨯ User Business Logic Integration → Permission and Role Business Rules → it enforces permission conflicts
  ⨯ User Business Logic Integration → Permission and Role Business Rules → it enforces role-based access control
  ⨯ User Business Logic Integration → Data Integrity Business Rules → it enforces referential integrity for user relationships
  ⨯ User Business Logic Integration → Data Integrity Business Rules → it enforces data consistency across user attributes
  ⨯ User Business Logic Integration → Data Integrity Business Rules → it enforces audit trail for sensitive operations
  ⨯ User Business Logic Integration → Security Business Rules → it enforces password expiration policies
  ⨯ User Business Logic Integration → Security Business Rules → it enforces account lockout policies
  ⨯ User Business Logic Integration → Security Business Rules → it enforces session management policies

   PASS  Modules\User\tests\Feature\UserCommandIntegrationTest
  ✓ User Command Integration → it can be registered with Laravel artisa… 0.01s  
  ✓ User Command Integration → it integrates with XotData system
  ✓ User Command Integration → it validates command registration in service provider
  ✓ User Command Integration → it handles Laravel Prompts integration
  ✓ User Command Integration → it validates Webmozart Assert integration
  ✓ User Command Integration → it integrates with Illuminate Support Arr
  ✓ User Command Integration → it can handle command input/output operations
  ✓ User Command Integration → it validates command signature and options
  ✓ User Command Integration → it handles enum integration correctly
  ✓ User Command Integration → it validates user contract integration
  ✓ User Command Integration → it handles command execution context
  ✓ User Command Integration → it validates error handling patterns
  ✓ User Command Integration → it can work with type checking utilities
  ✓ User Command Integration → it integrates with Laravel configuration system
  ✓ User Command Integration → it handles string manipulation correctly
  ✓ User Command Integration → it validates array operations
  ✓ User Command Integration → it can handle command lifecycle
  ✓ User Command Integration → it validates dependency injection compatibility
  ✓ User Command Integration → it handles console application integration
  ✓ User Command Integration → it validates command help and description
  ✓ User Command Integration → it can access Laravel facades
  ✓ User Command Integration → it handles reflection operations correctly
  ✓ User Command Integration → it validates method existence checks
  ✓ User Command Integration → it can handle object property access safely

   FAIL  Modules\User\tests\Feature\UserManagementBusinessLogicTest
  ⨯ it can create user with profile                                      0.01s  
  ⨯ it can assign role to user
  ⨯ it can assign multiple roles to user
  ⨯ it can remove role from user
  ⨯ it can sync user roles
  ⨯ it can check user permissions
  ⨯ it can assign direct permission to user
  ⨯ it can revoke direct permission from user
  ⨯ it can check user has any role
  ⨯ it can check user has all roles
  ⨯ it can get user permissions
  ⨯ it can get user roles
  ⨯ it can check user is super admin
  ⨯ it can check user is admin
  ⨯ it can check user is doctor
  ⨯ it can check user is patient
  ⨯ it can update user profile
  ⨯ it can delete user with profile
  ⨯ it can soft delete user
  ⨯ it can restore soft deleted user
  ⨯ it can force delete user
  ⨯ it can search users by name
  ⨯ it can search users by email
  ⨯ it can filter users by role
  ⨯ it can filter users by permission
  ⨯ it can get users with roles and permissions
  ⨯ it can validate user email uniqueness
  ⨯ it can handle user password reset
  ⨯ it can handle user email verification
  ⨯ it can handle user last login
  ⨯ it can handle user status changes
  ⨯ it can handle user preferences

   FAIL  Modules\User\tests\Feature\UserModelBasicTest
  ✓ user model can be created                                            0.25s  
  ✓ user model can access connection                                     0.24s  
  ✓ user model can create basic record                                   0.38s  
  ⨯ user model can query records                                         0.51s  
  ⨯ user model can filter records                                        0.51s  
  ✓ user model can update records                                        0.39s  

   PASS  Modules\User\tests\Feature\UserModelSimpleTest
  ✓ user model can be instantiated                                       0.24s  
  ✓ user model can access connection                                     0.23s  
  ✓ user model can create basic record                                   0.40s  

   FAIL  Modules\User\tests\Feature\UserModelTest
  ⨯ User Model Creation → it can be created with valid data
  ⨯ User Model Creation → it generates uuid for id
  ✓ User Model Creation → it uses user database connection
  ✓ User Model Creation → it has correct table name
  ⨯ User Model Creation → it can be mass assigned with fillable fields
  ⨯ User Relationships → it has profile relationship
  ⨯ User Relationships → it has teams relationship
  ⨯ User Relationships → it has owned teams relationship
  ⨯ User Relationships → it has permissions relationship
  ⨯ User Relationships → it has roles relationship
  ⨯ User Scopes and Queries → it can filter by language
  ⨯ User Scopes and Queries → it can filter by active status
  ⨯ User Scopes and Queries → it can order by name
  ⨯ User Soft Deletes → it can handle soft deletes if supported
  ⨯ User Soft Deletes → it can handle restore after soft delete if supported
  ⨯ User Soft Deletes → it can handle force delete if supported
  ⨯ User Soft Deletes → it excludes soft deleted records from normal queries
  ⨯ User Attributes and Methods → it has full name attribute
  ⨯ User Attributes and Methods → it can check if active
  ⨯ User Attributes and Methods → it has correct email attribute
  ⨯ User Attributes and Methods → it has correct language attribute

   PASS  Modules\User\tests\Unit\Actions\GetCurrentDeviceActionTest
  ✓ it creates device with valid agent data                              0.25s  
  ✓ it creates device with mobile id                                     0.25s  
  ✓ it handles empty mobile id                                           0.24s  
  ✓ it handles null mobile id                                            0.24s  
  ✓ it handles unknown device types                                      0.27s  
  ✓ it handles robot detection                                           0.24s  
  ✓ it handles tablet detection                                          0.24s  
  ✓ it handles desktop detection                                         0.25s  
  ✓ it handles mobile phone detection                                    0.25s  
  ✓ it handles edge case platforms                                       0.24s  
  ✓ it handles legacy browsers                                           0.25s  
  ✓ it handles unknown browser versions                                  0.25s  

   PASS  Modules\User\tests\Unit\AuthenticationBusinessLogicTest
  ✓ Authentication Business Logic → User Authentication Logic → it vali… 0.26s  
  ✓ Authentication Business Logic → User Authentication Logic → it vali… 0.23s  
  ✓ Authentication Business Logic → User Authentication Logic → it hand… 0.23s  
  ✓ Authentication Business Logic → User Authentication Logic → it trac… 0.25s  
  ✓ Authentication Business Logic → User Authentication Logic → it mana… 0.24s  
  ✓ Authentication Business Logic → User Authentication Logic → it vali… 0.23s  
  ✓ Authentication Business Logic → Team Management Logic → it validate… 0.25s  
  ✓ Authentication Business Logic → Team Management Logic → it distingu… 0.24s  
  ✓ Authentication Business Logic → Team Management Logic → it validate… 0.24s  
  ✓ Authentication Business Logic → Team Management Logic → it handles…  0.25s  
  ✓ Authentication Business Logic → Role-Based Access Control → it vali… 0.24s  
  ✓ Authentication Business Logic → Role-Based Access Control → it vali… 0.24s  
  ✓ Authentication Business Logic → Role-Based Access Control → it hand… 0.25s  
  ✓ Authentication Business Logic → Role-Based Access Control → it vali… 0.24s  
  ✓ Authentication Business Logic → OAuth Integration Logic → it valida… 0.23s  
  ✓ Authentication Business Logic → OAuth Integration Logic → it handle… 0.25s  
  ✓ Authentication Business Logic → OAuth Integration Logic → it valida… 0.24s  
  ✓ Authentication Business Logic → OAuth Integration Logic → it handle… 0.24s  
  ✓ Authentication Business Logic → Device Management Logic → it valida… 0.25s  
  ✓ Authentication Business Logic → Device Management Logic → it tracks… 0.23s  
  ✓ Authentication Business Logic → Device Management Logic → it valida… 0.28s  
  ✓ Authentication Business Logic → Device Management Logic → it handle… 0.55s  
  ✓ Authentication Business Logic → Session Security Logic → it validat… 0.25s  
  ✓ Authentication Business Logic → Session Security Logic → it handles… 0.23s  
  ✓ Authentication Business Logic → Session Security Logic → it validat… 0.25s  

   PASS  Modules\User\tests\Unit\ChangeTypeCommandTest
  ✓ ChangeTypeCommand → it can be instantiated                           0.01s  
  ✓ ChangeTypeCommand → it has correct command name
  ✓ ChangeTypeCommand → it has correct command description
  ✓ ChangeTypeCommand → it has correct command signature properties
  ✓ ChangeTypeCommand → it can access XotData instance
  ✓ ChangeTypeCommand → it validates required methods exist in command
  ✓ ChangeTypeCommand → it uses correct Laravel Prompts functions
  ✓ ChangeTypeCommand → it imports required dependencies
  ✓ ChangeTypeCommand → it can handle command execution flow
  ✓ ChangeTypeCommand → it validates command constructor
  ✓ ChangeTypeCommand → it has proper error handling structure
  ✓ ChangeTypeCommand → it uses correct array helper methods
  ✓ ChangeTypeCommand → it implements proper type checking
  ✓ ChangeTypeCommand → it has proper command properties structure
  ✓ ChangeTypeCommand → it validates command inheritance chain
  ✓ ChangeTypeCommand → it can access Laravel console features
  ✓ ChangeTypeCommand → it has proper docblock documentation

   FAIL  Modules\User\tests\Unit\CurrentTeamInfiniteLoopFixTest
  ⨯ currentTeam getter does not crash when user has no teams             0.24s  
  ✓ currentTeam getter is side-effect-free                               0.26s  
  ✓ currentTeam getter does not trigger save operations                  0.24s  
  ✓ initializeCurrentTeam sets personal team correctly                   0.24s  
  ✓ initializeCurrentTeam does not override existing current_team_id     0.26s  
  ⨯ initializeCurrentTeam sets first available team if no personal team  0.25s  
  ⨯ initializeCurrentTeam handles user without teams gracefully          0.24s  
  ⨯ currentTeam getter does not cause N+1 queries                        0.26s  
  ✓ currentTeam getter works correctly with existing team                0.24s  
  ⨯ user creation does not trigger infinite loop                         0.37s  
  ⨯ multiple users can be created without issues                         1.25s  

   PASS  Modules\User\tests\Unit\Datas\PasswordDataTest
  ✓ password data can be created with custom parameters                  0.24s  
  ✓ password data has default values                                     0.25s  
  ✓ password data extends spatie data class                              0.23s  
  ✓ password data has correct properties                                 0.25s  
  ✓ password data has correct types                                      0.25s  
  ✓ password data has correct constructor parameters                     0.23s  
  ✓ password data has correct namespace                                  0.23s  
  ✓ password data has correct strict types declaration                   0.25s  

   FAIL  Modules\User\tests\Unit\HasTeamsTraitCurrentTeamTest
  ⨯ HasTeams Trait CurrentTeam → it currentTeam does not crash when use… 0.38s  
  ⨯ HasTeams Trait CurrentTeam → it currentTeam is side effect free      0.41s  
  ⨯ HasTeams Trait CurrentTeam → it currentTeam can access personal tea… 0.25s  
  ⨯ HasTeams Trait CurrentTeam → it currentTeam does not override exist… 0.24s  
  ⨯ HasTeams Trait CurrentTeam → it switchTeam can change current team   0.23s  
  ⨯ HasTeams Trait CurrentTeam → it currentTeam does not cause N+1 quer… 0.25s  

   FAIL  Modules\User\tests\Unit\HasTeamsTraitPestTest
  ⨯ it correctly checks if user belongs to teams                         0.25s  
  ✓ it correctly checks if user belongs to specific team                 0.27s  
  ✓ it correctly checks team ownership                                   0.25s  
  ✓ it uses belongs to many x for teams relationship                     0.26s  
  ⨯ it correctly manages current team                                    0.27s  
  ✓ it correctly identifies current team                                 0.25s  
  ⨯ it returns all teams user owns or belongs to                         0.30s  
  ✓ it returns owned teams                                               0.52s  
  ✓ it returns personal team                                             0.26s  
  ⨯ it correctly determines team role                                    0.24s  
  ✓ it provides team role name helper                                    0.26s  
  ✓ it correctly checks team role                                        0.25s  
  ✓ it correctly manages team permissions                                0.25s  
  ⨯ it handles edge cases

   FAIL  Modules\User\tests\Unit\HasTeamsTraitTest
  ⨯ it correctly checks if user belongs to teams                         0.25s  
  ✓ it correctly checks if user belongs to specific team                 0.26s  
  ✓ it correctly checks team ownership                                   0.25s  
  ✓ it uses belongs to many x for teams relationship                     0.24s  
  ⨯ it correctly manages current team                                    0.43s  
  ✓ it correctly identifies current team                                 0.40s  
  ⨯ it returns all teams user owns or belongs to                         0.25s  
  ✓ it returns owned teams                                               0.26s  
  ✓ it returns personal team                                             0.24s  
  ✓ it correctly determines team role                                    0.24s  
  ⨯ it provides team role name helper                                    0.26s  
  ⨯ it correctly checks team role
  ⨯ it correctly manages team permissions                                0.25s  
  ⨯ it provides utility methods                                          0.24s  
  ✓ it handles edge cases correctly                                      0.26s  
  ⨯ it validates assertions correctly                                    0.24s  

   FAIL  Modules\User\tests\Unit\Models\BaseUserTest
  ✓ base user extends eloquent model                                     0.31s  
  ✓ base user has correct table name                                     0.46s  
  ✓ base user can be instantiated                                        0.24s  
  ✓ base user has proper inheritance chain                               0.25s  
  ⨯ base user has authentication traits                                  0.23s  

   FAIL  Modules\User\tests\Unit\Models\DeviceTest
  ⨯ can create device with minimal data                                  0.24s  
  ⨯ can create device with all fields                                    0.25s  
  ⨯ device has soft deletes                                              0.24s  
  - can restore soft deleted device → SoftDeletes trait not present on…  0.23s  
  ✓ can find device by uuid                                              0.25s  
  ✓ can find device by mobile id                                         0.24s  
  ✓ can find device by device type                                       0.24s  
  ✓ can find device by platform                                          0.27s  
  ✓ can find device by browser                                           0.52s  
  ✓ can find device by version                                           0.28s  
  ⨯ can find desktop devices                                             0.26s  
  ✓ can find mobile devices                                              0.25s  
  ✓ can find tablet devices                                              0.24s  
  ✓ can find phone devices                                               0.26s  
  ✓ can find robot devices                                               0.24s  
  ✓ can find devices by language                                         0.25s  
  ✓ can find devices by device pattern                                   0.26s  
  ⨯ can update device                                                    0.24s  
  ⨯ can handle null values                                               0.24s  
  ✓ can find devices by multiple criteria                                0.27s  
  ✓ device has users relationship                                        0.23s  
  ✓ device has factory                                                   0.23s  
  ✓ device has fillable attributes                                       0.25s  
  ✓ device has casts                                                     0.23s  

   FAIL  Modules\User\tests\Unit\Models\PermissionTest
  ⨯ can create permission with minimal data                              0.26s  
  ⨯ can create permission with all fields                                0.24s  
  ⨯ permission has connection attribute                                  0.23s  
  ⨯ permission has key type attribute                                    0.26s  
  ⨯ permission has fillable attributes                                   0.24s  
  ⨯ permission has casts                                                 0.24s  
  ⨯ can find permission by name                                          0.26s  
  ⨯ can find permission by guard name                                    0.25s  
  ⨯ can find permission by created by                                    0.24s  
  ⨯ can find permission by updated by                                    0.26s  
  ⨯ can find permissions by name pattern                                 0.24s  
  ⨯ can update permission                                                0.24s  
  ⨯ can handle null values                                               0.26s  
  ⨯ can find permissions by multiple criteria                            0.24s  
  ⨯ permission has roles relationship                                    0.24s  
  ⨯ permission has users relationship                                    0.26s  
  ⨯ permission can use role scopes                                       0.25s  
  ⨯ permission can use permission scopes                                 0.24s  
  ⨯ permission can use without role scopes                               0.25s  
  ✓ permission has factory method                                        0.24s  
  ✓ permission has get table method                                      0.24s  

   FAIL  Modules\User\tests\Unit\Models\ProfileTest
  ⨯ can create profile with minimal data                                 0.27s  
  ⨯ can create profile with all fields                                   0.24s  
  ✓ profile has schemaless attributes                                    0.23s  
  ✓ profile has table name                                               0.26s  
  ✓ can find profile by email                                            0.24s  
  ✓ can find profile by user name                                        0.24s  
  ✓ can find profile by first name                                       0.26s  
  ✓ can find profile by last name                                        0.24s  
  ✓ can find profile by phone                                            0.24s  
  ✓ can find profile by status                                           0.26s  
  ✓ can find profile by timezone                                         0.24s  
  ✓ can find profile by locale                                           0.24s  
  ✓ can find profiles by name pattern                                    0.26s  
  ✓ can find profiles by bio pattern                                     0.25s  
  ⨯ can update profile                                                   0.25s  
  ⨯ can handle null values                                               0.27s  
  ✓ can find profiles by multiple criteria                               0.25s  
  ✓ profile has roles relationship                                       0.24s  
  ✓ profile has permissions relationship                                 0.25s  
  ✓ profile has teams relationship                                       0.23s  
  ✓ profile has devices relationship                                     0.24s  
  ✓ profile has media relationship                                       0.26s  
  ✓ profile can use permission scopes                                    0.23s  
  ✓ profile can use role scopes                                          0.24s  
  ✓ profile can use extra attributes scopes                              0.26s  
  ✓ profile has factory                                                  0.23s  

   FAIL  Modules\User\tests\Unit\Models\RoleTest
  ⨯ can create role with minimal data                                    0.26s  
  ⨯ can create role with all fields                                      0.24s  
  ⨯ role has connection attribute                                        0.23s  
  ⨯ role has key type attribute                                          0.25s  
  ✓ role constants are defined                                           0.24s  
  ⨯ can find role by name                                                0.24s  
  ⨯ can find role by guard name                                          0.25s  
  ⨯ can find role by team id                                             0.24s  
  ⨯ can find role by uuid                                                0.24s  
  ⨯ can find roles by name pattern                                       0.25s  
  ⨯ can update role                                                      0.24s  
  ⨯ can handle null values                                               0.23s  
  ⨯ can find roles by multiple criteria                                  0.25s  
  ⨯ role has permissions relationship                                    0.24s  
  ⨯ role has team relationship                                           0.23s  
  ⨯ role has users relationship                                          0.25s  
  ⨯ role can use permission scopes                                       0.23s  
  ⨯ role can use role scopes                                             0.24s  

   FAIL  Modules\User\tests\Unit\Models\TeamTest
  ✓ can create team with minimal data                                    0.26s  
  ⨯ can create team with all fields                                      0.23s  
  ✓ can find team by name                                                0.24s  
  ✓ can find team by code                                                0.26s  
  ✓ can find team by uuid                                                0.24s  
  ✓ can find team by owner id                                            0.23s  
  ⨯ can find personal teams                                              0.26s  
  ✓ can find teams by user id                                            0.24s  
  ✓ can find teams by name pattern                                       0.24s  
  ✓ can update team                                                      0.26s  
  ✓ can handle null values                                               0.24s  
  ⨯ can find teams by multiple criteria                                  0.24s  

   FAIL  Modules\User\tests\Unit\Models\TenantTest
  ⨯ it can create tenant with minimal data                               0.27s  
  ⨯ it can create tenant with all fields                                 0.23s  
  ⨯ it tenant has soft deletes                                           0.24s  
  - it can restore soft deleted tenant → SoftDeletes trait not present…  0.25s  
  ⨯ it can find tenant by name                                           0.25s  
  ⨯ it can find tenant by slug                                           0.25s  
  ⨯ it can find tenant by domain                                         0.26s  
  ⨯ it can find tenant by database                                       0.24s  
  ⨯ it can find active tenants                                           0.26s  
  ⨯ it can find tenants by name pattern                                  0.29s  
  ⨯ it can find tenants by domain pattern                                0.25s  
  ⨯ it can update tenant                                                 0.26s  
  ⨯ it can handle null values                                            0.30s  
  ⨯ it can find tenants by multiple criteria                             0.26s  
  ✓ it tenant has users relationship                                     0.24s  
  ✓ it tenant has members relationship                                   0.26s  
  ✓ it tenant has media relationship                                     0.24s  
  ✓ it tenant has factory                                                0.23s  
  ⨯ it can find tenants by trial status                                  0.25s  
  ⨯ it can find tenants by settings value                                0.24s  

   FAIL  Modules\User\tests\Unit\Models\Traits\HasTeamsTest
  ✓ HasTeams Trait → it can be used in a model                           0.26s  
  ✓ HasTeams Trait → it has teams relationship method                    0.24s  
  ⨯ HasTeams Trait → it can check if user belongs to a team by ID        0.25s  
  ⨯ HasTeams Trait → it can check if user belongs to a team by Team mod… 0.24s  
  ⨯ HasTeams Trait → it returns false when user does not belong to team  0.24s  
  ⨯ HasTeams Trait → it handles Team model parameters                    0.26s  
  ✓ HasTeams Trait → it can get all teams for user                       0.23s  
  ✓ HasTeams Trait → it can filter teams by specific criteria            0.26s  
  ⨯ HasTeams Trait → it can check team membership with timestamps        0.23s  
  ⨯ HasTeams Trait → it can handle multiple team memberships             0.24s  
  ⨯ HasTeams Trait → it can handle non-existent team                     0.25s  
  ⨯ HasTeams Trait → it can work with team pivot table                   0.24s  
  ✓ HasTeams Trait → it can handle team relationship with custom pivot…  0.24s  
  ✓ HasTeams Trait → it can handle team relationship with custom foreig… 0.26s  
  ✓ HasTeams Trait → it can handle team relationship with timestamps     0.23s  
  ✓ HasTeams Trait Integration → it can be used with User model          0.26s  
  ✓ HasTeams Trait Integration → it maintains trait functionality acros… 0.24s  
  ⨯ HasTeams Trait Integration → it can handle concurrent team checks    0.24s  
  ✓ HasTeams Trait Integration → it can work with team collections       0.25s  
  ⨯ HasTeams Trait Error Handling → it handles missing team gracefully   0.23s  
  ✓ HasTeams Trait Error Handling → it handles empty team collections    0.23s  
  ⨯ HasTeams Trait Performance → it can handle large numbers of team ch… 0.25s  
  ✓ HasTeams Trait Performance → it can handle team relationship querie… 0.23s  

   PASS  Modules\User\tests\Unit\Models\UserBusinessLogicTest
  ✓ User Business Logic → user extends base user                         0.26s  
  ✓ User Business Logic → user has authentication capabilities           0.49s  
  ✓ User Business Logic → user can have name components                  0.23s  
  ✓ User Business Logic → user has activation status                     0.26s  
  ✓ User Business Logic → user has otp capability                        0.24s  
  ✓ User Business Logic → user can have language preference              0.23s  
  ✓ User Business Logic → user has email verification tracking           0.25s  
  ✓ User Business Logic → user has password expiry tracking              0.24s  
  ✓ User Business Logic → user can have current team                     0.23s  
  ✓ User Business Logic → user can have profile photo                    0.25s  
  ✓ User Business Logic → user can have remember token                   0.24s  

   PASS  Modules\User\tests\Unit\Models\UserTest
  ✓ user can be created                                                  0.39s  
  ✓ user has correct type casting                                        0.37s  
  ✓ user password is hashed                                              0.63s  
  ✓ user can change password                                             0.78s  
  ✓ user can be updated                                                  0.37s  
  ✓ user can be deleted                                                  0.37s  
  ✓ user has fillable attributes                                         0.39s  
  ✓ user has hidden attributes                                           0.37s  
  ✓ user can be found by email                                           0.37s  
  ✓ user can be found by type                                            0.39s  
  ✓ user can be created with different types                             0.37s  
  ✓ user has timestamps                                                  0.38s  
  ✓ user can access socialite                                            0.39s  
  ✓ user has connection attribute                                        0.37s  
  ✓ user can be found by name pattern                                    0.37s  
  ✓ user can be found by language                                        0.39s  
  ✓ user can be found by active status                                   0.38s  
  ✓ user can be found by otp status                                      0.37s  
  ✓ user can handle null values                                          0.39s  

   FAIL  Modules\User\tests\Unit\PermissionTest
  ⨯ permission can be created
  ⨯ permission has correct fillable attributes
  ⨯ permission has correct table configuration
  ⨯ permission has correct casts
  ⨯ permission can be updated
  ⨯ permission can be deleted
  ⨯ permission can be assigned to roles
  ⨯ permission can be assigned to multiple roles
  ⨯ permission can be found by name
  ⨯ permission can be found by guard
  ⨯ permission has timestamps
  ⨯ permission can be created with factory
  ⨯ permission can be created with specific attributes
  ⨯ permission can check if it has role
  ⨯ permission can check if it has any roles
  ⨯ permission can check if it has all roles
  ⨯ permission can be revoked from role
  ⨯ permission can be synced with roles
  ⨯ permission can be filtered by created_by
  ⨯ permission can be filtered by updated_by
  ⨯ permission handles null metadata values

   FAIL  Modules\User\tests\Unit\RoleTest
  ⨯ role can be created
  ⨯ role has correct constants
  ⨯ role has correct table configuration
  ⨯ role has correct casts
  ⨯ role can be updated
  ⨯ role can be deleted
  ⨯ role can have permissions
  ⨯ role can have multiple permissions
  ⨯ role can revoke permissions
  ⨯ role can be found by name
  ⨯ role can be found by guard
  ⨯ role has timestamps
  ⨯ role can be created with factory
  ⨯ role can be created with specific attributes
  ⨯ role can check if it has any permissions
  ⨯ role can check if it has all permissions
  ⨯ role can be filtered by team_id
  ⨯ role handles null metadata values

   FAIL  Modules\User\tests\Unit\TenantTest
  ✓ tenant can be created                                                0.26s  
  ✓ tenant extends correct base class                                    0.23s  
  ✓ tenant has correct fillable attributes                               0.24s  
  ✓ tenant has slug generated from name                                  0.23s  
  ✓ tenant slug is automatically generated                               0.26s  
  ✓ tenant has users relationship                                        0.24s  
  ✓ tenant has members relationship                                      0.23s  
  ✓ tenant implements required interfaces                                0.25s  
  ✓ tenant has slug options configuration                                0.24s  
  ⨯ tenant has filament avatar url method                                0.24s  
  ✓ tenant can be found by slug                                          0.26s  
  ✓ tenant has correct table name                                        0.24s  
  ✓ tenant has correct primary key                                       0.23s  
  ✓ tenant has correct connection                                        0.26s  
  ✓ tenant can be updated                                                0.23s  
  ⨯ tenant can be deleted                                                0.24s  
  ✓ can find tenant by name                                              0.26s  
  ✓ can find active tenants                                              0.24s  
  ✓ can find tenants by name pattern                                     0.24s  

   PASS  Modules\User\tests\Unit\UserModelTest
  ✓ User Model → it can be created (in-memory)                           0.29s  
  ✓ User Model → it supports mass-assignment of expected attributes (be… 0.24s  
  ✓ User Model → it declares sensitive attributes as hidden (without se… 0.26s  
  ✓ User Model → it casts attributes correctly                           0.29s  
  ✓ User Model → Relationships → it has profile relationship (in-memory… 0.27s  
  ✓ User Model → Relationships → it can attach authentication logs in-m… 0.27s  
  ✓ User Model → Relationships → it can expose ownedTeams relation when… 0.29s  
  ✓ User Model → Relationships → it can expose teams relation when pres… 0.27s  
  ✓ User Model → Accessors and Mutators → it has full_name accessor      0.27s  
  ✓ User Model → Accessors and Mutators → it handles null names in full… 0.29s  
  ✓ User Model → Accessors and Mutators → it hashes password when set    0.52s  
  ✓ User Model → Authentication Features → it reflects verified email s… 0.28s  
  ✓ User Model → Authentication Features → it can be activated/deactiva… 0.29s  
  ✓ User Model → Authentication Features → it supports OTP authenticati… 0.27s  
  ✓ User Model → Scopes and Queries → it exposes active flag for filter… 0.30s  
  ✓ User Model → Scopes and Queries → it exposes email verification fla… 0.32s  
  ✓ User Model → Scopes and Queries → it exposes language for filtering… 0.31s  
  ✓ User Model → Security Features → it has password expiration          0.27s  
  ✓ User Model → Security Features → it tracks creation and updates (in… 0.29s  
  ✓ User Model → Team Management → it can have current team (in-memory)  0.27s  
  ✓ User Model → Team Management → it can own teams (in-memory)          0.27s  

   WARN  Modules\User\tests\Unit\UserModulePhpstanFixesTest
  ✓ it password data can be instantiated                                 0.27s  
  ✓ it password data can be configured                                   0.24s  
  ✓ it password data get password rule works                             0.24s  
  ✓ it password data get helper text works                               0.25s  
  ! it password data get form components returns array → This test did…  0.24s  
  ✓ it events can be instantiated                                        0.25s  
  ! it events have dispatchable trait → This test did not perform any a… 0.26s  
  ✓ it password data static make method exists                           0.23s  
  ✓ it password data get validation messages method exists               0.23s  
  ✓ it password data get form schema method exists                       0.25s  

   WARN  Modules\User\tests\Unit\UserTest
  ✓ user can be created                                                  0.37s  
  ✓ user has correct type casting                                        0.25s  
  ✓ user password is hashed                                              0.63s  
  ✓ user can change password                                             0.76s  
  ✓ user can be updated                                                  0.26s  
  ✓ user can be deleted                                                  0.24s  
  ✓ user has fillable attributes                                         0.27s  
  ✓ user has hidden attributes                                           0.28s  
  ✓ user can be found by email                                           0.24s  
  ✓ user can be found by type                                            0.23s  
  ✓ user can be created with different types                             0.26s  
  ✓ user has timestamps                                                  0.24s  
  - user soft delete functionality → User model does not implement Soft… 0.23s  

   PASS  Modules\User\tests\Unit\UserTypeTest
  ✓ user type enum has correct cases                                     0.26s  
  ✓ user type enum implements required interfaces                        0.24s  
  ✓ user type enum getLabel method returns correct labels                0.23s  
  ✓ user type enum getColor method returns correct colors                0.26s  
  ✓ user type enum getIcon method returns correct icons                  0.23s  
  ✓ user type enum getDefaultGuard method returns correct guards         0.23s  
  ✓ user type enum can be used in database queries                       0.26s  
  ✓ user type enum can be compared                                       0.24s  
  ✓ user type enum can be used in match statements                       0.23s  
  ✓ user type enum can be serialized                                     0.25s  
  ✓ user type enum can be unserialized                                   0.23s  
  ✓ user type enum has correct string representation                     0.24s  
  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\AuthComponentsTest > `Auth Components…    
  Failed asserting that false is true.

  at Modules/User/tests/Feature/AuthComponentsTest.php:16
     12▕ 
     13▕ describe('Auth Components Tests', function (): void {
     14▕     test('auth components exist and work correctly', function (): void {
     15▕         // Test existing auth components
  ➜  16▕         expect(View::exists('components.auth-session-status'))->toBeTrue();
     17▕         expect(View::exists('components.auth-header'))->toBeTrue();
     18▕         expect(View::exists('user::components.auth-session-status'))->toBeTrue();
     19▕     });
     20▕

  1   Modules/User/tests/Feature/AuthComponentsTest.php:16

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\AuthComponentsTest > `Auth Components…    
  Failed asserting that false is true.

  at Modules/User/tests/Feature/AuthComponentsTest.php:23
     19▕     });
     20▕ 
     21▕     test('auth layout components exist and work correctly', function (): void {
     22▕         // Test auth layout components that actually exist
  ➜  23▕         expect(View::exists('components.layouts.auth'))->toBeTrue();
     24▕         expect(View::exists('user::layouts.auth'))->toBeTrue();
     25▕     });
     26▕ 
     27▕     test('login page loads correctly', function (): void {

  1   Modules/User/tests/Feature/AuthComponentsTest.php:23

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\AuthComponentsTest > `Auth Components…    
  Expected response status code [200] but received 500.
Failed asserting that 500 is identical to 200.

The following exception occurred during the last request:

Illuminate\Foundation\ViteManifestNotFoundException: Vite manifest not found at: /var/www/_bases/base_quaeris_fila4_mono/public_html/build/manifest.json in /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Vite.php:946
Stack trace:
#0 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Vite.php(384): Illuminate\Foundation\Vite->manifest()
#1 /var/www/_bases/base_quaeris_fila4_mono/laravel/storage/framework/views/53c107abd3aaca46e6fb3de49c65857b.php(22): Illuminate\Foundation\Vite->__invoke()
#2 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Filesystem/Filesystem.php(123): require('...')
#3 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Filesystem/Filesystem.php(124): Illuminate\Filesystem\Filesystem::Illuminate\Filesystem\{closure}()
#4 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Engines/PhpEngine.php(57): Illuminate\Filesystem\Filesystem->getRequire()
#5 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(22): Illuminate\View\Engines\PhpEngine->evaluatePath()
#6 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Engines/CompilerEngine.php(76): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->evaluatePath()
#7 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(10): Illuminate\View\Engines\CompilerEngine->get()
#8 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(208): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->get()
#9 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(191): Illuminate\View\View->getContents()
#10 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(160): Illuminate\View\View->renderContents()
#11 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesComponents.php(103): Illuminate\View\View->render()
#12 /var/www/_bases/base_quaeris_fila4_mono/laravel/storage/framework/views/bbae9269c8cc48f8eeeb47ad9dbd4f6e.php(101): Illuminate\View\Factory->renderComponent()
#13 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Filesystem/Filesystem.php(123): require('...')
#14 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Filesystem/Filesystem.php(124): Illuminate\Filesystem\Filesystem::Illuminate\Filesystem\{closure}()
#15 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Engines/PhpEngine.php(57): Illuminate\Filesystem\Filesystem->getRequire()
#16 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(22): Illuminate\View\Engines\PhpEngine->evaluatePath()
#17 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Engines/CompilerEngine.php(76): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->evaluatePath()
#18 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(10): Illuminate\View\Engines\CompilerEngine->get()
#19 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(208): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->get()
#20 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(191): Illuminate\View\View->getContents()
#21 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(160): Illuminate\View\View->renderContents()
#22 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Response.php(78): Illuminate\View\View->render()
#23 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Response.php(34): Illuminate\Http\Response->setContent()
#24 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(939): Illuminate\Http\Response->__construct()
#25 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php(363): Illuminate\Routing\Router::toResponse()
#26 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(102): Illuminate\Support\Facades\Facade::__callStatic()
#27 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(62): Laravel\Folio\RequestHandler->toResponse()
#28 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Laravel\Folio\RequestHandler->Laravel\Folio\{closure}()
#29 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/Cms/app/Providers/FolioVoltServiceProvider.php(97): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#30 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(201): Modules\Cms\Providers\FolioVoltServiceProvider->Modules\Cms\Providers\{closure}()
#31 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/mcamara/laravel-localization/src/Mcamara/LaravelLocalization/Middleware/LaravelLocalizationRedirectFilter.php(45): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#32 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter->handle()
#33 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/mcamara/laravel-localization/src/Mcamara/LaravelLocalization/Middleware/LocaleSessionRedirect.php(32): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#34 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect->handle()
#35 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/statikbe/laravel-cookie-consent/src/CookieConsentMiddleware.php(13): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#36 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Statikbe\CookieConsent\CookieConsentMiddleware->handle()
#37 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/barryvdh/laravel-debugbar/src/Middleware/InjectDebugbar.php(59): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#38 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Barryvdh\Debugbar\Middleware\InjectDebugbar->handle()
#39 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php(50): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#40 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Routing\Middleware\SubstituteBindings->handle()
#41 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/VerifyCsrfToken.php(87): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#42 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\VerifyCsrfToken->handle()
#43 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Middleware/ShareErrorsFromSession.php(48): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#44 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\View\Middleware\ShareErrorsFromSession->handle()
#45 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(120): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#46 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(63): Illuminate\Session\Middleware\StartSession->handleStatefulRequest()
#47 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Session\Middleware\StartSession->handle()
#48 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/AddQueuedCookiesToResponse.php(36): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#49 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse->handle()
#50 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/EncryptCookies.php(74): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#51 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Cookie\Middleware\EncryptCookies->handle()
#52 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/Xot/app/Http/Middleware/SetDefaultTenantForUrlsMiddleware.php(35): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#53 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Modules\Xot\Http\Middleware\SetDefaultTenantForUrlsMiddleware->handle()
#54 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#55 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(55): Illuminate\Pipeline\Pipeline->then()
#56 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/FolioManager.php(93): Laravel\Folio\RequestHandler->__invoke()
#57 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/CallableDispatcher.php(39): Laravel\Folio\FolioManager->Laravel\Folio\{closure}()
#58 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Route.php(243): Illuminate\Routing\CallableDispatcher->dispatch()
#59 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Route.php(214): Illuminate\Routing\Route->runCallable()
#60 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(822): Illuminate\Routing\Route->run()
#61 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\Routing\Router->Illuminate\Routing\{closure}()
#62 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#63 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(821): Illuminate\Pipeline\Pipeline->then()
#64 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(800): Illuminate\Routing\Router->runRouteWithinStack()
#65 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(764): Illuminate\Routing\Router->runRoute()
#66 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(753): Illuminate\Routing\Router->dispatchToRoute()
#67 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(200): Illuminate\Routing\Router->dispatch()
#68 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\Foundation\Http\Kernel->Illuminate\Foundation\Http\{closure}()
#69 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Features/SupportDisablingBackButtonCache/DisableBackButtonCacheMiddleware.php(19): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#70 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Livewire\Features\SupportDisablingBackButtonCache\DisableBackButtonCacheMiddleware->handle()
#71 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/barryvdh/laravel-debugbar/src/Middleware/InjectDebugbar.php(59): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#72 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Barryvdh\Debugbar\Middleware\InjectDebugbar->handle()
#73 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#74 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php(31): Illuminate\Foundation\Http\Middleware\TransformsRequest->handle()
#75 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull->handle()
#76 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#77 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php(51): Illuminate\Foundation\Http\Middleware\TransformsRequest->handle()
#78 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\TrimStrings->handle()
#79 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePostSize.php(27): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#80 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\ValidatePostSize->handle()
#81 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php(109): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#82 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance->handle()
#83 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php(48): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#84 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\HandleCors->handle()
#85 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php(58): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#86 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\TrustProxies->handle()
#87 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/InvokeDeferredCallbacks.php(22): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#88 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks->handle()
#89 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePathEncoding.php(26): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#90 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\ValidatePathEncoding->handle()
#91 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#92 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(175): Illuminate\Pipeline\Pipeline->then()
#93 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(144): Illuminate\Foundation\Http\Kernel->sendRequestThroughRouter()
#94 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php(607): Illuminate\Foundation\Http\Kernel->handle()
#95 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php(368): Illuminate\Foundation\Testing\TestCase->call()
#96 [internal function]: Illuminate\Foundation\Testing\TestCase->get()
#97 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/Reflection.php(37): ReflectionMethod->invoke()
#98 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/HigherOrderMessage.php(58): Pest\Support\Reflection::call()
#99 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/HigherOrderTapProxy.php(66): Pest\Support\HigherOrderMessage->call()
#100 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest-plugin-laravel/src/Http.php(189): Pest\Support\HigherOrderTapProxy->__call()
#101 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/User/tests/Feature/AuthComponentsTest.php(29): Pest\Laravel\get()
#102 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Factories/TestCaseMethodFactory.php(168): P\Modules\User\tests\Feature\AuthComponentsTest->{closure}()
#103 [internal function]: P\Modules\User\tests\Feature\AuthComponentsTest->Pest\Factories\{closure}()
#104 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(419): call_user_func_array()
#105 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/ExceptionTrace.php(26): P\Modules\User\tests\Feature\AuthComponentsTest->Pest\Concerns\{closure}()
#106 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(419): Pest\Support\ExceptionTrace::ensure()
#107 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(321): P\Modules\User\tests\Feature\AuthComponentsTest->__callClosure()
#108 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Factories/TestCaseFactory.php(169) : eval()'d code(35): P\Modules\User\tests\Feature\AuthComponentsTest->__runTest()
#109 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(1656): P\Modules\User\tests\Feature\AuthComponentsTest->__pest_evaluable__Auth_Components_Tests__→_login_page_loads_correctly()
#110 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(514): PHPUnit\Framework\TestCase->runTest()
#111 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestRunner/TestRunner.php(87): PHPUnit\Framework\TestCase->runBare()
#112 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(361): PHPUnit\Framework\TestRunner->run()
#113 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestSuite.php(369): PHPUnit\Framework\TestCase->run()
#114 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestSuite.php(369): PHPUnit\Framework\TestSuite->run()
#115 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/TextUI/TestRunner.php(64): PHPUnit\Framework\TestSuite->run()
#116 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/TextUI/Application.php(211): PHPUnit\TextUI\TestRunner->run()
#117 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Kernel.php(103): PHPUnit\TextUI\Application->run()
#118 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/bin/pest(184): Pest\Kernel->handle()
#119 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/bin/pest(192): {closure}()
#120 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/bin/pest(119): include('...')
#121 {main}

Next Illuminate\View\ViewException: Vite manifest not found at: /var/www/_bases/base_quaeris_fila4_mono/public_html/build/manifest.json (View: /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/UI/resources/views/components/layouts/main.blade.php) in /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Vite.php:946
Stack trace:
#0 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(58): Illuminate\View\Engines\CompilerEngine->handleViewException()
#1 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Engines/PhpEngine.php(59): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->handleViewException()
#2 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(22): Illuminate\View\Engines\PhpEngine->evaluatePath()
#3 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Engines/CompilerEngine.php(76): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->evaluatePath()
#4 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(10): Illuminate\View\Engines\CompilerEngine->get()
#5 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(208): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->get()
#6 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(191): Illuminate\View\View->getContents()
#7 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(160): Illuminate\View\View->renderContents()
#8 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesComponents.php(103): Illuminate\View\View->render()
#9 /var/www/_bases/base_quaeris_fila4_mono/laravel/storage/framework/views/bbae9269c8cc48f8eeeb47ad9dbd4f6e.php(101): Illuminate\View\Factory->renderComponent()
#10 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Filesystem/Filesystem.php(123): require('...')
#11 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Filesystem/Filesystem.php(124): Illuminate\Filesystem\Filesystem::Illuminate\Filesystem\{closure}()
#12 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Engines/PhpEngine.php(57): Illuminate\Filesystem\Filesystem->getRequire()
#13 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(22): Illuminate\View\Engines\PhpEngine->evaluatePath()
#14 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Engines/CompilerEngine.php(76): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->evaluatePath()
#15 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(10): Illuminate\View\Engines\CompilerEngine->get()
#16 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(208): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->get()
#17 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(191): Illuminate\View\View->getContents()
#18 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(160): Illuminate\View\View->renderContents()
#19 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Response.php(78): Illuminate\View\View->render()
#20 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Response.php(34): Illuminate\Http\Response->setContent()
#21 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(939): Illuminate\Http\Response->__construct()
#22 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php(363): Illuminate\Routing\Router::toResponse()
#23 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(102): Illuminate\Support\Facades\Facade::__callStatic()
#24 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(62): Laravel\Folio\RequestHandler->toResponse()
#25 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Laravel\Folio\RequestHandler->Laravel\Folio\{closure}()
#26 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/Cms/app/Providers/FolioVoltServiceProvider.php(97): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#27 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(201): Modules\Cms\Providers\FolioVoltServiceProvider->Modules\Cms\Providers\{closure}()
#28 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/mcamara/laravel-localization/src/Mcamara/LaravelLocalization/Middleware/LaravelLocalizationRedirectFilter.php(45): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#29 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter->handle()
#30 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/mcamara/laravel-localization/src/Mcamara/LaravelLocalization/Middleware/LocaleSessionRedirect.php(32): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#31 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect->handle()
#32 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/statikbe/laravel-cookie-consent/src/CookieConsentMiddleware.php(13): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#33 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Statikbe\CookieConsent\CookieConsentMiddleware->handle()
#34 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/barryvdh/laravel-debugbar/src/Middleware/InjectDebugbar.php(59): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#35 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Barryvdh\Debugbar\Middleware\InjectDebugbar->handle()
#36 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php(50): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#37 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Routing\Middleware\SubstituteBindings->handle()
#38 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/VerifyCsrfToken.php(87): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#39 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\VerifyCsrfToken->handle()
#40 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Middleware/ShareErrorsFromSession.php(48): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#41 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\View\Middleware\ShareErrorsFromSession->handle()
#42 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(120): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#43 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(63): Illuminate\Session\Middleware\StartSession->handleStatefulRequest()
#44 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Session\Middleware\StartSession->handle()
#45 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/AddQueuedCookiesToResponse.php(36): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#46 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse->handle()
#47 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/EncryptCookies.php(74): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#48 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Cookie\Middleware\EncryptCookies->handle()
#49 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/Xot/app/Http/Middleware/SetDefaultTenantForUrlsMiddleware.php(35): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#50 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Modules\Xot\Http\Middleware\SetDefaultTenantForUrlsMiddleware->handle()
#51 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#52 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(55): Illuminate\Pipeline\Pipeline->then()
#53 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/FolioManager.php(93): Laravel\Folio\RequestHandler->__invoke()
#54 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/CallableDispatcher.php(39): Laravel\Folio\FolioManager->Laravel\Folio\{closure}()
#55 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Route.php(243): Illuminate\Routing\CallableDispatcher->dispatch()
#56 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Route.php(214): Illuminate\Routing\Route->runCallable()
#57 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(822): Illuminate\Routing\Route->run()
#58 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\Routing\Router->Illuminate\Routing\{closure}()
#59 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#60 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(821): Illuminate\Pipeline\Pipeline->then()
#61 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(800): Illuminate\Routing\Router->runRouteWithinStack()
#62 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(764): Illuminate\Routing\Router->runRoute()
#63 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(753): Illuminate\Routing\Router->dispatchToRoute()
#64 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(200): Illuminate\Routing\Router->dispatch()
#65 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\Foundation\Http\Kernel->Illuminate\Foundation\Http\{closure}()
#66 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Features/SupportDisablingBackButtonCache/DisableBackButtonCacheMiddleware.php(19): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#67 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Livewire\Features\SupportDisablingBackButtonCache\DisableBackButtonCacheMiddleware->handle()
#68 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/barryvdh/laravel-debugbar/src/Middleware/InjectDebugbar.php(59): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#69 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Barryvdh\Debugbar\Middleware\InjectDebugbar->handle()
#70 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#71 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php(31): Illuminate\Foundation\Http\Middleware\TransformsRequest->handle()
#72 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull->handle()
#73 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#74 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php(51): Illuminate\Foundation\Http\Middleware\TransformsRequest->handle()
#75 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\TrimStrings->handle()
#76 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePostSize.php(27): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#77 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\ValidatePostSize->handle()
#78 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php(109): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#79 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance->handle()
#80 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php(48): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#81 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\HandleCors->handle()
#82 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php(58): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#83 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\TrustProxies->handle()
#84 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/InvokeDeferredCallbacks.php(22): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#85 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks->handle()
#86 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePathEncoding.php(26): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#87 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\ValidatePathEncoding->handle()
#88 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#89 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(175): Illuminate\Pipeline\Pipeline->then()
#90 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(144): Illuminate\Foundation\Http\Kernel->sendRequestThroughRouter()
#91 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php(607): Illuminate\Foundation\Http\Kernel->handle()
#92 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php(368): Illuminate\Foundation\Testing\TestCase->call()
#93 [internal function]: Illuminate\Foundation\Testing\TestCase->get()
#94 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/Reflection.php(37): ReflectionMethod->invoke()
#95 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/HigherOrderMessage.php(58): Pest\Support\Reflection::call()
#96 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/HigherOrderTapProxy.php(66): Pest\Support\HigherOrderMessage->call()
#97 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest-plugin-laravel/src/Http.php(189): Pest\Support\HigherOrderTapProxy->__call()
#98 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/User/tests/Feature/AuthComponentsTest.php(29): Pest\Laravel\get()
#99 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Factories/TestCaseMethodFactory.php(168): P\Modules\User\tests\Feature\AuthComponentsTest->{closure}()
#100 [internal function]: P\Modules\User\tests\Feature\AuthComponentsTest->Pest\Factories\{closure}()
#101 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(419): call_user_func_array()
#102 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/ExceptionTrace.php(26): P\Modules\User\tests\Feature\AuthComponentsTest->Pest\Concerns\{closure}()
#103 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(419): Pest\Support\ExceptionTrace::ensure()
#104 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(321): P\Modules\User\tests\Feature\AuthComponentsTest->__callClosure()
#105 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Factories/TestCaseFactory.php(169) : eval()'d code(35): P\Modules\User\tests\Feature\AuthComponentsTest->__runTest()
#106 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(1656): P\Modules\User\tests\Feature\AuthComponentsTest->__pest_evaluable__Auth_Components_Tests__→_login_page_loads_correctly()
#107 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(514): PHPUnit\Framework\TestCase->runTest()
#108 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestRunner/TestRunner.php(87): PHPUnit\Framework\TestCase->runBare()
#109 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(361): PHPUnit\Framework\TestRunner->run()
#110 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestSuite.php(369): PHPUnit\Framework\TestCase->run()
#111 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestSuite.php(369): PHPUnit\Framework\TestSuite->run()
#112 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/TextUI/TestRunner.php(64): PHPUnit\Framework\TestSuite->run()
#113 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/TextUI/Application.php(211): PHPUnit\TextUI\TestRunner->run()
#114 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Kernel.php(103): PHPUnit\TextUI\Application->run()
#115 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/bin/pest(184): Pest\Kernel->handle()
#116 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/bin/pest(192): {closure}()
#117 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/bin/pest(119): include('...')
#118 {main}

Next Illuminate\View\ViewException: Vite manifest not found at: /var/www/_bases/base_quaeris_fila4_mono/public_html/build/manifest.json (View: /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/UI/resources/views/components/layouts/main.blade.php) (View: /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/UI/resources/views/components/layouts/main.blade.php) in /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Vite.php:946
Stack trace:
#0 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(58): Illuminate\View\Engines\CompilerEngine->handleViewException()
#1 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Engines/PhpEngine.php(59): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->handleViewException()
#2 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(22): Illuminate\View\Engines\PhpEngine->evaluatePath()
#3 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Engines/CompilerEngine.php(76): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->evaluatePath()
#4 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(10): Illuminate\View\Engines\CompilerEngine->get()
#5 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(208): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->get()
#6 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(191): Illuminate\View\View->getContents()
#7 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(160): Illuminate\View\View->renderContents()
#8 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Response.php(78): Illuminate\View\View->render()
#9 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Response.php(34): Illuminate\Http\Response->setContent()
#10 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(939): Illuminate\Http\Response->__construct()
#11 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php(363): Illuminate\Routing\Router::toResponse()
#12 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(102): Illuminate\Support\Facades\Facade::__callStatic()
#13 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(62): Laravel\Folio\RequestHandler->toResponse()
#14 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Laravel\Folio\RequestHandler->Laravel\Folio\{closure}()
#15 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/Cms/app/Providers/FolioVoltServiceProvider.php(97): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#16 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(201): Modules\Cms\Providers\FolioVoltServiceProvider->Modules\Cms\Providers\{closure}()
#17 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/mcamara/laravel-localization/src/Mcamara/LaravelLocalization/Middleware/LaravelLocalizationRedirectFilter.php(45): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#18 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter->handle()
#19 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/mcamara/laravel-localization/src/Mcamara/LaravelLocalization/Middleware/LocaleSessionRedirect.php(32): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#20 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect->handle()
#21 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/statikbe/laravel-cookie-consent/src/CookieConsentMiddleware.php(13): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#22 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Statikbe\CookieConsent\CookieConsentMiddleware->handle()
#23 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/barryvdh/laravel-debugbar/src/Middleware/InjectDebugbar.php(59): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#24 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Barryvdh\Debugbar\Middleware\InjectDebugbar->handle()
#25 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php(50): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#26 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Routing\Middleware\SubstituteBindings->handle()
#27 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/VerifyCsrfToken.php(87): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#28 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\VerifyCsrfToken->handle()
#29 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Middleware/ShareErrorsFromSession.php(48): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#30 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\View\Middleware\ShareErrorsFromSession->handle()
#31 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(120): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#32 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(63): Illuminate\Session\Middleware\StartSession->handleStatefulRequest()
#33 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Session\Middleware\StartSession->handle()
#34 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/AddQueuedCookiesToResponse.php(36): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#35 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse->handle()
#36 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/EncryptCookies.php(74): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#37 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Cookie\Middleware\EncryptCookies->handle()
#38 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/Xot/app/Http/Middleware/SetDefaultTenantForUrlsMiddleware.php(35): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#39 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Modules\Xot\Http\Middleware\SetDefaultTenantForUrlsMiddleware->handle()
#40 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#41 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(55): Illuminate\Pipeline\Pipeline->then()
#42 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/FolioManager.php(93): Laravel\Folio\RequestHandler->__invoke()
#43 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/CallableDispatcher.php(39): Laravel\Folio\FolioManager->Laravel\Folio\{closure}()
#44 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Route.php(243): Illuminate\Routing\CallableDispatcher->dispatch()
#45 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Route.php(214): Illuminate\Routing\Route->runCallable()
#46 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(822): Illuminate\Routing\Route->run()
#47 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\Routing\Router->Illuminate\Routing\{closure}()
#48 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#49 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(821): Illuminate\Pipeline\Pipeline->then()
#50 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(800): Illuminate\Routing\Router->runRouteWithinStack()
#51 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(764): Illuminate\Routing\Router->runRoute()
#52 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(753): Illuminate\Routing\Router->dispatchToRoute()
#53 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(200): Illuminate\Routing\Router->dispatch()
#54 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\Foundation\Http\Kernel->Illuminate\Foundation\Http\{closure}()
#55 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Features/SupportDisablingBackButtonCache/DisableBackButtonCacheMiddleware.php(19): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#56 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Livewire\Features\SupportDisablingBackButtonCache\DisableBackButtonCacheMiddleware->handle()
#57 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/barryvdh/laravel-debugbar/src/Middleware/InjectDebugbar.php(59): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#58 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Barryvdh\Debugbar\Middleware\InjectDebugbar->handle()
#59 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#60 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php(31): Illuminate\Foundation\Http\Middleware\TransformsRequest->handle()
#61 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull->handle()
#62 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#63 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php(51): Illuminate\Foundation\Http\Middleware\TransformsRequest->handle()
#64 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\TrimStrings->handle()
#65 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePostSize.php(27): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#66 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\ValidatePostSize->handle()
#67 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php(109): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#68 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance->handle()
#69 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php(48): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#70 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\HandleCors->handle()
#71 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php(58): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#72 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\TrustProxies->handle()
#73 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/InvokeDeferredCallbacks.php(22): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#74 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks->handle()
#75 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePathEncoding.php(26): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#76 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\ValidatePathEncoding->handle()
#77 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#78 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(175): Illuminate\Pipeline\Pipeline->then()
#79 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(144): Illuminate\Foundation\Http\Kernel->sendRequestThroughRouter()
#80 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php(607): Illuminate\Foundation\Http\Kernel->handle()
#81 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php(368): Illuminate\Foundation\Testing\TestCase->call()
#82 [internal function]: Illuminate\Foundation\Testing\TestCase->get()
#83 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/Reflection.php(37): ReflectionMethod->invoke()
#84 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/HigherOrderMessage.php(58): Pest\Support\Reflection::call()
#85 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/HigherOrderTapProxy.php(66): Pest\Support\HigherOrderMessage->call()
#86 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest-plugin-laravel/src/Http.php(189): Pest\Support\HigherOrderTapProxy->__call()
#87 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/User/tests/Feature/AuthComponentsTest.php(29): Pest\Laravel\get()
#88 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Factories/TestCaseMethodFactory.php(168): P\Modules\User\tests\Feature\AuthComponentsTest->{closure}()
#89 [internal function]: P\Modules\User\tests\Feature\AuthComponentsTest->Pest\Factories\{closure}()
#90 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(419): call_user_func_array()
#91 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/ExceptionTrace.php(26): P\Modules\User\tests\Feature\AuthComponentsTest->Pest\Concerns\{closure}()
#92 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(419): Pest\Support\ExceptionTrace::ensure()
#93 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(321): P\Modules\User\tests\Feature\AuthComponentsTest->__callClosure()
#94 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Factories/TestCaseFactory.php(169) : eval()'d code(35): P\Modules\User\tests\Feature\AuthComponentsTest->__runTest()
#95 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(1656): P\Modules\User\tests\Feature\AuthComponentsTest->__pest_evaluable__Auth_Components_Tests__→_login_page_loads_correctly()
#96 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(514): PHPUnit\Framework\TestCase->runTest()
#97 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestRunner/TestRunner.php(87): PHPUnit\Framework\TestCase->runBare()
#98 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(361): PHPUnit\Framework\TestRunner->run()
#99 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestSuite.php(369): PHPUnit\Framework\TestCase->run()
#100 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestSuite.php(369): PHPUnit\Framework\TestSuite->run()
#101 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/TextUI/TestRunner.php(64): PHPUnit\Framework\TestSuite->run()
#102 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/TextUI/Application.php(211): PHPUnit\TextUI\TestRunner->run()
#103 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Kernel.php(103): PHPUnit\TextUI\Application->run()
#104 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/bin/pest(184): Pest\Kernel->handle()
#105 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/bin/pest(192): {closure}()
#106 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/bin/pest(119): include('...')
#107 {main}

----------------------------------------------------------------------------------

Vite manifest not found at: /var/www/_bases/base_quaeris_fila4_mono/public_html/build/manifest.json (View: /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/UI/resources/views/components/layouts/main.blade.php) (View: /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/UI/resources/views/components/layouts/main.blade.php)

  at Modules/User/tests/Feature/AuthComponentsTest.php:31
     27▕     test('login page loads correctly', function (): void {
     28▕         // Test that login page loads correctly
     29▕         $response = get('/it/auth/login');
     30▕         /* @phpstan-ignore-next-line method.nonObject */
  ➜  31▕         $response->assertStatus(200);
     32▕     });
     33▕ 
     34▕     test('register page loads correctly', function (): void {
     35▕         // Test that register page loads correctly

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\AuthComponentsTest > `Auth Components…    
  Expected response status code [200] but received 500.
Failed asserting that 500 is identical to 200.

The following exception occurred during the last request:

Illuminate\Contracts\Container\BindingResolutionException: Unable to resolve dependency [Parameter #0 [ <required> string $type ]] in class Modules\User\Filament\Widgets\RegistrationWidget in /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php:198
Stack trace:
#0 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/ImplicitlyBoundMethod.php(21): Illuminate\Container\BoundMethod::addDependencyForCallParameter()
#1 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Livewire\ImplicitlyBoundMethod::getMethodDependencies()
#2 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Container/Util.php(43): Illuminate\Container\BoundMethod::Illuminate\Container\{closure}()
#3 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(96): Illuminate\Container\Util::unwrapIfClosure()
#4 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\Container\BoundMethod::callBoundMethod()
#5 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Wrapped.php(23): Illuminate\Container\BoundMethod::call()
#6 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Features/SupportLifecycleHooks/SupportLifecycleHooks.php(134): Livewire\Wrapped->__call()
#7 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Features/SupportLifecycleHooks/SupportLifecycleHooks.php(20): Livewire\Features\SupportLifecycleHooks\SupportLifecycleHooks->callHook()
#8 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/ComponentHook.php(19): Livewire\Features\SupportLifecycleHooks\SupportLifecycleHooks->mount()
#9 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/ComponentHookRegistry.php(45): Livewire\ComponentHook->callMount()
#10 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/EventBus.php(60): Livewire\ComponentHookRegistry::Livewire\{closure}()
#11 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/helpers.php(98): Livewire\EventBus->trigger()
#12 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/HandleComponents/HandleComponents.php(50): Livewire\trigger()
#13 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/LivewireManager.php(73): Livewire\Mechanisms\HandleComponents\HandleComponents->mount()
#14 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/volt/src/LivewireManager.php(23): Livewire\LivewireManager->mount()
#15 /var/www/_bases/base_quaeris_fila4_mono/laravel/storage/framework/views/56605d057c4da24e39d52b2735540345.php(86): Livewire\Volt\LivewireManager->mount()
#16 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Filesystem/Filesystem.php(123): require('...')
#17 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Filesystem/Filesystem.php(124): Illuminate\Filesystem\Filesystem::Illuminate\Filesystem\{closure}()
#18 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Engines/PhpEngine.php(57): Illuminate\Filesystem\Filesystem->getRequire()
#19 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(22): Illuminate\View\Engines\PhpEngine->evaluatePath()
#20 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Engines/CompilerEngine.php(76): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->evaluatePath()
#21 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(10): Illuminate\View\Engines\CompilerEngine->get()
#22 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(208): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->get()
#23 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(191): Illuminate\View\View->getContents()
#24 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(160): Illuminate\View\View->renderContents()
#25 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Response.php(78): Illuminate\View\View->render()
#26 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Response.php(34): Illuminate\Http\Response->setContent()
#27 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(939): Illuminate\Http\Response->__construct()
#28 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php(363): Illuminate\Routing\Router::toResponse()
#29 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(102): Illuminate\Support\Facades\Facade::__callStatic()
#30 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(62): Laravel\Folio\RequestHandler->toResponse()
#31 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Laravel\Folio\RequestHandler->Laravel\Folio\{closure}()
#32 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Auth/Middleware/RedirectIfAuthenticated.php(47): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#33 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Auth\Middleware\RedirectIfAuthenticated->handle()
#34 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/Cms/app/Providers/FolioVoltServiceProvider.php(120): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#35 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(201): Modules\Cms\Providers\FolioVoltServiceProvider->Modules\Cms\Providers\{closure}()
#36 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/mcamara/laravel-localization/src/Mcamara/LaravelLocalization/Middleware/LaravelLocalizationRedirectFilter.php(45): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#37 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter->handle()
#38 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/mcamara/laravel-localization/src/Mcamara/LaravelLocalization/Middleware/LocaleSessionRedirect.php(32): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#39 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect->handle()
#40 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/statikbe/laravel-cookie-consent/src/CookieConsentMiddleware.php(13): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#41 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Statikbe\CookieConsent\CookieConsentMiddleware->handle()
#42 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/barryvdh/laravel-debugbar/src/Middleware/InjectDebugbar.php(59): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#43 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Barryvdh\Debugbar\Middleware\InjectDebugbar->handle()
#44 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php(50): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#45 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Routing\Middleware\SubstituteBindings->handle()
#46 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/VerifyCsrfToken.php(87): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#47 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\VerifyCsrfToken->handle()
#48 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Middleware/ShareErrorsFromSession.php(48): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#49 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\View\Middleware\ShareErrorsFromSession->handle()
#50 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(120): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#51 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(63): Illuminate\Session\Middleware\StartSession->handleStatefulRequest()
#52 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Session\Middleware\StartSession->handle()
#53 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/AddQueuedCookiesToResponse.php(36): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#54 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse->handle()
#55 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/EncryptCookies.php(74): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#56 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Cookie\Middleware\EncryptCookies->handle()
#57 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/Xot/app/Http/Middleware/SetDefaultTenantForUrlsMiddleware.php(35): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#58 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Modules\Xot\Http\Middleware\SetDefaultTenantForUrlsMiddleware->handle()
#59 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#60 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(55): Illuminate\Pipeline\Pipeline->then()
#61 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/FolioManager.php(93): Laravel\Folio\RequestHandler->__invoke()
#62 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/CallableDispatcher.php(39): Laravel\Folio\FolioManager->Laravel\Folio\{closure}()
#63 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Route.php(243): Illuminate\Routing\CallableDispatcher->dispatch()
#64 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Route.php(214): Illuminate\Routing\Route->runCallable()
#65 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(822): Illuminate\Routing\Route->run()
#66 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\Routing\Router->Illuminate\Routing\{closure}()
#67 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#68 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(821): Illuminate\Pipeline\Pipeline->then()
#69 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(800): Illuminate\Routing\Router->runRouteWithinStack()
#70 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(764): Illuminate\Routing\Router->runRoute()
#71 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(753): Illuminate\Routing\Router->dispatchToRoute()
#72 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(200): Illuminate\Routing\Router->dispatch()
#73 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\Foundation\Http\Kernel->Illuminate\Foundation\Http\{closure}()
#74 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Features/SupportDisablingBackButtonCache/DisableBackButtonCacheMiddleware.php(19): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#75 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Livewire\Features\SupportDisablingBackButtonCache\DisableBackButtonCacheMiddleware->handle()
#76 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/barryvdh/laravel-debugbar/src/Middleware/InjectDebugbar.php(59): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#77 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Barryvdh\Debugbar\Middleware\InjectDebugbar->handle()
#78 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#79 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php(31): Illuminate\Foundation\Http\Middleware\TransformsRequest->handle()
#80 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull->handle()
#81 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#82 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php(51): Illuminate\Foundation\Http\Middleware\TransformsRequest->handle()
#83 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\TrimStrings->handle()
#84 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePostSize.php(27): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#85 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\ValidatePostSize->handle()
#86 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php(109): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#87 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance->handle()
#88 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php(48): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#89 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\HandleCors->handle()
#90 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php(58): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#91 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\TrustProxies->handle()
#92 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/InvokeDeferredCallbacks.php(22): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#93 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks->handle()
#94 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePathEncoding.php(26): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#95 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\ValidatePathEncoding->handle()
#96 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#97 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(175): Illuminate\Pipeline\Pipeline->then()
#98 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(144): Illuminate\Foundation\Http\Kernel->sendRequestThroughRouter()
#99 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php(607): Illuminate\Foundation\Http\Kernel->handle()
#100 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php(368): Illuminate\Foundation\Testing\TestCase->call()
#101 [internal function]: Illuminate\Foundation\Testing\TestCase->get()
#102 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/Reflection.php(37): ReflectionMethod->invoke()
#103 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/HigherOrderMessage.php(58): Pest\Support\Reflection::call()
#104 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/HigherOrderTapProxy.php(66): Pest\Support\HigherOrderMessage->call()
#105 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest-plugin-laravel/src/Http.php(189): Pest\Support\HigherOrderTapProxy->__call()
#106 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/User/tests/Feature/AuthComponentsTest.php(36): Pest\Laravel\get()
#107 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Factories/TestCaseMethodFactory.php(168): P\Modules\User\tests\Feature\AuthComponentsTest->{closure}()
#108 [internal function]: P\Modules\User\tests\Feature\AuthComponentsTest->Pest\Factories\{closure}()
#109 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(419): call_user_func_array()
#110 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/ExceptionTrace.php(26): P\Modules\User\tests\Feature\AuthComponentsTest->Pest\Concerns\{closure}()
#111 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(419): Pest\Support\ExceptionTrace::ensure()
#112 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(321): P\Modules\User\tests\Feature\AuthComponentsTest->__callClosure()
#113 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Factories/TestCaseFactory.php(169) : eval()'d code(44): P\Modules\User\tests\Feature\AuthComponentsTest->__runTest()
#114 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(1656): P\Modules\User\tests\Feature\AuthComponentsTest->__pest_evaluable__Auth_Components_Tests__→_register_page_loads_correctly()
#115 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(514): PHPUnit\Framework\TestCase->runTest()
#116 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestRunner/TestRunner.php(87): PHPUnit\Framework\TestCase->runBare()
#117 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(361): PHPUnit\Framework\TestRunner->run()
#118 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestSuite.php(369): PHPUnit\Framework\TestCase->run()
#119 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestSuite.php(369): PHPUnit\Framework\TestSuite->run()
#120 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/TextUI/TestRunner.php(64): PHPUnit\Framework\TestSuite->run()
#121 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/TextUI/Application.php(211): PHPUnit\TextUI\TestRunner->run()
#122 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Kernel.php(103): PHPUnit\TextUI\Application->run()
#123 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/bin/pest(184): Pest\Kernel->handle()
#124 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/bin/pest(192): {closure}()
#125 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/bin/pest(119): include('...')
#126 {main}

Next Illuminate\View\ViewException: Unable to resolve dependency [Parameter #0 [ <required> string $type ]] in class Modules\User\Filament\Widgets\RegistrationWidget (View: /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/User/resources/views/pages/auth/register.blade.php) in /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php:198
Stack trace:
#0 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(58): Illuminate\View\Engines\CompilerEngine->handleViewException()
#1 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Engines/PhpEngine.php(59): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->handleViewException()
#2 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(22): Illuminate\View\Engines\PhpEngine->evaluatePath()
#3 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Engines/CompilerEngine.php(76): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->evaluatePath()
#4 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(10): Illuminate\View\Engines\CompilerEngine->get()
#5 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(208): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->get()
#6 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(191): Illuminate\View\View->getContents()
#7 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(160): Illuminate\View\View->renderContents()
#8 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Response.php(78): Illuminate\View\View->render()
#9 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Response.php(34): Illuminate\Http\Response->setContent()
#10 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(939): Illuminate\Http\Response->__construct()
#11 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php(363): Illuminate\Routing\Router::toResponse()
#12 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(102): Illuminate\Support\Facades\Facade::__callStatic()
#13 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(62): Laravel\Folio\RequestHandler->toResponse()
#14 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Laravel\Folio\RequestHandler->Laravel\Folio\{closure}()
#15 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Auth/Middleware/RedirectIfAuthenticated.php(47): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#16 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Auth\Middleware\RedirectIfAuthenticated->handle()
#17 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/Cms/app/Providers/FolioVoltServiceProvider.php(120): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#18 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(201): Modules\Cms\Providers\FolioVoltServiceProvider->Modules\Cms\Providers\{closure}()
#19 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/mcamara/laravel-localization/src/Mcamara/LaravelLocalization/Middleware/LaravelLocalizationRedirectFilter.php(45): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#20 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter->handle()
#21 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/mcamara/laravel-localization/src/Mcamara/LaravelLocalization/Middleware/LocaleSessionRedirect.php(32): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#22 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect->handle()
#23 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/statikbe/laravel-cookie-consent/src/CookieConsentMiddleware.php(13): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#24 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Statikbe\CookieConsent\CookieConsentMiddleware->handle()
#25 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/barryvdh/laravel-debugbar/src/Middleware/InjectDebugbar.php(59): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#26 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Barryvdh\Debugbar\Middleware\InjectDebugbar->handle()
#27 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php(50): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#28 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Routing\Middleware\SubstituteBindings->handle()
#29 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/VerifyCsrfToken.php(87): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#30 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\VerifyCsrfToken->handle()
#31 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Middleware/ShareErrorsFromSession.php(48): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#32 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\View\Middleware\ShareErrorsFromSession->handle()
#33 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(120): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#34 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(63): Illuminate\Session\Middleware\StartSession->handleStatefulRequest()
#35 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Session\Middleware\StartSession->handle()
#36 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/AddQueuedCookiesToResponse.php(36): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#37 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse->handle()
#38 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/EncryptCookies.php(74): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#39 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Cookie\Middleware\EncryptCookies->handle()
#40 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/Xot/app/Http/Middleware/SetDefaultTenantForUrlsMiddleware.php(35): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#41 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Modules\Xot\Http\Middleware\SetDefaultTenantForUrlsMiddleware->handle()
#42 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#43 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(55): Illuminate\Pipeline\Pipeline->then()
#44 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/FolioManager.php(93): Laravel\Folio\RequestHandler->__invoke()
#45 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/CallableDispatcher.php(39): Laravel\Folio\FolioManager->Laravel\Folio\{closure}()
#46 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Route.php(243): Illuminate\Routing\CallableDispatcher->dispatch()
#47 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Route.php(214): Illuminate\Routing\Route->runCallable()
#48 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(822): Illuminate\Routing\Route->run()
#49 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\Routing\Router->Illuminate\Routing\{closure}()
#50 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#51 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(821): Illuminate\Pipeline\Pipeline->then()
#52 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(800): Illuminate\Routing\Router->runRouteWithinStack()
#53 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(764): Illuminate\Routing\Router->runRoute()
#54 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(753): Illuminate\Routing\Router->dispatchToRoute()
#55 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(200): Illuminate\Routing\Router->dispatch()
#56 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\Foundation\Http\Kernel->Illuminate\Foundation\Http\{closure}()
#57 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Features/SupportDisablingBackButtonCache/DisableBackButtonCacheMiddleware.php(19): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#58 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Livewire\Features\SupportDisablingBackButtonCache\DisableBackButtonCacheMiddleware->handle()
#59 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/barryvdh/laravel-debugbar/src/Middleware/InjectDebugbar.php(59): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#60 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Barryvdh\Debugbar\Middleware\InjectDebugbar->handle()
#61 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#62 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php(31): Illuminate\Foundation\Http\Middleware\TransformsRequest->handle()
#63 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull->handle()
#64 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#65 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php(51): Illuminate\Foundation\Http\Middleware\TransformsRequest->handle()
#66 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\TrimStrings->handle()
#67 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePostSize.php(27): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#68 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\ValidatePostSize->handle()
#69 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php(109): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#70 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance->handle()
#71 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php(48): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#72 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\HandleCors->handle()
#73 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php(58): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#74 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\TrustProxies->handle()
#75 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/InvokeDeferredCallbacks.php(22): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#76 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks->handle()
#77 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePathEncoding.php(26): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#78 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\ValidatePathEncoding->handle()
#79 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#80 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(175): Illuminate\Pipeline\Pipeline->then()
#81 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(144): Illuminate\Foundation\Http\Kernel->sendRequestThroughRouter()
#82 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php(607): Illuminate\Foundation\Http\Kernel->handle()
#83 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php(368): Illuminate\Foundation\Testing\TestCase->call()
#84 [internal function]: Illuminate\Foundation\Testing\TestCase->get()
#85 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/Reflection.php(37): ReflectionMethod->invoke()
#86 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/HigherOrderMessage.php(58): Pest\Support\Reflection::call()
#87 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/HigherOrderTapProxy.php(66): Pest\Support\HigherOrderMessage->call()
#88 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest-plugin-laravel/src/Http.php(189): Pest\Support\HigherOrderTapProxy->__call()
#89 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/User/tests/Feature/AuthComponentsTest.php(36): Pest\Laravel\get()
#90 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Factories/TestCaseMethodFactory.php(168): P\Modules\User\tests\Feature\AuthComponentsTest->{closure}()
#91 [internal function]: P\Modules\User\tests\Feature\AuthComponentsTest->Pest\Factories\{closure}()
#92 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(419): call_user_func_array()
#93 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/ExceptionTrace.php(26): P\Modules\User\tests\Feature\AuthComponentsTest->Pest\Concerns\{closure}()
#94 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(419): Pest\Support\ExceptionTrace::ensure()
#95 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(321): P\Modules\User\tests\Feature\AuthComponentsTest->__callClosure()
#96 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Factories/TestCaseFactory.php(169) : eval()'d code(44): P\Modules\User\tests\Feature\AuthComponentsTest->__runTest()
#97 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(1656): P\Modules\User\tests\Feature\AuthComponentsTest->__pest_evaluable__Auth_Components_Tests__→_register_page_loads_correctly()
#98 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(514): PHPUnit\Framework\TestCase->runTest()
#99 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestRunner/TestRunner.php(87): PHPUnit\Framework\TestCase->runBare()
#100 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(361): PHPUnit\Framework\TestRunner->run()
#101 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestSuite.php(369): PHPUnit\Framework\TestCase->run()
#102 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestSuite.php(369): PHPUnit\Framework\TestSuite->run()
#103 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/TextUI/TestRunner.php(64): PHPUnit\Framework\TestSuite->run()
#104 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/TextUI/Application.php(211): PHPUnit\TextUI\TestRunner->run()
#105 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Kernel.php(103): PHPUnit\TextUI\Application->run()
#106 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/bin/pest(184): Pest\Kernel->handle()
#107 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/bin/pest(192): {closure}()
#108 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/bin/pest(119): include('...')
#109 {main}

----------------------------------------------------------------------------------

Unable to resolve dependency [Parameter #0 [ <required> string $type ]] in class Modules\User\Filament\Widgets\RegistrationWidget (View: /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/User/resources/views/pages/auth/register.blade.php)

  at Modules/User/tests/Feature/AuthComponentsTest.php:38
     34▕     test('register page loads correctly', function (): void {
     35▕         // Test that register page loads correctly
     36▕         $response = get('/it/auth/register');
     37▕         /* @phpstan-ignore-next-line method.nonObject */
  ➜  38▕         $response->assertStatus(200);
     39▕     });
     40▕ 
     41▕     test('auth-session-status component renders correctly', function (): void {
     42▕         // Test the existing auth-session-status component rendering

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\AuthComponen…  InvalidArgumentException   
  View [components.auth-session-status] not found.

  at vendor/laravel/framework/src/Illuminate/View/FileViewFinder.php:138
    134▕                 }
    135▕             }
    136▕         }
    137▕ 
  ➜ 138▕         throw new InvalidArgumentException("View [{$name}] not found.");
    139▕     }
    140▕ 
    141▕     /**
    142▕      * Get an array of possible view files.

      [2m+4 vendor frames [22m
  5   Modules/User/tests/Feature/AuthComponentsTest.php:43

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\AuthComponentsTest > `Auth Components…    
  Failed asserting that false is true.

  at Modules/User/tests/Feature/AuthComponentsTest.php:51
     47▕     });
     48▕ 
     49▕     test('auth header component exists and renders', function (): void {
     50▕         // Test the auth header component that exists
  ➜  51▕         expect(View::exists('components.auth-header'))->toBeTrue();
     52▕ 
     53▕         $html = view('components.auth-header', [
     54▕             'title' => 'Login Test',
     55▕             'description' => 'Test description',

  1   Modules/User/tests/Feature/AuthComponentsTest.php:51

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\AuthComponentsTest > `Authentication F…   
  Expected response status code [200] but received 500.
Failed asserting that 500 is identical to 200.

The following exception occurred during the last request:

Illuminate\Foundation\ViteManifestNotFoundException: Vite manifest not found at: /var/www/_bases/base_quaeris_fila4_mono/public_html/build/manifest.json in /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Vite.php:946
Stack trace:
#0 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Vite.php(384): Illuminate\Foundation\Vite->manifest()
#1 /var/www/_bases/base_quaeris_fila4_mono/laravel/storage/framework/views/53c107abd3aaca46e6fb3de49c65857b.php(22): Illuminate\Foundation\Vite->__invoke()
#2 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Filesystem/Filesystem.php(123): require('...')
#3 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Filesystem/Filesystem.php(124): Illuminate\Filesystem\Filesystem::Illuminate\Filesystem\{closure}()
#4 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Engines/PhpEngine.php(57): Illuminate\Filesystem\Filesystem->getRequire()
#5 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(22): Illuminate\View\Engines\PhpEngine->evaluatePath()
#6 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Engines/CompilerEngine.php(76): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->evaluatePath()
#7 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(10): Illuminate\View\Engines\CompilerEngine->get()
#8 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(208): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->get()
#9 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(191): Illuminate\View\View->getContents()
#10 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(160): Illuminate\View\View->renderContents()
#11 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesComponents.php(103): Illuminate\View\View->render()
#12 /var/www/_bases/base_quaeris_fila4_mono/laravel/storage/framework/views/bbae9269c8cc48f8eeeb47ad9dbd4f6e.php(101): Illuminate\View\Factory->renderComponent()
#13 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Filesystem/Filesystem.php(123): require('...')
#14 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Filesystem/Filesystem.php(124): Illuminate\Filesystem\Filesystem::Illuminate\Filesystem\{closure}()
#15 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Engines/PhpEngine.php(57): Illuminate\Filesystem\Filesystem->getRequire()
#16 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(22): Illuminate\View\Engines\PhpEngine->evaluatePath()
#17 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Engines/CompilerEngine.php(76): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->evaluatePath()
#18 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(10): Illuminate\View\Engines\CompilerEngine->get()
#19 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(208): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->get()
#20 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(191): Illuminate\View\View->getContents()
#21 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(160): Illuminate\View\View->renderContents()
#22 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Response.php(78): Illuminate\View\View->render()
#23 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Response.php(34): Illuminate\Http\Response->setContent()
#24 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(939): Illuminate\Http\Response->__construct()
#25 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php(363): Illuminate\Routing\Router::toResponse()
#26 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(102): Illuminate\Support\Facades\Facade::__callStatic()
#27 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(62): Laravel\Folio\RequestHandler->toResponse()
#28 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Laravel\Folio\RequestHandler->Laravel\Folio\{closure}()
#29 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/Cms/app/Providers/FolioVoltServiceProvider.php(97): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#30 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(201): Modules\Cms\Providers\FolioVoltServiceProvider->Modules\Cms\Providers\{closure}()
#31 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/mcamara/laravel-localization/src/Mcamara/LaravelLocalization/Middleware/LaravelLocalizationRedirectFilter.php(45): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#32 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter->handle()
#33 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/mcamara/laravel-localization/src/Mcamara/LaravelLocalization/Middleware/LocaleSessionRedirect.php(32): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#34 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect->handle()
#35 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/statikbe/laravel-cookie-consent/src/CookieConsentMiddleware.php(13): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#36 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Statikbe\CookieConsent\CookieConsentMiddleware->handle()
#37 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/barryvdh/laravel-debugbar/src/Middleware/InjectDebugbar.php(59): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#38 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Barryvdh\Debugbar\Middleware\InjectDebugbar->handle()
#39 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php(50): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#40 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Routing\Middleware\SubstituteBindings->handle()
#41 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/VerifyCsrfToken.php(87): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#42 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\VerifyCsrfToken->handle()
#43 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Middleware/ShareErrorsFromSession.php(48): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#44 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\View\Middleware\ShareErrorsFromSession->handle()
#45 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(120): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#46 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(63): Illuminate\Session\Middleware\StartSession->handleStatefulRequest()
#47 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Session\Middleware\StartSession->handle()
#48 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/AddQueuedCookiesToResponse.php(36): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#49 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse->handle()
#50 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/EncryptCookies.php(74): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#51 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Cookie\Middleware\EncryptCookies->handle()
#52 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/Xot/app/Http/Middleware/SetDefaultTenantForUrlsMiddleware.php(35): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#53 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Modules\Xot\Http\Middleware\SetDefaultTenantForUrlsMiddleware->handle()
#54 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#55 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(55): Illuminate\Pipeline\Pipeline->then()
#56 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/FolioManager.php(93): Laravel\Folio\RequestHandler->__invoke()
#57 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/CallableDispatcher.php(39): Laravel\Folio\FolioManager->Laravel\Folio\{closure}()
#58 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Route.php(243): Illuminate\Routing\CallableDispatcher->dispatch()
#59 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Route.php(214): Illuminate\Routing\Route->runCallable()
#60 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(822): Illuminate\Routing\Route->run()
#61 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\Routing\Router->Illuminate\Routing\{closure}()
#62 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#63 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(821): Illuminate\Pipeline\Pipeline->then()
#64 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(800): Illuminate\Routing\Router->runRouteWithinStack()
#65 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(764): Illuminate\Routing\Router->runRoute()
#66 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(753): Illuminate\Routing\Router->dispatchToRoute()
#67 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(200): Illuminate\Routing\Router->dispatch()
#68 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\Foundation\Http\Kernel->Illuminate\Foundation\Http\{closure}()
#69 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Features/SupportDisablingBackButtonCache/DisableBackButtonCacheMiddleware.php(19): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#70 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Livewire\Features\SupportDisablingBackButtonCache\DisableBackButtonCacheMiddleware->handle()
#71 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/barryvdh/laravel-debugbar/src/Middleware/InjectDebugbar.php(59): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#72 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Barryvdh\Debugbar\Middleware\InjectDebugbar->handle()
#73 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#74 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php(31): Illuminate\Foundation\Http\Middleware\TransformsRequest->handle()
#75 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull->handle()
#76 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#77 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php(51): Illuminate\Foundation\Http\Middleware\TransformsRequest->handle()
#78 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\TrimStrings->handle()
#79 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePostSize.php(27): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#80 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\ValidatePostSize->handle()
#81 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php(109): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#82 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance->handle()
#83 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php(48): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#84 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\HandleCors->handle()
#85 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php(58): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#86 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\TrustProxies->handle()
#87 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/InvokeDeferredCallbacks.php(22): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#88 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks->handle()
#89 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePathEncoding.php(26): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#90 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\ValidatePathEncoding->handle()
#91 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#92 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(175): Illuminate\Pipeline\Pipeline->then()
#93 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(144): Illuminate\Foundation\Http\Kernel->sendRequestThroughRouter()
#94 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php(607): Illuminate\Foundation\Http\Kernel->handle()
#95 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php(368): Illuminate\Foundation\Testing\TestCase->call()
#96 [internal function]: Illuminate\Foundation\Testing\TestCase->get()
#97 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/Reflection.php(37): ReflectionMethod->invoke()
#98 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/HigherOrderMessage.php(58): Pest\Support\Reflection::call()
#99 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/HigherOrderTapProxy.php(66): Pest\Support\HigherOrderMessage->call()
#100 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest-plugin-laravel/src/Http.php(189): Pest\Support\HigherOrderTapProxy->__call()
#101 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/User/tests/Feature/AuthComponentsTest.php(66): Pest\Laravel\get()
#102 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Factories/TestCaseMethodFactory.php(168): P\Modules\User\tests\Feature\AuthComponentsTest->{closure}()
#103 [internal function]: P\Modules\User\tests\Feature\AuthComponentsTest->Pest\Factories\{closure}()
#104 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(419): call_user_func_array()
#105 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/ExceptionTrace.php(26): P\Modules\User\tests\Feature\AuthComponentsTest->Pest\Concerns\{closure}()
#106 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(419): Pest\Support\ExceptionTrace::ensure()
#107 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(321): P\Modules\User\tests\Feature\AuthComponentsTest->__callClosure()
#108 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Factories/TestCaseFactory.php(169) : eval()'d code(71): P\Modules\User\tests\Feature\AuthComponentsTest->__runTest()
#109 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(1656): P\Modules\User\tests\Feature\AuthComponentsTest->__pest_evaluable__Authentication_Flow_with_Reorganized_Components__→_login_form_components_work_after_reorganization()
#110 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(514): PHPUnit\Framework\TestCase->runTest()
#111 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestRunner/TestRunner.php(87): PHPUnit\Framework\TestCase->runBare()
#112 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(361): PHPUnit\Framework\TestRunner->run()
#113 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestSuite.php(369): PHPUnit\Framework\TestCase->run()
#114 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestSuite.php(369): PHPUnit\Framework\TestSuite->run()
#115 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/TextUI/TestRunner.php(64): PHPUnit\Framework\TestSuite->run()
#116 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/TextUI/Application.php(211): PHPUnit\TextUI\TestRunner->run()
#117 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Kernel.php(103): PHPUnit\TextUI\Application->run()
#118 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/bin/pest(184): Pest\Kernel->handle()
#119 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/bin/pest(192): {closure}()
#120 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/bin/pest(119): include('...')
#121 {main}

Next Illuminate\View\ViewException: Vite manifest not found at: /var/www/_bases/base_quaeris_fila4_mono/public_html/build/manifest.json (View: /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/UI/resources/views/components/layouts/main.blade.php) in /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Vite.php:946
Stack trace:
#0 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(58): Illuminate\View\Engines\CompilerEngine->handleViewException()
#1 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Engines/PhpEngine.php(59): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->handleViewException()
#2 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(22): Illuminate\View\Engines\PhpEngine->evaluatePath()
#3 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Engines/CompilerEngine.php(76): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->evaluatePath()
#4 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(10): Illuminate\View\Engines\CompilerEngine->get()
#5 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(208): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->get()
#6 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(191): Illuminate\View\View->getContents()
#7 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(160): Illuminate\View\View->renderContents()
#8 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesComponents.php(103): Illuminate\View\View->render()
#9 /var/www/_bases/base_quaeris_fila4_mono/laravel/storage/framework/views/bbae9269c8cc48f8eeeb47ad9dbd4f6e.php(101): Illuminate\View\Factory->renderComponent()
#10 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Filesystem/Filesystem.php(123): require('...')
#11 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Filesystem/Filesystem.php(124): Illuminate\Filesystem\Filesystem::Illuminate\Filesystem\{closure}()
#12 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Engines/PhpEngine.php(57): Illuminate\Filesystem\Filesystem->getRequire()
#13 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(22): Illuminate\View\Engines\PhpEngine->evaluatePath()
#14 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Engines/CompilerEngine.php(76): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->evaluatePath()
#15 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(10): Illuminate\View\Engines\CompilerEngine->get()
#16 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(208): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->get()
#17 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(191): Illuminate\View\View->getContents()
#18 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(160): Illuminate\View\View->renderContents()
#19 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Response.php(78): Illuminate\View\View->render()
#20 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Response.php(34): Illuminate\Http\Response->setContent()
#21 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(939): Illuminate\Http\Response->__construct()
#22 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php(363): Illuminate\Routing\Router::toResponse()
#23 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(102): Illuminate\Support\Facades\Facade::__callStatic()
#24 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(62): Laravel\Folio\RequestHandler->toResponse()
#25 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Laravel\Folio\RequestHandler->Laravel\Folio\{closure}()
#26 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/Cms/app/Providers/FolioVoltServiceProvider.php(97): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#27 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(201): Modules\Cms\Providers\FolioVoltServiceProvider->Modules\Cms\Providers\{closure}()
#28 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/mcamara/laravel-localization/src/Mcamara/LaravelLocalization/Middleware/LaravelLocalizationRedirectFilter.php(45): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#29 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter->handle()
#30 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/mcamara/laravel-localization/src/Mcamara/LaravelLocalization/Middleware/LocaleSessionRedirect.php(32): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#31 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect->handle()
#32 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/statikbe/laravel-cookie-consent/src/CookieConsentMiddleware.php(13): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#33 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Statikbe\CookieConsent\CookieConsentMiddleware->handle()
#34 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/barryvdh/laravel-debugbar/src/Middleware/InjectDebugbar.php(59): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#35 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Barryvdh\Debugbar\Middleware\InjectDebugbar->handle()
#36 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php(50): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#37 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Routing\Middleware\SubstituteBindings->handle()
#38 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/VerifyCsrfToken.php(87): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#39 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\VerifyCsrfToken->handle()
#40 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Middleware/ShareErrorsFromSession.php(48): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#41 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\View\Middleware\ShareErrorsFromSession->handle()
#42 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(120): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#43 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(63): Illuminate\Session\Middleware\StartSession->handleStatefulRequest()
#44 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Session\Middleware\StartSession->handle()
#45 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/AddQueuedCookiesToResponse.php(36): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#46 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse->handle()
#47 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/EncryptCookies.php(74): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#48 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Cookie\Middleware\EncryptCookies->handle()
#49 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/Xot/app/Http/Middleware/SetDefaultTenantForUrlsMiddleware.php(35): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#50 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Modules\Xot\Http\Middleware\SetDefaultTenantForUrlsMiddleware->handle()
#51 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#52 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(55): Illuminate\Pipeline\Pipeline->then()
#53 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/FolioManager.php(93): Laravel\Folio\RequestHandler->__invoke()
#54 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/CallableDispatcher.php(39): Laravel\Folio\FolioManager->Laravel\Folio\{closure}()
#55 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Route.php(243): Illuminate\Routing\CallableDispatcher->dispatch()
#56 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Route.php(214): Illuminate\Routing\Route->runCallable()
#57 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(822): Illuminate\Routing\Route->run()
#58 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\Routing\Router->Illuminate\Routing\{closure}()
#59 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#60 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(821): Illuminate\Pipeline\Pipeline->then()
#61 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(800): Illuminate\Routing\Router->runRouteWithinStack()
#62 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(764): Illuminate\Routing\Router->runRoute()
#63 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(753): Illuminate\Routing\Router->dispatchToRoute()
#64 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(200): Illuminate\Routing\Router->dispatch()
#65 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\Foundation\Http\Kernel->Illuminate\Foundation\Http\{closure}()
#66 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Features/SupportDisablingBackButtonCache/DisableBackButtonCacheMiddleware.php(19): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#67 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Livewire\Features\SupportDisablingBackButtonCache\DisableBackButtonCacheMiddleware->handle()
#68 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/barryvdh/laravel-debugbar/src/Middleware/InjectDebugbar.php(59): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#69 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Barryvdh\Debugbar\Middleware\InjectDebugbar->handle()
#70 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#71 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php(31): Illuminate\Foundation\Http\Middleware\TransformsRequest->handle()
#72 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull->handle()
#73 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#74 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php(51): Illuminate\Foundation\Http\Middleware\TransformsRequest->handle()
#75 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\TrimStrings->handle()
#76 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePostSize.php(27): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#77 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\ValidatePostSize->handle()
#78 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php(109): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#79 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance->handle()
#80 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php(48): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#81 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\HandleCors->handle()
#82 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php(58): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#83 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\TrustProxies->handle()
#84 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/InvokeDeferredCallbacks.php(22): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#85 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks->handle()
#86 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePathEncoding.php(26): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#87 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\ValidatePathEncoding->handle()
#88 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#89 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(175): Illuminate\Pipeline\Pipeline->then()
#90 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(144): Illuminate\Foundation\Http\Kernel->sendRequestThroughRouter()
#91 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php(607): Illuminate\Foundation\Http\Kernel->handle()
#92 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php(368): Illuminate\Foundation\Testing\TestCase->call()
#93 [internal function]: Illuminate\Foundation\Testing\TestCase->get()
#94 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/Reflection.php(37): ReflectionMethod->invoke()
#95 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/HigherOrderMessage.php(58): Pest\Support\Reflection::call()
#96 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/HigherOrderTapProxy.php(66): Pest\Support\HigherOrderMessage->call()
#97 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest-plugin-laravel/src/Http.php(189): Pest\Support\HigherOrderTapProxy->__call()
#98 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/User/tests/Feature/AuthComponentsTest.php(66): Pest\Laravel\get()
#99 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Factories/TestCaseMethodFactory.php(168): P\Modules\User\tests\Feature\AuthComponentsTest->{closure}()
#100 [internal function]: P\Modules\User\tests\Feature\AuthComponentsTest->Pest\Factories\{closure}()
#101 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(419): call_user_func_array()
#102 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/ExceptionTrace.php(26): P\Modules\User\tests\Feature\AuthComponentsTest->Pest\Concerns\{closure}()
#103 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(419): Pest\Support\ExceptionTrace::ensure()
#104 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(321): P\Modules\User\tests\Feature\AuthComponentsTest->__callClosure()
#105 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Factories/TestCaseFactory.php(169) : eval()'d code(71): P\Modules\User\tests\Feature\AuthComponentsTest->__runTest()
#106 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(1656): P\Modules\User\tests\Feature\AuthComponentsTest->__pest_evaluable__Authentication_Flow_with_Reorganized_Components__→_login_form_components_work_after_reorganization()
#107 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(514): PHPUnit\Framework\TestCase->runTest()
#108 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestRunner/TestRunner.php(87): PHPUnit\Framework\TestCase->runBare()
#109 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(361): PHPUnit\Framework\TestRunner->run()
#110 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestSuite.php(369): PHPUnit\Framework\TestCase->run()
#111 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestSuite.php(369): PHPUnit\Framework\TestSuite->run()
#112 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/TextUI/TestRunner.php(64): PHPUnit\Framework\TestSuite->run()
#113 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/TextUI/Application.php(211): PHPUnit\TextUI\TestRunner->run()
#114 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Kernel.php(103): PHPUnit\TextUI\Application->run()
#115 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/bin/pest(184): Pest\Kernel->handle()
#116 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/bin/pest(192): {closure}()
#117 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/bin/pest(119): include('...')
#118 {main}

Next Illuminate\View\ViewException: Vite manifest not found at: /var/www/_bases/base_quaeris_fila4_mono/public_html/build/manifest.json (View: /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/UI/resources/views/components/layouts/main.blade.php) (View: /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/UI/resources/views/components/layouts/main.blade.php) in /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Vite.php:946
Stack trace:
#0 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(58): Illuminate\View\Engines\CompilerEngine->handleViewException()
#1 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Engines/PhpEngine.php(59): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->handleViewException()
#2 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(22): Illuminate\View\Engines\PhpEngine->evaluatePath()
#3 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Engines/CompilerEngine.php(76): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->evaluatePath()
#4 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Mechanisms/ExtendBlade/ExtendedCompilerEngine.php(10): Illuminate\View\Engines\CompilerEngine->get()
#5 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(208): Livewire\Mechanisms\ExtendBlade\ExtendedCompilerEngine->get()
#6 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(191): Illuminate\View\View->getContents()
#7 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(160): Illuminate\View\View->renderContents()
#8 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Response.php(78): Illuminate\View\View->render()
#9 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Response.php(34): Illuminate\Http\Response->setContent()
#10 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(939): Illuminate\Http\Response->__construct()
#11 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php(363): Illuminate\Routing\Router::toResponse()
#12 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(102): Illuminate\Support\Facades\Facade::__callStatic()
#13 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(62): Laravel\Folio\RequestHandler->toResponse()
#14 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Laravel\Folio\RequestHandler->Laravel\Folio\{closure}()
#15 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/Cms/app/Providers/FolioVoltServiceProvider.php(97): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#16 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(201): Modules\Cms\Providers\FolioVoltServiceProvider->Modules\Cms\Providers\{closure}()
#17 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/mcamara/laravel-localization/src/Mcamara/LaravelLocalization/Middleware/LaravelLocalizationRedirectFilter.php(45): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#18 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter->handle()
#19 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/mcamara/laravel-localization/src/Mcamara/LaravelLocalization/Middleware/LocaleSessionRedirect.php(32): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#20 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect->handle()
#21 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/statikbe/laravel-cookie-consent/src/CookieConsentMiddleware.php(13): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#22 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Statikbe\CookieConsent\CookieConsentMiddleware->handle()
#23 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/barryvdh/laravel-debugbar/src/Middleware/InjectDebugbar.php(59): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#24 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Barryvdh\Debugbar\Middleware\InjectDebugbar->handle()
#25 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php(50): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#26 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Routing\Middleware\SubstituteBindings->handle()
#27 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/VerifyCsrfToken.php(87): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#28 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\VerifyCsrfToken->handle()
#29 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Middleware/ShareErrorsFromSession.php(48): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#30 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\View\Middleware\ShareErrorsFromSession->handle()
#31 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(120): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#32 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(63): Illuminate\Session\Middleware\StartSession->handleStatefulRequest()
#33 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Session\Middleware\StartSession->handle()
#34 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/AddQueuedCookiesToResponse.php(36): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#35 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse->handle()
#36 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/EncryptCookies.php(74): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#37 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Cookie\Middleware\EncryptCookies->handle()
#38 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/Xot/app/Http/Middleware/SetDefaultTenantForUrlsMiddleware.php(35): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#39 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Modules\Xot\Http\Middleware\SetDefaultTenantForUrlsMiddleware->handle()
#40 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#41 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(55): Illuminate\Pipeline\Pipeline->then()
#42 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/FolioManager.php(93): Laravel\Folio\RequestHandler->__invoke()
#43 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/CallableDispatcher.php(39): Laravel\Folio\FolioManager->Laravel\Folio\{closure}()
#44 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Route.php(243): Illuminate\Routing\CallableDispatcher->dispatch()
#45 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Route.php(214): Illuminate\Routing\Route->runCallable()
#46 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(822): Illuminate\Routing\Route->run()
#47 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\Routing\Router->Illuminate\Routing\{closure}()
#48 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#49 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(821): Illuminate\Pipeline\Pipeline->then()
#50 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(800): Illuminate\Routing\Router->runRouteWithinStack()
#51 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(764): Illuminate\Routing\Router->runRoute()
#52 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(753): Illuminate\Routing\Router->dispatchToRoute()
#53 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(200): Illuminate\Routing\Router->dispatch()
#54 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\Foundation\Http\Kernel->Illuminate\Foundation\Http\{closure}()
#55 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Features/SupportDisablingBackButtonCache/DisableBackButtonCacheMiddleware.php(19): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#56 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Livewire\Features\SupportDisablingBackButtonCache\DisableBackButtonCacheMiddleware->handle()
#57 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/barryvdh/laravel-debugbar/src/Middleware/InjectDebugbar.php(59): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#58 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Barryvdh\Debugbar\Middleware\InjectDebugbar->handle()
#59 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#60 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php(31): Illuminate\Foundation\Http\Middleware\TransformsRequest->handle()
#61 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull->handle()
#62 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#63 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php(51): Illuminate\Foundation\Http\Middleware\TransformsRequest->handle()
#64 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\TrimStrings->handle()
#65 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePostSize.php(27): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#66 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\ValidatePostSize->handle()
#67 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php(109): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#68 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance->handle()
#69 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php(48): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#70 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\HandleCors->handle()
#71 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php(58): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#72 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\TrustProxies->handle()
#73 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/InvokeDeferredCallbacks.php(22): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#74 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks->handle()
#75 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePathEncoding.php(26): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#76 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\ValidatePathEncoding->handle()
#77 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#78 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(175): Illuminate\Pipeline\Pipeline->then()
#79 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(144): Illuminate\Foundation\Http\Kernel->sendRequestThroughRouter()
#80 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php(607): Illuminate\Foundation\Http\Kernel->handle()
#81 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php(368): Illuminate\Foundation\Testing\TestCase->call()
#82 [internal function]: Illuminate\Foundation\Testing\TestCase->get()
#83 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/Reflection.php(37): ReflectionMethod->invoke()
#84 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/HigherOrderMessage.php(58): Pest\Support\Reflection::call()
#85 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/HigherOrderTapProxy.php(66): Pest\Support\HigherOrderMessage->call()
#86 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest-plugin-laravel/src/Http.php(189): Pest\Support\HigherOrderTapProxy->__call()
#87 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/User/tests/Feature/AuthComponentsTest.php(66): Pest\Laravel\get()
#88 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Factories/TestCaseMethodFactory.php(168): P\Modules\User\tests\Feature\AuthComponentsTest->{closure}()
#89 [internal function]: P\Modules\User\tests\Feature\AuthComponentsTest->Pest\Factories\{closure}()
#90 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(419): call_user_func_array()
#91 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/ExceptionTrace.php(26): P\Modules\User\tests\Feature\AuthComponentsTest->Pest\Concerns\{closure}()
#92 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(419): Pest\Support\ExceptionTrace::ensure()
#93 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(321): P\Modules\User\tests\Feature\AuthComponentsTest->__callClosure()
#94 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Factories/TestCaseFactory.php(169) : eval()'d code(71): P\Modules\User\tests\Feature\AuthComponentsTest->__runTest()
#95 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(1656): P\Modules\User\tests\Feature\AuthComponentsTest->__pest_evaluable__Authentication_Flow_with_Reorganized_Components__→_login_form_components_work_after_reorganization()
#96 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(514): PHPUnit\Framework\TestCase->runTest()
#97 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestRunner/TestRunner.php(87): PHPUnit\Framework\TestCase->runBare()
#98 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(361): PHPUnit\Framework\TestRunner->run()
#99 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestSuite.php(369): PHPUnit\Framework\TestCase->run()
#100 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestSuite.php(369): PHPUnit\Framework\TestSuite->run()
#101 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/TextUI/TestRunner.php(64): PHPUnit\Framework\TestSuite->run()
#102 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/TextUI/Application.php(211): PHPUnit\TextUI\TestRunner->run()
#103 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Kernel.php(103): PHPUnit\TextUI\Application->run()
#104 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/bin/pest(184): Pest\Kernel->handle()
#105 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/bin/pest(192): {closure}()
#106 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/bin/pest(119): include('...')
#107 {main}

----------------------------------------------------------------------------------

Vite manifest not found at: /var/www/_bases/base_quaeris_fila4_mono/public_html/build/manifest.json (View: /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/UI/resources/views/components/layouts/main.blade.php) (View: /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/UI/resources/views/components/layouts/main.blade.php)

  at Modules/User/tests/Feature/AuthComponentsTest.php:69
     65▕         // Visit login page and ensure all reorganized components render
     66▕         $response = get('/it/auth/login');
     67▕ 
     68▕         /* @phpstan-ignore-next-line method.nonObject */
  ➜  69▕         $response->assertStatus(200);
     70▕         /* @phpstan-ignore-next-line method.nonObject */
     71▕         $response->assertSee('Login');
     72▕     });
     73▕

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\AuthComponentsTest > `Authentication F…   
  Expected response status code [200] but received 500.
Failed asserting that 500 is identical to 200.

The following exception occurred during the last request:

InvalidArgumentException: Database connection [quaeris] not configured. in /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Database/DatabaseManager.php:221
Stack trace:
#0 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Database/DatabaseManager.php(187): Illuminate\Database\DatabaseManager->configuration()
#1 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Database/DatabaseManager.php(102): Illuminate\Database\DatabaseManager->makeConnection()
#2 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(1980): Illuminate\Database\DatabaseManager->connection()
#3 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(1946): Illuminate\Database\Eloquent\Model::resolveConnection()
#4 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(1713): Illuminate\Database\Eloquent\Model->getConnection()
#5 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(1611): Illuminate\Database\Eloquent\Model->newBaseQueryBuilder()
#6 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(1647): Illuminate\Database\Eloquent\Model->newModelQuery()
#7 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(1600): Illuminate\Database\Eloquent\Model->newQueryWithoutScopes()
#8 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(2540): Illuminate\Database\Eloquent\Model->newQuery()
#9 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/Xot/app/Datas/XotData.php(261): Illuminate\Database\Eloquent\Model->__call()
#10 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/Xot/app/Datas/XotData.php(301): Modules\Xot\Datas\XotData->getProfileModelByUserId()
#11 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/Xot/app/View/Composers/XotComposer.php(81): Modules\Xot\Datas\XotData->getProfileModel()
#12 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesEvents.php(124): Modules\Xot\View\Composers\XotComposer->compose()
#13 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesEvents.php(162): Illuminate\View\Factory->Illuminate\View\Concerns\{closure}()
#14 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Events/Dispatcher.php(485): Illuminate\View\Factory->Illuminate\View\Concerns\{closure}()
#15 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Events/Dispatcher.php(315): Illuminate\Events\Dispatcher->Illuminate\Events\{closure}()
#16 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Events/Dispatcher.php(295): Illuminate\Events\Dispatcher->invokeListeners()
#17 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesEvents.php(178): Illuminate\Events\Dispatcher->dispatch()
#18 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(189): Illuminate\View\Factory->callComposer()
#19 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(160): Illuminate\View\View->renderContents()
#20 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/statikbe/laravel-cookie-consent/src/CookieConsentMiddleware.php(43): Illuminate\View\View->render()
#21 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/statikbe/laravel-cookie-consent/src/CookieConsentMiddleware.php(27): Statikbe\CookieConsent\CookieConsentMiddleware->addCookieConsentScriptToResponse()
#22 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Statikbe\CookieConsent\CookieConsentMiddleware->handle()
#23 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/barryvdh/laravel-debugbar/src/Middleware/InjectDebugbar.php(59): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#24 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Barryvdh\Debugbar\Middleware\InjectDebugbar->handle()
#25 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php(50): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#26 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Routing\Middleware\SubstituteBindings->handle()
#27 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/VerifyCsrfToken.php(87): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#28 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\VerifyCsrfToken->handle()
#29 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Middleware/ShareErrorsFromSession.php(48): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#30 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\View\Middleware\ShareErrorsFromSession->handle()
#31 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(120): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#32 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(63): Illuminate\Session\Middleware\StartSession->handleStatefulRequest()
#33 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Session\Middleware\StartSession->handle()
#34 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/AddQueuedCookiesToResponse.php(36): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#35 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse->handle()
#36 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/EncryptCookies.php(74): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#37 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Cookie\Middleware\EncryptCookies->handle()
#38 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/Xot/app/Http/Middleware/SetDefaultTenantForUrlsMiddleware.php(35): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#39 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Modules\Xot\Http\Middleware\SetDefaultTenantForUrlsMiddleware->handle()
#40 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#41 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(55): Illuminate\Pipeline\Pipeline->then()
#42 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/FolioManager.php(93): Laravel\Folio\RequestHandler->__invoke()
#43 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/CallableDispatcher.php(39): Laravel\Folio\FolioManager->Laravel\Folio\{closure}()
#44 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Route.php(243): Illuminate\Routing\CallableDispatcher->dispatch()
#45 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Route.php(214): Illuminate\Routing\Route->runCallable()
#46 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(822): Illuminate\Routing\Route->run()
#47 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\Routing\Router->Illuminate\Routing\{closure}()
#48 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#49 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(821): Illuminate\Pipeline\Pipeline->then()
#50 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(800): Illuminate\Routing\Router->runRouteWithinStack()
#51 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(764): Illuminate\Routing\Router->runRoute()
#52 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(753): Illuminate\Routing\Router->dispatchToRoute()
#53 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(200): Illuminate\Routing\Router->dispatch()
#54 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\Foundation\Http\Kernel->Illuminate\Foundation\Http\{closure}()
#55 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Features/SupportDisablingBackButtonCache/DisableBackButtonCacheMiddleware.php(19): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#56 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Livewire\Features\SupportDisablingBackButtonCache\DisableBackButtonCacheMiddleware->handle()
#57 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/barryvdh/laravel-debugbar/src/Middleware/InjectDebugbar.php(59): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#58 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Barryvdh\Debugbar\Middleware\InjectDebugbar->handle()
#59 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#60 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php(31): Illuminate\Foundation\Http\Middleware\TransformsRequest->handle()
#61 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull->handle()
#62 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#63 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php(51): Illuminate\Foundation\Http\Middleware\TransformsRequest->handle()
#64 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\TrimStrings->handle()
#65 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePostSize.php(27): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#66 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\ValidatePostSize->handle()
#67 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php(109): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#68 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance->handle()
#69 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php(48): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#70 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\HandleCors->handle()
#71 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php(58): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#72 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\TrustProxies->handle()
#73 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/InvokeDeferredCallbacks.php(22): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#74 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks->handle()
#75 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePathEncoding.php(26): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#76 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\ValidatePathEncoding->handle()
#77 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#78 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(175): Illuminate\Pipeline\Pipeline->then()
#79 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(144): Illuminate\Foundation\Http\Kernel->sendRequestThroughRouter()
#80 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php(607): Illuminate\Foundation\Http\Kernel->handle()
#81 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php(368): Illuminate\Foundation\Testing\TestCase->call()
#82 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/User/tests/Feature/AuthComponentsTest.php(79): Illuminate\Foundation\Testing\TestCase->get()
#83 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Factories/TestCaseMethodFactory.php(168): P\Modules\User\tests\Feature\AuthComponentsTest->{closure}()
#84 [internal function]: P\Modules\User\tests\Feature\AuthComponentsTest->Pest\Factories\{closure}()
#85 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(419): call_user_func_array()
#86 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/ExceptionTrace.php(26): P\Modules\User\tests\Feature\AuthComponentsTest->Pest\Concerns\{closure}()
#87 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(419): Pest\Support\ExceptionTrace::ensure()
#88 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(321): P\Modules\User\tests\Feature\AuthComponentsTest->__callClosure()
#89 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Factories/TestCaseFactory.php(169) : eval()'d code(80): P\Modules\User\tests\Feature\AuthComponentsTest->__runTest()
#90 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(1656): P\Modules\User\tests\Feature\AuthComponentsTest->__pest_evaluable__Authentication_Flow_with_Reorganized_Components__→_password_confirmation_uses_reorganized_components()
#91 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(514): PHPUnit\Framework\TestCase->runTest()
#92 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestRunner/TestRunner.php(87): PHPUnit\Framework\TestCase->runBare()
#93 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(361): PHPUnit\Framework\TestRunner->run()
#94 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestSuite.php(369): PHPUnit\Framework\TestCase->run()
#95 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestSuite.php(369): PHPUnit\Framework\TestSuite->run()
#96 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/TextUI/TestRunner.php(64): PHPUnit\Framework\TestSuite->run()
#97 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/TextUI/Application.php(211): PHPUnit\TextUI\TestRunner->run()
#98 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Kernel.php(103): PHPUnit\TextUI\Application->run()
#99 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/bin/pest(184): Pest\Kernel->handle()
#100 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/bin/pest(192): {closure}()
#101 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/bin/pest(119): include('...')
#102 {main}

----------------------------------------------------------------------------------

Database connection [quaeris] not configured.

  at Modules/User/tests/Feature/AuthComponentsTest.php:80
     76▕         $user = User/* @phpstan-ignore-line */ ::factory()->create();
     77▕ 
     78▕         actingAs($user)
     79▕             ->get('/it/auth/password/confirm')
  ➜  80▕             ->assertStatus(200);
     81▕     });
     82▕ });
     83▕ 
     84▕ describe('User Profile Components Tests', function (): void {

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\AuthComponentsTest > `User Profile Com…   
  Expected response status code [200] but received 500.
Failed asserting that 500 is identical to 200.

The following exception occurred during the last request:

InvalidArgumentException: Database connection [quaeris] not configured. in /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Database/DatabaseManager.php:221
Stack trace:
#0 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Database/DatabaseManager.php(187): Illuminate\Database\DatabaseManager->configuration()
#1 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Database/DatabaseManager.php(102): Illuminate\Database\DatabaseManager->makeConnection()
#2 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(1980): Illuminate\Database\DatabaseManager->connection()
#3 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(1946): Illuminate\Database\Eloquent\Model::resolveConnection()
#4 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(1713): Illuminate\Database\Eloquent\Model->getConnection()
#5 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(1611): Illuminate\Database\Eloquent\Model->newBaseQueryBuilder()
#6 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(1647): Illuminate\Database\Eloquent\Model->newModelQuery()
#7 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(1600): Illuminate\Database\Eloquent\Model->newQueryWithoutScopes()
#8 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(2540): Illuminate\Database\Eloquent\Model->newQuery()
#9 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/Xot/app/Datas/XotData.php(261): Illuminate\Database\Eloquent\Model->__call()
#10 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/Xot/app/Datas/XotData.php(301): Modules\Xot\Datas\XotData->getProfileModelByUserId()
#11 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/Xot/app/View/Composers/XotComposer.php(81): Modules\Xot\Datas\XotData->getProfileModel()
#12 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesEvents.php(124): Modules\Xot\View\Composers\XotComposer->compose()
#13 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesEvents.php(162): Illuminate\View\Factory->Illuminate\View\Concerns\{closure}()
#14 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Events/Dispatcher.php(485): Illuminate\View\Factory->Illuminate\View\Concerns\{closure}()
#15 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Events/Dispatcher.php(315): Illuminate\Events\Dispatcher->Illuminate\Events\{closure}()
#16 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Events/Dispatcher.php(295): Illuminate\Events\Dispatcher->invokeListeners()
#17 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesEvents.php(178): Illuminate\Events\Dispatcher->dispatch()
#18 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(189): Illuminate\View\Factory->callComposer()
#19 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/View.php(160): Illuminate\View\View->renderContents()
#20 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/statikbe/laravel-cookie-consent/src/CookieConsentMiddleware.php(43): Illuminate\View\View->render()
#21 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/statikbe/laravel-cookie-consent/src/CookieConsentMiddleware.php(27): Statikbe\CookieConsent\CookieConsentMiddleware->addCookieConsentScriptToResponse()
#22 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Statikbe\CookieConsent\CookieConsentMiddleware->handle()
#23 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/barryvdh/laravel-debugbar/src/Middleware/InjectDebugbar.php(59): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#24 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Barryvdh\Debugbar\Middleware\InjectDebugbar->handle()
#25 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php(50): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#26 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Routing\Middleware\SubstituteBindings->handle()
#27 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Auth/Middleware/Authenticate.php(63): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#28 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Auth\Middleware\Authenticate->handle()
#29 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/VerifyCsrfToken.php(87): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#30 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\VerifyCsrfToken->handle()
#31 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/View/Middleware/ShareErrorsFromSession.php(48): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#32 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\View\Middleware\ShareErrorsFromSession->handle()
#33 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(120): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#34 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(63): Illuminate\Session\Middleware\StartSession->handleStatefulRequest()
#35 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Session\Middleware\StartSession->handle()
#36 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/AddQueuedCookiesToResponse.php(36): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#37 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse->handle()
#38 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/EncryptCookies.php(74): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#39 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Cookie\Middleware\EncryptCookies->handle()
#40 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/Xot/app/Http/Middleware/SetDefaultTenantForUrlsMiddleware.php(35): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#41 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Modules\Xot\Http\Middleware\SetDefaultTenantForUrlsMiddleware->handle()
#42 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#43 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/RequestHandler.php(55): Illuminate\Pipeline\Pipeline->then()
#44 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/folio/src/FolioManager.php(93): Laravel\Folio\RequestHandler->__invoke()
#45 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/CallableDispatcher.php(39): Laravel\Folio\FolioManager->Laravel\Folio\{closure}()
#46 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Route.php(243): Illuminate\Routing\CallableDispatcher->dispatch()
#47 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Route.php(214): Illuminate\Routing\Route->runCallable()
#48 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(822): Illuminate\Routing\Route->run()
#49 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\Routing\Router->Illuminate\Routing\{closure}()
#50 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#51 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(821): Illuminate\Pipeline\Pipeline->then()
#52 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(800): Illuminate\Routing\Router->runRouteWithinStack()
#53 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(764): Illuminate\Routing\Router->runRoute()
#54 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Routing/Router.php(753): Illuminate\Routing\Router->dispatchToRoute()
#55 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(200): Illuminate\Routing\Router->dispatch()
#56 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\Foundation\Http\Kernel->Illuminate\Foundation\Http\{closure}()
#57 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/livewire/livewire/src/Features/SupportDisablingBackButtonCache/DisableBackButtonCacheMiddleware.php(19): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#58 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Livewire\Features\SupportDisablingBackButtonCache\DisableBackButtonCacheMiddleware->handle()
#59 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/barryvdh/laravel-debugbar/src/Middleware/InjectDebugbar.php(59): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#60 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Barryvdh\Debugbar\Middleware\InjectDebugbar->handle()
#61 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#62 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php(31): Illuminate\Foundation\Http\Middleware\TransformsRequest->handle()
#63 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull->handle()
#64 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#65 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php(51): Illuminate\Foundation\Http\Middleware\TransformsRequest->handle()
#66 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\TrimStrings->handle()
#67 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePostSize.php(27): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#68 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\ValidatePostSize->handle()
#69 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php(109): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#70 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance->handle()
#71 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php(48): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#72 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\HandleCors->handle()
#73 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php(58): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#74 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\TrustProxies->handle()
#75 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/InvokeDeferredCallbacks.php(22): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#76 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks->handle()
#77 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePathEncoding.php(26): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#78 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\Http\Middleware\ValidatePathEncoding->handle()
#79 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}()
#80 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(175): Illuminate\Pipeline\Pipeline->then()
#81 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(144): Illuminate\Foundation\Http\Kernel->sendRequestThroughRouter()
#82 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php(607): Illuminate\Foundation\Http\Kernel->handle()
#83 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php(368): Illuminate\Foundation\Testing\TestCase->call()
#84 /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/User/tests/Feature/AuthComponentsTest.php(89): Illuminate\Foundation\Testing\TestCase->get()
#85 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Factories/TestCaseMethodFactory.php(168): P\Modules\User\tests\Feature\AuthComponentsTest->{closure}()
#86 [internal function]: P\Modules\User\tests\Feature\AuthComponentsTest->Pest\Factories\{closure}()
#87 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(419): call_user_func_array()
#88 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Support/ExceptionTrace.php(26): P\Modules\User\tests\Feature\AuthComponentsTest->Pest\Concerns\{closure}()
#89 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(419): Pest\Support\ExceptionTrace::ensure()
#90 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Concerns/Testable.php(321): P\Modules\User\tests\Feature\AuthComponentsTest->__callClosure()
#91 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Factories/TestCaseFactory.php(169) : eval()'d code(89): P\Modules\User\tests\Feature\AuthComponentsTest->__runTest()
#92 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(1656): P\Modules\User\tests\Feature\AuthComponentsTest->__pest_evaluable__User_Profile_Components_Tests__→_profile_pages_use_reorganized_components_correctly()
#93 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(514): PHPUnit\Framework\TestCase->runTest()
#94 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestRunner/TestRunner.php(87): PHPUnit\Framework\TestCase->runBare()
#95 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestCase.php(361): PHPUnit\Framework\TestRunner->run()
#96 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestSuite.php(369): PHPUnit\Framework\TestCase->run()
#97 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/Framework/TestSuite.php(369): PHPUnit\Framework\TestSuite->run()
#98 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/TextUI/TestRunner.php(64): PHPUnit\Framework\TestSuite->run()
#99 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/phpunit/phpunit/src/TextUI/Application.php(211): PHPUnit\TextUI\TestRunner->run()
#100 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/src/Kernel.php(103): PHPUnit\TextUI\Application->run()
#101 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/bin/pest(184): Pest\Kernel->handle()
#102 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/pestphp/pest/bin/pest(192): {closure}()
#103 /var/www/_bases/base_quaeris_fila4_mono/laravel/vendor/bin/pest(119): include('...')
#104 {main}

----------------------------------------------------------------------------------

Database connection [quaeris] not configured.

  at Modules/User/tests/Feature/AuthComponentsTest.php:92
     88▕ 
     89▕         $response = actingAs($user)->get('/it/profile/edit');
     90▕ 
     91▕         /* @phpstan-ignore-next-line method.nonObject */
  ➜  92▕         $response->assertStatus(200);
     93▕     });
     94▕ });
     95▕

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Au…  UniqueConstraintViolationException   
  SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'edit posts-web' for key 'permissions.permissions_name_guard_name_unique' (Connection: user, Host: 127.0.0.1, Port: 3306, Database: quaeris_user_test, SQL: insert into `permissions` (`name`, `guard_name`, `updated_at`, `created_at`) values (edit posts, web, 2026-01-17 17:58:02, 2026-01-17 17:58:02))

  at vendor/laravel/framework/src/Illuminate/Database/MySqlConnection.php:53
     49▕             $this->bindValues($statement, $this->prepareBindings($bindings));
     50▕ 
     51▕             $this->recordsHaveBeenModified();
     52▕ 
  ➜  53▕             $result = $statement->execute();
     54▕ 
     55▕             $this->lastInsertId = $this->getPdo()->lastInsertId($sequence);
     56▕ 
     57▕             return $result;

      [2m+15 vendor frames [22m
  16  Modules/User/tests/Feature/Authentication/UserAuthenticationTest.php:213

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Au…  UniqueConstraintViolationException   
  SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'edit posts-web' for key 'permissions.permissions_name_guard_name_unique' (Connection: user, Host: 127.0.0.1, Port: 3306, Database: quaeris_user_test, SQL: insert into `permissions` (`name`, `guard_name`, `updated_at`, `created_at`) values (edit posts, web, 2026-01-17 17:58:03, 2026-01-17 17:58:03))

  at vendor/laravel/framework/src/Illuminate/Database/MySqlConnection.php:53
     49▕             $this->bindValues($statement, $this->prepareBindings($bindings));
     50▕ 
     51▕             $this->recordsHaveBeenModified();
     52▕ 
  ➜  53▕             $result = $statement->execute();
     54▕ 
     55▕             $this->lastInsertId = $this->getPdo()->lastInsertId($sequence);
     56▕ 
     57▕             return $result;

      [2m+15 vendor frames [22m
  16  Modules/User/tests/Feature/Authentication/UserAuthenticationTest.php:225

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Au…  UniqueConstraintViolationException   
  SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'edit posts-web' for key 'permissions.permissions_name_guard_name_unique' (Connection: user, Host: 127.0.0.1, Port: 3306, Database: quaeris_user_test, SQL: insert into `permissions` (`name`, `guard_name`, `updated_at`, `created_at`) values (edit posts, web, 2026-01-17 17:58:03, 2026-01-17 17:58:03))

  at vendor/laravel/framework/src/Illuminate/Database/MySqlConnection.php:53
     49▕             $this->bindValues($statement, $this->prepareBindings($bindings));
     50▕ 
     51▕             $this->recordsHaveBeenModified();
     52▕ 
  ➜  53▕             $result = $statement->execute();
     54▕ 
     55▕             $this->lastInsertId = $this->getPdo()->lastInsertId($sequence);
     56▕ 
     57▕             return $result;

      [2m+15 vendor frames [22m
  16  Modules/User/tests/Feature/Authentication/UserAuthenticationTest.php:234

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Au…  UniqueConstraintViolationException   
  SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'edit posts-web' for key 'permissions.permissions_name_guard_name_unique' (Connection: user, Host: 127.0.0.1, Port: 3306, Database: quaeris_user_test, SQL: insert into `permissions` (`name`, `guard_name`, `updated_at`, `created_at`) values (edit posts, web, 2026-01-17 17:58:03, 2026-01-17 17:58:03))

  at vendor/laravel/framework/src/Illuminate/Database/MySqlConnection.php:53
     49▕             $this->bindValues($statement, $this->prepareBindings($bindings));
     50▕ 
     51▕             $this->recordsHaveBeenModified();
     52▕ 
  ➜  53▕             $result = $statement->execute();
     54▕ 
     55▕             $this->lastInsertId = $this->getPdo()->lastInsertId($sequence);
     56▕ 
     57▕             return $result;

      [2m+15 vendor frames [22m
  16  Modules/User/tests/Feature/Authentication/UserAuthenticationTest.php:245

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\ChangeProfil…  InvalidArgumentException   
  Database connection [quaeris] not configured.

  at vendor/laravel/framework/src/Illuminate/Database/DatabaseManager.php:221
    217▕ 
    218▕         $config = $this->dynamicConnectionConfigurations[$name] ?? Arr::get($connections, $name);
    219▕ 
    220▕         if (is_null($config)) {
  ➜ 221▕             throw new InvalidArgumentException("Database connection [{$name}] not configured.");
    222▕         }
    223▕ 
    224▕         return (new ConfigurationUrlParser)
    225▕             ->parseConfiguration($config);

      [2m+10 vendor frames [22m
  11  Modules/Xot/app/Datas/XotData.php:261
  12  Modules/Xot/app/Datas/XotData.php:301

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\ChangeProfil…  InvalidArgumentException   
  Database connection [quaeris] not configured.

  at vendor/laravel/framework/src/Illuminate/Database/DatabaseManager.php:221
    217▕ 
    218▕         $config = $this->dynamicConnectionConfigurations[$name] ?? Arr::get($connections, $name);
    219▕ 
    220▕         if (is_null($config)) {
  ➜ 221▕             throw new InvalidArgumentException("Database connection [{$name}] not configured.");
    222▕         }
    223▕ 
    224▕         return (new ConfigurationUrlParser)
    225▕             ->parseConfiguration($config);

      [2m+10 vendor frames [22m
  11  Modules/Xot/app/Datas/XotData.php:261
  12  Modules/Xot/app/Datas/XotData.php:301

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\Actio…  BadMethodCallException   
  Method Modules\User\Filament\Actions\ChangePasswordAction::setUp does not exist.

  at vendor/filament/support/src/Concerns/Macroable.php:77
     73▕     {
     74▕         $macro = static::getMacro($method);
     75▕ 
     76▕         if ($macro === null) {
  ➜  77▕             throw new BadMethodCallException(sprintf(
     78▕                 'Method %s::%s does not exist.',
     79▕                 static::class,
     80▕                 $method,
     81▕             ));

      [2m+1 vendor frames [22m
  2   Modules/User/tests/Feature/Filament/Actions/ChangePasswordActionTest.php:35

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\Actio…  BadMethodCallException   
  Method Modules\User\Filament\Actions\ChangePasswordAction::setUp does not exist.

  at vendor/filament/support/src/Concerns/Macroable.php:77
     73▕     {
     74▕         $macro = static::getMacro($method);
     75▕ 
     76▕         if ($macro === null) {
  ➜  77▕             throw new BadMethodCallException(sprintf(
     78▕                 'Method %s::%s does not exist.',
     79▕                 static::class,
     80▕                 $method,
     81▕             ));

      [2m+1 vendor frames [22m
  2   Modules/User/tests/Feature/Filament/Actions/ChangePasswordActionTest.php:42

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\Actio…  BadMethodCallException   
  Method Modules\User\Filament\Actions\ChangePasswordAction::setUp does not exist.

  at vendor/filament/support/src/Concerns/Macroable.php:77
     73▕     {
     74▕         $macro = static::getMacro($method);
     75▕ 
     76▕         if ($macro === null) {
  ➜  77▕             throw new BadMethodCallException(sprintf(
     78▕                 'Method %s::%s does not exist.',
     79▕                 static::class,
     80▕                 $method,
     81▕             ));

      [2m+1 vendor frames [22m
  2   Modules/User/tests/Feature/Filament/Actions/ChangePasswordActionTest.php:49

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\Actio…  BadMethodCallException   
  Method Modules\User\Filament\Actions\ChangePasswordAction::setUp does not exist.

  at vendor/filament/support/src/Concerns/Macroable.php:77
     73▕     {
     74▕         $macro = static::getMacro($method);
     75▕ 
     76▕         if ($macro === null) {
  ➜  77▕             throw new BadMethodCallException(sprintf(
     78▕                 'Method %s::%s does not exist.',
     79▕                 static::class,
     80▕                 $method,
     81▕             ));

      [2m+1 vendor frames [22m
  2   Modules/User/tests/Feature/Filament/Actions/ChangePasswordActionTest.php:56

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\Actio…  BadMethodCallException   
  Method Modules\User\Filament\Actions\ChangePasswordAction::setUp does not exist.

  at vendor/filament/support/src/Concerns/Macroable.php:77
     73▕     {
     74▕         $macro = static::getMacro($method);
     75▕ 
     76▕         if ($macro === null) {
  ➜  77▕             throw new BadMethodCallException(sprintf(
     78▕                 'Method %s::%s does not exist.',
     79▕                 static::class,
     80▕                 $method,
     81▕             ));

      [2m+1 vendor frames [22m
  2   Modules/User/tests/Feature/Filament/Actions/ChangePasswordActionTest.php:63

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\Actio…  BadMethodCallException   
  Method Modules\User\Filament\Actions\ChangePasswordAction::setUp does not exist.

  at vendor/filament/support/src/Concerns/Macroable.php:77
     73▕     {
     74▕         $macro = static::getMacro($method);
     75▕ 
     76▕         if ($macro === null) {
  ➜  77▕             throw new BadMethodCallException(sprintf(
     78▕                 'Method %s::%s does not exist.',
     79▕                 static::class,
     80▕                 $method,
     81▕             ));

      [2m+1 vendor frames [22m
  2   Modules/User/tests/Feature/Filament/Actions/ChangePasswordActionTest.php:70

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\Actio…  BadMethodCallException   
  Method Modules\User\Filament\Actions\ChangePasswordAction::setUp does not exist.

  at vendor/filament/support/src/Concerns/Macroable.php:77
     73▕     {
     74▕         $macro = static::getMacro($method);
     75▕ 
     76▕         if ($macro === null) {
  ➜  77▕             throw new BadMethodCallException(sprintf(
     78▕                 'Method %s::%s does not exist.',
     79▕                 static::class,
     80▕                 $method,
     81▕             ));

      [2m+1 vendor frames [22m
  2   Modules/User/tests/Feature/Filament/Actions/ChangePasswordActionTest.php:77

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\Actio…  BadMethodCallException   
  Method Modules\User\Filament\Actions\ChangePasswordAction::setUp does not exist.

  at vendor/filament/support/src/Concerns/Macroable.php:77
     73▕     {
     74▕         $macro = static::getMacro($method);
     75▕ 
     76▕         if ($macro === null) {
  ➜  77▕             throw new BadMethodCallException(sprintf(
     78▕                 'Method %s::%s does not exist.',
     79▕                 static::class,
     80▕                 $method,
     81▕             ));

      [2m+1 vendor frames [22m
  2   Modules/User/tests/Feature/Filament/Actions/ChangePasswordActionTest.php:84

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\Actio…  BadMethodCallException   
  Method Modules\User\Filament\Actions\ChangePasswordAction::setUp does not exist.

  at vendor/filament/support/src/Concerns/Macroable.php:77
     73▕     {
     74▕         $macro = static::getMacro($method);
     75▕ 
     76▕         if ($macro === null) {
  ➜  77▕             throw new BadMethodCallException(sprintf(
     78▕                 'Method %s::%s does not exist.',
     79▕                 static::class,
     80▕                 $method,
     81▕             ));

      [2m+1 vendor frames [22m
  2   Modules/User/tests/Feature/Filament/Actions/ChangePasswordActionTest.php:91

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Fi…  UniqueConstraintViolationException   
  SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'test4300@mail.com' for key 'users.users_email_unique' (Connection: user, Host: 127.0.0.1, Port: 3306, Database: quaeris_user_test, SQL: insert into `users` (`is_active`, `first_name`, `last_name`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `lang`, `is_otp`, `password_expires_at`, `type`, `id`, `updated_at`, `created_at`) values (1, Antonio, Russo, Giuseppe Bianchi, test4300@mail.com, 2026-01-17 17:58:18, $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi, UHHUcJpAfX, de, 0, 2026-06-06 17:58:18, master_admin, 019bcce4-b04c-7166-a8a4-a96175a7258d, 2026-01-17 17:58:18, 2026-01-17 17:58:18))

  at vendor/laravel/framework/src/Illuminate/Database/MySqlConnection.php:53
     49▕             $this->bindValues($statement, $this->prepareBindings($bindings));
     50▕ 
     51▕             $this->recordsHaveBeenModified();
     52▕ 
  ➜  53▕             $result = $statement->execute();
     54▕ 
     55▕             $this->lastInsertId = $this->getPdo()->lastInsertId($sequence);
     56▕ 
     57▕             return $result;

      [2m+13 vendor frames [22m
  14  Modules/User/tests/Feature/Filament/Pages/ListUsersTest.php:35

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\Resources\Use…  ErrorException   
  Undefined variable $createUserPage

  at Modules/User/tests/Feature/Filament/Resources/UserResourceTest.php:129
    125▕     $section01Schema = $section01->getDefaultChildComponents();
    126▕ 
    127▕     $passwordField = collect($section01Schema)->first(fn ($c) => 'password' === $c->getName());
    128▕ 
  ➜ 129▕     expect($passwordField->isRequired($createUserPage))->toBeTrue();
    130▕ 
    131▕     // Test with EditUser page
    132▕     $editUserPage = new EditUser();
    133▕     expect($passwordField->isRequired($editUserPage))->toBeFalse();

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\Resources\UserResource…  Error   
  Typed property Filament\Schemas\Components\Component::$container must not be accessed before initialization

  at vendor/filament/schemas/src/Components/Concerns/BelongsToContainer.php:24
     20▕     }
     21▕ 
     22▕     public function getContainer(): Schema
     23▕     {
  ➜  24▕         return $this->container;
     25▕     }
     26▕ 
     27▕     public function getRootContainer(): Schema
     28▕     {

      [2m+6 vendor frames [22m
  7   Modules/User/tests/Feature/Filament/Resources/UserResourceTest.php:154

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\Resources\UserResource…  Error   
  Typed property Filament\Schemas\Components\Component::$container must not be accessed before initialization

  at vendor/filament/schemas/src/Components/Concerns/BelongsToContainer.php:24
     20▕     }
     21▕ 
     22▕     public function getContainer(): Schema
     23▕     {
  ➜  24▕         return $this->container;
     25▕     }
     26▕ 
     27▕     public function getRootContainer(): Schema
     28▕     {

      [2m+8 vendor frames [22m
  9   Modules/User/tests/Feature/Filament/Resources/UserResourceTest.php:166

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\U…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/Filament/UserResourceTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\Filament\Widgets\LoginWidgetTest > it…    
  Expected: user::filament.widgets.login

  To contain: pub_theme::filament.widgets.auth.login

  at Modules/User/tests/Feature/Filament/Widgets/LoginWidgetTest.php:28
     24▕     $property = $reflection->getProperty('view');
     25▕     $property->setAccessible(true);
     26▕     $view = $property->getValue($widget);
     27▕ 
  ➜  28▕     expect($view)->toContain('pub_theme::filament.widgets.auth.login');
     29▕ });
     30▕ 
     31▕ test('it has correct form schema', function (): void {
     32▕     $form = $this->widget->getFormSchema();

  1   Modules/User/tests/Feature/Filament/Widgets/LoginWidgetTest.php:28

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\MigrateDbTes…  InvalidArgumentException   
  Database connection [xot] not configured.

  at vendor/laravel/framework/src/Illuminate/Database/DatabaseManager.php:221
    217▕ 
    218▕         $config = $this->dynamicConnectionConfigurations[$name] ?? Arr::get($connections, $name);
    219▕ 
    220▕         if (is_null($config)) {
  ➜ 221▕             throw new InvalidArgumentException("Database connection [{$name}] not configured.");
    222▕         }
    223▕ 
    224▕         return (new ConfigurationUrlParser)
    225▕             ->parseConfiguration($config);

      [2m+39 vendor frames [22m
  40  Modules/User/tests/Feature/MigrateDbTest.php:18

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\PasswordDataLabelsTest…   ViewException   
  Route [social.redirect] not defined. (View: /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/User/resources/views/livewire/auth/login.blade.php) (View: /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/User/resources/views/livewire/auth/login.blade.php)

  at vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:526
    522▕             ! is_null($url = call_user_func($this->missingNamedRouteResolver, $name, $parameters, $absolute))) {
    523▕             return $url;
    524▕         }
    525▕ 
  ➜ 526▕         throw new RouteNotFoundException("Route [{$name}] not defined.");
    527▕     }
    528▕ 
    529▕     /**
    530▕      * Get the URL for a given route instance.

      [2m+6 vendor frames [22m
  7   storage/framework/views/3a9dd3fc04e2c2b4c403c52b9b806e87.php:112
      [2m+13 vendor frames [22m
  21  storage/framework/views/6174aaa9ffbb913d058e8fbab4d3174c.php:11

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TeamManagementBusinessLogicTest > it c…   
  Failed asserting that '{"read":true,"write":true,"delete":true}' is of type array.

  at Modules/User/tests/Feature/TeamManagementBusinessLogicTest.php:110
    106▕     $userPermissions = $team->teamUsers()->where('user_id', $user->id)->first()->permissions;
    107▕ 
    108▕     // Assert
    109▕     expect($userPermissions)
  ➜ 110▕         ->toBeArray()
    111▕         ->toHaveKey('read')
    112▕         ->toHaveKey('write')
    113▕         ->toHaveKey('delete');
    114▕ });

  1   Modules/User/tests/Feature/TeamManagementBusinessLogicTest.php:110

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TeamManagementBusinessLogicTest > it c…   
  Failed asserting that false is true.

  at Modules/User/tests/Feature/TeamManagementBusinessLogicTest.php:128
    124▕         'permissions' => json_encode(['read' => true, 'write' => true]),
    125▕     ]);
    126▕ 
    127▕     // Act & Assert
  ➜ 128▕     expect($team->userHasPermission($user, 'read'))->toBeTrue();
    129▕     expect($team->userHasPermission($user, 'write'))->toBeTrue();
    130▕     expect($team->userHasPermission($user, 'delete'))->toBeFalse();
    131▕ });
    132▕

  1   Modules/User/tests/Feature/TeamManagementBusinessLogicTest.php:128

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TeamManagementBusinessLogicTest > it c…   
  Failed asserting that actual size 1410 matches expected size 3.

  at Modules/User/tests/Feature/TeamManagementBusinessLogicTest.php:250
    246▕     $members = $team->users;
    247▕ 
    248▕     // Assert
    249▕     expect($members)
  ➜ 250▕         ->toHaveCount(3)
    251▕         ->pluck('id')
    252▕         ->toContain($user1->id, $user2->id, $user3->id);
    253▕ });
    254▕

  1   Modules/User/tests/Feature/TeamManagementBusinessLogicTest.php:250

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TeamManagementBusinessLogicTest > it c…   
  Failed asserting that actual size 940 matches expected size 2.

  at Modules/User/tests/Feature/TeamManagementBusinessLogicTest.php:270
    266▕     // Act
    267▕     $admins = $team->users()->wherePivot('role', 'admin')->get();
    268▕ 
    269▕     // Assert
  ➜ 270▕     expect($admins)->toHaveCount(2);
    271▕     expect($admins->pluck('id'))
    272▕         ->toContain($admin1->id, $admin2->id)
    273▕         ->not()->toContain($member->id);
    274▕ });

  1   Modules/User/tests/Feature/TeamManagementBusinessLogicTest.php:270

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TeamManagementBusinessLogicTest > it c…   
  Failed asserting that actual size 940 matches expected size 2.

  at Modules/User/tests/Feature/TeamManagementBusinessLogicTest.php:293
    289▕     $nurses = $team->users()->wherePivot('role', 'nurse')->get();
    290▕ 
    291▕     // Assert
    292▕     // Assert
  ➜ 293▕     expect($doctors)->toHaveCount(2);
    294▕     expect($doctors->pluck('id'))->toContain($doctor1->id, $doctor2->id);
    295▕     expect($nurses)->toHaveCount(1);
    296▕     expect($nurses->pluck('id'))->toContain($nurse->id);
    297▕ });

  1   Modules/User/tests/Feature/TeamManagementBusinessLogicTest.php:293

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TeamManagementBusinessLogicTest > it c…   
  Failed asserting that false is true.

  at Modules/User/tests/Feature/TeamManagementBusinessLogicTest.php:321
    317▕         'permissions' => json_encode(['read' => true, 'write' => true]),
    318▕     ]);
    319▕ 
    320▕     // Act & Assert
  ➜ 321▕     expect($team->userHasPermission($user, 'read'))->toBeTrue();
    322▕     expect($team->userHasPermission($user, 'write'))->toBeTrue();
    323▕     expect($team->userHasPermission($user, 'delete'))->toBeFalse();
    324▕ });
    325▕

  1   Modules/User/tests/Feature/TeamManagementBusinessLogicTest.php:321

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TeamManagementBusinessLogicTest > it c…   
  Failed asserting that 1410 is identical to 3.

  at Modules/User/tests/Feature/TeamManagementBusinessLogicTest.php:402
    398▕     $adminCount = $team->users()->wherePivot('role', 'admin')->count();
    399▕     $memberCount = $team->users()->wherePivot('role', 'member')->count();
    400▕ 
    401▕     // Assert
  ➜ 402▕     expect($totalMembers)->toBe(3);
    403▕     expect($adminCount)->toBe(1);
    404▕     expect($memberCount)->toBe(2);
    405▕ });
    406▕

  1   Modules/User/tests/Feature/TeamManagementBusinessLogicTest.php:402

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TeamManagementBusiness…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.teams' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: select exists(select * from `teams` where (`id` = 1583)) as `exists`)

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:420
    416▕             // For select statements, we'll simply execute the query and return an array
    417▕             // of the database result set. Each element in the array will be a single
    418▕             // row from the database table, and will either be an array or objects.
    419▕             $statement = $this->prepared(
  ➜ 420▕                 $this->getPdoForSelect($useReadPdo)->prepare($query)
    421▕             );
    422▕ 
    423▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    424▕

      [2m+5 vendor frames [22m
  6   Modules/User/tests/Feature/TeamManagementBusinessLogicTest.php:442

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TeamManagementTest > `Team Membership`…   
  Failed asserting that actual size 1413 matches expected size 3.

  at Modules/User/tests/Feature/TeamManagementTest.php:96
     92▕         $member3 = User::factory()->create();
     93▕ 
     94▕         $this->team->users()->attach([$member1->id, $member2->id, $member3->id]);
     95▕ 
  ➜  96▕         expect($this->team->users)->toHaveCount(3);
     97▕     });
     98▕ 
     99▕     it('can check if user is team member', function () {
    100▕         $this->team->users()->attach($this->member);

  1   Modules/User/tests/Feature/TeamManagementTest.php:96

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TeamManagementTest > `…  ErrorException   
  Attempt to read property "role" on null

  at Modules/User/tests/Feature/TeamManagementTest.php:119
    115▕             ->where('user_id', $this->member->id)
    116▕             ->first()
    117▕             ->membership; // Accessed as 'membership' due to as('membership')
    118▕ 
  ➜ 119▕         expect($membership->role)->toBe('editor');
    120▕         expect($membership->joined_at)->not->toBeNull();
    121▕     });
    122▕ });
    123▕

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TeamManagementTest > `User Team Relati…   
  Failed asserting that actual size 11 matches expected size 2.

  at Modules/User/tests/Feature/TeamManagementTest.php:131
    127▕         $team2 = Team::factory()->create(['user_id' => $this->owner->id]);
    128▕ 
    129▕         $this->member->teams()->attach([$team1->id, $team2->id]);
    130▕ 
  ➜ 131▕         expect($this->member->teams)->toHaveCount(2);
    132▕     });
    133▕ 
    134▕     it('user can switch current team', function () {
    135▕         $this->member->teams()->attach($this->team);

  1   Modules/User/tests/Feature/TeamManagementTest.php:131

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TeamManagementTest > `…  ErrorException   
  Attempt to read property "team_id" on null

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Relations/BelongsToMany.php:311
    307▕         // parents without having a possibly slow inner loop for every model.
    308▕         $dictionary = [];
    309▕ 
    310▕         foreach ($results as $result) {
  ➜ 311▕             $value = $this->getDictionaryKey($result->{$this->accessor}->{$this->foreignPivotKey});
    312▕ 
    313▕             $dictionary[$value][] = $result;
    314▕         }
    315▕

      [2m+4 vendor frames [22m
  5   Modules/User/app/Models/Traits/HasTeams.php:184
  6   Modules/User/tests/Feature/TeamManagementTest.php:162

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TeamManagementTest > `…  ErrorException   
  Attempt to read property "role" on null

  at Modules/User/tests/Feature/TeamManagementTest.php:275
    271▕             ->where('user_id', $this->member->id)
    272▕             ->first()
    273▕             ->membership;
    274▕ 
  ➜ 275▕         expect($membership->role)->toBe('admin');
    276▕     });
    277▕ });
    278▕ 
    279▕ describe('Team Scopes and Queries', function () {

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TeamManagementTest > `Team Scopes and…    
  Failed asserting that 940 is identical to 2.

  at Modules/User/tests/Feature/TeamManagementTest.php:305
    301▕         $this->team->users()->attach([$member1->id, $member2->id]);
    302▕ 
    303▕         $teamWithCount = Team::withCount('users')->find($this->team->id);
    304▕ 
  ➜ 305▕         expect($teamWithCount->users_count)->toBe(2);
    306▕     });
    307▕ });
    308▕ 
    309▕ describe('Team Features', function () {

  1   Modules/User/tests/Feature/TeamManagementTest.php:305

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TenantScopeConsoleTest…  QueryException   
  SQLSTATE[42S22]: Column not found: 1054 Unknown column 'tenant_id' in 'field list' (Connection: user, Host: 127.0.0.1, Port: 3306, Database: quaeris_user_test, SQL: insert into `users` (`is_active`, `first_name`, `last_name`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `lang`, `is_otp`, `password_expires_at`, `tenant_id`, `id`, `updated_at`, `created_at`) values (1, Giuseppe, Bianchi, Tenant 1 User, test3265@mail.com, 2026-01-17 17:58:49, $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi, 1PnJXVEEXb, it, 0, 2026-09-25 17:58:49, f155f975-d42e-380a-9585-db9a377cdf64, 019bcce5-2cb9-724b-aea3-38e8064d0b55, 2026-01-17 17:58:49, 2026-01-17 17:58:49))

  at vendor/laravel/framework/src/Illuminate/Database/MySqlConnection.php:47
     43▕             if ($this->pretending()) {
     44▕                 return true;
     45▕             }
     46▕ 
  ➜  47▕             $statement = $this->getPdo()->prepare($query);
     48▕ 
     49▕             $this->bindValues($statement, $this->prepareBindings($bindings));
     50▕ 
     51▕             $this->recordsHaveBeenModified();

      [2m+13 vendor frames [22m
  14  Modules/User/tests/Feature/TenantScopeConsoleTest.php:63

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TenantScopeConsoleTest…  QueryException   
  SQLSTATE[42S22]: Column not found: 1054 Unknown column 'tenant_id' in 'field list' (Connection: user, Host: 127.0.0.1, Port: 3306, Database: quaeris_user_test, SQL: insert into `users` (`is_active`, `first_name`, `last_name`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `lang`, `is_otp`, `password_expires_at`, `tenant_id`, `id`, `updated_at`, `created_at`) values (1, Antonio, Verdi, Tenant 1 User Only, tenant1-only@example.com, 2026-01-17 17:58:50, $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi, Lf1zQzoOS9, it, 0, 2026-11-06 17:58:50, 1c1b4150-dbf4-3c1d-9501-94d513d1661e, 019bcce5-2f22-736d-92cd-e4bca2c7ae52, 2026-01-17 17:58:50, 2026-01-17 17:58:50))

  at vendor/laravel/framework/src/Illuminate/Database/MySqlConnection.php:47
     43▕             if ($this->pretending()) {
     44▕                 return true;
     45▕             }
     46▕ 
  ➜  47▕             $statement = $this->getPdo()->prepare($query);
     48▕ 
     49▕             $this->bindValues($statement, $this->prepareBindings($bindings));
     50▕ 
     51▕             $this->recordsHaveBeenModified();

      [2m+13 vendor frames [22m
  14  Modules/User/tests/Feature/TenantScopeConsoleTest.php:106

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TenantScopeConsoleTest > `TenantScope…    
  Failed asserting that null is identical to 'ca71060e-f141-3646-a638-e6d563c483c8'.

  at Modules/User/tests/Feature/TenantScopeConsoleTest.php:174
    170▕                 'password' => bcrypt('password123'),
    171▕                 'tenant_id' => $this->tenant1->id,
    172▕             ]);
    173▕ 
  ➜ 174▕             expect($user->tenant_id)->toBe($this->tenant1->id);
    175▕ 
    176▕             // Verifica che l'utente sia effettivamente associato al tenant
    177▕             $user->refresh();
    178▕             expect($user->tenant_id)->toBe($this->tenant1->id);

  1   Modules/User/tests/Feature/TenantScopeConsoleTest.php:174

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TenantScopeConsoleTest…  QueryException   
  SQLSTATE[42S22]: Column not found: 1054 Unknown column 'tenant_id' in 'field list' (Connection: user, Host: 127.0.0.1, Port: 3306, Database: quaeris_user_test, SQL: insert into `users` (`is_active`, `first_name`, `last_name`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `lang`, `is_otp`, `password_expires_at`, `tenant_id`, `id`, `updated_at`, `created_at`) values (1, Marco, Ferrari, Antonio Russo, test9838@mail.com, 2026-01-17 17:58:51, $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi, SLhugy5yyz, de, 0, ?, a8354996-2df0-3272-9403-7ccec040e6c9, 019bcce5-341e-731a-8e7b-bffbb6d51790, 2026-01-17 17:58:51, 2026-01-17 17:58:51))

  at vendor/laravel/framework/src/Illuminate/Database/MySqlConnection.php:47
     43▕             if ($this->pretending()) {
     44▕                 return true;
     45▕             }
     46▕ 
  ➜  47▕             $statement = $this->getPdo()->prepare($query);
     48▕ 
     49▕             $this->bindValues($statement, $this->prepareBindings($bindings));
     50▕ 
     51▕             $this->recordsHaveBeenModified();

      [2m+13 vendor frames [22m
  14  Modules/User/tests/Feature/TenantScopeConsoleTest.php:183

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TwoFactorServiceTest > enable g…  Error   
  Class "Modules\User\Services\TwoFactorService" not found

  at Modules/User/tests/Feature/TwoFactorServiceTest.php:14
     10▕ 
     11▕ uses(TestCase::class);
     12▕ 
     13▕ beforeEach(function (): void {
  ➜  14▕     $this->service = new TwoFactorService();
     15▕     $this->user = User::factory()->create();
     16▕     $this->google2fa = new Google2FA();
     17▕ });
     18▕

  1   Modules/User/tests/Feature/TwoFactorServiceTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TwoFactorServiceTest > enable s…  Error   
  Class "Modules\User\Services\TwoFactorService" not found

  at Modules/User/tests/Feature/TwoFactorServiceTest.php:14
     10▕ 
     11▕ uses(TestCase::class);
     12▕ 
     13▕ beforeEach(function (): void {
  ➜  14▕     $this->service = new TwoFactorService();
     15▕     $this->user = User::factory()->create();
     16▕     $this->google2fa = new Google2FA();
     17▕ });
     18▕

  1   Modules/User/tests/Feature/TwoFactorServiceTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TwoFactorServiceTest > enable g…  Error   
  Class "Modules\User\Services\TwoFactorService" not found

  at Modules/User/tests/Feature/TwoFactorServiceTest.php:14
     10▕ 
     11▕ uses(TestCase::class);
     12▕ 
     13▕ beforeEach(function (): void {
  ➜  14▕     $this->service = new TwoFactorService();
     15▕     $this->user = User::factory()->create();
     16▕     $this->google2fa = new Google2FA();
     17▕ });
     18▕

  1   Modules/User/tests/Feature/TwoFactorServiceTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TwoFactorServiceTest > confirm…   Error   
  Class "Modules\User\Services\TwoFactorService" not found

  at Modules/User/tests/Feature/TwoFactorServiceTest.php:14
     10▕ 
     11▕ uses(TestCase::class);
     12▕ 
     13▕ beforeEach(function (): void {
  ➜  14▕     $this->service = new TwoFactorService();
     15▕     $this->user = User::factory()->create();
     16▕     $this->google2fa = new Google2FA();
     17▕ });
     18▕

  1   Modules/User/tests/Feature/TwoFactorServiceTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TwoFactorServiceTest > confirm…   Error   
  Class "Modules\User\Services\TwoFactorService" not found

  at Modules/User/tests/Feature/TwoFactorServiceTest.php:14
     10▕ 
     11▕ uses(TestCase::class);
     12▕ 
     13▕ beforeEach(function (): void {
  ➜  14▕     $this->service = new TwoFactorService();
     15▕     $this->user = User::factory()->create();
     16▕     $this->google2fa = new Google2FA();
     17▕ });
     18▕

  1   Modules/User/tests/Feature/TwoFactorServiceTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TwoFactorServiceTest > disable…   Error   
  Class "Modules\User\Services\TwoFactorService" not found

  at Modules/User/tests/Feature/TwoFactorServiceTest.php:14
     10▕ 
     11▕ uses(TestCase::class);
     12▕ 
     13▕ beforeEach(function (): void {
  ➜  14▕     $this->service = new TwoFactorService();
     15▕     $this->user = User::factory()->create();
     16▕     $this->google2fa = new Google2FA();
     17▕ });
     18▕

  1   Modules/User/tests/Feature/TwoFactorServiceTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TwoFactorServiceTest > verify v…  Error   
  Class "Modules\User\Services\TwoFactorService" not found

  at Modules/User/tests/Feature/TwoFactorServiceTest.php:14
     10▕ 
     11▕ uses(TestCase::class);
     12▕ 
     13▕ beforeEach(function (): void {
  ➜  14▕     $this->service = new TwoFactorService();
     15▕     $this->user = User::factory()->create();
     16▕     $this->google2fa = new Google2FA();
     17▕ });
     18▕

  1   Modules/User/tests/Feature/TwoFactorServiceTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TwoFactorServiceTest > verify r…  Error   
  Class "Modules\User\Services\TwoFactorService" not found

  at Modules/User/tests/Feature/TwoFactorServiceTest.php:14
     10▕ 
     11▕ uses(TestCase::class);
     12▕ 
     13▕ beforeEach(function (): void {
  ➜  14▕     $this->service = new TwoFactorService();
     15▕     $this->user = User::factory()->create();
     16▕     $this->google2fa = new Google2FA();
     17▕ });
     18▕

  1   Modules/User/tests/Feature/TwoFactorServiceTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TwoFactorServiceTest > verify r…  Error   
  Class "Modules\User\Services\TwoFactorService" not found

  at Modules/User/tests/Feature/TwoFactorServiceTest.php:14
     10▕ 
     11▕ uses(TestCase::class);
     12▕ 
     13▕ beforeEach(function (): void {
  ➜  14▕     $this->service = new TwoFactorService();
     15▕     $this->user = User::factory()->create();
     16▕     $this->google2fa = new Google2FA();
     17▕ });
     18▕

  1   Modules/User/tests/Feature/TwoFactorServiceTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TwoFactorServiceTest > verify r…  Error   
  Class "Modules\User\Services\TwoFactorService" not found

  at Modules/User/tests/Feature/TwoFactorServiceTest.php:14
     10▕ 
     11▕ uses(TestCase::class);
     12▕ 
     13▕ beforeEach(function (): void {
  ➜  14▕     $this->service = new TwoFactorService();
     15▕     $this->user = User::factory()->create();
     16▕     $this->google2fa = new Google2FA();
     17▕ });
     18▕

  1   Modules/User/tests/Feature/TwoFactorServiceTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TwoFactorServiceTest > verify r…  Error   
  Class "Modules\User\Services\TwoFactorService" not found

  at Modules/User/tests/Feature/TwoFactorServiceTest.php:14
     10▕ 
     11▕ uses(TestCase::class);
     12▕ 
     13▕ beforeEach(function (): void {
  ➜  14▕     $this->service = new TwoFactorService();
     15▕     $this->user = User::factory()->create();
     16▕     $this->google2fa = new Google2FA();
     17▕ });
     18▕

  1   Modules/User/tests/Feature/TwoFactorServiceTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TwoFactorServiceTest > verify r…  Error   
  Class "Modules\User\Services\TwoFactorService" not found

  at Modules/User/tests/Feature/TwoFactorServiceTest.php:14
     10▕ 
     11▕ uses(TestCase::class);
     12▕ 
     13▕ beforeEach(function (): void {
  ➜  14▕     $this->service = new TwoFactorService();
     15▕     $this->user = User::factory()->create();
     16▕     $this->google2fa = new Google2FA();
     17▕ });
     18▕

  1   Modules/User/tests/Feature/TwoFactorServiceTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TwoFactorServiceTest > regenera…  Error   
  Class "Modules\User\Services\TwoFactorService" not found

  at Modules/User/tests/Feature/TwoFactorServiceTest.php:14
     10▕ 
     11▕ uses(TestCase::class);
     12▕ 
     13▕ beforeEach(function (): void {
  ➜  14▕     $this->service = new TwoFactorService();
     15▕     $this->user = User::factory()->create();
     16▕     $this->google2fa = new Google2FA();
     17▕ });
     18▕

  1   Modules/User/tests/Feature/TwoFactorServiceTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TwoFactorServiceTest > regenera…  Error   
  Class "Modules\User\Services\TwoFactorService" not found

  at Modules/User/tests/Feature/TwoFactorServiceTest.php:14
     10▕ 
     11▕ uses(TestCase::class);
     12▕ 
     13▕ beforeEach(function (): void {
  ➜  14▕     $this->service = new TwoFactorService();
     15▕     $this->user = User::factory()->create();
     16▕     $this->google2fa = new Google2FA();
     17▕ });
     18▕

  1   Modules/User/tests/Feature/TwoFactorServiceTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TwoFactorServiceTest > qr code…   Error   
  Class "Modules\User\Services\TwoFactorService" not found

  at Modules/User/tests/Feature/TwoFactorServiceTest.php:14
     10▕ 
     11▕ uses(TestCase::class);
     12▕ 
     13▕ beforeEach(function (): void {
  ➜  14▕     $this->service = new TwoFactorService();
     15▕     $this->user = User::factory()->create();
     16▕     $this->google2fa = new Google2FA();
     17▕ });
     18▕

  1   Modules/User/tests/Feature/TwoFactorServiceTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TwoFactorServiceTest > qr code…   Error   
  Class "Modules\User\Services\TwoFactorService" not found

  at Modules/User/tests/Feature/TwoFactorServiceTest.php:14
     10▕ 
     11▕ uses(TestCase::class);
     12▕ 
     13▕ beforeEach(function (): void {
  ➜  14▕     $this->service = new TwoFactorService();
     15▕     $this->user = User::factory()->create();
     16▕     $this->google2fa = new Google2FA();
     17▕ });
     18▕

  1   Modules/User/tests/Feature/TwoFactorServiceTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TwoFactorServiceTest > secret i…  Error   
  Class "Modules\User\Services\TwoFactorService" not found

  at Modules/User/tests/Feature/TwoFactorServiceTest.php:14
     10▕ 
     11▕ uses(TestCase::class);
     12▕ 
     13▕ beforeEach(function (): void {
  ➜  14▕     $this->service = new TwoFactorService();
     15▕     $this->user = User::factory()->create();
     16▕     $this->google2fa = new Google2FA();
     17▕ });
     18▕

  1   Modules/User/tests/Feature/TwoFactorServiceTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TwoFactorServiceTest > recovery…  Error   
  Class "Modules\User\Services\TwoFactorService" not found

  at Modules/User/tests/Feature/TwoFactorServiceTest.php:14
     10▕ 
     11▕ uses(TestCase::class);
     12▕ 
     13▕ beforeEach(function (): void {
  ➜  14▕     $this->service = new TwoFactorService();
     15▕     $this->user = User::factory()->create();
     16▕     $this->google2fa = new Google2FA();
     17▕ });
     18▕

  1   Modules/User/tests/Feature/TwoFactorServiceTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TwoFactorServiceTest > enable c…  Error   
  Class "Modules\User\Services\TwoFactorService" not found

  at Modules/User/tests/Feature/TwoFactorServiceTest.php:14
     10▕ 
     11▕ uses(TestCase::class);
     12▕ 
     13▕ beforeEach(function (): void {
  ➜  14▕     $this->service = new TwoFactorService();
     15▕     $this->user = User::factory()->create();
     16▕     $this->google2fa = new Google2FA();
     17▕ });
     18▕

  1   Modules/User/tests/Feature/TwoFactorServiceTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\TwoFactorServiceTest > confirm…   Error   
  Class "Modules\User\Services\TwoFactorService" not found

  at Modules/User/tests/Feature/TwoFactorServiceTest.php:14
     10▕ 
     11▕ uses(TestCase::class);
     12▕ 
     13▕ beforeEach(function (): void {
  ➜  14▕     $this->service = new TwoFactorService();
     15▕     $this->user = User::factory()->create();
     16▕     $this->google2fa = new Google2FA();
     17▕ });
     18▕

  1   Modules/User/tests/Feature/TwoFactorServiceTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserAuthenticationTest > `User…   Error   
  Call to undefined function createUser()

  at Modules/User/tests/Feature/UserAuthenticationTest.php:11
      7▕ use Modules\User\Models\AuthenticationLog;
      8▕ 
      9▕ describe('User Authentication', function () {
     10▕     it('can authenticate user with correct credentials', function () {
  ➜  11▕         $user = createUser([
     12▕             'email' => 'test@example.com',
     13▕             'password' => Hash::make('password123'),
     14▕             'is_active' => true,
     15▕         ]);

  1   Modules/User/tests/Feature/UserAuthenticationTest.php:11

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserAuthenticationTest > `User…   Error   
  Call to undefined function createUser()

  at Modules/User/tests/Feature/UserAuthenticationTest.php:26
     22▕         expect($authenticated)->toBeTrue()->and(Auth::user()?->id)->toBe($user->id);
     23▕     });
     24▕ 
     25▕     it('cannot authenticate inactive user', function () {
  ➜  26▕         createUser([
     27▕             'email' => 'inactive@example.com',
     28▕             'password' => Hash::make('password123'),
     29▕             'is_active' => false,
     30▕         ]);

  1   Modules/User/tests/Feature/UserAuthenticationTest.php:26

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserAuthenticationTest > `User…   Error   
  Call to undefined function createUser()

  at Modules/User/tests/Feature/UserAuthenticationTest.php:41
     37▕         expect($authenticated)->toBeFalse();
     38▕     });
     39▕ 
     40▕     it('logs authentication attempts', function () {
  ➜  41▕         $user = createUser([
     42▕             'email' => 'test@example.com',
     43▕             'password' => Hash::make('password123'),
     44▕             'is_active' => true,
     45▕         ]);

  1   Modules/User/tests/Feature/UserAuthenticationTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserAuthenticationTest > `User…   Error   
  Call to undefined function createUser()

  at Modules/User/tests/Feature/UserAuthenticationTest.php:59
     55▕             ->toBeInstanceOf(AuthenticationLog::class);
     56▕     });
     57▕ 
     58▕     it('handles password expiration', function () {
  ➜  59▕         $user = createUser([
     60▕             'password_expires_at' => now()->subDay(),
     61▕         ]);
     62▕ 
     63▕         expect($user->password_expires_at->isPast())->toBeTrue();

  1   Modules/User/tests/Feature/UserAuthenticationTest.php:59

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserAuthenticationTest > `User…   Error   
  Call to undefined function createUser()

  at Modules/User/tests/Feature/UserAuthenticationTest.php:67
     63▕         expect($user->password_expires_at->isPast())->toBeTrue();
     64▕     });
     65▕ 
     66▕     it('supports OTP authentication', function () {
  ➜  67▕         $user = createUser(['is_otp' => true]);
     68▕ 
     69▕         expect($user->is_otp)->toBeTrue();
     70▕     });
     71▕ });

  1   Modules/User/tests/Feature/UserAuthenticationTest.php:67

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserBusine…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserBusinessLogicTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserBusine…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserBusinessLogicTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserBusine…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserBusinessLogicTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserBusine…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserBusinessLogicTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserBusine…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserBusinessLogicTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserBusine…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserBusinessLogicTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserBusine…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserBusinessLogicTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserBusine…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserBusinessLogicTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserBusine…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserBusinessLogicTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserBusine…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserBusinessLogicTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserBusine…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserBusinessLogicTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserBusine…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserBusinessLogicTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserBusine…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserBusinessLogicTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserBusine…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserBusinessLogicTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserBusine…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserBusinessLogicTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserBusine…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserBusinessLogicTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserBusine…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserBusinessLogicTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserBusine…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserBusinessLogicTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Target class [hash] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+9 vendor frames [22m
  10  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:22

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:60

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:74

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:91

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:106

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:125

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:140

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:154

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:169

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:183

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:196

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:215

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:232

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:244

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:256

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:268

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:280

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:306

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:321

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:333

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:346

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+20 vendor frames [22m
  21  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:361

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+20 vendor frames [22m
  21  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:377

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+23 vendor frames [22m
  24  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:393

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Target class [config] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+15 vendor frames [22m
  16  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:416

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Target class [config] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+15 vendor frames [22m
  16  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:437

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+20 vendor frames [22m
  21  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:458

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:470

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+20 vendor frames [22m
  21  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:485

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:497

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+20 vendor frames [22m
  21  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:512

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserManage…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+19 vendor frames [22m
  20  Modules/User/tests/Feature/UserManagementBusinessLogicTest.php:529

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserModelBasicTest > user model can qu…   
  Failed asserting that actual size 468 matches expected size 2.

  at Modules/User/tests/Feature/UserModelBasicTest.php:61
     57▕     ]);
     58▕ 
     59▕     $users = User::all();
     60▕     
  ➜  61▕     expect($users)->toHaveCount(2);
     62▕ });
     63▕ 
     64▕ test('user model can filter records', function () {
     65▕     // Create test data

  1   Modules/User/tests/Feature/UserModelBasicTest.php:61

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserModelBasicTest > user model can fi…   
  Failed asserting that actual size 465 matches expected size 1.

  at Modules/User/tests/Feature/UserModelBasicTest.php:71
     67▕     User::create(['name' => 'Inactive User', 'is_active' => false, 'email' => 'inactive-' . uniqid() . '@example.com', 'password' => bcrypt('password')]);
     68▕ 
     69▕     $activeUsers = User::where('is_active', true)->get();
     70▕     
  ➜  71▕     expect($activeUsers)->toHaveCount(1);
     72▕     expect($activeUsers->first()->name)->toBe('Active User');
     73▕ });
     74▕ 
     75▕ test('user model can update records', function () {

  1   Modules/User/tests/Feature/UserModelBasicTest.php:71

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserModelT…  BindingResolutionException   
  Target class [hash] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+7 vendor frames [22m
  8   Modules/User/tests/Feature/UserModelTest.php:28

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserModelT…  BindingResolutionException   
  Target class [hash] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+7 vendor frames [22m
  8   Modules/User/tests/Feature/UserModelTest.php:48

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserModelT…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1429
    1425▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1426▕     {
    1427▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1428▕ 
  ➜ 1429▕         throw new BindingResolutionException($message);
    1430▕     }
    1431▕ 
    1432▕     /**
    1433▕      * Register a new before resolving callback for all types.

      [2m+21 vendor frames [22m
  22  Modules/User/tests/Feature/UserModelTest.php:74

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserModelT…  BindingResolutionException   
  Target class [hash] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+7 vendor frames [22m
  8   Modules/User/tests/Feature/UserModelTest.php:89

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserModelT…  BindingResolutionException   
  Target class [hash] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+7 vendor frames [22m
  8   Modules/User/tests/Feature/UserModelTest.php:89

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserModelT…  BindingResolutionException   
  Target class [hash] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+7 vendor frames [22m
  8   Modules/User/tests/Feature/UserModelTest.php:89

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserModelT…  BindingResolutionException   
  Target class [hash] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+7 vendor frames [22m
  8   Modules/User/tests/Feature/UserModelTest.php:89

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserModelT…  BindingResolutionException   
  Target class [hash] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+7 vendor frames [22m
  8   Modules/User/tests/Feature/UserModelTest.php:89

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserModelT…  BindingResolutionException   
  Target class [hash] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+7 vendor frames [22m
  8   Modules/User/tests/Feature/UserModelTest.php:116

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserModelT…  BindingResolutionException   
  Target class [hash] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+7 vendor frames [22m
  8   Modules/User/tests/Feature/UserModelTest.php:127

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserModelT…  BindingResolutionException   
  Target class [hash] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+7 vendor frames [22m
  8   Modules/User/tests/Feature/UserModelTest.php:138

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserModelT…  BindingResolutionException   
  Target class [hash] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+7 vendor frames [22m
  8   Modules/User/tests/Feature/UserModelTest.php:154

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserModelT…  BindingResolutionException   
  Target class [hash] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+7 vendor frames [22m
  8   Modules/User/tests/Feature/UserModelTest.php:166

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserModelT…  BindingResolutionException   
  Target class [hash] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+7 vendor frames [22m
  8   Modules/User/tests/Feature/UserModelTest.php:179

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserModelT…  BindingResolutionException   
  Target class [hash] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+7 vendor frames [22m
  8   Modules/User/tests/Feature/UserModelTest.php:191

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserModelT…  BindingResolutionException   
  Target class [hash] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+7 vendor frames [22m
  8   Modules/User/tests/Feature/UserModelTest.php:216

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserModelT…  BindingResolutionException   
  Target class [hash] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+7 vendor frames [22m
  8   Modules/User/tests/Feature/UserModelTest.php:216

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserModelT…  BindingResolutionException   
  Target class [hash] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+7 vendor frames [22m
  8   Modules/User/tests/Feature/UserModelTest.php:216

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Feature\UserModelT…  BindingResolutionException   
  Target class [hash] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+7 vendor frames [22m
  8   Modules/User/tests/Feature/UserModelTest.php:216

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\CurrentTeamInfiniteLoopFixTest > currentT…   
  Failed asserting that null is an instance of class Illuminate\Database\Eloquent\Relations\BelongsTo.

  at Modules/User/tests/Unit/CurrentTeamInfiniteLoopFixTest.php:34
     30▕     // Act: Accedi al getter currentTeam (non dovrebbe crashare)
     31▕     $currentTeamRelation = $user->currentTeam;
     32▕ 
     33▕     // Assert: La relazione dovrebbe esistere ma il team dovrebbe essere null
  ➜  34▕     expect($currentTeamRelation)->toBeInstanceOf(BelongsTo::class);
     35▕     expect($user->currentTeam()->first())->toBeNull();
     36▕ });
     37▕ 
     38▕ test('currentTeam getter is side-effect-free', function (): void {

  1   Modules/User/tests/Unit/CurrentTeamInfiniteLoopFixTest.php:34

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\CurrentTeamInfiniteLoopFixTest > initiali…   
  Failed asserting that 11 is identical to 1626.

  at Modules/User/tests/Unit/CurrentTeamInfiniteLoopFixTest.php:147
    143▕     $user->initializeCurrentTeam();
    144▕ 
    145▕     // Assert: current_team_id dovrebbe essere impostato al team disponibile
    146▕     $user->refresh();
  ➜ 147▕     expect($user->current_team_id)->toBe($team->id);
    148▕ });
    149▕ 
    150▕ test('initializeCurrentTeam handles user without teams gracefully', function (): void {
    151▕     // Arrange: Crea un utente senza team

  1   Modules/User/tests/Unit/CurrentTeamInfiniteLoopFixTest.php:147

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\CurrentTeamInfiniteLoopFixTest > initiali…   
  Failed asserting that 11 is null.

  at Modules/User/tests/Unit/CurrentTeamInfiniteLoopFixTest.php:163
    159▕     $user->initializeCurrentTeam();
    160▕ 
    161▕     // Assert: current_team_id dovrebbe rimanere null
    162▕     $user->refresh();
  ➜ 163▕     expect($user->current_team_id)->toBeNull();
    164▕ });
    165▕ 
    166▕ test('currentTeam getter does not cause N+1 queries', function (): void {
    167▕     // Arrange: Crea un utente con un team

  1   Modules/User/tests/Unit/CurrentTeamInfiniteLoopFixTest.php:163

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\CurrentTeamInfiniteLoopFixTest > currentT…   
  Failed asserting that an instance of class Modules\User\Models\Team is an instance of class Illuminate\Database\Eloquent\Relations\BelongsTo.

  at Modules/User/tests/Unit/CurrentTeamInfiniteLoopFixTest.php:189
    185▕     $relation2 = $user->currentTeam;
    186▕     $relation3 = $user->currentTeam;
    187▕ 
    188▕     // Assert: Tutti gli accessi dovrebbero funzionare
  ➜ 189▕     expect($relation1)->toBeInstanceOf(BelongsTo::class);
    190▕     expect($relation2)->toBeInstanceOf(BelongsTo::class);
    191▕     expect($relation3)->toBeInstanceOf(BelongsTo::class);
    192▕ });
    193▕

  1   Modules/User/tests/Unit/CurrentTeamInfiniteLoopFixTest.php:189

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\CurrentTeamInfiniteLoopFixTest > user cre…   
  Failed asserting that null is an instance of class Illuminate\Database\Eloquent\Relations\BelongsTo.

  at Modules/User/tests/Unit/CurrentTeamInfiniteLoopFixTest.php:234
    230▕     expect($user->name)->toBe('New User');
    231▕ 
    232▕     // Accedi a currentTeam (non dovrebbe crashare)
    233▕     $relation = $user->currentTeam;
  ➜ 234▕     expect($relation)->toBeInstanceOf(BelongsTo::class);
    235▕ });
    236▕ 
    237▕ test('multiple users can be created without issues', function (): void {
    238▕     // Arrange & Act: Crea più utenti in sequenza

  1   Modules/User/tests/Unit/CurrentTeamInfiniteLoopFixTest.php:234

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\CurrentTeamInfiniteLoopFixTest > multiple…   
  Failed asserting that null is an instance of class Illuminate\Database\Eloquent\Relations\BelongsTo.

  at Modules/User/tests/Unit/CurrentTeamInfiniteLoopFixTest.php:257
    253▕         expect($user->id)->not->toBeNull();
    254▕ 
    255▕         // Verifica che currentTeam non crashi
    256▕         $relation = $user->currentTeam;
  ➜ 257▕         expect($relation)->toBeInstanceOf(BelongsTo::class);
    258▕     }
    259▕ });
    260▕

  1   Modules/User/tests/Unit/CurrentTeamInfiniteLoopFixTest.php:257

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\HasTe…  UniqueConstraintViolationException   
  SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'test@example.com' for key 'users.users_email_unique' (Connection: user, Host: 127.0.0.1, Port: 3306, Database: quaeris_user_test, SQL: insert into `users` (`is_active`, `first_name`, `last_name`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `lang`, `is_otp`, `password_expires_at`, `id`, `updated_at`, `created_at`) values (1, Mario, Esposito, Test User, test@example.com, 2026-01-17 17:59:19, $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi, tHO8AKhFZ2, en, 0, 2026-04-17 17:59:19, 019bcce5-a145-7045-8605-8842a49f8843, 2026-01-17 17:59:19, 2026-01-17 17:59:19))

  at vendor/laravel/framework/src/Illuminate/Database/MySqlConnection.php:53
     49▕             $this->bindValues($statement, $this->prepareBindings($bindings));
     50▕ 
     51▕             $this->recordsHaveBeenModified();
     52▕ 
  ➜  53▕             $result = $statement->execute();
     54▕ 
     55▕             $this->lastInsertId = $this->getPdo()->lastInsertId($sequence);
     56▕ 
     57▕             return $result;

      [2m+13 vendor frames [22m
  14  Modules/User/tests/Unit/HasTeamsTraitCurrentTeamTest.php:16

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\HasTe…  UniqueConstraintViolationException   
  SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'test@example.com' for key 'users.users_email_unique' (Connection: user, Host: 127.0.0.1, Port: 3306, Database: quaeris_user_test, SQL: insert into `users` (`is_active`, `first_name`, `last_name`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `lang`, `is_otp`, `password_expires_at`, `current_team_id`, `id`, `updated_at`, `created_at`) values (1, Francesco, Verdi, Test User, test@example.com, 2026-01-17 17:59:20, $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi, sDIEheCJak, en, 0, 2026-02-17 17:59:20, ?, 019bcce5-a2eb-71b0-9f98-263293ad011a, 2026-01-17 17:59:20, 2026-01-17 17:59:20))

  at vendor/laravel/framework/src/Illuminate/Database/MySqlConnection.php:53
     49▕             $this->bindValues($statement, $this->prepareBindings($bindings));
     50▕ 
     51▕             $this->recordsHaveBeenModified();
     52▕ 
  ➜  53▕             $result = $statement->execute();
     54▕ 
     55▕             $this->lastInsertId = $this->getPdo()->lastInsertId($sequence);
     56▕ 
     57▕             return $result;

      [2m+13 vendor frames [22m
  14  Modules/User/tests/Unit/HasTeamsTraitCurrentTeamTest.php:30

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\HasTe…  UniqueConstraintViolationException   
  SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'test@example.com' for key 'users.users_email_unique' (Connection: user, Host: 127.0.0.1, Port: 3306, Database: quaeris_user_test, SQL: insert into `users` (`is_active`, `first_name`, `last_name`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `lang`, `is_otp`, `password_expires_at`, `id`, `updated_at`, `created_at`) values (1, Marco, Esposito, Test User, test@example.com, 2026-01-17 17:59:20, $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi, lK9eSR9rRi, en, 0, 2026-08-04 17:59:20, 019bcce5-a3e9-70f8-a476-6b489a1d3b70, 2026-01-17 17:59:20, 2026-01-17 17:59:20))

  at vendor/laravel/framework/src/Illuminate/Database/MySqlConnection.php:53
     49▕             $this->bindValues($statement, $this->prepareBindings($bindings));
     50▕ 
     51▕             $this->recordsHaveBeenModified();
     52▕ 
  ➜  53▕             $result = $statement->execute();
     54▕ 
     55▕             $this->lastInsertId = $this->getPdo()->lastInsertId($sequence);
     56▕ 
     57▕             return $result;

      [2m+13 vendor frames [22m
  14  Modules/User/tests/Unit/HasTeamsTraitCurrentTeamTest.php:49

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\HasTe…  UniqueConstraintViolationException   
  SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'test@example.com' for key 'users.users_email_unique' (Connection: user, Host: 127.0.0.1, Port: 3306, Database: quaeris_user_test, SQL: insert into `users` (`is_active`, `first_name`, `last_name`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `lang`, `is_otp`, `password_expires_at`, `id`, `updated_at`, `created_at`) values (1, Giuseppe, Esposito, Test User, test@example.com, 2026-01-17 17:59:20, $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi, 197iwHzcQ0, en, 0, ?, 019bcce5-a4d7-7282-a045-a3166c5d5b84, 2026-01-17 17:59:20, 2026-01-17 17:59:20))

  at vendor/laravel/framework/src/Illuminate/Database/MySqlConnection.php:53
     49▕             $this->bindValues($statement, $this->prepareBindings($bindings));
     50▕ 
     51▕             $this->recordsHaveBeenModified();
     52▕ 
  ➜  53▕             $result = $statement->execute();
     54▕ 
     55▕             $this->lastInsertId = $this->getPdo()->lastInsertId($sequence);
     56▕ 
     57▕             return $result;

      [2m+13 vendor frames [22m
  14  Modules/User/tests/Unit/HasTeamsTraitCurrentTeamTest.php:74

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\HasTe…  UniqueConstraintViolationException   
  SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'test@example.com' for key 'users.users_email_unique' (Connection: user, Host: 127.0.0.1, Port: 3306, Database: quaeris_user_test, SQL: insert into `users` (`is_active`, `first_name`, `last_name`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `lang`, `is_otp`, `password_expires_at`, `id`, `updated_at`, `created_at`) values (1, Luigi, Verdi, Test User, test@example.com, 2026-01-17 17:59:20, $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi, eG0coFuldH, de, 0, 2026-09-12 17:59:20, 019bcce5-a5c1-71fd-bbff-b034a72026bf, 2026-01-17 17:59:20, 2026-01-17 17:59:20))

  at vendor/laravel/framework/src/Illuminate/Database/MySqlConnection.php:53
     49▕             $this->bindValues($statement, $this->prepareBindings($bindings));
     50▕ 
     51▕             $this->recordsHaveBeenModified();
     52▕ 
  ➜  53▕             $result = $statement->execute();
     54▕ 
     55▕             $this->lastInsertId = $this->getPdo()->lastInsertId($sequence);
     56▕ 
     57▕             return $result;

      [2m+13 vendor frames [22m
  14  Modules/User/tests/Unit/HasTeamsTraitCurrentTeamTest.php:105

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\HasTe…  UniqueConstraintViolationException   
  SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'test@example.com' for key 'users.users_email_unique' (Connection: user, Host: 127.0.0.1, Port: 3306, Database: quaeris_user_test, SQL: insert into `users` (`is_active`, `first_name`, `last_name`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `lang`, `is_otp`, `password_expires_at`, `id`, `updated_at`, `created_at`) values (1, Mario, Verdi, Test User, test@example.com, 2026-01-17 17:59:21, $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi, EjRr2WlkUu, it, 0, ?, 019bcce5-a6be-717d-98f3-63faa77b28d9, 2026-01-17 17:59:21, 2026-01-17 17:59:21))

  at vendor/laravel/framework/src/Illuminate/Database/MySqlConnection.php:53
     49▕             $this->bindValues($statement, $this->prepareBindings($bindings));
     50▕ 
     51▕             $this->recordsHaveBeenModified();
     52▕ 
  ➜  53▕             $result = $statement->execute();
     54▕ 
     55▕             $this->lastInsertId = $this->getPdo()->lastInsertId($sequence);
     56▕ 
     57▕             return $result;

      [2m+13 vendor frames [22m
  14  Modules/User/tests/Unit/HasTeamsTraitCurrentTeamTest.php:137

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\HasTeamsTraitPestTest > it correctly chec…   
  Failed asserting that true is false.

  at Modules/User/tests/Unit/HasTeamsTraitPestTest.php:27
     23▕ 
     24▕ test('it correctly checks if user belongs to teams', function () {
     25▕     // Test: User without teams
     26▕     $userWithoutTeams = User::factory()->create();
  ➜  27▕     expect($userWithoutTeams->belongsToTeams())->toBeFalse();
     28▕ 
     29▕     // Test: User with owned team
     30▕     expect($this->user->belongsToTeams())->toBeTrue();
     31▕

  1   Modules/User/tests/Unit/HasTeamsTraitPestTest.php:27

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\HasTeamsTraitPestTest > it correctly mana…   
  Failed asserting that 1638 is identical to '1638'.

  at Modules/User/tests/Unit/HasTeamsTraitPestTest.php:82
     78▕     $this->user->teams()->attach($this->team->id, ['role' => 'member']);
     79▕     $this->user->refresh();
     80▕     $result = $this->user->switchTeam($this->team);
     81▕ 
  ➜  82▕     expect($result)->toBeTrue()->and($this->user->current_team_id)->toBe((string) $this->team->id);
     83▕ 
     84▕     // Test: Switch to null
     85▕     $result = $this->user->switchTeam(null);
     86▕     expect($result)->toBeTrue()->and($this->user->current_team_id)->toBeNull();

  1   Modules/User/tests/Unit/HasTeamsTraitPestTest.php:82

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\HasTeamsTraitPestTest > it returns all te…   
  Failed asserting that actual size 10 matches expected size 2.

  at Modules/User/tests/Unit/HasTeamsTraitPestTest.php:112
    108▕     $allTeams = $this->user->allTeams();
    109▕ 
    110▕     expect($allTeams)
    111▕         ->toBeInstanceOf(Collection::class)
  ➜ 112▕         ->toHaveCount(2);
    113▕ 
    114▕     expect($allTeams->pluck('id')->toArray())
    115▕         ->toContain($this->personalTeam->id)
    116▕         ->toContain($this->team->id); // personal team + member team

  1   Modules/User/tests/Unit/HasTeamsTraitPestTest.php:112

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\HasTeamsTraitPestTest > it correctly dete…   
  Failed asserting that Modules\User\Models\Role Object #27299 (
    'connection' => 'user',
    'table' => 'roles',
    'primaryKey' => 'id',
    'keyType' => 'int',
    'incrementing' => true,
    'with' => Array &0 [],
    'withCount' => Array &1 [],
    'preventsLazyLoading' => false,
    'perPage' => 15,
    'exists' => false,
    'wasRecentlyCreated' => false,
    'escapeWhenCastingToString' => false,
    'attributes' => Array &2 [
        'name' => 'admin',
        'guard_name' => 'web',
    ],
    'original' => Array &3 [],
    'changes' => Array &4 [],
    'previous' => Array &5 [],
    'casts' => Array &6 [
        'id' => 'int',
        'name' => 'string',
        'guard_name' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ],
    'classCastCache' => Array &7 [],
    'attributeCastCache' => Array &8 [],
    'dateFormat' => null,
    'appends' => Array &9 [],
    'dispatchesEvents' => Array &10 [],
    'observables' => Array &11 [],
    'relations' => Array &12 [],
    'touches' => Array &13 [],
    'relationAutoloadCallback' => null,
    'relationAutoloadContext' => null,
    'timestamps' => true,
    'usesUniqueIds' => false,
    'hidden' => Array &14 [],
    'visible' => Array &15 [],
    'fillable' => Array &16 [
        0 => 'name',
        1 => 'guard_name',
        2 => 'display_name',
        3 => 'description',
        4 => 'team_id',
        5 => 'created_by',
        6 => 'updated_by',
    ],
    'guarded' => Array &17 [
        0 => 'id',
    ],
    'permissionClass' => null,
    'wildcardClass' => null,
) is null.

  at Modules/User/tests/Unit/HasTeamsTraitPestTest.php:147
    143▕     expect($role)->toBeInstanceOf(Role::class)->name->toBe('admin');
    144▕ 
    145▕     // Test: No role
    146▕     $otherUser = User::factory()->create();
  ➜ 147▕     expect($otherUser->teamRole($this->team))->toBeNull();
    148▕ });
    149▕ 
    150▕ test('it provides team role name helper', function () {
    151▕     // Test: Owner role name

  1   Modules/User/tests/Unit/HasTeamsTraitPestTest.php:147

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\HasTe…  UniqueConstraintViolationException   
  SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'user5628@example.com' for key 'users.users_email_unique' (Connection: user, Host: 127.0.0.1, Port: 3306, Database: quaeris_user_test, SQL: insert into `users` (`is_active`, `first_name`, `last_name`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `lang`, `is_otp`, `password_expires_at`, `id`, `updated_at`, `created_at`) values (1, Giuseppe, Ferrari, Giuseppe Bianchi, user5628@example.com, 2026-01-17 17:59:25, $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi, 27dKGLooLd, de, 0, 2026-02-09 17:59:25, 019bcce5-b5e2-73cd-aacb-430670e5d517, 2026-01-17 17:59:25, 2026-01-17 17:59:25))

  at vendor/laravel/framework/src/Illuminate/Database/MySqlConnection.php:53
     49▕             $this->bindValues($statement, $this->prepareBindings($bindings));
     50▕ 
     51▕             $this->recordsHaveBeenModified();
     52▕ 
  ➜  53▕             $result = $statement->execute();
     54▕ 
     55▕             $this->lastInsertId = $this->getPdo()->lastInsertId($sequence);
     56▕ 
     57▕             return $result;

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/HasTeamsTraitPestTest.php:17

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\HasTeamsTraitTest > it correctly checks i…   
  Failed asserting that true is false.

  at Modules/User/tests/Unit/HasTeamsTraitTest.php:39
     35▕ 
     36▕ test('it correctly checks if user belongs to teams', function (): void {
     37▕     // Test: User senza team
     38▕     $userWithoutTeams = User::factory()->create();
  ➜  39▕     expect($userWithoutTeams->belongsToTeams())->toBeFalse();
     40▕ 
     41▕     // Test: User con team owned
     42▕     expect($this->user->belongsToTeams())->toBeTrue();
     43▕

  1   Modules/User/tests/Unit/HasTeamsTraitTest.php:39

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\HasTeamsTraitTest > it correct…  TypeError   
  Modules\User\Models\BaseUser::switchTeam(): Argument #1 ($team) must be of type Modules\User\Contracts\TeamContract, null given, called in /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/User/tests/Unit/HasTeamsTraitTest.php on line 95

  at Modules/User/app/Models/Traits/HasTeams.php:420
    416▕ 
    417▕     /**
    418▕      * Switch the user's context to the given team.
    419▕      */
  ➜ 420▕     public function switchTeam(TeamContract $team): bool
    421▕     {
    422▕         if (! $this->belongsToTeam($team)) {
    423▕             return false;
    424▕         }

  1   Modules/User/app/Models/Traits/HasTeams.php:420
  2   Modules/User/tests/Unit/HasTeamsTraitTest.php:95

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\HasTeamsTraitTest > it returns all teams…    
  Failed asserting that actual size 10 matches expected size 2.

  at Modules/User/tests/Unit/HasTeamsTraitTest.php:119
    115▕ 
    116▕     $allTeams = $this->user->allTeams();
    117▕ 
    118▕     expect($allTeams)->toBeInstanceOf(Collection::class);
  ➜ 119▕     expect($allTeams)->toHaveCount(2); // personal team + member team
    120▕     expect($allTeams->contains($this->personalTeam))->toBeTrue();
    121▕     expect($allTeams->contains($this->team))->toBeTrue();
    122▕ });
    123▕

  1   Modules/User/tests/Unit/HasTeamsTraitTest.php:119

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\HasTeamsTraitTest > it provides team role…   
  Failed asserting that 'Unknown' is null.

  at Modules/User/tests/Unit/HasTeamsTraitTest.php:172
    168▕ 
    169▕     // Test: No role (not member)
    170▕     $otherTeam = Team::factory()->create();
    171▕     $roleName = $this->user->teamRoleName($otherTeam);
  ➜ 172▕     expect($roleName)->toBeNull();
    173▕ });
    174▕ 
    175▕ test('it correctly checks team role', function (): void {
    176▕     // Test: Owner always has any role

  1   Modules/User/tests/Unit/HasTeamsTraitTest.php:172

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\HasTe…  UniqueConstraintViolationException   
  SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'test6586@mail.com' for key 'users.users_email_unique' (Connection: user, Host: 127.0.0.1, Port: 3306, Database: quaeris_user_test, SQL: insert into `users` (`is_active`, `first_name`, `last_name`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `lang`, `is_otp`, `password_expires_at`, `id`, `updated_at`, `created_at`) values (1, Antonio, Bianchi, Luigi Verdi, test6586@mail.com, 2026-01-17 17:59:28, $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi, LZdItmpkhS, en, 0, 2026-08-25 17:59:28, 019bcce5-c2ed-7191-9238-df255da041e4, 2026-01-17 17:59:28, 2026-01-17 17:59:28))

  at vendor/laravel/framework/src/Illuminate/Database/MySqlConnection.php:53
     49▕             $this->bindValues($statement, $this->prepareBindings($bindings));
     50▕ 
     51▕             $this->recordsHaveBeenModified();
     52▕ 
  ➜  53▕             $result = $statement->execute();
     54▕ 
     55▕             $this->lastInsertId = $this->getPdo()->lastInsertId($sequence);
     56▕ 
     57▕             return $result;

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/HasTeamsTraitTest.php:29

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\HasTeamsTraitTest > it correctly manages…    
  Failed asserting that two arrays are identical.
  -Array &0 [
  -    0 => '*',
  -]
  +Array &0 []
  

  at Modules/User/tests/Unit/HasTeamsTraitTest.php:189
    185▕ 
    186▕ test('it correctly manages team permissions', function (): void {
    187▕     // Test: Owner has all permissions
    188▕     $permissions = $this->user->teamPermissions($this->personalTeam);
  ➜ 189▕     expect($permissions)->toBe(['*']);
    190▕     expect($this->user->hasTeamPermission($this->personalTeam, 'any_permission'))->toBeTrue();
    191▕ 
    192▕     // Test: Non-member has no permissions
    193▕     $otherTeam = Team::factory()->create();

  1   Modules/User/tests/Unit/HasTeamsTraitTest.php:189

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\HasTeamsTraitTest > it provides utility m…   
  Failed asserting that false is true.

  at Modules/User/tests/Unit/HasTeamsTraitTest.php:213
    209▕     // Test: isOwnerOrMember()
    210▕     expect($this->user->isOwnerOrMember($this->personalTeam))->toBeTrue();
    211▕ 
    212▕     $this->user->teams()->attach($this->team->id, ['role' => 'member']);
  ➜ 213▕     expect($this->user->isOwnerOrMember($this->team))->toBeTrue();
    214▕ 
    215▕     $otherTeam = Team::factory()->create();
    216▕     expect($this->user->isOwnerOrMember($otherTeam))->toBeFalse();
    217▕ });

  1   Modules/User/tests/Unit/HasTeamsTraitTest.php:213

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\HasTeamsTraitTest > it validates assertio…   
  Exception "InvalidArgumentException" not thrown.

  at Modules/User/tests/Unit/HasTeamsTraitTest.php:230
    226▕     expect($this->user->ownsTeam($teamWithoutOwner))->toBeFalse();
    227▕ });
    228▕ 
    229▕ test('it validates assertions correctly', function (): void {
  ➜ 230▕     expect(fn () => $this->user->ownsTeam(null))->toThrow(InvalidArgumentException::class, 'Team cannot be null');
    231▕ });
    232▕

  1   Modules/User/tests/Unit/HasTeamsTraitTest.php:230

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\BaseUserTest > base user has authe…   
  Failed asserting that an array contains 'Illuminate\Foundation\Auth\User'.

  at Modules/User/tests/Unit/Models/BaseUserTest.php:41
     37▕ 
     38▕ test('base user has authentication traits', function () {
     39▕     $traits = class_uses($this->baseUser);
     40▕ 
  ➜  41▕     expect($traits)->toContain(User::class);
     42▕     expect($traits)->toContain(Notifiable::class);
     43▕ });
     44▕

  1   Modules/User/tests/Unit/Models/BaseUserTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\DeviceTest > can c…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.devices' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: select exists(select * from `devices` where (`id` = 481 and `device` = iPhone and `platform` = iOS)) as `exists`)

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:420
    416▕             // For select statements, we'll simply execute the query and return an array
    417▕             // of the database result set. Each element in the array will be a single
    418▕             // row from the database table, and will either be an array or objects.
    419▕             $statement = $this->prepared(
  ➜ 420▕                 $this->getPdoForSelect($useReadPdo)->prepare($query)
    421▕             );
    422▕ 
    423▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    424▕

      [2m+5 vendor frames [22m
  6   Modules/User/tests/Unit/Models/DeviceTest.php:19

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\DeviceTest > can c…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.devices' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: select exists(select * from `devices` where (`id` = 482 and `uuid` = 550e8400-e29b-41d4-a716-446655440000 and `mobile_id` = mobile123 and `device` = iPhone 13 and `platform` = iOS and `browser` = Safari and `version` = 15.0 and `is_robot` = 0 and `is_desktop` = 0 and `is_mobile` = 1 and `is_tablet` = 0 and `is_phone` = 1)) as `exists`)

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:420
    416▕             // For select statements, we'll simply execute the query and return an array
    417▕             // of the database result set. Each element in the array will be a single
    418▕             // row from the database table, and will either be an array or objects.
    419▕             $statement = $this->prepared(
  ➜ 420▕                 $this->getPdoForSelect($useReadPdo)->prepare($query)
    421▕             );
    422▕ 
    423▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    424▕

      [2m+5 vendor frames [22m
  6   Modules/User/tests/Unit/Models/DeviceTest.php:45

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\DeviceTest > devic…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.devices' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: select exists(select * from `devices` where (`id` = 483) and `deleted_at` is not null) as `exists`)

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:420
    416▕             // For select statements, we'll simply execute the query and return an array
    417▕             // of the database result set. Each element in the array will be a single
    418▕             // row from the database table, and will either be an array or objects.
    419▕             $statement = $this->prepared(
  ➜ 420▕                 $this->getPdoForSelect($useReadPdo)->prepare($query)
    421▕             );
    422▕ 
    423▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    424▕

      [2m+5 vendor frames [22m
  6   Modules/User/tests/Unit/Models/DeviceTest.php:70

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\DeviceTest > can find desktop devi…   
  Failed asserting that actual size 3 matches expected size 2.

  at Modules/User/tests/Unit/Models/DeviceTest.php:158
    154▕     Device::factory()->create(['is_desktop' => true]);
    155▕ 
    156▕     $desktopDevices = Device::where('is_desktop', true)->get();
    157▕ 
  ➜ 158▕     expect($desktopDevices)->toHaveCount(2);
    159▕     expect($desktopDevices->every(fn ($device) => $device->is_desktop))->toBeTrue();
    160▕ });
    161▕ 
    162▕ test('can find mobile devices', function (): void {

  1   Modules/User/tests/Unit/Models/DeviceTest.php:158

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\DeviceTest > can u…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.devices' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: select exists(select * from `devices` where (`id` = 515 and `device` = New Device)) as `exists`)

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:420
    416▕             // For select statements, we'll simply execute the query and return an array
    417▕             // of the database result set. Each element in the array will be a single
    418▕             // row from the database table, and will either be an array or objects.
    419▕             $statement = $this->prepared(
  ➜ 420▕                 $this->getPdoForSelect($useReadPdo)->prepare($query)
    421▕             );
    422▕ 
    423▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    424▕

      [2m+5 vendor frames [22m
  6   Modules/User/tests/Unit/Models/DeviceTest.php:232

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\DeviceTest > can h…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.devices' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: select exists(select * from `devices` where (`id` = 516 and `mobile_id` is null and `browser` is null and `version` is null and `robot` is null)) as `exists`)

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:420
    416▕             // For select statements, we'll simply execute the query and return an array
    417▕             // of the database result set. Each element in the array will be a single
    418▕             // row from the database table, and will either be an array or objects.
    419▕             $statement = $this->prepared(
  ➜ 420▕                 $this->getPdoForSelect($useReadPdo)->prepare($query)
    421▕             );
    422▕ 
    423▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    424▕

      [2m+5 vendor frames [22m
  6   Modules/User/tests/Unit/Models/DeviceTest.php:249

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\PermissionTest > c…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/Models/PermissionTest.php:11

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\PermissionTest > c…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/Models/PermissionTest.php:29

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\PermissionTest > permission has co…   
  Failed asserting that null is identical to 'user'.

  at Modules/User/tests/Unit/Models/PermissionTest.php:41
     37▕ 
     38▕ test('permission has connection attribute', function (): void {
     39▕     $permission = new Permission();
     40▕ 
  ➜  41▕     expect($permission->connection)->toBe('user');
     42▕ });
     43▕ 
     44▕ test('permission has key type attribute', function (): void {
     45▕     $permission = new Permission();

  1   Modules/User/tests/Unit/Models/PermissionTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\PermissionTest > permission has ke…   
  Failed asserting that null is identical to 'string'.

  at Modules/User/tests/Unit/Models/PermissionTest.php:47
     43▕ 
     44▕ test('permission has key type attribute', function (): void {
     45▕     $permission = new Permission();
     46▕ 
  ➜  47▕     expect($permission->keyType)->toBe('string');
     48▕ });
     49▕ 
     50▕ test('permission has fillable attributes', function (): void {
     51▕     $permission = new Permission();

  1   Modules/User/tests/Unit/Models/PermissionTest.php:47

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\PermissionTest > permission has fi…   
  Failed asserting that an array contains 'id'.

  at Modules/User/tests/Unit/Models/PermissionTest.php:55
     51▕     $permission = new Permission();
     52▕ 
     53▕     $fillable = $permission->getFillable();
     54▕ 
  ➜  55▕     expect($fillable)->toContain('id');
     56▕     expect($fillable)->toContain('name');
     57▕     expect($fillable)->toContain('guard_name');
     58▕ });
     59▕

  1   Modules/User/tests/Unit/Models/PermissionTest.php:55

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\PermissionTest > permission has ca…   
  Failed asserting that an array has the key 'name'

  at Modules/User/tests/Unit/Models/PermissionTest.php:66
     62▕ 
     63▕     $casts = $permission->getCasts();
     64▕ 
     65▕     expect($casts)->toHaveKey('id');
  ➜  66▕     expect($casts)->toHaveKey('name');
     67▕     expect($casts)->toHaveKey('guard_name');
     68▕     expect($casts)->toHaveKey('created_at');
     69▕     expect($casts)->toHaveKey('updated_at');
     70▕ });

  1   Modules/User/tests/Unit/Models/PermissionTest.php:66

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\PermissionTest > c…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/Models/PermissionTest.php:73

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\PermissionTest > c…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/Models/PermissionTest.php:82

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\PermissionTest > c…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/Models/PermissionTest.php:93

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\PermissionTest > c…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/Models/PermissionTest.php:102

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\PermissionTest > c…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/Models/PermissionTest.php:111

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\PermissionTest > c…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/Models/PermissionTest.php:123

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\PermissionTest > c…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/Models/PermissionTest.php:131

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\PermissionTest > c…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/Models/PermissionTest.php:143

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\PermissionTest > p…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+21 vendor frames [22m
  22  Modules/User/tests/Unit/Models/PermissionTest.php:164

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\PermissionTest > p…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+21 vendor frames [22m
  22  Modules/User/tests/Unit/Models/PermissionTest.php:170

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\PermissionTest > p…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+21 vendor frames [22m
  22  Modules/User/tests/Unit/Models/PermissionTest.php:176

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\PermissionTest > p…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+21 vendor frames [22m
  22  Modules/User/tests/Unit/Models/PermissionTest.php:182

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\PermissionTest > p…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+21 vendor frames [22m
  22  Modules/User/tests/Unit/Models/PermissionTest.php:189

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\ProfileTest > can…   QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.profiles' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: select exists(select * from `profiles` where (`id` = 019bcce6-083e-7111-8d71-69c9baaab179 and `first_name` = John and `last_name` = Doe and `user_name` = johndoe and `email` = john@example.com)) as `exists`)

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:420
    416▕             // For select statements, we'll simply execute the query and return an array
    417▕             // of the database result set. Each element in the array will be a single
    418▕             // row from the database table, and will either be an array or objects.
    419▕             $statement = $this->prepared(
  ➜ 420▕                 $this->getPdoForSelect($useReadPdo)->prepare($query)
    421▕             );
    422▕ 
    423▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    424▕

      [2m+5 vendor frames [22m
  6   Modules/User/tests/Unit/Models/ProfileTest.php:21

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\ProfileTest > can…   QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.profiles' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: select exists(select * from `profiles` where (`id` = 019bcce6-092e-717b-954e-153a94327246 and `first_name` = Jane and `last_name` = Smith and `user_name` = janesmith and `email` = jane@example.com and `phone` = +1234567890 and `bio` = Software Developer and `avatar` = avatar.jpg and `timezone` = UTC and `locale` = en and `status` = active)) as `exists`)

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:420
    416▕             // For select statements, we'll simply execute the query and return an array
    417▕             // of the database result set. Each element in the array will be a single
    418▕             // row from the database table, and will either be an array or objects.
    419▕             $statement = $this->prepared(
  ➜ 420▕                 $this->getPdoForSelect($useReadPdo)->prepare($query)
    421▕             );
    422▕ 
    423▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    424▕

      [2m+5 vendor frames [22m
  6   Modules/User/tests/Unit/Models/ProfileTest.php:48

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\ProfileTest > can…   QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.profiles' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: select exists(select * from `profiles` where (`id` = 019bcce6-15be-738e-9399-ca158d96a12b and `first_name` = New Name)) as `exists`)

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:420
    416▕             // For select statements, we'll simply execute the query and return an array
    417▕             // of the database result set. Each element in the array will be a single
    418▕             // row from the database table, and will either be an array or objects.
    419▕             $statement = $this->prepared(
  ➜ 420▕                 $this->getPdoForSelect($useReadPdo)->prepare($query)
    421▕             );
    422▕ 
    423▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    424▕

      [2m+5 vendor frames [22m
  6   Modules/User/tests/Unit/Models/ProfileTest.php:167

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\ProfileTest > can…   QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.profiles' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: select exists(select * from `profiles` where (`id` = 019bcce6-16cb-72c8-a28e-9f3dbc351c67 and `phone` is null and `bio` is null and `avatar` is null and `timezone` is null and `locale` is null)) as `exists`)

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:420
    416▕             // For select statements, we'll simply execute the query and return an array
    417▕             // of the database result set. Each element in the array will be a single
    418▕             // row from the database table, and will either be an array or objects.
    419▕             $statement = $this->prepared(
  ➜ 420▕                 $this->getPdoForSelect($useReadPdo)->prepare($query)
    421▕             );
    422▕ 
    423▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    424▕

      [2m+5 vendor frames [22m
  6   Modules/User/tests/Unit/Models/ProfileTest.php:186

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\RoleTest > can cre…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/Models/RoleTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\RoleTest > can cre…  QueryException   
  SQLSTATE[42S22]: Column not found: 1054 Unknown column 'uuid' in 'field list' (Connection: user, Host: 127.0.0.1, Port: 3306, Database: quaeris_user_test, SQL: insert into `roles` (`name`, `guard_name`, `team_id`, `uuid`, `updated_at`, `created_at`) values (Full Role, web, 1692, 550e8400-e29b-41d4-a716-446655440000, 2026-01-17 17:59:52, 2026-01-17 17:59:52))

  at vendor/laravel/framework/src/Illuminate/Database/MySqlConnection.php:47
     43▕             if ($this->pretending()) {
     44▕                 return true;
     45▕             }
     46▕ 
  ➜  47▕             $statement = $this->getPdo()->prepare($query);
     48▕ 
     49▕             $this->bindValues($statement, $this->prepareBindings($bindings));
     50▕ 
     51▕             $this->recordsHaveBeenModified();

      [2m+15 vendor frames [22m
  16  Modules/User/tests/Unit/Models/RoleTest.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\RoleTest > role has connection att…   
  Failed asserting that null is identical to 'user'.

  at Modules/User/tests/Unit/Models/RoleTest.php:44
     40▕ 
     41▕ test('role has connection attribute', function (): void {
     42▕     $role = new Role();
     43▕ 
  ➜  44▕     expect($role->connection)->toBe('user');
     45▕ });
     46▕ 
     47▕ test('role has key type attribute', function (): void {
     48▕     $role = new Role();

  1   Modules/User/tests/Unit/Models/RoleTest.php:44

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\RoleTest > role has key type attri…   
  Failed asserting that null is identical to 'string'.

  at Modules/User/tests/Unit/Models/RoleTest.php:50
     46▕ 
     47▕ test('role has key type attribute', function (): void {
     48▕     $role = new Role();
     49▕ 
  ➜  50▕     expect($role->keyType)->toBe('string');
     51▕ });
     52▕ 
     53▕ test('role constants are defined', function (): void {
     54▕     expect(Role::ROLE_ADMINISTRATOR)->toBe(1);

  1   Modules/User/tests/Unit/Models/RoleTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\RoleTest > can fin…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/Models/RoleTest.php:60

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\RoleTest > can fin…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/Models/RoleTest.php:69

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\RoleTest > can fin…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/Models/RoleTest.php:81

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\RoleTest > can fin…  QueryException   
  SQLSTATE[42S22]: Column not found: 1054 Unknown column 'uuid' in 'field list' (Connection: user, Host: 127.0.0.1, Port: 3306, Database: quaeris_user_test, SQL: insert into `roles` (`name`, `guard_name`, `uuid`, `updated_at`, `created_at`) values (contributor, web, 550e8400-e29b-41d4-a716-446655440000, 2026-01-17 17:59:54, 2026-01-17 17:59:54))

  at vendor/laravel/framework/src/Illuminate/Database/MySqlConnection.php:47
     43▕             if ($this->pretending()) {
     44▕                 return true;
     45▕             }
     46▕ 
  ➜  47▕             $statement = $this->getPdo()->prepare($query);
     48▕ 
     49▕             $this->bindValues($statement, $this->prepareBindings($bindings));
     50▕ 
     51▕             $this->recordsHaveBeenModified();

      [2m+15 vendor frames [22m
  16  Modules/User/tests/Unit/Models/RoleTest.php:91

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\RoleTest > can fin…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/Models/RoleTest.php:100

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\RoleTest > can upd…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/Models/RoleTest.php:111

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\RoleTest > can han…  QueryException   
  SQLSTATE[42S22]: Column not found: 1054 Unknown column 'uuid' in 'field list' (Connection: user, Host: 127.0.0.1, Port: 3306, Database: quaeris_user_test, SQL: insert into `roles` (`name`, `guard_name`, `team_id`, `uuid`, `updated_at`, `created_at`) values (Test Role, web, ?, ?, 2026-01-17 17:59:55, 2026-01-17 17:59:55))

  at vendor/laravel/framework/src/Illuminate/Database/MySqlConnection.php:47
     43▕             if ($this->pretending()) {
     44▕                 return true;
     45▕             }
     46▕ 
  ➜  47▕             $statement = $this->getPdo()->prepare($query);
     48▕ 
     49▕             $this->bindValues($statement, $this->prepareBindings($bindings));
     50▕ 
     51▕             $this->recordsHaveBeenModified();

      [2m+15 vendor frames [22m
  16  Modules/User/tests/Unit/Models/RoleTest.php:119

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\RoleTest > can fin…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/Models/RoleTest.php:132

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\RoleTest > role ha…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+21 vendor frames [22m
  22  Modules/User/tests/Unit/Models/RoleTest.php:152

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\RoleTest > role ha…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+21 vendor frames [22m
  22  Modules/User/tests/Unit/Models/RoleTest.php:158

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\RoleTest > role ha…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+21 vendor frames [22m
  22  Modules/User/tests/Unit/Models/RoleTest.php:164

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\RoleTest > role ca…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+21 vendor frames [22m
  22  Modules/User/tests/Unit/Models/RoleTest.php:170

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\RoleTest > role ca…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+21 vendor frames [22m
  22  Modules/User/tests/Unit/Models/RoleTest.php:177

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\TeamTest > can create team with al…   
  Failed asserting that false is identical to 0.

  at Modules/User/tests/Unit/Models/TeamTest.php:41
     37▕ 
     38▕     expect($team->id)->not->toBeNull();
     39▕     expect($team->user_id)->toBe($user->id);
     40▕     expect($team->name)->toBe('Full Team');
  ➜  41▕     expect($team->personal_team)->toBe(0);
     42▕     expect($team->code)->toBe('TEAM001');
     43▕     expect($team->uuid)->toBe('550e8400-e29b-41d4-a716-446655440000');
     44▕     expect($team->owner_id)->toBe($user->id);
     45▕ });

  1   Modules/User/tests/Unit/Models/TeamTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\TeamTest > can find personal teams    
  Failed asserting that true is identical to 1.

  at Modules/User/tests/Unit/Models/TeamTest.php:114
    110▕ 
    111▕     $personalTeams = Team::where('personal_team', 1)->get();
    112▕ 
    113▕     expect($personalTeams->count())->toBeGreaterThanOrEqual(1);
  ➜ 114▕     expect($personalTeams->first()->personal_team)->toBe(1);
    115▕ });
    116▕ 
    117▕ test('can find teams by user id', function (): void {
    118▕     $user1 = User::factory()->create();

  1   Modules/User/tests/Unit/Models/TeamTest.php:114

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\TeamTest > can find teams by multi…   
  Failed asserting that false is identical to 0.

  at Modules/User/tests/Unit/Models/TeamTest.php:188
    184▕     $teams = Team::where('user_id', $user->id)->where('personal_team', 0)->get();
    185▕ 
    186▕     expect($teams->count())->toBeGreaterThanOrEqual(1);
    187▕     expect($teams->first()->name)->toBe('Development Team');
  ➜ 188▕     expect($teams->first()->personal_team)->toBe(0);
    189▕ });
    190▕

  1   Modules/User/tests/Unit/Models/TeamTest.php:188

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\TenantTest > it ca…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.tenants' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: select exists(select * from `tenants` where (`id` = 077820da-868e-3a65-92ce-2a372f370d46 and `name` = Test Tenant)) as `exists`)

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:420
    416▕             // For select statements, we'll simply execute the query and return an array
    417▕             // of the database result set. Each element in the array will be a single
    418▕             // row from the database table, and will either be an array or objects.
    419▕             $statement = $this->prepared(
  ➜ 420▕                 $this->getPdoForSelect($useReadPdo)->prepare($query)
    421▕             );
    422▕ 
    423▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    424▕

      [2m+5 vendor frames [22m
  6   Modules/User/tests/Unit/Models/TenantTest.php:18

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\TenantTest > it ca…  QueryException   
  SQLSTATE[42S22]: Column not found: 1054 Unknown column 'settings' in 'field list' (Connection: user, Host: 127.0.0.1, Port: 3306, Database: quaeris_user_test, SQL: insert into `tenants` (`id`, `name`, `domain`, `database`, `is_active`, `slug`, `settings`, `trial_ends_at`, `updated_at`, `created_at`) values (e636089a-9a19-38b2-b3e9-6d316cb60920, Full Tenant, fulltenant.com, fulltenant_db, 1, full-tenant, ?, 2026-02-16 18:00:00, 2026-01-17 18:00:00, 2026-01-17 18:00:00))

  at vendor/laravel/framework/src/Illuminate/Database/MySqlConnection.php:47
     43▕             if ($this->pretending()) {
     44▕                 return true;
     45▕             }
     46▕ 
  ➜  47▕             $statement = $this->getPdo()->prepare($query);
     48▕ 
     49▕             $this->bindValues($statement, $this->prepareBindings($bindings));
     50▕ 
     51▕             $this->recordsHaveBeenModified();

      [2m+13 vendor frames [22m
  14  Modules/User/tests/Unit/Models/TenantTest.php:35

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\TenantTest > it te…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_user_test.media' doesn't exist (Connection: user, Host: 127.0.0.1, Port: 3306, Database: quaeris_user_test, SQL: select * from `media` where `media`.`model_type` = Modules\User\Models\Tenant and `media`.`model_id` = 644ffd11-3103-39a5-ad70-59b9f890c869 and `media`.`model_id` is not null)

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:483
    479▕             // First we will create a statement for the query. Then, we will set the fetch
    480▕             // mode and prepare the bindings for the query. Once that's done we will be
    481▕             // ready to execute the query against the database and return the cursor.
    482▕             $statement = $this->prepared($this->getPdoForSelect($useReadPdo)
  ➜ 483▕                 ->prepare($query));
    484▕ 
    485▕             $this->bindValues(
    486▕                 $statement, $this->prepareBindings($bindings)
    487▕             );

      [2m+18 vendor frames [22m
  19  Modules/User/tests/Unit/Models/TenantTest.php:54

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\TenantTest > it can find tenant by…   
  Failed asserting that two strings are identical.
  -'4941682b-2346-3ece-a6b8-22aca55f29c4'
  +'0cac6ff4-e546-3f0e-85a8-77426ea68dec'
  

  at Modules/User/tests/Unit/Models/TenantTest.php:86
     82▕ 
     83▕     $foundTenant = Tenant::where('name', 'Unique Tenant Name')->first();
     84▕ 
     85▕     expect($foundTenant)->not()->toBeNull()
  ➜  86▕         ->and($foundTenant->id)->toBe($tenant->id);
     87▕ });
     88▕ 
     89▕ it('can find tenant by slug', function () {
     90▕     $tenant = Tenant::factory()->create(['slug' => 'unique-tenant']);

  1   Modules/User/tests/Unit/Models/TenantTest.php:86

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\TenantTest > it can find tenant by…   
  Failed asserting that two strings are identical.
  -'11de3251-6ed9-3753-8a34-b5862be43e57'
  +'a5ddcf4e-73ca-37a0-87c3-2bee656d1a2d'
  

  at Modules/User/tests/Unit/Models/TenantTest.php:95
     91▕ 
     92▕     $foundTenant = Tenant::where('slug', 'unique-tenant')->first();
     93▕ 
     94▕     expect($foundTenant)->not()->toBeNull()
  ➜  95▕         ->and($foundTenant->id)->toBe($tenant->id);
     96▕ });
     97▕ 
     98▕ it('can find tenant by domain', function () {
     99▕     $tenant = Tenant::factory()->create(['domain' => 'uniquetenant.com']);

  1   Modules/User/tests/Unit/Models/TenantTest.php:95

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\TenantTest > it can find tenant by…   
  Failed asserting that two strings are identical.
  -'b4d45187-8d0b-3d47-a3ac-014642971f02'
  +'146f7c32-24f5-3115-84bb-4461b80bdc1d'
  

  at Modules/User/tests/Unit/Models/TenantTest.php:104
    100▕ 
    101▕     $foundTenant = Tenant::where('domain', 'uniquetenant.com')->first();
    102▕ 
    103▕     expect($foundTenant)->not()->toBeNull()
  ➜ 104▕         ->and($foundTenant->id)->toBe($tenant->id);
    105▕ });
    106▕ 
    107▕ it('can find tenant by database', function () {
    108▕     $tenant = Tenant::factory()->create(['database' => 'unique_db']);

  1   Modules/User/tests/Unit/Models/TenantTest.php:104

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\TenantTest > it can find tenant by…   
  Failed asserting that two strings are identical.
  -'427724c0-67d8-3f8c-97d1-df05b14f7cd9'
  +'385f0a0b-4cec-3fff-bc7e-b46e2600aaca'
  

  at Modules/User/tests/Unit/Models/TenantTest.php:113
    109▕ 
    110▕     $foundTenant = Tenant::where('database', 'unique_db')->first();
    111▕ 
    112▕     expect($foundTenant)->not()->toBeNull()
  ➜ 113▕         ->and($foundTenant->id)->toBe($tenant->id);
    114▕ });
    115▕ 
    116▕ it('can find active tenants', function () {
    117▕     Tenant::factory()->create(['is_active' => true]);

  1   Modules/User/tests/Unit/Models/TenantTest.php:113

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\TenantTest > it can find active te…   
  Failed asserting that actual size 201 matches expected size 2.

  at Modules/User/tests/Unit/Models/TenantTest.php:123
    119▕     Tenant::factory()->create(['is_active' => true]);
    120▕ 
    121▕     $activeTenants = Tenant::where('is_active', true)->get();
    122▕ 
  ➜ 123▕     expect($activeTenants)->toHaveCount(2)
    124▕         ->and($activeTenants->every(fn ($tenant) => $tenant->is_active))->toBeTrue();
    125▕ });
    126▕ 
    127▕ it('can find tenants by name pattern', function () {

  1   Modules/User/tests/Unit/Models/TenantTest.php:123

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\TenantTest > it can find tenants b…   
  Failed asserting that actual size 49 matches expected size 1.

  at Modules/User/tests/Unit/Models/TenantTest.php:134
    130▕     Tenant::factory()->create(['name' => 'Sales Corporation']);
    131▕ 
    132▕     $companyTenants = Tenant::where('name', 'like', '%Company%')->get();
    133▕ 
  ➜ 134▕     expect($companyTenants)->toHaveCount(1)
    135▕         ->and($companyTenants->every(fn ($tenant) => str_contains($tenant->name, 'Company')))->toBeTrue();
    136▕ });
    137▕ 
    138▕ it('can find tenants by domain pattern', function () {

  1   Modules/User/tests/Unit/Models/TenantTest.php:134

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\TenantTest > it can find tenants b…   
  Failed asserting that actual size 51 matches expected size 3.

  at Modules/User/tests/Unit/Models/TenantTest.php:145
    141▕     Tenant::factory()->create(['domain' => 'prod.example.com']);
    142▕ 
    143▕     $exampleTenants = Tenant::where('domain', 'like', '%.example.com')->get();
    144▕ 
  ➜ 145▕     expect($exampleTenants)->toHaveCount(3)
    146▕         ->and($exampleTenants->every(fn ($tenant) => str_ends_with($tenant->domain, '.example.com')))->toBeTrue();
    147▕ });
    148▕ 
    149▕ it('can update tenant', function () {

  1   Modules/User/tests/Unit/Models/TenantTest.php:145

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\TenantTest > it ca…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.tenants' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: select exists(select * from `tenants` where (`id` = f26f2687-0d18-3e07-bdeb-67be1941b6fd and `name` = New Name)) as `exists`)

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:420
    416▕             // For select statements, we'll simply execute the query and return an array
    417▕             // of the database result set. Each element in the array will be a single
    418▕             // row from the database table, and will either be an array or objects.
    419▕             $statement = $this->prepared(
  ➜ 420▕                 $this->getPdoForSelect($useReadPdo)->prepare($query)
    421▕             );
    422▕ 
    423▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    424▕

      [2m+5 vendor frames [22m
  6   Modules/User/tests/Unit/Models/TenantTest.php:154

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\TenantTest > it ca…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.tenants' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: select exists(select * from `tenants` where (`id` = 1405478d-d29f-3e98-8a34-9c24629bcc94 and `slug` is null and `domain` is null and `database` is null)) as `exists`)

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:420
    416▕             // For select statements, we'll simply execute the query and return an array
    417▕             // of the database result set. Each element in the array will be a single
    418▕             // row from the database table, and will either be an array or objects.
    419▕             $statement = $this->prepared(
  ➜ 420▕                 $this->getPdoForSelect($useReadPdo)->prepare($query)
    421▕             );
    422▕ 
    423▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    424▕

      [2m+5 vendor frames [22m
  6   Modules/User/tests/Unit/Models/TenantTest.php:168

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\TenantTest > it can find tenants b…   
  Failed asserting that actual size 112 matches expected size 1.

  at Modules/User/tests/Unit/Models/TenantTest.php:191
    187▕     ]);
    188▕ 
    189▕     $tenants = Tenant::where('is_active', true)->where('domain', 'like', '%.com')->get();
    190▕ 
  ➜ 191▕     expect($tenants)->toHaveCount(1)
    192▕         ->and($tenants->first()->name)->toBe('Active Company')
    193▕         ->and($tenants->first()->is_active)->toBeTrue();
    194▕ });
    195▕

  1   Modules/User/tests/Unit/Models/TenantTest.php:191

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\TenantTest > it ca…  QueryException   
  SQLSTATE[42S22]: Column not found: 1054 Unknown column 'trial_ends_at' in 'field list' (Connection: user, Host: 127.0.0.1, Port: 3306, Database: quaeris_user_test, SQL: insert into `tenants` (`id`, `name`, `domain`, `database`, `is_active`, `trial_ends_at`, `slug`, `updated_at`, `created_at`) values (a1c99ef4-046d-3122-b725-fed77e663d53, Vitali SPA, longo.it, in, 1, 2026-02-16 18:00:04, vitali-spa, 2026-01-17 18:00:04, 2026-01-17 18:00:04))

  at vendor/laravel/framework/src/Illuminate/Database/MySqlConnection.php:47
     43▕             if ($this->pretending()) {
     44▕                 return true;
     45▕             }
     46▕ 
  ➜  47▕             $statement = $this->getPdo()->prepare($query);
     48▕ 
     49▕             $this->bindValues($statement, $this->prepareBindings($bindings));
     50▕ 
     51▕             $this->recordsHaveBeenModified();

      [2m+13 vendor frames [22m
  14  Modules/User/tests/Unit/Models/TenantTest.php:222

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\TenantTest > it ca…  QueryException   
  SQLSTATE[42S22]: Column not found: 1054 Unknown column 'settings' in 'field list' (Connection: user, Host: 127.0.0.1, Port: 3306, Database: quaeris_user_test, SQL: insert into `tenants` (`id`, `name`, `domain`, `database`, `is_active`, `settings`, `slug`, `updated_at`, `created_at`) values (ff4d2720-9c20-3347-bb1e-ec2d28f97bb1, Fabbri, Amato e Romano Group, neri.net, atque, 0, ?, fabbri-amato-e-romano-group, 2026-01-17 18:00:04, 2026-01-17 18:00:04))

  at vendor/laravel/framework/src/Illuminate/Database/MySqlConnection.php:47
     43▕             if ($this->pretending()) {
     44▕                 return true;
     45▕             }
     46▕ 
  ➜  47▕             $statement = $this->getPdo()->prepare($query);
     48▕ 
     49▕             $this->bindValues($statement, $this->prepareBindings($bindings));
     50▕ 
     51▕             $this->recordsHaveBeenModified();

      [2m+13 vendor frames [22m
  14  Modules/User/tests/Unit/Models/TenantTest.php:237

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\Traits\Has…  BadMethodCallException   
  Received Mockery_5_Illuminate_Database_Eloquent_Relations_BelongsToMany::getResults(), but no expectations were specified

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Concerns/HasAttributes.php:635
    631▕                 '%s::%s must return a relationship instance.', static::class, $method
    632▕             ));
    633▕         }
    634▕ 
  ➜ 635▕         return tap($relation->getResults(), function ($results) use ($method) {
    636▕             $this->setRelation($method, $results);
    637▕         });
    638▕     }
    639▕

      [2m+4 vendor frames [22m
  5   Modules/User/app/Models/Traits/HasTeams.php:77
  6   Modules/User/tests/Unit/Models/Traits/HasTeamsTest.php:52

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\Traits\Has…  BadMethodCallException   
  Received Mockery_5_Illuminate_Database_Eloquent_Relations_BelongsToMany::getResults(), but no expectations were specified

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Concerns/HasAttributes.php:635
    631▕                 '%s::%s must return a relationship instance.', static::class, $method
    632▕             ));
    633▕         }
    634▕ 
  ➜ 635▕         return tap($relation->getResults(), function ($results) use ($method) {
    636▕             $this->setRelation($method, $results);
    637▕         });
    638▕     }
    639▕

      [2m+4 vendor frames [22m
  5   Modules/User/app/Models/Traits/HasTeams.php:77
  6   Modules/User/tests/Unit/Models/Traits/HasTeamsTest.php:68

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\Traits\Has…  BadMethodCallException   
  Received Mockery_5_Illuminate_Database_Eloquent_Relations_BelongsToMany::getResults(), but no expectations were specified

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Concerns/HasAttributes.php:635
    631▕                 '%s::%s must return a relationship instance.', static::class, $method
    632▕             ));
    633▕         }
    634▕ 
  ➜ 635▕         return tap($relation->getResults(), function ($results) use ($method) {
    636▕             $this->setRelation($method, $results);
    637▕         });
    638▕     }
    639▕

      [2m+4 vendor frames [22m
  5   Modules/User/app/Models/Traits/HasTeams.php:77
  6   Modules/User/tests/Unit/Models/Traits/HasTeamsTest.php:84

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\Traits\Has…  BadMethodCallException   
  Received Mockery_5_Illuminate_Database_Eloquent_Relations_BelongsToMany::getResults(), but no expectations were specified

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Concerns/HasAttributes.php:635
    631▕                 '%s::%s must return a relationship instance.', static::class, $method
    632▕             ));
    633▕         }
    634▕ 
  ➜ 635▕         return tap($relation->getResults(), function ($results) use ($method) {
    636▕             $this->setRelation($method, $results);
    637▕         });
    638▕     }
    639▕

      [2m+4 vendor frames [22m
  5   Modules/User/app/Models/Traits/HasTeams.php:77
  6   Modules/User/tests/Unit/Models/Traits/HasTeamsTest.php:100

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\Traits\Has…  BadMethodCallException   
  Received Mockery_5_Illuminate_Database_Eloquent_Relations_BelongsToMany::getResults(), but no expectations were specified

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Concerns/HasAttributes.php:635
    631▕                 '%s::%s must return a relationship instance.', static::class, $method
    632▕             ));
    633▕         }
    634▕ 
  ➜ 635▕         return tap($relation->getResults(), function ($results) use ($method) {
    636▕             $this->setRelation($method, $results);
    637▕         });
    638▕     }
    639▕

      [2m+4 vendor frames [22m
  5   Modules/User/app/Models/Traits/HasTeams.php:77
  6   Modules/User/tests/Unit/Models/Traits/HasTeamsTest.php:162

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\Traits\Has…  BadMethodCallException   
  Received Mockery_5_Illuminate_Database_Eloquent_Relations_BelongsToMany::getResults(), but no expectations were specified

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Concerns/HasAttributes.php:635
    631▕                 '%s::%s must return a relationship instance.', static::class, $method
    632▕             ));
    633▕         }
    634▕ 
  ➜ 635▕         return tap($relation->getResults(), function ($results) use ($method) {
    636▕             $this->setRelation($method, $results);
    637▕         });
    638▕     }
    639▕

      [2m+4 vendor frames [22m
  5   Modules/User/app/Models/Traits/HasTeams.php:77
  6   Modules/User/tests/Unit/Models/Traits/HasTeamsTest.php:182

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\Traits\Has…  BadMethodCallException   
  Received Mockery_5_Illuminate_Database_Eloquent_Relations_BelongsToMany::getResults(), but no expectations were specified

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Concerns/HasAttributes.php:635
    631▕                 '%s::%s must return a relationship instance.', static::class, $method
    632▕             ));
    633▕         }
    634▕ 
  ➜ 635▕         return tap($relation->getResults(), function ($results) use ($method) {
    636▕             $this->setRelation($method, $results);
    637▕         });
    638▕     }
    639▕

      [2m+4 vendor frames [22m
  5   Modules/User/app/Models/Traits/HasTeams.php:77
  6   Modules/User/tests/Unit/Models/Traits/HasTeamsTest.php:198

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\Traits\Has…  BadMethodCallException   
  Received Mockery_5_Illuminate_Database_Eloquent_Relations_BelongsToMany::getResults(), but no expectations were specified

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Concerns/HasAttributes.php:635
    631▕                 '%s::%s must return a relationship instance.', static::class, $method
    632▕             ));
    633▕         }
    634▕ 
  ➜ 635▕         return tap($relation->getResults(), function ($results) use ($method) {
    636▕             $this->setRelation($method, $results);
    637▕         });
    638▕     }
    639▕

      [2m+4 vendor frames [22m
  5   Modules/User/app/Models/Traits/HasTeams.php:77
  6   Modules/User/tests/Unit/Models/Traits/HasTeamsTest.php:213

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\Traits\Has…  BadMethodCallException   
  Received Mockery_5_Illuminate_Database_Eloquent_Relations_BelongsToMany::getResults(), but no expectations were specified

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Concerns/HasAttributes.php:635
    631▕                 '%s::%s must return a relationship instance.', static::class, $method
    632▕             ));
    633▕         }
    634▕ 
  ➜ 635▕         return tap($relation->getResults(), function ($results) use ($method) {
    636▕             $this->setRelation($method, $results);
    637▕         });
    638▕     }
    639▕

      [2m+4 vendor frames [22m
  5   Modules/User/app/Models/Traits/HasTeams.php:77
  6   Modules/User/tests/Unit/Models/Traits/HasTeamsTest.php:314

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\Traits\Has…  BadMethodCallException   
  Received Mockery_5_Illuminate_Database_Eloquent_Relations_BelongsToMany::getResults(), but no expectations were specified

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Concerns/HasAttributes.php:635
    631▕                 '%s::%s must return a relationship instance.', static::class, $method
    632▕             ));
    633▕         }
    634▕ 
  ➜ 635▕         return tap($relation->getResults(), function ($results) use ($method) {
    636▕             $this->setRelation($method, $results);
    637▕         });
    638▕     }
    639▕

      [2m+4 vendor frames [22m
  5   Modules/User/app/Models/Traits/HasTeams.php:77
  6   Modules/User/tests/Unit/Models/Traits/HasTeamsTest.php:352

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\Models\Traits\Has…  BadMethodCallException   
  Received Mockery_5_Illuminate_Database_Eloquent_Relations_BelongsToMany::getResults(), but no expectations were specified

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Concerns/HasAttributes.php:635
    631▕                 '%s::%s must return a relationship instance.', static::class, $method
    632▕             ));
    633▕         }
    634▕ 
  ➜ 635▕         return tap($relation->getResults(), function ($results) use ($method) {
    636▕             $this->setRelation($method, $results);
    637▕         });
    638▕     }
    639▕

      [2m+4 vendor frames [22m
  5   Modules/User/app/Models/Traits/HasTeams.php:77
  6   Modules/User/tests/Unit/Models/Traits/HasTeamsTest.php:396

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\PermissionTest > permissi…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/PermissionTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\PermissionTest > permissi…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/PermissionTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\PermissionTest > permissi…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/PermissionTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\PermissionTest > permissi…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/PermissionTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\PermissionTest > permissi…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/PermissionTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\PermissionTest > permissi…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/PermissionTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\PermissionTest > permissi…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/PermissionTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\PermissionTest > permissi…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/PermissionTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\PermissionTest > permissi…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/PermissionTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\PermissionTest > permissi…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/PermissionTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\PermissionTest > permissi…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/PermissionTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\PermissionTest > permissi…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/PermissionTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\PermissionTest > permissi…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/PermissionTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\PermissionTest > permissi…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/PermissionTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\PermissionTest > permissi…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/PermissionTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\PermissionTest > permissi…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/PermissionTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\PermissionTest > permissi…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/PermissionTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\PermissionTest > permissi…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/PermissionTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\PermissionTest > permissi…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/PermissionTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\PermissionTest > permissi…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/PermissionTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\PermissionTest > permissi…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/PermissionTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\RoleTest > role can be cr…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/RoleTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\RoleTest > role has corre…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/RoleTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\RoleTest > role has corre…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/RoleTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\RoleTest > role has corre…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/RoleTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\RoleTest > role can be up…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/RoleTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\RoleTest > role can be de…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/RoleTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\RoleTest > role can have…   QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/RoleTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\RoleTest > role can have…   QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/RoleTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\RoleTest > role can revok…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/RoleTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\RoleTest > role can be fo…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/RoleTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\RoleTest > role can be fo…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/RoleTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\RoleTest > role has times…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/RoleTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\RoleTest > role can be cr…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/RoleTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\RoleTest > role can be cr…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/RoleTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\RoleTest > role can check…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/RoleTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\RoleTest > role can check…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/RoleTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\RoleTest > role can be fi…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/RoleTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\RoleTest > role handles n…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_spatie.permission.cache, laravel_cache_illuminate:cache:flexible:created:spatie.permission.cache))

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:605
    601▕ 
    602▕             // For update or delete statements, we want to get the number of rows affected
    603▕             // by the statement and return that back to the developer. We'll first need
    604▕             // to execute the statement and then we'll use PDO to fetch the affected.
  ➜ 605▕             $statement = $this->getPdo()->prepare($query);
    606▕ 
    607▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    608▕ 
    609▕             $statement->execute();

      [2m+22 vendor frames [22m
  23  Modules/User/tests/Unit/RoleTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\TenantTest > tenant has f…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_user_test.media' doesn't exist (Connection: user, Host: 127.0.0.1, Port: 3306, Database: quaeris_user_test, SQL: select * from `media` where `media`.`model_id` in (ce551e05-712f-4234-a3c1-45acae098386) and `media`.`model_type` = Modules\User\Models\Tenant)

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:420
    416▕             // For select statements, we'll simply execute the query and return an array
    417▕             // of the database result set. Each element in the array will be a single
    418▕             // row from the database table, and will either be an array or objects.
    419▕             $statement = $this->prepared(
  ➜ 420▕                 $this->getPdoForSelect($useReadPdo)->prepare($query)
    421▕             );
    422▕ 
    423▕             $this->bindValues($statement, $this->prepareBindings($bindings));
    424▕

      [2m+25 vendor frames [22m
  26  Modules/User/app/Models/BaseTenant.php:108
  27  Modules/User/tests/Unit/TenantTest.php:121

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\User\tests\Unit\TenantTest > tenant can b…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_user_test.media' doesn't exist (Connection: user, Host: 127.0.0.1, Port: 3306, Database: quaeris_user_test, SQL: select * from `media` where `media`.`model_type` = Modules\User\Models\Tenant and `media`.`model_id` = 5f58b2a4-e769-4b49-a43d-22170079b6de and `media`.`model_id` is not null)

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:483
    479▕             // First we will create a statement for the query. Then, we will set the fetch
    480▕             // mode and prepare the bindings for the query. Once that's done we will be
    481▕             // ready to execute the query against the database and return the cursor.
    482▕             $statement = $this->prepared($this->getPdoForSelect($useReadPdo)
  ➜ 483▕                 ->prepare($query));
    484▕ 
    485▕             $this->bindValues(
    486▕                 $statement, $this->prepareBindings($bindings)
    487▕             );

      [2m+18 vendor frames [22m
  19  Modules/User/tests/Unit/TenantTest.php:172


  Tests:    321 failed, 2 risky, 4 skipped, 413 passed (1126 assertions)
  Duration: 170.56s

