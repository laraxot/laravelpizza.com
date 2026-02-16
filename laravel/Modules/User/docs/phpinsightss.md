


[2026-01-12 21:05:06] `Modules/User/app`

                                                                                                    
              82.0%                 91.9%                 76.5%                 88.0%               
                                                                                                    
                                                                                                    
               Code               Complexity           Architecture             Style               


Score scale: ◼ 1-49 ◼ 50-79 ◼ 80-100

[CODE] 82 pts within 14237 lines

Comments ...................................................... 53.7 %
Classes ....................................................... 23.7 %
Functions ...................................................... 0.0 %
Globally ...................................................... 22.5 %

[COMPLEXITY] 91.9 pts with average of 1.60 cyclomatic complexity

[ARCHITECTURE] 76.5 pts within 454 files

Classes ....................................................... 90.7 %
Interfaces ..................................................... 5.1 %
Globally ....................................................... 1.3 %
Traits ......................................................... 2.9 %

[MISC] 88 pts on coding style

• [Code] Forbidden public property:
  Providers/EventServiceProvider.php:23: Do not use public properties. Use method access instead.
  Providers/RouteServiceProvider.php:11: Do not use public properties. Use method access instead.
  Providers/UserServiceProvider.php:26: Do not use public properties. Use method access instead.
  +128 issues omitted

• [Code] Forbidden setter:
  Datas/PasswordData.php:126: Setters are not allowed. Use constructor injection and behavior naming instead.
  Models/BaseUser.php:480: Setters are not allowed. Use constructor injection and behavior naming instead.
  Models/Traits/InteractsWithTenant.php:89: Setters are not allowed. Use constructor injection and behavior naming instead.
  +1 issues omitted

• [Code] Unused variable:
  Models/Policies/UserBasePolicy.php:24: Unused variable $xotData.
  Models/Traits/InteractsWithTenant.php:36: Unused variable $tenant.
  Providers/UserServiceProvider.php:54: Unused variable $app_name.
  +15 issues omitted

• [Code] Empty statement:
  Actions/Socialite/RetrieveSocialiteUserAction.php:76: Empty CATCH statement detected
  Actions/Socialite/Utils/UserNameFieldsResolver.php:87: Empty CATCH statement detected
  Models/Policies/UserPermissionBasePolicy.php:38: Empty CATCH statement detected

• [Code] Useless overriding method:
  Filament/Resources/PasswordResetResource.php:48: Possible useless method overriding detected
  Models/DeviceProfile.php:42: Possible useless method overriding detected
  Providers/UserServiceProvider.php:44: Possible useless method overriding detected

• [Code] Disallow empty:
  Models/BaseUser.php:482: Use of empty() is disallowed.
  Models/SsoProvider.php:110: Use of empty() is disallowed.
  Providers/PassportServiceProvider.php:143: Use of empty() is disallowed.
  +32 issues omitted

• [Code] Disallow yoda comparison:
  Models/Traits/IsProfileTrait.php:298: Yoda comparisons are disallowed.
  Observers/UserObserver.php:35: Yoda comparisons are disallowed.
  Rules/CheckOtpExpiredRule.php:29: Yoda comparisons are disallowed.
  +148 issues omitted

• [Code] Declare strict types:
  Filament/Resources/TenantResource/RelationManagers/DomainsRelationManager.php:6: Expected 1 line before declare statement, found 0.
  Http/Controllers/Api/RegisterController.php:19: Expected 1 line before declare statement, found 0.
  Http/Controllers/Auth/EmailVerificationController.php:19: Expected 1 line before declare statement, found 0.
  +4 issues omitted

• [Code] Todo:
  Http/Controllers/Api/LogoutController.php:48: Comment refers to a TODO task "Implement token cleanup logic here"
  Http/Controllers/Api/LogoutController.php:57: Comment refers to a TODO task "Implement mobile device user logout logic here"
  Http/Controllers/Api/LogoutController.php:60: Comment refers to a TODO task "Implement response logic here"
  +1 issues omitted

