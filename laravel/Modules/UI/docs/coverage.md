# Code Coverage: UI

**Date:** 2026-01-17
**Lines Coverage:** N/A (Failed to parse)
**Test Exit Code:** 2

## Output

```text
endor/laravel/framework/src/Illuminate/Container/Container.php:1415
    1411▕         } else {
    1412▕             $message = "Target [$concrete] is not instantiable.";
    1413▕         }
    1414▕ 
  ➜ 1415▕         throw new BindingResolutionException($message);
    1416▕     }
    1417▕ 
    1418▕     /**
    1419▕      * Throw an exception for an unresolvable primitive.

      [2m+8 vendor frames [22m
  9   Modules/Xot/app/Filament/Widgets/XotBaseWidget.php:233
  10  Modules/Xot/app/Filament/Widgets/XotBaseWidget.php:69

  ──────────────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Widgets\BaseCalendarWidge…  BindingResolutionException   
  Target [Illuminate\Contracts\View\Factory] is not instantiable.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1415
    1411▕         } else {
    1412▕             $message = "Target [$concrete] is not instantiable.";
    1413▕         }
    1414▕ 
  ➜ 1415▕         throw new BindingResolutionException($message);
    1416▕     }
    1417▕ 
    1418▕     /**
    1419▕      * Throw an exception for an unresolvable primitive.

      [2m+8 vendor frames [22m
  9   Modules/Xot/app/Filament/Widgets/XotBaseWidget.php:233
  10  Modules/Xot/app/Filament/Widgets/XotBaseWidget.php:69

  ──────────────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Widgets\BaseCalendarWidge…  BindingResolutionException   
  Target [Illuminate\Contracts\View\Factory] is not instantiable.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1415
    1411▕         } else {
    1412▕             $message = "Target [$concrete] is not instantiable.";
    1413▕         }
    1414▕ 
  ➜ 1415▕         throw new BindingResolutionException($message);
    1416▕     }
    1417▕ 
    1418▕     /**
    1419▕      * Throw an exception for an unresolvable primitive.

      [2m+8 vendor frames [22m
  9   Modules/Xot/app/Filament/Widgets/XotBaseWidget.php:233
  10  Modules/Xot/app/Filament/Widgets/XotBaseWidget.php:69

  ──────────────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Widgets\BaseCalendarWidge…  BindingResolutionException   
  Target [Illuminate\Contracts\View\Factory] is not instantiable.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1415
    1411▕         } else {
    1412▕             $message = "Target [$concrete] is not instantiable.";
    1413▕         }
    1414▕ 
  ➜ 1415▕         throw new BindingResolutionException($message);
    1416▕     }
    1417▕ 
    1418▕     /**
    1419▕      * Throw an exception for an unresolvable primitive.

      [2m+8 vendor frames [22m
  9   Modules/Xot/app/Filament/Widgets/XotBaseWidget.php:233
  10  Modules/Xot/app/Filament/Widgets/XotBaseWidget.php:69


  Tests:    76 failed, 1 risky, 39 skipped, 42 passed (90 assertions)
  Duration: 33.74s


```
