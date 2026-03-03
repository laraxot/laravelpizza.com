# UI Coverage Report

- Generated: 2026-03-03T16:05:25Z
- Threshold: 100%
- Exit code: 2

```text

  sssssssssss⨯⨯⨯⨯sssssssssssssssssss..sssss⨯⨯....!..................⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯
  ⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯
  ⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯
  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\ComponentFilesExistTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\ComponentFilesExistTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\ComponentFilesExistTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\ComponentFilesExistTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\DarkModeToggleTest > bor…  ErrorException   
  file_get_contents(/var/www/_bases/base_laravelpizza/laravel/Themes/TwentyOne/resources/views/components/blocks/hero/kalshi-inspired.blade.php): Failed to open stream: No such file or directory

  at Modules/UI/tests/Feature/DarkModeToggleTest.php:187
    183▕ 
    184▕ test('border colors adapt to dark mode', function () {
    185▕     // Test that components have appropriate dark mode border colors
    186▕     $heroPath = base_path('Themes/TwentyOne/resources/views/components/blocks/hero/kalshi-inspired.blade.php');
  ➜ 187▕     $content = file_get_contents($heroPath);
    188▕ 
    189▕     // Borders should have appropriate colors (may include white/10 for glassmorphism)
    190▕     if (str_contains($content, 'border-')) {
    191▕         expect($content)->toContain('border-white/10')

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\DarkModeToggleTest > bac…  ErrorException   
  file_get_contents(/var/www/_bases/base_laravelpizza/laravel/Themes/TwentyOne/resources/views/components/blocks/hero/kalshi-inspired.blade.php): Failed to open stream: No such file or directory

  at Modules/UI/tests/Feature/DarkModeToggleTest.php:201
    197▕ 
    198▕ test('backdrop effects work in dark mode', function () {
    199▕     // Test that hero component has backdrop effects
    200▕     $heroPath = base_path('Themes/TwentyOne/resources/views/components/blocks/hero/kalshi-inspired.blade.php');
  ➜ 201▕     $content = file_get_contents($heroPath);
    202▕ 
    203▕     // Should have backdrop blur and similar effects
    204▕     if (str_contains($content, 'backdrop-blur')) {
    205▕         expect($content)->toContain('bg-white/5')

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\InlineDatePickerTest > it can be…   Error   
  Class "Filament\Forms\Forms\Components\InlineDatePicker" not found

  at Modules/UI/tests/Feature/InlineDatePickerTest.php:16
     12▕ 
     13▕ uses(TestCase::class);
     14▕ 
     15▕ test('it can be instantiated', function (): void {
  ➜  16▕     $component = InlineDatePicker::make('test');
     17▕     expect($component)->toBeInstanceOf(Field::class);
     18▕     expect($component)->toBeInstanceOf(InlineDatePicker::class);
     19▕ });
     20▕

  1   Modules/UI/tests/Feature/InlineDatePickerTest.php:16

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\InlineDatePickerTest > it can set…  Error   
  Class "Filament\Forms\Forms\Components\InlineDatePicker" not found

  at Modules/UI/tests/Feature/InlineDatePickerTest.php:24
     20▕ 
     21▕ test('it can set and get enabled dates', function (): void {
     22▕     $dates = ['2025-06-01', '2025-06-15', '2025-06-30'];
     23▕ 
  ➜  24▕     $component = InlineDatePicker::make('test')->enabledDates($dates);
     25▕     expect($component->getEnabledDates()->toArray())->toBe($dates);
     26▕ });
     27▕ 
     28▕ test('it accepts closure for enabled dates', function (): void {

  1   Modules/UI/tests/Feature/InlineDatePickerTest.php:24

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\InlineDatePickerTest > it accepts…  Error   
  Class "Filament\Forms\Forms\Components\InlineDatePicker" not found

  at Modules/UI/tests/Feature/InlineDatePickerTest.php:31
     27▕ 
     28▕ test('it accepts closure for enabled dates', function (): void {
     29▕     $dates = ['2025-06-01', '2025-06-15', '2025-06-30'];
     30▕ 
  ➜  31▕     $component = InlineDatePicker::make('test')->enabledDates(fn () => $dates);
     32▕     expect($component->getEnabledDates()->toArray())->toBe($dates);
     33▕ });
     34▕ 
     35▕ test('it checks if date is enabled', function (): void {

  1   Modules/UI/tests/Feature/InlineDatePickerTest.php:31

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\InlineDatePickerTest > it checks…   Error   
  Class "Filament\Forms\Forms\Components\InlineDatePicker" not found

  at Modules/UI/tests/Feature/InlineDatePickerTest.php:38
     34▕ 
     35▕ test('it checks if date is enabled', function (): void {
     36▕     $dates = ['2025-06-15'];
     37▕ 
  ➜  38▕     $component = InlineDatePicker::make('test')->enabledDates($dates);
     39▕ 
     40▕     expect($component->isDateEnabled('2025-06-15'))->toBeTrue();
     41▕     expect($component->isDateEnabled('2025-06-16'))->toBeFalse();
     42▕ });

  1   Modules/UI/tests/Feature/InlineDatePickerTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\InlineDatePickerTest > it generat…  Error   
  Class "Filament\Forms\Forms\Components\InlineDatePicker" not found

  at Modules/UI/tests/Feature/InlineDatePickerTest.php:45
     41▕     expect($component->isDateEnabled('2025-06-16'))->toBeFalse();
     42▕ });
     43▕ 
     44▕ test('it generates calendar data and marks enabled dates', function (): void {
  ➜  45▕     $component = InlineDatePicker::make('test')->enabledDates(['2025-06-15']);
     46▕     $component->currentViewMonth('2025-06');
     47▕     $data = $component->generateCalendarData();
     48▕ 
     49▕     expect($data)->toHaveKeys(['year', 'month', 'weeks', 'monthName', 'weekdays']);

  1   Modules/UI/tests/Feature/InlineDatePickerTest.php:45

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\InlineDatePickerTest > it respect…  Error   
  Class "Filament\Forms\Forms\Components\InlineDatePicker" not found

  at Modules/UI/tests/Feature/InlineDatePickerTest.php:64
     60▕ });
     61▕ 
     62▕ test('it respects locale in calendar data', function (): void {
     63▕     App::setLocale('it');
  ➜  64▕     $component = InlineDatePicker::make('test');
     65▕     $data = $component->generateCalendarData();
     66▕     expect($data)->toHaveKey('monthName');
     67▕ });
     68▕

  1   Modules/UI/tests/Feature/InlineDatePickerTest.php:64

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\InlineDatePickerTest > it can be…   Error   
  Class "Filament\Forms\Forms\Components\InlineDatePicker" not found

  at Modules/UI/tests/Feature/InlineDatePickerTest.php:71
     67▕ });
     68▕ 
     69▕ test('it can be used in a form', function (): void {
     70▕     $form = Schema::make()->components([
  ➜  71▕         InlineDatePicker::make('appointment_date')->enabledDates(['2025-06-15']),
     72▕     ]);
     73▕ 
     74▕     expect($form->getComponents())->toHaveCount(1);
     75▕     expect($form->getComponent('appointment_date'))->toBeInstanceOf(InlineDatePicker::class);

  1   Modules/UI/tests/Feature/InlineDatePickerTest.php:71

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\InlineDatePickerTest > it handles…  Error   
  Class "Filament\Forms\Forms\Components\InlineDatePicker" not found

  at Modules/UI/tests/Feature/InlineDatePickerTest.php:79
     75▕     expect($form->getComponent('appointment_date'))->toBeInstanceOf(InlineDatePicker::class);
     76▕ });
     77▕ 
     78▕ test('it handles empty enabled dates', function (): void {
  ➜  79▕     $component = InlineDatePicker::make('test')->enabledDates([]);
     80▕ 
     81▕     expect($component->getEnabledDates())->toBeInstanceOf(Collection::class);
     82▕     expect($component->getEnabledDates()->isEmpty())->toBeTrue();
     83▕     expect($component->isDateEnabled('2025-06-15'))->toBeTrue();

  1   Modules/UI/tests/Feature/InlineDatePickerTest.php:79

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\InlineDatePickerTest > it throws…   Error   
  Class "Filament\Forms\Forms\Components\InlineDatePicker" not found

  at Modules/UI/tests/Feature/InlineDatePickerTest.php:87
     83▕     expect($component->isDateEnabled('2025-06-15'))->toBeTrue();
     84▕ });
     85▕ 
     86▕ test('it throws on invalid enabled dates input', function (): void {
  ➜  87▕     $component = InlineDatePicker::make('test')->enabledDates(['invalid-date']);
     88▕     expect($component->getEnabledDates()->toArray(...))->toThrow(InvalidFormatException::class);
     89▕ });
     90▕ 
     91▕ test('it handles different date formats', function (): void {

  1   Modules/UI/tests/Feature/InlineDatePickerTest.php:87

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\InlineDatePickerTest > it handles…  Error   
  Class "Filament\Forms\Forms\Components\InlineDatePicker" not found

  at Modules/UI/tests/Feature/InlineDatePickerTest.php:92
     88▕     expect($component->getEnabledDates()->toArray(...))->toThrow(InvalidFormatException::class);
     89▕ });
     90▕ 
     91▕ test('it handles different date formats', function (): void {
  ➜  92▕     $component = InlineDatePicker::make('test')->enabledDates(['2025-06-15']);
     93▕ 
     94▕     expect($component->isDateEnabled('2025-06-15'))->toBeTrue();
     95▕     expect($component->isDateEnabled('15-06-2025'))->toBeFalse();
     96▕ });

  1   Modules/UI/tests/Feature/InlineDatePickerTest.php:92

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\InlineDatePickerTest > it handles…  Error   
  Class "Filament\Forms\Forms\Components\InlineDatePicker" not found

  at Modules/UI/tests/Feature/InlineDatePickerTest.php:99
     95▕     expect($component->isDateEnabled('15-06-2025'))->toBeFalse();
     96▕ });
     97▕ 
     98▕ test('it handles time portion gracefully', function (): void {
  ➜  99▕     $component = InlineDatePicker::make('test')->enabledDates(['2025-06-15']);
    100▕ 
    101▕     expect($component->isDateEnabled('2025-06-15 14:30:00'))->toBeTrue();
    102▕ });
    103▕

  1   Modules/UI/tests/Feature/InlineDatePickerTest.php:99

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\InlineDatePickerTest > it uses ca…  Error   
  Class "Filament\Forms\Forms\Components\InlineDatePicker" not found

  at Modules/UI/tests/Feature/InlineDatePickerTest.php:107
    103▕ 
    104▕ test('it uses carbon for localization', function (): void {
    105▕     // Arrange
    106▕     App::setLocale('it');
  ➜ 107▕     $picker = InlineDatePicker::make('test_date');
    108▕ 
    109▕     // Act
    110▕     $weekdays = invokeMethod($picker, 'getLocalizedWeekdays', []);
    111▕

  1   Modules/UI/tests/Feature/InlineDatePickerTest.php:107

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\InlineDatePickerTest > it generat…  Error   
  Class "Filament\Forms\Forms\Components\InlineDatePicker" not found

  at Modules/UI/tests/Feature/InlineDatePickerTest.php:118
    114▕ });
    115▕ 
    116▕ test('it generates correct calendar data', function (): void {
    117▕     // Arrange
  ➜ 118▕     $picker = InlineDatePicker::make('test_date');
    119▕     $picker->currentViewMonth = '2024-01';
    120▕ 
    121▕     // Act
    122▕     $calendarData = $picker->generateCalendarData();

  1   Modules/UI/tests/Feature/InlineDatePickerTest.php:118

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\InlineDatePickerTest > it handles…  Error   
  Class "Filament\Forms\Forms\Components\InlineDatePicker" not found

  at Modules/UI/tests/Feature/InlineDatePickerTest.php:135
    131▕ });
    132▕ 
    133▕ test('it handles enabled dates correctly', function (): void {
    134▕     // Arrange
  ➜ 135▕     $picker = InlineDatePicker::make('test_date');
    136▕     $picker->enabledDates(['2024-01-15', '2024-01-16']);
    137▕ 
    138▕     // Act & Assert
    139▕     expect($picker->isDateEnabled('2024-01-15'))->toBeTrue();

  1   Modules/UI/tests/Feature/InlineDatePickerTest.php:135

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\InlineDatePickerTest > i…  ErrorException   
  file_get_contents(/var/www/_bases/base_laravelpizza/laravel/laravel/Modules/UI/resources/views/filament/forms/components/inline-date-picker.blade.php): Failed to open stream: No such file or directory

  at Modules/UI/tests/Feature/InlineDatePickerTest.php:146
    142▕ });
    143▕ 
    144▕ test('it is dry no code duplication', function (): void {
    145▕     // Verifica che non ci sia duplicazione di logica tra PHP e JavaScript
  ➜ 146▕     $viewContent = file_get_contents(base_path(
    147▕         'laravel/Modules/UI/resources/views/filament/forms/components/inline-date-picker.blade.php',
    148▕     ));
    149▕ 
    150▕     // Assert: Nessun JavaScript complesso per navigazione

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\InlineDatePickerTest > it is kiss…  Error   
  Class "Filament\Forms\Forms\Components\InlineDatePicker" not found

  at Modules/UI/tests/Feature/InlineDatePickerTest.php:160
    156▕     expect($viewContent)->toContain('wire:click="nextMonth"');
    157▕ });
    158▕ 
    159▕ test('it is kiss simple and clear', function (): void {
  ➜ 160▕     $picker = InlineDatePicker::make('test_date');
    161▕ 
    162▕     // Assert: API semplice
    163▕     expect($picker->enabledDates(['2024-01-01']))->toBeInstanceOf(InlineDatePicker::class);
    164▕

  1   Modules/UI/tests/Feature/InlineDatePickerTest.php:160

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\KalshiHeroComp…  InvalidArgumentException   
  View [components.blocks.hero.kalshi-inspired] not found.

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

      [2m+5 vendor frames [22m
  6   Modules/UI/tests/Feature/KalshiHeroComponentTest.php:29

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\KalshiHeroComp…  InvalidArgumentException   
  View [components.blocks.hero.kalshi-inspired] not found.

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

      [2m+5 vendor frames [22m
  6   Modules/UI/tests/Feature/KalshiHeroComponentTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\KalshiHeroComp…  InvalidArgumentException   
  View [components.blocks.hero.kalshi-inspired] not found.

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

      [2m+5 vendor frames [22m
  6   Modules/UI/tests/Feature/KalshiHeroComponentTest.php:57

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\KalshiHeroComp…  InvalidArgumentException   
  View [components.blocks.hero.kalshi-inspired] not found.

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

      [2m+5 vendor frames [22m
  6   Modules/UI/tests/Feature/KalshiHeroComponentTest.php:67

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\KalshiHeroComp…  InvalidArgumentException   
  View [components.blocks.hero.kalshi-inspired] not found.

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

      [2m+5 vendor frames [22m
  6   Modules/UI/tests/Feature/KalshiHeroComponentTest.php:82

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\KalshiHeroComp…  InvalidArgumentException   
  View [components.blocks.hero.kalshi-inspired] not found.

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

      [2m+5 vendor frames [22m
  6   Modules/UI/tests/Feature/KalshiHeroComponentTest.php:91

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\KalshiHeroComp…  InvalidArgumentException   
  View [components.blocks.hero.kalshi-inspired] not found.

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

      [2m+5 vendor frames [22m
  6   Modules/UI/tests/Feature/KalshiHeroComponentTest.php:110

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\KalshiHeroComp…  InvalidArgumentException   
  View [components.blocks.hero.kalshi-inspired] not found.

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

      [2m+5 vendor frames [22m
  6   Modules/UI/tests/Feature/KalshiHeroComponentTest.php:120

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\KalshiHeroComp…  InvalidArgumentException   
  View [components.blocks.hero.kalshi-inspired] not found.

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

      [2m+5 vendor frames [22m
  6   Modules/UI/tests/Feature/KalshiHeroComponentTest.php:129

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\UIBusinessLogicTest > `UI…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\UIBusinessLogicTest > `UI…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\UIBusinessLogicTest > `UI…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\UIBusinessLogicTest > `UI…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\UIBusinessLogicTest > `UI…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\UIBusinessLogicTest > `UI…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\UIBusinessLogicTest > `UI…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\UIBusinessLogicTest > `UI…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\UIBusinessLogicTest > `UI…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\UIBusinessLogicTest > `UI…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\UIBusinessLogicTest > `UI…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\UIBusinessLogicTest > `UI…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\UIBusinessLogicTest > `UI…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\UIBusinessLogicTest > `UI…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\UIBusinessLogicTest > `UI…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\UIBusinessLogicTest > `UI…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\UIBusinessLogicTest > `UI…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\UIBusinessLogicTest > `UI…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\UIBusinessLogicTest > `UI…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\UIBusinessLogicTest > `UI…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\UIBusinessLogicTest > `UI…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Feature\WidgetBusinessLogicTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Components\ComponentTest > ui…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Components\ComponentTest > ui…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Components\ComponentTest > ui…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Enums\TableLayoutEnumTest > i…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Enums\TableLayoutEnumTest > i…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Enums\TableLayoutEnumTest > i…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Enums\TableLayoutEnumTest > i…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Enums\TableLayoutEnumTest > i…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Enums\TableLayoutEnumTest > i…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Enums\TableLayoutEnumTest > i…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Enums\TableLayoutEnumTest > i…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Enums\TableLayoutEnumTest > i…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Enums\TableLayoutEnumTest > i…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Filament\Widgets\RowWidgetTest > row…  Error   
  Cannot instantiate abstract class Modules\UI\Filament\Widgets\RowWidget

  at Modules/UI/tests/Unit/Filament/Widgets/RowWidgetTest.php:15
     11▕ 
     12▕ uses(TestCase::class);
     13▕ 
     14▕ beforeEach(function () {
  ➜  15▕     $this->widget = new RowWidget();
     16▕ });
     17▕ 
     18▕ test('row widget extends filament widget', function () {
     19▕     expect($this->widget)->toBeInstanceOf(Widget::class);

  1   Modules/UI/tests/Unit/Filament/Widgets/RowWidgetTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Filament\Widgets\RowWidgetTest > row…  Error   
  Cannot instantiate abstract class Modules\UI\Filament\Widgets\RowWidget

  at Modules/UI/tests/Unit/Filament/Widgets/RowWidgetTest.php:15
     11▕ 
     12▕ uses(TestCase::class);
     13▕ 
     14▕ beforeEach(function () {
  ➜  15▕     $this->widget = new RowWidget();
     16▕ });
     17▕ 
     18▕ test('row widget extends filament widget', function () {
     19▕     expect($this->widget)->toBeInstanceOf(Widget::class);

  1   Modules/UI/tests/Unit/Filament/Widgets/RowWidgetTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Filament\Widgets\RowWidgetTest > row…  Error   
  Cannot instantiate abstract class Modules\UI\Filament\Widgets\RowWidget

  at Modules/UI/tests/Unit/Filament/Widgets/RowWidgetTest.php:15
     11▕ 
     12▕ uses(TestCase::class);
     13▕ 
     14▕ beforeEach(function () {
  ➜  15▕     $this->widget = new RowWidget();
     16▕ });
     17▕ 
     18▕ test('row widget extends filament widget', function () {
     19▕     expect($this->widget)->toBeInstanceOf(Widget::class);

  1   Modules/UI/tests/Unit/Filament/Widgets/RowWidgetTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Filament\Widgets\RowWidgetTest > row…  Error   
  Cannot instantiate abstract class Modules\UI\Filament\Widgets\RowWidget

  at Modules/UI/tests/Unit/Filament/Widgets/RowWidgetTest.php:15
     11▕ 
     12▕ uses(TestCase::class);
     13▕ 
     14▕ beforeEach(function () {
  ➜  15▕     $this->widget = new RowWidget();
     16▕ });
     17▕ 
     18▕ test('row widget extends filament widget', function () {
     19▕     expect($this->widget)->toBeInstanceOf(Widget::class);

  1   Modules/UI/tests/Unit/Filament/Widgets/RowWidgetTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Filament\Widgets\RowWidgetTest > row…  Error   
  Cannot instantiate abstract class Modules\UI\Filament\Widgets\RowWidget

  at Modules/UI/tests/Unit/Filament/Widgets/RowWidgetTest.php:15
     11▕ 
     12▕ uses(TestCase::class);
     13▕ 
     14▕ beforeEach(function () {
  ➜  15▕     $this->widget = new RowWidget();
     16▕ });
     17▕ 
     18▕ test('row widget extends filament widget', function () {
     19▕     expect($this->widget)->toBeInstanceOf(Widget::class);

  1   Modules/UI/tests/Unit/Filament/Widgets/RowWidgetTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Filament\Widgets\StatWithIconWid…  Exception   
  View not found: pub_theme::filament.widgets.statwithicon, ui::filament.widgets.statwithicon

  at Modules/Xot/app/Actions/View/GetViewByClassAction.php:62
     58▕             $module_low.'::'.$implode.$suffix,
     59▕         ];
     60▕         $view = Arr::first($views, view()->exists(...));
     61▕         if (null === $view) {
  ➜  62▕             throw new \Exception('View not found: '.implode(', ', $views));
     63▕         }
     64▕ 
     65▕         if (view()->exists($view)) {
     66▕             return $view;

  1   Modules/Xot/app/Actions/View/GetViewByClassAction.php:62
  2   Modules/Xot/app/Filament/Widgets/XotBaseWidget.php:237

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Filament\Widgets\StatWithIconWid…  Exception   
  View not found: pub_theme::filament.widgets.statwithicon, ui::filament.widgets.statwithicon

  at Modules/Xot/app/Actions/View/GetViewByClassAction.php:62
     58▕             $module_low.'::'.$implode.$suffix,
     59▕         ];
     60▕         $view = Arr::first($views, view()->exists(...));
     61▕         if (null === $view) {
  ➜  62▕             throw new \Exception('View not found: '.implode(', ', $views));
     63▕         }
     64▕ 
     65▕         if (view()->exists($view)) {
     66▕             return $view;

  1   Modules/Xot/app/Actions/View/GetViewByClassAction.php:62
  2   Modules/Xot/app/Filament/Widgets/XotBaseWidget.php:237

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Filament\Widgets\StatWithIconWid…  Exception   
  View not found: pub_theme::filament.widgets.statwithicon, ui::filament.widgets.statwithicon

  at Modules/Xot/app/Actions/View/GetViewByClassAction.php:62
     58▕             $module_low.'::'.$implode.$suffix,
     59▕         ];
     60▕         $view = Arr::first($views, view()->exists(...));
     61▕         if (null === $view) {
  ➜  62▕             throw new \Exception('View not found: '.implode(', ', $views));
     63▕         }
     64▕ 
     65▕         if (view()->exists($view)) {
     66▕             return $view;

  1   Modules/Xot/app/Actions/View/GetViewByClassAction.php:62
  2   Modules/Xot/app/Filament/Widgets/XotBaseWidget.php:237

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Filament\Widgets\StatWithIconWid…  Exception   
  View not found: pub_theme::filament.widgets.statwithicon, ui::filament.widgets.statwithicon

  at Modules/Xot/app/Actions/View/GetViewByClassAction.php:62
     58▕             $module_low.'::'.$implode.$suffix,
     59▕         ];
     60▕         $view = Arr::first($views, view()->exists(...));
     61▕         if (null === $view) {
  ➜  62▕             throw new \Exception('View not found: '.implode(', ', $views));
     63▕         }
     64▕ 
     65▕         if (view()->exists($view)) {
     66▕             return $view;

  1   Modules/Xot/app/Actions/View/GetViewByClassAction.php:62
  2   Modules/Xot/app/Filament/Widgets/XotBaseWidget.php:237

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Filament\Widgets\StatWithIconWid…  Exception   
  View not found: pub_theme::filament.widgets.statwithicon, ui::filament.widgets.statwithicon

  at Modules/Xot/app/Actions/View/GetViewByClassAction.php:62
     58▕             $module_low.'::'.$implode.$suffix,
     59▕         ];
     60▕         $view = Arr::first($views, view()->exists(...));
     61▕         if (null === $view) {
  ➜  62▕             throw new \Exception('View not found: '.implode(', ', $views));
     63▕         }
     64▕ 
     65▕         if (view()->exists($view)) {
     66▕             return $view;

  1   Modules/Xot/app/Actions/View/GetViewByClassAction.php:62
  2   Modules/Xot/app/Filament/Widgets/XotBaseWidget.php:237

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Filament\Widgets\StatWithIconWid…  Exception   
  View not found: pub_theme::filament.widgets.statwithicon, ui::filament.widgets.statwithicon

  at Modules/Xot/app/Actions/View/GetViewByClassAction.php:62
     58▕             $module_low.'::'.$implode.$suffix,
     59▕         ];
     60▕         $view = Arr::first($views, view()->exists(...));
     61▕         if (null === $view) {
  ➜  62▕             throw new \Exception('View not found: '.implode(', ', $views));
     63▕         }
     64▕ 
     65▕         if (view()->exists($view)) {
     66▕             return $view;

  1   Modules/Xot/app/Actions/View/GetViewByClassAction.php:62
  2   Modules/Xot/app/Filament/Widgets/XotBaseWidget.php:237

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Widgets\BaseCalendarWidgetTes…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Widgets\BaseCalendarWidgetTes…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Widgets\BaseCalendarWidgetTes…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\UI\tests\Unit\Widgets\BaseCalendarWidgetTes…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**



  Tests:    111 failed, 1 risky, 35 skipped, 24 passed (36 assertions)
  Duration: 49.48s
```