• [Code] Inline doc comment declaration:
  Providers/PassportServiceProvider.php:115: Invalid comment type /* */ for inline documentation comment, use /** */.
  Providers/PassportServiceProvider.php:144: Invalid comment type /* */ for inline documentation comment, use /** */.
  Providers/Traits/HasPassportConfiguration.php:82: Invalid comment type /* */ for inline documentation comment, use /** */.
  +58 issues omitted

• [Code] Disallow mixed type hint:
  Models/OauthClient.php:114: Usage of "mixed" type hint is disallowed.
  Models/OauthClient.php:125: Usage of "mixed" type hint is disallowed.
  Notifications/Auth/Otp.php:34: Usage of "mixed" type hint is disallowed.
  +57 issues omitted

• [Code] Parameter type hint:
  Notifications/Auth/ResetPassword.php:16: Method \Modules\User\Notifications\Auth\ResetPassword::resetUrl() does not have parameter type hint nor @param annotation for its parameter $notifiable.
  Notifications/Auth/ResetPassword.php:24: Method \Modules\User\Notifications\Auth\ResetPassword::buildMailMessage() does not have parameter type hint nor @param annotation for its parameter $url.
  Notifications/Auth/VerifyEmail.php:13: Method \Modules\User\Notifications\Auth\VerifyEmail::verificationUrl() does not have parameter type hint nor @param annotation for its parameter $notifiable.
  +25 issues omitted

• [Code] Property type hint:
  Models/User.php:142: Property \Modules\User\Models\User::$childTypes does not have native type hint for its value but it should be possible to add it based on @var annotation "array<string, class-string>".
  Providers/EventServiceProvider.php:34: Property \Modules\User\Providers\EventServiceProvider::$listen does not have native type hint for its value but it should be possible to add it based on @var annotation "array<class-string, array<int, class-string>>".
  Providers/EventServiceProvider.php:52: Property \Modules\User\Providers\EventServiceProvider::$subscribe does not have native type hint nor @var annotation for its value.
  +131 issues omitted

• [Code] Return type hint:
  Support/Utils.php:219: Method \Modules\User\Support\Utils::getExcludedPages() does not have @return annotation for its traversable return value.
  Support/Utils.php:226: Method \Modules\User\Support\Utils::getExcludedWidgets() does not have @return annotation for its traversable return value.
  Support/Utils.php:257: Method \Modules\User\Support\Utils::getResourcePermissionPrefixes() does not have @return annotation for its traversable return value.
  +113 issues omitted

• [Code] Unused parameter:
  Notifications/Auth/VerifyEmail.php:13: Unused parameter $notifiable.
  Rules/CheckOtpExpiredRule.php:27: Unused parameter $_attribute.
  Rules/CheckOtpExpiredRule.php:27: Unused parameter $_value.
  +153 issues omitted

• [Code] Static closure:
  Providers/UserServiceProvider.php:110: Closure not using "$this" should be declared static.
  Providers/UserServiceProvider.php:135: Closure not using "$this" should be declared static.
  Providers/UserServiceProvider.php:140: Closure not using "$this" should be declared static.
  +85 issues omitted

• [Code] Defining global helpers is prohibited:
  Enums/UserType.php:2:getLabel
  Enums/UserType.php:3:getColor
  Enums/UserType.php:4:getIcon
  +3 issues omitted

• [Code] Return assignment:
  Filament/Widgets/EditUserWidget.php: 
@@ -128,5 +128,3 @@
         /** @var array<int|string, Component> $result */
-        $result = $schema;
-
-        return $result;
+        return $schema;
     }
  Filament/Widgets/RegistrationWidget.php: 
@@ -79,5 +79,3 @@
             /** @var Model $model */
-            $model = app($this->model);
-
-            return $model;
+            return app($this->model);
         }
  Http/Livewire/Auth/Passwords/Confirm.php: 
@@ -40,5 +40,3 @@
         /** @var View $result */
