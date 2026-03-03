# Geo Coverage Report

- Generated: 2026-03-03T16:05:25Z
- Threshold: 100%
- Exit code: 2

```text

  ⨯⨯⨯⨯⨯⨯.........................⨯........................................⨯⨯⨯⨯
  ......⨯⨯⨯⨯⨯.......⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯...................................⨯..⨯.
  .....................⨯⨯.⨯⨯⨯!⨯⨯⨯!⨯!!!!!!!!⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯!!!!⨯⨯.⨯⨯!!!⨯⨯⨯⨯⨯⨯⨯
  ⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯!!!!⨯⨯⨯......⨯⨯.⨯⨯!⨯⨯⨯⨯.⨯⨯⨯!⨯⨯........⨯⨯⨯⨯⨯⨯⨯..
  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Feature\AddressIntegrationTest >…   PDOException   
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

      [2m+8 vendor frames [22m
  9   Modules/Geo/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Feature\AddressIntegrationTest >…   PDOException   
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

      [2m+8 vendor frames [22m
  9   Modules/Geo/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Feature\AddressIntegrationTest >…   PDOException   
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

      [2m+8 vendor frames [22m
  9   Modules/Geo/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Feature\AddressIntegrationTest >…   PDOException   
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

      [2m+8 vendor frames [22m
  9   Modules/Geo/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Feature\AddressIntegrationTest >…   PDOException   
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

      [2m+8 vendor frames [22m
  9   Modules/Geo/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Feature\AddressIntegrationTest >…   PDOException   
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

      [2m+8 vendor frames [22m
  9   Modules/Geo/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\ClusterLocationsActionTest > it cl…   
  Failed asserting that actual size 3 matches expected size 2.

  at Modules/Geo/tests/Unit/Actions/ClusterLocationsActionTest.php:36
     32▕                     $from->latitude === $location2->latitude
     33▕                     && $from->longitude === $location2->longitude
     34▕                     && $to->latitude === $location1->latitude
     35▕                     && $to->longitude === $location1->longitude
  ➜  36▕                 );
     37▕ 
     38▕             return ['distance' => ['value' => $isPairClose ? 100 : 150000]];
     39▕         });
     40▕

  1   Modules/Geo/tests/Unit/Actions/ClusterLocationsActionTest.php:36

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\Nominatim\LookupPlaceAction…  Error   
  Call to undefined method Modules\Geo\tests\Unit\Actions\Nominatim\LookupPlaceActionTest::mock(). Did you forget to use the [pest()->extend()] function? Read more at: https://pestphp.com/docs/configuring-tests

  at Modules/Geo/tests/Unit/Actions/Nominatim/LookupPlaceActionTest.php:15
     11▕ 
     12▕ 
     13▕ beforeEach(function (): void {
     14▕     /* @phpstan-ignore-next-line method.nonObject */
  ➜  15▕     $this->mockClient = $this->mock(Client::class);
     16▕     $this->action = new LookupPlaceAction();
     17▕ 
     18▕     // Replace the client instance with our mock
     19▕     /** @phpstan-ignore-next-line property.notFound */

  1   Modules/Geo/tests/Unit/Actions/Nominatim/LookupPlaceActionTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\Nominatim\LookupPlaceAction…  Error   
  Call to undefined method Modules\Geo\tests\Unit\Actions\Nominatim\LookupPlaceActionTest::mock(). Did you forget to use the [pest()->extend()] function? Read more at: https://pestphp.com/docs/configuring-tests

  at Modules/Geo/tests/Unit/Actions/Nominatim/LookupPlaceActionTest.php:15
     11▕ 
     12▕ 
     13▕ beforeEach(function (): void {
     14▕     /* @phpstan-ignore-next-line method.nonObject */
  ➜  15▕     $this->mockClient = $this->mock(Client::class);
     16▕     $this->action = new LookupPlaceAction();
     17▕ 
     18▕     // Replace the client instance with our mock
     19▕     /** @phpstan-ignore-next-line property.notFound */

  1   Modules/Geo/tests/Unit/Actions/Nominatim/LookupPlaceActionTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\Nominatim\LookupPlaceAction…  Error   
  Call to undefined method Modules\Geo\tests\Unit\Actions\Nominatim\LookupPlaceActionTest::mock(). Did you forget to use the [pest()->extend()] function? Read more at: https://pestphp.com/docs/configuring-tests

  at Modules/Geo/tests/Unit/Actions/Nominatim/LookupPlaceActionTest.php:15
     11▕ 
     12▕ 
     13▕ beforeEach(function (): void {
     14▕     /* @phpstan-ignore-next-line method.nonObject */
  ➜  15▕     $this->mockClient = $this->mock(Client::class);
     16▕     $this->action = new LookupPlaceAction();
     17▕ 
     18▕     // Replace the client instance with our mock
     19▕     /** @phpstan-ignore-next-line property.notFound */

  1   Modules/Geo/tests/Unit/Actions/Nominatim/LookupPlaceActionTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\Nominatim\LookupPlaceAction…  Error   
  Call to undefined method Modules\Geo\tests\Unit\Actions\Nominatim\LookupPlaceActionTest::mock(). Did you forget to use the [pest()->extend()] function? Read more at: https://pestphp.com/docs/configuring-tests

  at Modules/Geo/tests/Unit/Actions/Nominatim/LookupPlaceActionTest.php:15
     11▕ 
     12▕ 
     13▕ beforeEach(function (): void {
     14▕     /* @phpstan-ignore-next-line method.nonObject */
  ➜  15▕     $this->mockClient = $this->mock(Client::class);
     16▕     $this->action = new LookupPlaceAction();
     17▕ 
     18▕     // Replace the client instance with our mock
     19▕     /** @phpstan-ignore-next-line property.notFound */

  1   Modules/Geo/tests/Unit/Actions/Nominatim/LookupPlaceActionTest.php:15

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\Update…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1425
    1421▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1422▕     {
    1423▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1424▕ 
  ➜ 1425▕         throw new BindingResolutionException($message);
    1426▕     }
    1427▕ 
    1428▕     /**
    1429▕      * Register a new before resolving callback for all types.

      [2m+15 vendor frames [22m
  16  Modules/Geo/tests/Unit/Actions/UpdateCoordinatesActionTest.php:40

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\Update…  BindingResolutionException   
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

      [2m+14 vendor frames [22m
  15  Modules/Geo/tests/Unit/Actions/UpdateCoordinatesActionTest.php:78

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\Update…  BindingResolutionException   
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

      [2m+14 vendor frames [22m
  15  Modules/Geo/tests/Unit/Actions/UpdateCoordinatesActionTest.php:91

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\Update…  BindingResolutionException   
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

      [2m+14 vendor frames [22m
  15  Modules/Geo/tests/Unit/Actions/UpdateCoordinatesActionTest.php:125

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\Update…  BindingResolutionException   
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

      [2m+14 vendor frames [22m
  15  Modules/Geo/tests/Unit/Actions/UpdateCoordinatesActionTest.php:152

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\AddressModelTest…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+7 vendor frames [22m
  12  Modules/Geo/tests/Unit/AddressModelTest.php:13

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\AddressModelTe…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1425
    1421▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1422▕     {
    1423▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1424▕ 
  ➜ 1425▕         throw new BindingResolutionException($message);
    1426▕     }
    1427▕ 
    1428▕     /**
    1429▕      * Register a new before resolving callback for all types.

      [2m+15 vendor frames [22m
  16  Modules/Geo/tests/Unit/AddressModelTest.php:24

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\AddressModelTest > `Address Model` → it im…   
  Failed asserting that an instance of class Modules\Geo\Models\Address is an instance of interface Modules\Geo\Contracts\HasGeolocation.

  at Modules/Geo/tests/Unit/AddressModelTest.php:52
     48▕ 
     49▕     it('implements HasGeolocation contract', function () {
     50▕         $address = new Address();
     51▕ 
  ➜  52▕         expect($address)->toBeInstanceOf(HasGeolocation::class);
     53▕     });
     54▕ 
     55▕     it('uses soft deletes', function () {
     56▕         $address = Address::factory()->create();

  1   Modules/Geo/tests/Unit/AddressModelTest.php:52

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\AddressModelTest…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+7 vendor frames [22m
  12  Modules/Geo/tests/Unit/AddressModelTest.php:56

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\AddressModelTest…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+8 vendor frames [22m
  13  Modules/Geo/tests/Unit/AddressModelTest.php:65

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\AddressModelTest…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+7 vendor frames [22m
  12  Modules/Geo/tests/Unit/AddressModelTest.php:83

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\AddressModelTest…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+8 vendor frames [22m
  13  Modules/Geo/tests/Unit/AddressModelTest.php:90

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\AddressModelTest…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+8 vendor frames [22m
  13  Modules/Geo/tests/Unit/AddressModelTest.php:108

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\AddressModelTest…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+8 vendor frames [22m
  13  Modules/Geo/tests/Unit/AddressModelTest.php:124

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\AddressModelTest…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+8 vendor frames [22m
  13  Modules/Geo/tests/Unit/AddressModelTest.php:133

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\AddressModelTest…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+8 vendor frames [22m
  13  Modules/Geo/tests/Unit/AddressModelTest.php:152

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\AddressModelTest…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+8 vendor frames [22m
  13  Modules/Geo/tests/Unit/AddressModelTest.php:158

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\AddressModelTest…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+8 vendor frames [22m
  13  Modules/Geo/tests/Unit/AddressModelTest.php:166

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\AddressModelTest…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+8 vendor frames [22m
  13  Modules/Geo/tests/Unit/AddressModelTest.php:175

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\AddressModelTest…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+8 vendor frames [22m
  13  Modules/Geo/tests/Unit/AddressModelTest.php:184

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\AddressModelTest…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+8 vendor frames [22m
  13  Modules/Geo/tests/Unit/AddressModelTest.php:195

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\AddressModelTest…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+8 vendor frames [22m
  13  Modules/Geo/tests/Unit/AddressModelTest.php:203

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\AddressModelTest…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+8 vendor frames [22m
  13  Modules/Geo/tests/Unit/AddressModelTest.php:220

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Filament\Filam…  BindingResolutionException   
  Target class [translator] does not exist.

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

      [2m+8 vendor frames [22m
  9   Modules/Geo/app/Filament/Resources/AddressResource.php:71
  10  Modules/Geo/app/Filament/Forms/Components/AddressField.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Filament\Filam…  BindingResolutionException   
  Target class [translator] does not exist.

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

      [2m+8 vendor frames [22m
  9   Modules/Geo/app/Filament/Actions/UpdateCoordinatesBulkAction.php:43
      [2m+3 vendor frames [22m
  13  Modules/Geo/tests/Unit/Filament/FilamentComponentsTest.php:26

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\GeocodingBusinessLogicTest > `Geocoding Bu…   
  Failed asserting that 7 is equal to 6 or is less than 6.

  at Modules/Geo/tests/Unit/GeocodingBusinessLogicTest.php:386
    382▕             // Business Logic: Coordinates shouldn't exceed reasonable precision
    383▕             $latPrecision = strlen(substr(strrchr((string) $coordinates['lat'], '.'), 1));
    384▕             $lngPrecision = strlen(substr(strrchr((string) $coordinates['lng'], '.'), 1));
    385▕ 
  ➜ 386▕             expect($latPrecision)->toBeLessThanOrEqual($maxPrecision);
    387▕             expect($lngPrecision)->toBeLessThanOrEqual($maxPrecision);
    388▕         });
    389▕ 
    390▕         it('validates address completeness scoring', function () {

  1   Modules/Geo/tests/Unit/GeocodingBusinessLogicTest.php:386

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\GeocodingBusinessLogicTest > `Geocoding Bu…   
  Failed asserting that 140.0 is equal to 100 or is less than 100.

  at Modules/Geo/tests/Unit/GeocodingBusinessLogicTest.php:409
    405▕                 }
    406▕             }
    407▕ 
    408▕             expect($score)->toBeGreaterThan(80); // High quality address
  ➜ 409▕             expect($score)->toBeLessThanOrEqual(100);
    410▕         });
    411▕ 
    412▕         it('validates geocoding cache invalidation logic', function () {
    413▕             $cacheEntry = [

  1   Modules/Geo/tests/Unit/GeocodingBusinessLogicTest.php:409

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\Additio…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1425
    1421▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1422▕     {
    1423▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1424▕ 
  ➜ 1425▕         throw new BindingResolutionException($message);
    1426▕     }
    1427▕ 
    1428▕     /**
    1429▕      * Register a new before resolving callback for all types.

      [2m+15 vendor frames [22m
  16  Modules/Geo/tests/Unit/Models/AdditionalModelsTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\Additio…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1425
    1421▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1422▕     {
    1423▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1424▕ 
  ➜ 1425▕         throw new BindingResolutionException($message);
    1426▕     }
    1427▕ 
    1428▕     /**
    1429▕      * Register a new before resolving callback for all types.

      [2m+15 vendor frames [22m
  16  Modules/Geo/tests/Unit/Models/AdditionalModelsTest.php:20

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\Additio…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1425
    1421▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1422▕     {
    1423▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1424▕ 
  ➜ 1425▕         throw new BindingResolutionException($message);
    1426▕     }
    1427▕ 
    1428▕     /**
    1429▕      * Register a new before resolving callback for all types.

      [2m+15 vendor frames [22m
  16  Modules/Geo/tests/Unit/Models/AdditionalModelsTest.php:26

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\Additio…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1425
    1421▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1422▕     {
    1423▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1424▕ 
  ➜ 1425▕         throw new BindingResolutionException($message);
    1426▕     }
    1427▕ 
    1428▕     /**
    1429▕      * Register a new before resolving callback for all types.

      [2m+15 vendor frames [22m
  16  Modules/Geo/tests/Unit/Models/AdditionalModelsTest.php:38

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\Additio…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1425
    1421▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1422▕     {
    1423▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1424▕ 
  ➜ 1425▕         throw new BindingResolutionException($message);
    1426▕     }
    1427▕ 
    1428▕     /**
    1429▕      * Register a new before resolving callback for all types.

      [2m+15 vendor frames [22m
  16  Modules/Geo/tests/Unit/Models/AdditionalModelsTest.php:44

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\AddressBusi…  BadMethodCallException   
  Method "toBeSubclassOf" does not exist in string.

  at Modules/Geo/tests/Unit/Models/AddressBusinessLogicTest.php:13
      9▕ use Modules\Geo\Models\BaseModel;
     10▕ 
     11▕ describe('Address Business Logic', function () {
     12▕     test('address extends base model', function () {
  ➜  13▕         expect(Address::class)->toBeSubclassOf(BaseModel::class);
     14▕     });
     15▕ 
     16▕     test('address has expected fillable fields for postal address', function () {
     17▕         $address = new Address();

  1   Modules/Geo/tests/Unit/Models/AddressBusinessLogicTest.php:13

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\AddressBusinessLogicTest > `Address…   
  Failed asserting that null is identical to 'float'.

  at Modules/Geo/tests/Unit/Models/AddressBusinessLogicTest.php:47
     43▕     test('address has correct casts for geolocation and structured data', function () {
     44▕         $address = new Address();
     45▕         $casts = $address->getCasts();
     46▕ 
  ➜  47▕         expect($casts['latitude'])->toBe('float');
     48▕         expect($casts['longitude'])->toBe('float');
     49▕         expect($casts['is_primary'])->toBe('boolean');
     50▕         expect($casts['extra_data'])->toBe('array');
     51▕         expect($casts['type'])->toBe(AddressTypeEnum::class);

  1   Modules/Geo/tests/Unit/Models/AddressBusinessLogicTest.php:47

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\Address…  BindingResolutionException   
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

      [2m+17 vendor frames [22m
  18  Modules/Geo/tests/Unit/Models/AddressBusinessLogicTest.php:121

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\Address…  BindingResolutionException   
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

      [2m+17 vendor frames [22m
  18  Modules/Geo/tests/Unit/Models/AddressBusinessLogicTest.php:127

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\Address…  BindingResolutionException   
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

      [2m+17 vendor frames [22m
  18  Modules/Geo/tests/Unit/Models/AddressBusinessLogicTest.php:133

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\AddressTe…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+7 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/AddressTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\AddressTe…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+7 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/AddressTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\AddressTe…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+7 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/AddressTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\AddressTe…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+7 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/AddressTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\AddressTe…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+7 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/AddressTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\AddressTe…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+7 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/AddressTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\AddressTe…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+7 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/AddressTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\AddressTe…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+7 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/AddressTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\AddressTe…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+7 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/AddressTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\AddressTe…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+7 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/AddressTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\AddressTe…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+7 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/AddressTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\AddressTe…  InvalidArgumentException   
  Unknown format "streetName"

  at vendor/fakerphp/faker/src/Faker/Generator.php:743
    739▕                 return $this->formatters[$format];
    740▕             }
    741▕         }
    742▕ 
  ➜ 743▕         throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    744▕     }
    745▕ 
    746▕     /**
    747▕      * Replaces tokens ('{{ tokenName }}') with the result from the token method call

      [2m+3 vendor frames [22m
  4   Modules/Geo/database/factories/AddressFactory.php:22
      [2m+7 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/AddressTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\BaseMod…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1425
    1421▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1422▕     {
    1423▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1424▕ 
  ➜ 1425▕         throw new BindingResolutionException($message);
    1426▕     }
    1427▕ 
    1428▕     /**
    1429▕      * Register a new before resolving callback for all types.

      [2m+15 vendor frames [22m
  16  Modules/Geo/tests/Unit/Models/BaseModelTest.php:10

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneBusin…  BadMethodCallException   
  Method "toBeSubclassOf" does not exist in string.

  at Modules/Geo/tests/Unit/Models/ComuneBusinessLogicTest.php:12
      8▕ use Modules\Tenant\Models\Traits\SushiToJson;
      9▕ 
     10▕ describe('Comune Business Logic', function () {
     11▕     test('comune extends base model', function () {
  ➜  12▕         expect(Comune::class)->toBeSubclassOf(BaseModel::class);
     13▕     });
     14▕ 
     15▕     test('comune has factory trait for testing', function () {
     16▕         $traits = class_uses(Comune::class);

  1   Modules/Geo/tests/Unit/Models/ComuneBusinessLogicTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneBusinessLogicTest > `Comune B…   
  Failed asserting that an array has the key 'Illuminate\Database\Eloquent\Factories\HasFactory'

  at Modules/Geo/tests/Unit/Models/ComuneBusinessLogicTest.php:18
     14▕ 
     15▕     test('comune has factory trait for testing', function () {
     16▕         $traits = class_uses(Comune::class);
     17▕ 
  ➜  18▕         expect($traits)->toHaveKey(HasFactory::class);
     19▕     });
     20▕ 
     21▕     test('comune has sushi to json trait', function () {
     22▕         $traits = class_uses(Comune::class);

  1   Modules/Geo/tests/Unit/Models/ComuneBusinessLogicTest.php:18

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneB…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1425
    1421▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1422▕     {
    1423▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1424▕ 
  ➜ 1425▕         throw new BindingResolutionException($message);
    1426▕     }
    1427▕ 
    1428▕     /**
    1429▕      * Register a new before resolving callback for all types.

      [2m+15 vendor frames [22m
  16  Modules/Geo/tests/Unit/Models/ComuneBusinessLogicTest.php:28

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneBusinessLogicTest > `Comune B…   
  Failed asserting that null is identical to 'json'.

  at Modules/Geo/tests/Unit/Models/ComuneBusinessLogicTest.php:53
     49▕     test('comune has schema definition for structured geographic data', function () {
     50▕         $comune = new Comune();
     51▕ 
     52▕         expect($comune)->toHaveProperty('schema');
  ➜  53▕         expect($comune->schema['zona'])->toBe('json');
     54▕         expect($comune->schema['provincia'])->toBe('json');
     55▕         expect($comune->schema['regione'])->toBe('json');
     56▕         expect($comune->schema['cap'])->toBe('json');
     57▕     });

  1   Modules/Geo/tests/Unit/Models/ComuneBusinessLogicTest.php:53

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can load com…  Error   
  Call to a member function query() on null

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:1713
    1709▕      * @return \Illuminate\Database\Query\Builder
    1710▕      */
    1711▕     protected function newBaseQueryBuilder()
    1712▕     {
  ➜ 1713▕         return $this->getConnection()->query();
    1714▕     }
    1715▕ 
    1716▕     /**
    1717▕      * Create a new pivot model instance.

      [2m+6 vendor frames [22m
  7   Modules/Geo/tests/Unit/Models/ComuneTest.php:53

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can filter c…  Error   
  Call to a member function query() on null

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:1713
    1709▕      * @return \Illuminate\Database\Query\Builder
    1710▕      */
    1711▕     protected function newBaseQueryBuilder()
    1712▕     {
  ➜ 1713▕         return $this->getConnection()->query();
    1714▕     }
    1715▕ 
    1716▕     /**
    1717▕      * Create a new pivot model instance.

      [2m+6 vendor frames [22m
  7   Modules/Geo/tests/Unit/Models/ComuneTest.php:61

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can filter c…  Error   
  Call to a member function query() on null

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:1713
    1709▕      * @return \Illuminate\Database\Query\Builder
    1710▕      */
    1711▕     protected function newBaseQueryBuilder()
    1712▕     {
  ➜ 1713▕         return $this->getConnection()->query();
    1714▕     }
    1715▕ 
    1716▕     /**
    1717▕      * Create a new pivot model instance.

      [2m+6 vendor frames [22m
  7   Modules/Geo/tests/Unit/Models/ComuneTest.php:69

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can filter c…  Error   
  Call to a member function query() on null

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:1713
    1709▕      * @return \Illuminate\Database\Query\Builder
    1710▕      */
    1711▕     protected function newBaseQueryBuilder()
    1712▕     {
  ➜ 1713▕         return $this->getConnection()->query();
    1714▕     }
    1715▕ 
    1716▕     /**
    1717▕      * Create a new pivot model instance.

      [2m+6 vendor frames [22m
  7   Modules/Geo/tests/Unit/Models/ComuneTest.php:77

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can filter c…  Error   
  Call to a member function query() on null

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:1713
    1709▕      * @return \Illuminate\Database\Query\Builder
    1710▕      */
    1711▕     protected function newBaseQueryBuilder()
    1712▕     {
  ➜ 1713▕         return $this->getConnection()->query();
    1714▕     }
    1715▕ 
    1716▕     /**
    1717▕      * Create a new pivot model instance.

      [2m+6 vendor frames [22m
  7   Modules/Geo/tests/Unit/Models/ComuneTest.php:84

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can filter c…  Error   
  Call to a member function query() on null

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:1713
    1709▕      * @return \Illuminate\Database\Query\Builder
    1710▕      */
    1711▕     protected function newBaseQueryBuilder()
    1712▕     {
  ➜ 1713▕         return $this->getConnection()->query();
    1714▕     }
    1715▕ 
    1716▕     /**
    1717▕      * Create a new pivot model instance.

      [2m+6 vendor frames [22m
  7   Modules/Geo/tests/Unit/Models/ComuneTest.php:91

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can filter c…  Error   
  Call to a member function query() on null

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:1713
    1709▕      * @return \Illuminate\Database\Query\Builder
    1710▕      */
    1711▕     protected function newBaseQueryBuilder()
    1712▕     {
  ➜ 1713▕         return $this->getConnection()->query();
    1714▕     }
    1715▕ 
    1716▕     /**
    1717▕      * Create a new pivot model instance.

      [2m+6 vendor frames [22m
  7   Modules/Geo/tests/Unit/Models/ComuneTest.php:98

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can filter c…  Error   
  Call to a member function query() on null

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:1713
    1709▕      * @return \Illuminate\Database\Query\Builder
    1710▕      */
    1711▕     protected function newBaseQueryBuilder()
    1712▕     {
  ➜ 1713▕         return $this->getConnection()->query();
    1714▕     }
    1715▕ 
    1716▕     /**
    1717▕      * Create a new pivot model instance.

      [2m+6 vendor frames [22m
  7   Modules/Geo/tests/Unit/Models/ComuneTest.php:106

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can filter c…  Error   
  Call to a member function query() on null

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:1713
    1709▕      * @return \Illuminate\Database\Query\Builder
    1710▕      */
    1711▕     protected function newBaseQueryBuilder()
    1712▕     {
  ➜ 1713▕         return $this->getConnection()->query();
    1714▕     }
    1715▕ 
    1716▕     /**
    1717▕      * Create a new pivot model instance.

      [2m+6 vendor frames [22m
  7   Modules/Geo/tests/Unit/Models/ComuneTest.php:114

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can filter c…  Error   
  Call to a member function query() on null

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:1713
    1709▕      * @return \Illuminate\Database\Query\Builder
    1710▕      */
    1711▕     protected function newBaseQueryBuilder()
    1712▕     {
  ➜ 1713▕         return $this->getConnection()->query();
    1714▕     }
    1715▕ 
    1716▕     /**
    1717▕      * Create a new pivot model instance.

      [2m+6 vendor frames [22m
  7   Modules/Geo/tests/Unit/Models/ComuneTest.php:123

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can filter c…  Error   
  Call to a member function query() on null

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:1713
    1709▕      * @return \Illuminate\Database\Query\Builder
    1710▕      */
    1711▕     protected function newBaseQueryBuilder()
    1712▕     {
  ➜ 1713▕         return $this->getConnection()->query();
    1714▕     }
    1715▕ 
    1716▕     /**
    1717▕      * Create a new pivot model instance.

      [2m+6 vendor frames [22m
  7   Modules/Geo/tests/Unit/Models/ComuneTest.php:131

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can filter c…  Error   
  Call to a member function query() on null

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:1713
    1709▕      * @return \Illuminate\Database\Query\Builder
    1710▕      */
    1711▕     protected function newBaseQueryBuilder()
    1712▕     {
  ➜ 1713▕         return $this->getConnection()->query();
    1714▕     }
    1715▕ 
    1716▕     /**
    1717▕      * Create a new pivot model instance.

      [2m+6 vendor frames [22m
  7   Modules/Geo/tests/Unit/Models/ComuneTest.php:140

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can filter c…  Error   
  Call to a member function query() on null

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:1713
    1709▕      * @return \Illuminate\Database\Query\Builder
    1710▕      */
    1711▕     protected function newBaseQueryBuilder()
    1712▕     {
  ➜ 1713▕         return $this->getConnection()->query();
    1714▕     }
    1715▕ 
    1716▕     /**
    1717▕      * Create a new pivot model instance.

      [2m+6 vendor frames [22m
  7   Modules/Geo/tests/Unit/Models/ComuneTest.php:149

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can create a…  Error   
  Call to a member function query() on null

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:1713
    1709▕      * @return \Illuminate\Database\Query\Builder
    1710▕      */
    1711▕     protected function newBaseQueryBuilder()
    1712▕     {
  ➜ 1713▕         return $this->getConnection()->query();
    1714▕     }
    1715▕ 
    1716▕     /**
    1717▕      * Create a new pivot model instance.

      [2m+6 vendor frames [22m
  7   Modules/Geo/tests/Unit/Models/ComuneTest.php:159

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can update a…  Error   
  Call to a member function query() on null

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:1713
    1709▕      * @return \Illuminate\Database\Query\Builder
    1710▕      */
    1711▕     protected function newBaseQueryBuilder()
    1712▕     {
  ➜ 1713▕         return $this->getConnection()->query();
    1714▕     }
    1715▕ 
    1716▕     /**
    1717▕      * Create a new pivot model instance.

      [2m+6 vendor frames [22m
  7   Modules/Geo/tests/Unit/Models/ComuneTest.php:178

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can delete a…  Error   
  Call to a member function query() on null

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:1713
    1709▕      * @return \Illuminate\Database\Query\Builder
    1710▕      */
    1711▕     protected function newBaseQueryBuilder()
    1712▕     {
  ➜ 1713▕         return $this->getConnection()->query();
    1714▕     }
    1715▕ 
    1716▕     /**
    1717▕      * Create a new pivot model instance.

      [2m+6 vendor frames [22m
  7   Modules/Geo/tests/Unit/Models/ComuneTest.php:189

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\LocationBus…  BadMethodCallException   
  Method "toBeSubclassOf" does not exist in string.

  at Modules/Geo/tests/Unit/Models/LocationBusinessLogicTest.php:12
      8▕ use Modules\Geo\Models\Location;
      9▕ 
     10▕ describe('Location Business Logic', function () {
     11▕     test('location extends base model', function () {
  ➜  12▕         expect(Location::class)->toBeSubclassOf(BaseModel::class);
     13▕     });
     14▕ 
     15▕     test('location has factory trait for testing', function () {
     16▕         $traits = class_uses(Location::class);

  1   Modules/Geo/tests/Unit/Models/LocationBusinessLogicTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\LocationBusinessLogicTest > `Locati…   
  Failed asserting that an array has the key 'Illuminate\Database\Eloquent\Factories\HasFactory'

  at Modules/Geo/tests/Unit/Models/LocationBusinessLogicTest.php:18
     14▕ 
     15▕     test('location has factory trait for testing', function () {
     16▕         $traits = class_uses(Location::class);
     17▕ 
  ➜  18▕         expect($traits)->toHaveKey(HasFactory::class);
     19▕     });
     20▕ 
     21▕     test('location can be queried within distance scope', function () {
     22▕         $query = Location::withinDistance(45.4642, 9.1900, 10.0);

  1   Modules/Geo/tests/Unit/Models/LocationBusinessLogicTest.php:18

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\Locatio…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1425
    1421▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1422▕     {
    1423▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1424▕ 
  ➜ 1425▕         throw new BindingResolutionException($message);
    1426▕     }
    1427▕ 
    1428▕     /**
    1429▕      * Register a new before resolving callback for all types.

      [2m+16 vendor frames [22m
  17  Modules/Geo/tests/Unit/Models/LocationBusinessLogicTest.php:22

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\Locatio…  BindingResolutionException   
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

      [2m+17 vendor frames [22m
  18  Modules/Geo/tests/Unit/Models/LocationBusinessLogicTest.php:64

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\Locatio…  BindingResolutionException   
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

      [2m+17 vendor frames [22m
  18  Modules/Geo/tests/Unit/Models/LocationBusinessLogicTest.php:70

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\Locatio…  BindingResolutionException   
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

      [2m+17 vendor frames [22m
  18  Modules/Geo/tests/Unit/Models/LocationBusinessLogicTest.php:76

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ProvinceBus…  BadMethodCallException   
  Method "toBeSubclassOf" does not exist in string.

  at Modules/Geo/tests/Unit/Models/ProvinceBusinessLogicTest.php:13
      9▕ use Sushi\Sushi;
     10▕ 
     11▕ describe('Province Business Logic', function () {
     12▕     test('province extends base model', function () {
  ➜  13▕         expect(Province::class)->toBeSubclassOf(BaseModel::class);
     14▕     });
     15▕ 
     16▕     test('province has factory trait for testing', function () {
     17▕         $traits = class_uses(Province::class);

  1   Modules/Geo/tests/Unit/Models/ProvinceBusinessLogicTest.php:13

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ProvinceBusinessLogicTest > `Provin…   
  Failed asserting that an array has the key 'Illuminate\Database\Eloquent\Factories\HasFactory'

  at Modules/Geo/tests/Unit/Models/ProvinceBusinessLogicTest.php:19
     15▕ 
     16▕     test('province has factory trait for testing', function () {
     17▕         $traits = class_uses(Province::class);
     18▕ 
  ➜  19▕         expect($traits)->toHaveKey(HasFactory::class);
     20▕     });
     21▕ 
     22▕     test('province uses sushi trait for in-memory data', function () {
     23▕         $traits = class_uses(Province::class);

  1   Modules/Geo/tests/Unit/Models/ProvinceBusinessLogicTest.php:19

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\Provinc…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1425
    1421▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1422▕     {
    1423▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1424▕ 
  ➜ 1425▕         throw new BindingResolutionException($message);
    1426▕     }
    1427▕ 
    1428▕     /**
    1429▕      * Register a new before resolving callback for all types.

      [2m+15 vendor frames [22m
  16  Modules/Geo/tests/Unit/Models/ProvinceBusinessLogicTest.php:29

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ProvinceBusinessLogicTest >…   Error   
  Call to a member function query() on null

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:1713
    1709▕      * @return \Illuminate\Database\Query\Builder
    1710▕      */
    1711▕     protected function newBaseQueryBuilder()
    1712▕     {
  ➜ 1713▕         return $this->getConnection()->query();
    1714▕     }
    1715▕ 
    1716▕     /**
    1717▕      * Create a new pivot model instance.

      [2m+6 vendor frames [22m
  7   Modules/Geo/app/Models/Province.php:53
  8   Modules/Geo/tests/Unit/Models/ProvinceBusinessLogicTest.php:41

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ProvinceBusinessLogicTest >…   Error   
  Call to a member function query() on null

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:1713
    1709▕      * @return \Illuminate\Database\Query\Builder
    1710▕      */
    1711▕     protected function newBaseQueryBuilder()
    1712▕     {
  ➜ 1713▕         return $this->getConnection()->query();
    1714▕     }
    1715▕ 
    1716▕     /**
    1717▕      * Create a new pivot model instance.

      [2m+6 vendor frames [22m
  7   Modules/Geo/tests/Unit/Models/ProvinceBusinessLogicTest.php:52

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ProvinceBusinessLogicTest >…   Error   
  Call to a member function query() on null

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:1713
    1709▕      * @return \Illuminate\Database\Query\Builder
    1710▕      */
    1711▕     protected function newBaseQueryBuilder()
    1712▕     {
  ➜ 1713▕         return $this->getConnection()->query();
    1714▕     }
    1715▕ 
    1716▕     /**
    1717▕      * Create a new pivot model instance.

      [2m+6 vendor frames [22m
  7   Modules/Geo/tests/Unit/Models/ProvinceBusinessLogicTest.php:58

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\RegionBusin…  BadMethodCallException   
  Method "toBeSubclassOf" does not exist in string.

  at Modules/Geo/tests/Unit/Models/RegionBusinessLogicTest.php:14
     10▕ use Sushi\Sushi;
     11▕ 
     12▕ describe('Region Business Logic', function () {
     13▕     test('region extends base model', function () {
  ➜  14▕         expect(Region::class)->toBeSubclassOf(BaseModel::class);
     15▕     });
     16▕ 
     17▕     test('region has factory trait for testing', function () {
     18▕         $traits = class_uses(Region::class);

  1   Modules/Geo/tests/Unit/Models/RegionBusinessLogicTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\RegionBusinessLogicTest > `Region B…   
  Failed asserting that an array has the key 'Illuminate\Database\Eloquent\Factories\HasFactory'

  at Modules/Geo/tests/Unit/Models/RegionBusinessLogicTest.php:20
     16▕ 
     17▕     test('region has factory trait for testing', function () {
     18▕         $traits = class_uses(Region::class);
     19▕ 
  ➜  20▕         expect($traits)->toHaveKey(HasFactory::class);
     21▕     });
     22▕ 
     23▕     test('region uses sushi trait for in-memory data', function () {
     24▕         $traits = class_uses(Region::class);

  1   Modules/Geo/tests/Unit/Models/RegionBusinessLogicTest.php:20

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\RegionB…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1425
    1421▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1422▕     {
    1423▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1424▕ 
  ➜ 1425▕         throw new BindingResolutionException($message);
    1426▕     }
    1427▕ 
    1428▕     /**
    1429▕      * Register a new before resolving callback for all types.

      [2m+15 vendor frames [22m
  16  Modules/Geo/tests/Unit/Models/RegionBusinessLogicTest.php:30

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\RegionBusinessLogicTest > `Region B…   
  Failed asserting that null is identical to 'integer'.

  at Modules/Geo/tests/Unit/Models/RegionBusinessLogicTest.php:39
     35▕     test('region has schema definition for geographic data', function () {
     36▕         $region = new Region();
     37▕ 
     38▕         expect($region)->toHaveProperty('schema');
  ➜  39▕         expect($region->schema['id'])->toBe('integer');
     40▕         expect($region->schema['name'])->toBe('string');
     41▕     });
     42▕ 
     43▕     test('region has factory class configured', function () {

  1   Modules/Geo/tests/Unit/Models/RegionBusinessLogicTest.php:39

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\RegionBusinessLogicTest > `R…  Error   
  Cannot access protected property Modules\Geo\Models\Region::$factory

  at Modules/Geo/tests/Unit/Models/RegionBusinessLogicTest.php:44
     40▕         expect($region->schema['name'])->toBe('string');
     41▕     });
     42▕ 
     43▕     test('region has factory class configured', function () {
  ➜  44▕         expect(Region::$factory)->toBe(RegionFactory::class);
     45▕     });
     46▕ 
     47▕     test('region model can be instantiated without errors', function () {
     48▕         $region = new Region();

  1   Modules/Geo/tests/Unit/Models/RegionBusinessLogicTest.php:44

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\RegionBusinessLogicTest > `R…  Error   
  Call to a member function query() on null

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:1713
    1709▕      * @return \Illuminate\Database\Query\Builder
    1710▕      */
    1711▕     protected function newBaseQueryBuilder()
    1712▕     {
  ➜ 1713▕         return $this->getConnection()->query();
    1714▕     }
    1715▕ 
    1716▕     /**
    1717▕      * Create a new pivot model instance.

      [2m+6 vendor frames [22m
  7   Modules/Geo/tests/Unit/Models/RegionBusinessLogicTest.php:55

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\RegionBusinessLogicTest > `R…  Error   
  Call to a member function query() on null

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:1713
    1709▕      * @return \Illuminate\Database\Query\Builder
    1710▕      */
    1711▕     protected function newBaseQueryBuilder()
    1712▕     {
  ➜ 1713▕         return $this->getConnection()->query();
    1714▕     }
    1715▕ 
    1716▕     /**
    1717▕      * Create a new pivot model instance.

      [2m+6 vendor frames [22m
  7   Modules/Geo/tests/Unit/Models/RegionBusinessLogicTest.php:61

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Traits\HasAddr…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1425
    1421▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1422▕     {
    1423▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1424▕ 
  ➜ 1425▕         throw new BindingResolutionException($message);
    1426▕     }
    1427▕ 
    1428▕     /**
    1429▕      * Register a new before resolving callback for all types.

      [2m+15 vendor frames [22m
  16  Modules/Geo/tests/Unit/Traits/HasAddressTest.php:45

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Traits\HasAddr…  BindingResolutionException   
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

      [2m+13 vendor frames [22m
  14  Modules/Geo/tests/Unit/Traits/HasAddressTest.php:47

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Traits\HasAddr…  BindingResolutionException   
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

      [2m+13 vendor frames [22m
  14  Modules/Geo/tests/Unit/Traits/HasAddressTest.php:47

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Traits\HasAddr…  BindingResolutionException   
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

      [2m+13 vendor frames [22m
  14  Modules/Geo/tests/Unit/Traits/HasAddressTest.php:47

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Traits\HasAddr…  BindingResolutionException   
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

      [2m+13 vendor frames [22m
  14  Modules/Geo/tests/Unit/Traits/HasAddressTest.php:47

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Traits\TraitsT…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1425
    1421▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1422▕     {
    1423▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1424▕ 
  ➜ 1425▕         throw new BindingResolutionException($message);
    1426▕     }
    1427▕ 
    1428▕     /**
    1429▕      * Register a new before resolving callback for all types.

      [2m+15 vendor frames [22m
  16  Modules/Geo/tests/Unit/Traits/TraitsTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Traits\TraitsT…  BindingResolutionException   
  Unresolvable dependency resolving [Parameter #0 [ <required> string $storedEventRepository ]] in class Spatie\EventSourcing\StoredEvents\EventSubscriber

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1425
    1421▕     protected function unresolvablePrimitive(ReflectionParameter $parameter)
    1422▕     {
    1423▕         $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
    1424▕ 
  ➜ 1425▕         throw new BindingResolutionException($message);
    1426▕     }
    1427▕ 
    1428▕     /**
    1429▕      * Register a new before resolving callback for all types.

      [2m+15 vendor frames [22m
  16  Modules/Geo/tests/Unit/Traits/TraitsTest.php:29


  Tests:    107 failed, 23 warnings, 157 passed (460 assertions)
  Duration: 8.64s
```
