


[[DATE] 21:07:02] `Modules/Activity/app`

                                                                                                    
              90.0%                 89.2%                 82.4%                 98.8%               
                                                                                                    
                                                                                                    
               Code               Complexity           Architecture             Style               


Score scale: ◼ 1-49 ◼ 50-79 ◼ 80-100

[CODE] 90 pts within 1132 lines

Comments ...................................................... 53.2 %
Classes ....................................................... 24.7 %
Functions ...................................................... 0.0 %
Globally ...................................................... 22.1 %

[COMPLEXITY] 89.2 pts with average of 1.76 cyclomatic complexity

[ARCHITECTURE] 82.4 pts within 40 files

Classes ....................................................... 92.5 %
Interfaces ..................................................... 0.0 %
Globally ....................................................... 0.0 %
Traits ......................................................... 7.5 %

[MISC] 98.8 pts on coding style

• [Code] Forbidden public property:
  Filament/Pages/Concerns/CanPaginate.php:18: Do not use public properties. Use method access instead.
  Providers/ActivityServiceProvider.php:22: Do not use public properties. Use method access instead.
  Providers/RouteServiceProvider.php:16: Do not use public properties. Use method access instead.

• [Code] Empty statement:
  Actions/LogModelCreatedAction.php:24: Empty IF statement detected
  Actions/LogModelDeletedAction.php:24: Empty IF statement detected
  Actions/LogModelUpdatedAction.php:24: Empty IF statement detected

• [Code] Useless overriding method:
  Providers/Filament/AdminPanelProvider.php:16: Possible useless method overriding detected

• [Code] Inline doc comment declaration:
  Filament/Pages/ListLogActivities.php:118: Missing variable $builderQuery before or after the documentation comment.

• [Code] Disallow mixed type hint:
  Models/StoredEvent.php:25: Usage of "mixed" type hint is disallowed.
  Models/StoredEvent.php:52: Usage of "mixed" type hint is disallowed.
  Models/StoredEvent.php:53: Usage of "mixed" type hint is disallowed.
  +20 issues omitted

• [Code] Parameter type hint:
  Filament/Pages/ListLogActivities.php:322: Method \Modules\Activity\Filament\Pages\ListLogActivities::performRestore() does not have @param annotation for its traversable parameter $oldProperties.

• [Code] Property type hint:
  Models/StoredEvent.php:71: Property \Modules\Activity\Models\StoredEvent::$fillable does not have native type hint for its value but it should be possible to add it based on @var annotation "list<string>".
  Providers/EventServiceProvider.php:20: Property \Modules\Activity\Providers\EventServiceProvider::$listen does not have native type hint for its value but it should be possible to add it based on @var annotation "array<string, array<int, string>>".
  Providers/EventServiceProvider.php:34: Property \Modules\Activity\Providers\EventServiceProvider::$shouldDiscoverEvents does not have native type hint for its value but it should be possible to add it based on @var annotation "bool".
  +8 issues omitted

• [Code] Return type hint:
  Filament/Resources/StoredEventResource.php:23: Method \Modules\Activity\Filament\Resources\StoredEventResource::getFormSchema() does not have @return annotation for its traversable return value.
  Filament/Resources/StoredEventResource.php:36: Method \Modules\Activity\Filament\Resources\StoredEventResource::getRelations() does not have @return annotation for its traversable return value.
  Filament/Resources/StoredEventResource.php:42: Method \Modules\Activity\Filament\Resources\StoredEventResource::getPages() does not have @return annotation for its traversable return value.
  +6 issues omitted

• [Code] Unused parameter:
  Actions/ActivityLogger.php:258: Unused parameter $_key.

• [Code] Static closure:
  Actions/ActivityLogger.php:246: Closure not using "$this" should be declared static.
  Actions/ActivityLogger.php:258: Closure not using "$this" should be declared static.
  Filament/Actions/ListLogActivitiesAction.php:53: Closure not using "$this" should be declared static.

• [Complexity] Having `classes` with total cyclomatic complexity more than 5 is prohibited - Consider refactoring:
  Filament/Pages/Concerns/CanPaginate.php: 8 cyclomatic complexity
  Filament/Pages/ListLogActivities.php: 37 cyclomatic complexity
  Listeners/LogoutListener.php: 7 cyclomatic complexity
  +2 issues omitted

• [Complexity] Having `classes` with average method cyclomatic complexity more than 5 is prohibited - Consider refactoring:
  Listeners/LogoutListener.php: 7.00 cyclomatic complexity

• [Complexity] Having `methods` with cyclomatic complexity more than 5 is prohibited - Consider refactoring:
  Filament/Pages/ListLogActivities.php:prepareRestore: 7 cyclomatic complexity
  Filament/Pages/ListLogActivities.php:restoreActivity: 7 cyclomatic complexity
  Listeners/LogoutListener.php:handle: 7 cyclomatic complexity
  +4 issues omitted

• [Architecture] Normal classes are forbidden. Classes must be final or abstract:
  Providers/EventServiceProvider.php
  Providers/Filament/AdminPanelProvider.php
  Providers/RouteServiceProvider.php
  +31 issues omitted

• [Architecture] Function length:
  Filament/Pages/ListLogActivities.php:159: Your function is too long. Currently using 25 lines. Can be up to 20 lines.
  Filament/Pages/ListLogActivities.php:203: Your function is too long. Currently using 38 lines. Can be up to 20 lines.
  Listeners/LogoutListener.php:19: Your function is too long. Currently using 28 lines. Can be up to 20 lines.
  +5 issues omitted

• [Architecture] The use of `traits` is prohibited:
  Filament/Pages/Concerns/CanPaginate.php
  Traits/HasEvents.php
  Traits/HasSnapshots.php

• [Style] Line length:
  Providers/ActivityServiceProvider.php:62: Line exceeds 80 characters; contains 89 characters
  Providers/ActivityServiceProvider.php:65: Line exceeds 80 characters; contains 90 characters
  Providers/EventServiceProvider.php:9: Line exceeds 80 characters; contains 93 characters
  +96 issues omitted

 [ERROR] The complexity score is too low                                                                

 [ERROR] The architecture score is too low                                                              