-        $result = view($view)->extends('pub_theme::layouts.auth');
-
-        return $result;
+        return view($view)->extends('pub_theme::layouts.auth');
     }
  +1 issues omitted

• [Complexity] Having `classes` with total cyclomatic complexity more than 5 is prohibited - Consider refactoring:
  Observers/UserObserver.php: 7 cyclomatic complexity
  Providers/PassportServiceProvider.php: 7 cyclomatic complexity
  Providers/UserServiceProvider.php: 18 cyclomatic complexity
  +71 issues omitted

• [Complexity] Having `classes` with average method cyclomatic complexity more than 5 is prohibited - Consider refactoring:
  Http/Controllers/Auth/VerifyEmailController.php: 10.00 cyclomatic complexity
  Http/Controllers/Socialite/ProcessCallbackController.php: 14.00 cyclomatic complexity
  Http/Controllers/Socialite/RedirectToProviderController.php: 7.00 cyclomatic complexity
  +4 issues omitted

• [Complexity] Having `methods` with cyclomatic complexity more than 5 is prohibited - Consider refactoring:
  Listeners/LogoutListener.php:handle: 7 cyclomatic complexity
  Models/Traits/HasTeams.php:teamPermissions: 7 cyclomatic complexity
  Models/Traits/IsProfileTrait.php:getFullNameAttribute: 6 cyclomatic complexity
  +26 issues omitted

• [Architecture] Normal classes are forbidden. Classes must be final or abstract:
  Rules/CheckOtpExpiredRule.php
  Support/Utils.php
  View/Components/Mail/Message.php
  +367 issues omitted

• [Architecture] Function length:
  Models/Traits/IsProfileTrait.php:189: Your function is too long. Currently using 27 lines. Can be up to 20 lines.
  Observers/UserObserver.php:25: Your function is too long. Currently using 23 lines. Can be up to 20 lines.
  Providers/UserServiceProvider.php:50: Your function is too long. Currently using 48 lines. Can be up to 20 lines.
  +75 issues omitted

• [Architecture] The use of `traits` is prohibited:
  Models/Traits/IsTenant.php
  Providers/Traits/HasPassportConfiguration.php
  Traits/PasswordValidationRules.php
  +10 issues omitted

• [Architecture] Superfluous trait naming:
  Models/Traits/HasAuthenticationLogTrait.php:28: Superfluous suffix "Trait".
  Models/Traits/IsProfileTrait.php:46: Superfluous suffix "Trait".

• [Style] Object operator indent:
  Filament/Clusters/Passport/Resources/OauthAccessTokenResource.php:126: Object operator not indented correctly; expected 12 spaces but found 24

• [Style] Line length:
  Support/Utils.php:257: Line exceeds 80 characters; contains 85 characters
  Support/Utils.php:276: Line exceeds 80 characters; contains 89 characters
  Support/Utils.php:286: Line exceeds 80 characters; contains 94 characters
  +1060 issues omitted

• [Style] Alphabetically sorted uses:
  Console/Commands/SuperAdminCommand.php:12: Use statements should be sorted alphabetically. The first wrong one is Modules\User\Models\Role.
  Http/Livewire/PrivacyPolicy.php:14: Use statements should be sorted alphabetically. The first wrong one is Webmozart\Assert\Assert.
  Support/Utils.php:16: Use statements should be sorted alphabetically. The first wrong one is Spatie\Permission\Models\Permission.
  +9 issues omitted

• [Style] Unused uses:
  Filament/Widgets/Auth/ResetPasswordWidget.php:11: Type Illuminate\Database\Eloquent\Model is not used in this file.
  Http/Livewire/Auth/Passwords/Reset.php:13: Type Illuminate\Database\Eloquent\Model is not used in this file.
  Providers/PassportServiceProvider.php:8: Type Illuminate\Support\Facades\Gate is not used in this file.
  +4 issues omitted

• [Style] Use spacing:
  Http/Livewire/PrivacyPolicy.php:14: Expected 0 lines between different types of use statement, found 1.
  Support/Utils.php:13: Expected 0 lines between different types of use statement, found 1.
  Support/Utils.php:16: Expected 0 lines between different types of use statement, found 1.
  +27 issues omitted

• [Style] Doc comment spacing:
  Http/Resources/ClientResource.php:13: Expected 1 line between different annotations types, found 0.
  Models/Role.php:27: Expected 1 line between description and annotations, found 2.
  Models/Role.php:52: Expected 1 line between different annotations types, found 2.

• [Style] Align multiline comment:
  Models/Role.php: 
@@ -50,3 +50,3 @@
  *
-  *
+ *
  * @property int $id

• [Style] Method chaining indentation:
  Filament/Clusters/Passport/Resources/OauthAccessTokenResource.php: 
@@ -125,3 +125,3 @@
             ])
-                        ->defaultSort('created_at', 'desc');
+            ->defaultSort('created_at', 'desc');
     }

• [Style] Phpdoc indent:
  Models/Role.php: 
@@ -50,3 +50,3 @@
  *
-  *
+ *
  * @property int $id

• [Style] Ordered class elements:
  Filament/Widgets/Auth/BaseAuthWidget.php: 
@@ -21,2 +21,10 @@
     /**
+     * Restituisce lo schema del form per l'autenticazione.
+     * Deve essere implementato dalle classi concrete.
+     *
+     * @return array<mixed>
+     */
+    abstract public function getFormSchema(): array;
+
+    /**
      * Restituisce i dati per la view.
@@ -32,10 +40,2 @@
     }
-
-    /**
-     * Restituisce lo schema del form per l'autenticazione.
-     * Deve essere implementato dalle classi concrete.
-     *
-     * @return array<mixed>
-     */
-    abstract public function getFormSchema(): array;
 }
  Models/BaseUser.php: 
@@ -134,8 +134,2 @@
     }
-
-    public function createToken(string $name, array $scopes = []): \Laravel\Passport\PersonalAccessTokenResult
-    {
-        /** @var \Laravel\Passport\PersonalAccessTokenResult */
-        return $this->traitCreateToken($name, $scopes);
-    }
     use HasAuthenticationLogTrait;
@@ -235,2 +229,8 @@
 
+    public function createToken(string $name, array $scopes = []): \Laravel\Passport\PersonalAccessTokenResult
+    {
+        /** @var \Laravel\Passport\PersonalAccessTokenResult */
+        return $this->traitCreateToken($name, $scopes);
+    }
+
     public function getProviderName(): string
@@ -504,2 +504,18 @@
 
+    /**
+     * Find the user instance for the given username.
+     */
+    public static function findForPassport(string $username): ?self
+    {
+        return static::where('email', $username)->first();
+    }
+
+    /**
+     * Validate the password of the user for the given password.
+     */
+    public function validateForPassportPasswordGrant(string $password): bool
+    {
+        return Hash::check($password, (string) $this->password);
+    }
+
     /** @return array<string, string> */
@@ -525,18 +541,2 @@
         ];
-    }
-
-    /**
-     * Find the user instance for the given username.
-     */
-    public static function findForPassport(string $username): ?self
-    {
-        return static::where('email', $username)->first();
-    }
-
-    /**
-     * Validate the password of the user for the given password.
-     */
-    public function validateForPassportPasswordGrant(string $password): bool
-    {
-        return Hash::check($password, (string) $this->password);
     }
  Models/Profile.php: 
@@ -112,2 +112,9 @@
     /**
+     * The table associated with the model.
+     *
+     * @var string
+     */
+    protected $table = 'profiles';
+
+    /**
      * Get the teams that the profile belongs to.
@@ -138,9 +145,2 @@
     }
-
-    /**
-     * The table associated with the model.
-     *
-     * @var string
-     */
-    protected $table = 'profiles';
 }

 [ERROR] The code quality score is too low                                                              

 [ERROR] The architecture score is too low                                                              

 [ERROR] The style score is too low                                                                     


