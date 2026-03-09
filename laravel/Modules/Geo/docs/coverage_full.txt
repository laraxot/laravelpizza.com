
   PASS  Modules\Geo\tests\Feature\AddressIntegrationTest
  ✓ Address Integration → it can attach address to patient via polymorphic relationship
  ✓ Address Integration → it generates proper full address from components
  ✓ Address Integration → it handles geolocation data correctly
  ✓ Address Integration → it can store Google Places API data
  ✓ Address Integration → it supports multiple addresses per entity
  ✓ Address Integration → it handles soft deletion correctly

   PASS  Modules\Geo\tests\Unit\Actions\CalculateDistanceActionTest
  ✓ it calculates distance between two valid locations                   0.01s  
  ✓ it throws exception for invalid latitude
  ✓ it throws exception for invalid longitude
  ✓ it throws exception for negative latitude
  ✓ it throws exception for negative longitude
  ✓ it throws exception for empty response
  ✓ it throws exception for malformed response
  ✓ it throws exception when distance matrix fails
  ✓ it formats distance in meters correctly
  ✓ it formats distance in kilometers correctly
  ✓ it formats distance with decimal kilometers
  ✓ it formats exact kilometer distance
  ✓ it throws exception for negative distance
  ✓ it handles zero distance
  ✓ it handles very small distances
  ✓ it handles very large distances
  ✓ it handles boundary latitude values
  ✓ it handles boundary longitude values
  ✓ it handles same origin and destination

   FAIL  Modules\Geo\tests\Unit\Actions\GetCoordinatesActionTest
  ⨯ it returns coordinates for valid address                             0.01s  
  ⨯ it throws exception when api key missing
  ⨯ it throws exception when api request fails
  ⨯ it returns null for invalid address
  ⨯ it returns null for over query limit status
  ⨯ it returns null for request denied status
  ⨯ it handles empty results array
  ⨯ it handles multiple results and returns first
  ⨯ it handles special characters in address
  ⨯ it handles numeric coordinates correctly
  ⨯ it handles very long addresses
  ⨯ it handles coordinates with high precision
  ⨯ it handles network timeout gracefully
  ⨯ it handles invalid json response

   FAIL  Modules\Geo\tests\Unit\Actions\Nominatim\LookupPlaceActionTest
  ⨯ lookup place action returns location data for valid osm id           0.38s  
  ✓ lookup place action throws exception for empty results               0.23s  
  ⨯ lookup place action handles guzzle exceptions                        0.23s  
  ⨯ lookup place action uses correct user agent header                   0.22s  

   FAIL  Modules\Geo\tests\Unit\AddressModelTest
  ⨯ Address Model → it can be created with factory                       0.01s  
  ⨯ Address Model → it has correct fillable attributes
  ⨯ Address Model → it implements HasGeolocation contract
  ⨯ Address Model → it uses soft deletes
  ⨯ Address Model → it casts attributes correctly
  ⨯ Address Model → it has polymorphic relationship
  ⨯ Address Model → Accessors → it generates full_address accessor
  ⨯ Address Model → Accessors → it generates street_address accessor
  ⨯ Address Model → Geolocation Features → it stores coordinates correctly
  ⨯ Address Model → Geolocation Features → it can calculate distance between addresses
  ⨯ Address Model → Address Types → it can be set as primary address
  ⨯ Address Model → Address Types → it can have different types
  ⨯ Address Model → Scopes and Queries → it can filter by primary addresses
  ⨯ Address Model → Scopes and Queries → it can filter by locality
  ⨯ Address Model → Scopes and Queries → it can filter by postal code
  ⨯ Address Model → Google Places Integration → it can store place_id from Google Places
  ⨯ Address Model → Google Places Integration → it can store formatted_address from Google Places
  ⨯ Address Model → Extra Data Storage → it can store additional metadata

   FAIL  Modules\Geo\tests\Unit\GeocodingBusinessLogicTest
  ✓ Geocoding Business Logic → Italian Address Validation → it validate… 0.24s  
  ✓ Geocoding Business Logic → Italian Address Validation → it validate… 0.23s  
  ✓ Geocoding Business Logic → Italian Address Validation → it validate… 0.22s  
  ✓ Geocoding Business Logic → Italian Address Validation → it validate… 0.23s  
  ✓ Geocoding Business Logic → Italian Address Validation → it validate… 0.22s  
  ✓ Geocoding Business Logic → Geocoding Provider Logic → it validates…  0.22s  
  ✓ Geocoding Business Logic → Geocoding Provider Logic → it ensures ge… 0.24s  
  ✓ Geocoding Business Logic → Geocoding Provider Logic → it validates…  0.22s  
  ✓ Geocoding Business Logic → Geocoding Provider Logic → it validates…  0.23s  
  ✓ Geocoding Business Logic → Geocoding Provider Logic → it handles pr… 0.23s  
  ✓ Geocoding Business Logic → Weather Data Integration → it validates…  0.23s  
  ✓ Geocoding Business Logic → Weather Data Integration → it validates…  0.23s  
  ✓ Geocoding Business Logic → Weather Data Integration → it validates…  0.24s  
  ✓ Geocoding Business Logic → Weather Data Integration → it validates…  0.22s  
  ✓ Geocoding Business Logic → Weather Data Integration → it validates…  0.23s  
  ✓ Geocoding Business Logic → Place Classification Logic → it validate… 0.23s  
  ✓ Geocoding Business Logic → Place Classification Logic → it validate… 0.23s  
  ✓ Geocoding Business Logic → Place Classification Logic → it validate… 0.22s  
  ✓ Geocoding Business Logic → Place Classification Logic → it validate… 0.23s  
  ✓ Geocoding Business Logic → Distance and Route Calculations → it cal… 0.23s  
  ✓ Geocoding Business Logic → Distance and Route Calculations → it val… 0.22s  
  ✓ Geocoding Business Logic → Distance and Route Calculations → it val… 0.23s  
  ⨯ Geocoding Business Logic → Data Quality and Validation → it ensures… 0.23s  
  ⨯ Geocoding Business Logic → Data Quality and Validation → it validat… 0.23s  
  ✓ Geocoding Business Logic → Data Quality and Validation → it validat… 0.23s  

   FAIL  Modules\Geo\tests\Unit\Models\AddressBusinessLogicTest
  ⨯ Address Business Logic → address extends base model                  0.05s  
  ⨯ Address Business Logic → address has expected fillable fields for postal address
  ⨯ Address Business Logic → address has correct casts for geolocation and structured data
  ! Address Business Logic → address has polymorphic model relationship → Undefined array key "Modules\Geo\Models\Address"
  ! Address Business Logic → address can get region data from comune → Undefined array key "Modules\Geo\Models\Address"
  ! Address Business Logic → address can get province data from comune → Undefined array key "Modules\Geo\Models\Address"
  ! Address Business Logic → address can get locality data from comune → Undefined array key "Modules\Geo\Models\Address"
  ! Address Business Logic → address can format full address attribute → Undefined array key "Modules\Geo\Models\Address"
  ! Address Business Logic → address can format street address attribute → Undefined array key "Modules\Geo\Models\Address"
  ! Address Business Logic → address can get geolocation coordinates → Undefined array key "Modules\Geo\Models\Address"
  ! Address Business Logic → address can export to schema org format → Undefined array key "Modules\Geo\Models\Address"
  ⨯ Address Business Logic → address scope can query nearby addresses
  ⨯ Address Business Logic → address scope can query primary addresses
  ⨯ Address Business Logic → address scope can query by type

   FAIL  Modules\Geo\tests\Unit\Models\AddressTest
  ⨯ address can be created
  ⨯ address has fillable attributes
  ⨯ address has casts defined
  ⨯ address has proper table name
  ⨯ address belongs to comune
  ⨯ address belongs to province
  ⨯ address can get full address
  ⨯ address can be searched by street
  ⨯ address can be filtered by city
  ⨯ address can be filtered by postal code
  ⨯ address has proper relationships
  ⨯ address can validate coordinates

   FAIL  Modules\Geo\tests\Unit\Models\BaseModelTest
  ⨯ base model extends eloquent model
  ! base model has correct table name → Undefined array key "Modules\Geo\Models\BaseModel@anonymous"
  ! base model can be instantiated → Undefined array key "Modules\Geo\Models\BaseModel@anonymous"
  ! base model has proper inheritance chain → Undefined array key "Modules\Geo\Models\BaseModel@anonymous"
  ! base model has timestamps enabled → Undefined array key "Modules\Geo\Models\BaseModel@anonymous"

   FAIL  Modules\Geo\tests\Unit\Models\ComuneBusinessLogicTest
  ⨯ Comune Business Logic → comune extends base model
  ⨯ Comune Business Logic → comune has factory trait for testing
  ✓ Comune Business Logic → comune has sushi to json trait
  ⨯ Comune Business Logic → comune has expected fillable fields for italian municipalities
  ⨯ Comune Business Logic → comune has schema definition for structured geographic data
  ! Comune Business Logic → comune has json directory property for data source → Undefined array key "Modules\Geo\Models\Comune"
  ! Comune Business Logic → comune has translatable array configured → Undefined array key "Modules\Geo\Models\Comune"
  ! Comune Business Logic → comune model can be instantiated without errors → Undefined array key "Modules\Geo\Models\Comune"

   FAIL  Modules\Geo\tests\Unit\Models\ComuneTest
  ⨯ it can load comuni from json
  ⨯ it can filter comuni by region
  ⨯ it can filter comuni by province
  ⨯ it can filter comuni by cap
  ⨯ it can filter comuni by name
  ⨯ it can filter comuni by exact name
  ⨯ it can filter comuni by name and province
  ⨯ it can filter comuni by name and region
  ⨯ it can filter comuni by name province and region
  ⨯ it can filter comuni by name and cap
  ⨯ it can filter comuni by name province and cap
  ⨯ it can filter comuni by name region and cap
  ⨯ it can filter comuni by name province region and cap
  ⨯ it can create a new comune
  ⨯ it can update an existing comune
  ⨯ it can delete an existing comune

   FAIL  Modules\Geo\tests\Unit\Models\LocationBusinessLogicTest
  ⨯ Location Business Logic → location extends base model                0.01s  
  ⨯ Location Business Logic → location has factory trait for testing
  ⨯ Location Business Logic → location can be queried within distance scope
  ! Location Business Logic → location has geographic coordinate properties → Undefined array key "Modules\Geo\Models\Location"
  ! Location Business Logic → location can store address components → Undefined array key "Modules\Geo\Models\Location"
  ! Location Business Logic → location has processing status tracking → Undefined array key "Modules\Geo\Models\Location"
  ! Location Business Logic → location can store formatted address → Undefined array key "Modules\Geo\Models\Location"
  ⨯ Location Business Logic → location can be queried by city
  ⨯ Location Business Logic → location can be queried by coordinates
  ⨯ Location Business Logic → location can be queried by processing status

   FAIL  Modules\Geo\tests\Unit\Models\ProvinceBusinessLogicTest
  ⨯ Province Business Logic → province extends base model                0.01s  
  ⨯ Province Business Logic → province has factory trait for testing
  ✓ Province Business Logic → province uses sushi trait for in-memory data
  ⨯ Province Business Logic → province has schema definition for geographic hierarchy
  ⨯ Province Business Logic → province can get rows from comune data
  ! Province Business Logic → province model can be instantiated without errors → Undefined array key "Modules\Geo\Models\Province"
  ⨯ Province Business Logic → province can be queried by name
  ⨯ Province Business Logic → province can be queried by region id

   FAIL  Modules\Geo\tests\Unit\Models\RegionBusinessLogicTest
  ⨯ Region Business Logic → region extends base model
  ⨯ Region Business Logic → region has factory trait for testing
  ✓ Region Business Logic → region uses sushi trait for in-memory data
  ⨯ Region Business Logic → region has correct key type configured
  ⨯ Region Business Logic → region has schema definition for geographic data
  ⨯ Region Business Logic → region has factory class configured
  ! Region Business Logic → region model can be instantiated without errors → Undefined array key "Modules\Geo\Models\Region"
  ⨯ Region Business Logic → region can be queried by name
  ⨯ Region Business Logic → region can be queried by id

   FAIL  Modules\Geo\tests\Unit\Traits\HasAddressTest
  ⨯ it can have multiple addresses
  ⨯ it can get primary address
  ⨯ it can set primary address
  ⨯ it can get formatted address
  ⨯ it can filter models by city
  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\GetCoordinatesAc…  RuntimeException   
  A facade root has not been set.

  at vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php:360
    356▕     {
    357▕         $instance = static::getFacadeRoot();
    358▕ 
    359▕         if (! $instance) {
  ➜ 360▕             throw new RuntimeException('A facade root has not been set.');
    361▕         }
    362▕ 
    363▕         return $instance->$method(...$args);
    364▕     }

      [2m+1 vendor frames [22m
  2   Modules/Geo/tests/Unit/Actions/GetCoordinatesActionTest.php:35

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\GetCoordinatesAc…  RuntimeException   
  A facade root has not been set.

  at vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php:360
    356▕     {
    357▕         $instance = static::getFacadeRoot();
    358▕ 
    359▕         if (! $instance) {
  ➜ 360▕             throw new RuntimeException('A facade root has not been set.');
    361▕         }
    362▕ 
    363▕         return $instance->$method(...$args);
    364▕     }

      [2m+1 vendor frames [22m
  2   Modules/Geo/tests/Unit/Actions/GetCoordinatesActionTest.php:58

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\GetCoordinatesAc…  RuntimeException   
  A facade root has not been set.

  at vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php:360
    356▕     {
    357▕         $instance = static::getFacadeRoot();
    358▕ 
    359▕         if (! $instance) {
  ➜ 360▕             throw new RuntimeException('A facade root has not been set.');
    361▕         }
    362▕ 
    363▕         return $instance->$method(...$args);
    364▕     }

      [2m+1 vendor frames [22m
  2   Modules/Geo/tests/Unit/Actions/GetCoordinatesActionTest.php:70

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\GetCoordinatesAc…  RuntimeException   
  A facade root has not been set.

  at vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php:360
    356▕     {
    357▕         $instance = static::getFacadeRoot();
    358▕ 
    359▕         if (! $instance) {
  ➜ 360▕             throw new RuntimeException('A facade root has not been set.');
    361▕         }
    362▕ 
    363▕         return $instance->$method(...$args);
    364▕     }

      [2m+1 vendor frames [22m
  2   Modules/Geo/tests/Unit/Actions/GetCoordinatesActionTest.php:90

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\GetCoordinatesAc…  RuntimeException   
  A facade root has not been set.

  at vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php:360
    356▕     {
    357▕         $instance = static::getFacadeRoot();
    358▕ 
    359▕         if (! $instance) {
  ➜ 360▕             throw new RuntimeException('A facade root has not been set.');
    361▕         }
    362▕ 
    363▕         return $instance->$method(...$args);
    364▕     }

      [2m+1 vendor frames [22m
  2   Modules/Geo/tests/Unit/Actions/GetCoordinatesActionTest.php:112

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\GetCoordinatesAc…  RuntimeException   
  A facade root has not been set.

  at vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php:360
    356▕     {
    357▕         $instance = static::getFacadeRoot();
    358▕ 
    359▕         if (! $instance) {
  ➜ 360▕             throw new RuntimeException('A facade root has not been set.');
    361▕         }
    362▕ 
    363▕         return $instance->$method(...$args);
    364▕     }

      [2m+1 vendor frames [22m
  2   Modules/Geo/tests/Unit/Actions/GetCoordinatesActionTest.php:134

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\GetCoordinatesAc…  RuntimeException   
  A facade root has not been set.

  at vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php:360
    356▕     {
    357▕         $instance = static::getFacadeRoot();
    358▕ 
    359▕         if (! $instance) {
  ➜ 360▕             throw new RuntimeException('A facade root has not been set.');
    361▕         }
    362▕ 
    363▕         return $instance->$method(...$args);
    364▕     }

      [2m+1 vendor frames [22m
  2   Modules/Geo/tests/Unit/Actions/GetCoordinatesActionTest.php:156

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\GetCoordinatesAc…  RuntimeException   
  A facade root has not been set.

  at vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php:360
    356▕     {
    357▕         $instance = static::getFacadeRoot();
    358▕ 
    359▕         if (! $instance) {
  ➜ 360▕             throw new RuntimeException('A facade root has not been set.');
    361▕         }
    362▕ 
    363▕         return $instance->$method(...$args);
    364▕     }

      [2m+1 vendor frames [22m
  2   Modules/Geo/tests/Unit/Actions/GetCoordinatesActionTest.php:197

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\GetCoordinatesAc…  RuntimeException   
  A facade root has not been set.

  at vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php:360
    356▕     {
    357▕         $instance = static::getFacadeRoot();
    358▕ 
    359▕         if (! $instance) {
  ➜ 360▕             throw new RuntimeException('A facade root has not been set.');
    361▕         }
    362▕ 
    363▕         return $instance->$method(...$args);
    364▕     }

      [2m+1 vendor frames [22m
  2   Modules/Geo/tests/Unit/Actions/GetCoordinatesActionTest.php:235

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\GetCoordinatesAc…  RuntimeException   
  A facade root has not been set.

  at vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php:360
    356▕     {
    357▕         $instance = static::getFacadeRoot();
    358▕ 
    359▕         if (! $instance) {
  ➜ 360▕             throw new RuntimeException('A facade root has not been set.');
    361▕         }
    362▕ 
    363▕         return $instance->$method(...$args);
    364▕     }

      [2m+1 vendor frames [22m
  2   Modules/Geo/tests/Unit/Actions/GetCoordinatesActionTest.php:268

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\GetCoordinatesAc…  RuntimeException   
  A facade root has not been set.

  at vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php:360
    356▕     {
    357▕         $instance = static::getFacadeRoot();
    358▕ 
    359▕         if (! $instance) {
  ➜ 360▕             throw new RuntimeException('A facade root has not been set.');
    361▕         }
    362▕ 
    363▕         return $instance->$method(...$args);
    364▕     }

      [2m+1 vendor frames [22m
  2   Modules/Geo/tests/Unit/Actions/GetCoordinatesActionTest.php:306

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\GetCoordinatesAc…  RuntimeException   
  A facade root has not been set.

  at vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php:360
    356▕     {
    357▕         $instance = static::getFacadeRoot();
    358▕ 
    359▕         if (! $instance) {
  ➜ 360▕             throw new RuntimeException('A facade root has not been set.');
    361▕         }
    362▕ 
    363▕         return $instance->$method(...$args);
    364▕     }

      [2m+1 vendor frames [22m
  2   Modules/Geo/tests/Unit/Actions/GetCoordinatesActionTest.php:339

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\GetCoordinatesAc…  RuntimeException   
  A facade root has not been set.

  at vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php:360
    356▕     {
    357▕         $instance = static::getFacadeRoot();
    358▕ 
    359▕         if (! $instance) {
  ➜ 360▕             throw new RuntimeException('A facade root has not been set.');
    361▕         }
    362▕ 
    363▕         return $instance->$method(...$args);
    364▕     }

      [2m+1 vendor frames [22m
  2   Modules/Geo/tests/Unit/Actions/GetCoordinatesActionTest.php:361

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\GetCoordinatesAc…  RuntimeException   
  A facade root has not been set.

  at vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php:360
    356▕     {
    357▕         $instance = static::getFacadeRoot();
    358▕ 
    359▕         if (! $instance) {
  ➜ 360▕             throw new RuntimeException('A facade root has not been set.');
    361▕         }
    362▕ 
    363▕         return $instance->$method(...$args);
    364▕     }

      [2m+1 vendor frames [22m
  2   Modules/Geo/tests/Unit/Actions/GetCoordinatesActionTest.php:376

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\No…  NoMatchingExpectationException   
  No matching handler found for Mockery_1_GuzzleHttp_Client::get('https://nominatim.openstreetmap.org/lookup', ['query' => [...], 'headers' => [...]]). Either the method was unexpected or its arguments matched no expected argument list for this method

  at Modules/Geo/app/Actions/Nominatim/LookupPlaceAction.php:37
     33▕      * @throws \RuntimeException
     34▕      */
     35▕     public function execute(string $osmId): LocationData
     36▕     {
  ➜  37▕         $response = $this->client->get(self::API_URL, [
     38▕             'query' => [
     39▕                 'osm_ids' => $osmId,
     40▕                 'format' => 'json',
     41▕             ],

  1   Modules/Geo/tests/Unit/Actions/Nominatim/LookupPlaceActionTest.php:55

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\Nominatim\LookupPlaceAction…  Error   
  Cannot instantiate interface GuzzleHttp\Exception\GuzzleException

  at Modules/Geo/tests/Unit/Actions/Nominatim/LookupPlaceActionTest.php:82
     78▕     /* @phpstan-ignore-next-line property.notFound */
     79▕     $this->mockClient
     80▕         ->shouldReceive('get')
     81▕         ->once()
  ➜  82▕         ->andThrow(new GuzzleException('API unavailable'));
     83▕ 
     84▕     /* @phpstan-ignore-next-line property.notFound */
     85▕     expect(fn () => $this->action->execute('R123456'))
     86▕         ->toThrow(GuzzleException::class, 'API unavailable');

  1   Modules/Geo/tests/Unit/Actions/Nominatim/LookupPlaceActionTest.php:82

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Actions\No…  NoMatchingExpectationException   
  No matching handler found for Mockery_1_GuzzleHttp_Client::get('https://nominatim.openstreetmap.org/lookup', ['query' => [...], 'headers' => [...]]). Either the method was unexpected or its arguments matched no expected argument list for this method

  at Modules/Geo/app/Actions/Nominatim/LookupPlaceAction.php:37
     33▕      * @throws \RuntimeException
     34▕      */
     35▕     public function execute(string $osmId): LocationData
     36▕     {
  ➜  37▕         $response = $this->client->get(self::API_URL, [
     38▕             'query' => [
     39▕                 'osm_ids' => $osmId,
     40▕                 'format' => 'json',
     41▕             ],

  1   Modules/Geo/tests/Unit/Actions/Nominatim/LookupPlaceActionTest.php:107

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
  12  Modules/Geo/tests/Unit/AddressModelTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\AddressModelTe…  BindingResolutionException   
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

      [2m+15 vendor frames [22m
  16  Modules/Geo/tests/Unit/AddressModelTest.php:23

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\AddressModelTest > `Address Model` → it im…   
  Failed asserting that an instance of class Modules\Geo\Models\Address is an instance of interface Modules\Geo\Contracts\HasGeolocation.

  at Modules/Geo/tests/Unit/AddressModelTest.php:51
     47▕ 
     48▕     it('implements HasGeolocation contract', function () {
     49▕         $address = new Address();
     50▕ 
  ➜  51▕         expect($address)->toBeInstanceOf(HasGeolocation::class);
     52▕     });
     53▕ 
     54▕     it('uses soft deletes', function () {
     55▕         $address = Address::factory()->create();

  1   Modules/Geo/tests/Unit/AddressModelTest.php:51

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
  12  Modules/Geo/tests/Unit/AddressModelTest.php:55

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
  13  Modules/Geo/tests/Unit/AddressModelTest.php:64

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
  12  Modules/Geo/tests/Unit/AddressModelTest.php:82

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
  13  Modules/Geo/tests/Unit/AddressModelTest.php:89

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
  13  Modules/Geo/tests/Unit/AddressModelTest.php:107

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
  13  Modules/Geo/tests/Unit/AddressModelTest.php:123

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
  13  Modules/Geo/tests/Unit/AddressModelTest.php:132

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
  13  Modules/Geo/tests/Unit/AddressModelTest.php:151

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
  13  Modules/Geo/tests/Unit/AddressModelTest.php:157

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
  13  Modules/Geo/tests/Unit/AddressModelTest.php:165

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
  13  Modules/Geo/tests/Unit/AddressModelTest.php:174

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
  13  Modules/Geo/tests/Unit/AddressModelTest.php:183

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
  13  Modules/Geo/tests/Unit/AddressModelTest.php:194

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
  13  Modules/Geo/tests/Unit/AddressModelTest.php:202

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
  13  Modules/Geo/tests/Unit/AddressModelTest.php:219

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\GeocodingBusinessLogicTest > `Geocoding Bu…   
  Failed asserting that 7 is equal to 6 or is less than 6.

  at Modules/Geo/tests/Unit/GeocodingBusinessLogicTest.php:387
    383▕             // Business Logic: Coordinates shouldn't exceed reasonable precision
    384▕             $latPrecision = strlen(substr(strrchr((string) $coordinates['lat'], '.'), 1));
    385▕             $lngPrecision = strlen(substr(strrchr((string) $coordinates['lng'], '.'), 1));
    386▕ 
  ➜ 387▕             expect($latPrecision)->toBeLessThanOrEqual($maxPrecision);
    388▕             expect($lngPrecision)->toBeLessThanOrEqual($maxPrecision);
    389▕         });
    390▕ 
    391▕         it('validates address completeness scoring', function () {

  1   Modules/Geo/tests/Unit/GeocodingBusinessLogicTest.php:387

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\GeocodingBusinessLogicTest > `Geocoding Bu…   
  Failed asserting that 140.0 is equal to 100 or is less than 100.

  at Modules/Geo/tests/Unit/GeocodingBusinessLogicTest.php:410
    406▕                 }
    407▕             }
    408▕ 
    409▕             expect($score)->toBeGreaterThan(80); // High quality address
  ➜ 410▕             expect($score)->toBeLessThanOrEqual(100);
    411▕         });
    412▕ 
    413▕         it('validates geocoding cache invalidation logic', function () {
    414▕             $cacheEntry = [

  1   Modules/Geo/tests/Unit/GeocodingBusinessLogicTest.php:410

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\AddressBusi…  BadMethodCallException   
  Method "toBeSubclassOf" does not exist in string.

  at Modules/Geo/tests/Unit/Models/AddressBusinessLogicTest.php:12
      8▕ use Modules\Geo\Models\BaseModel;
      9▕ 
     10▕ describe('Address Business Logic', function () {
     11▕     test('address extends base model', function () {
  ➜  12▕         expect(Address::class)->toBeSubclassOf(BaseModel::class);
     13▕     });
     14▕ 
     15▕     test('address has expected fillable fields for postal address', function () {
     16▕         $address = new Address();

  1   Modules/Geo/tests/Unit/Models/AddressBusinessLogicTest.php:12

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\Address…  BindingResolutionException   
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

      [2m+15 vendor frames [22m
  16  Modules/Geo/tests/Unit/Models/AddressBusinessLogicTest.php:16

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\AddressBusinessLogicTest > `Address…   
  Failed asserting that null is identical to 'float'.

  at Modules/Geo/tests/Unit/Models/AddressBusinessLogicTest.php:46
     42▕     test('address has correct casts for geolocation and structured data', function () {
     43▕         $address = new Address();
     44▕         $casts = $address->getCasts();
     45▕ 
  ➜  46▕         expect($casts['latitude'])->toBe('float');
     47▕         expect($casts['longitude'])->toBe('float');
     48▕         expect($casts['is_primary'])->toBe('boolean');
     49▕         expect($casts['extra_data'])->toBe('array');
     50▕         expect($casts['type'])->toBe(AddressTypeEnum::class);

  1   Modules/Geo/tests/Unit/Models/AddressBusinessLogicTest.php:46

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
  18  Modules/Geo/tests/Unit/Models/AddressBusinessLogicTest.php:120

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
  18  Modules/Geo/tests/Unit/Models/AddressBusinessLogicTest.php:126

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
  18  Modules/Geo/tests/Unit/Models/AddressBusinessLogicTest.php:132

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
  12  Modules/Geo/tests/Unit/Models/AddressTest.php:13

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
  12  Modules/Geo/tests/Unit/Models/AddressTest.php:13

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
  12  Modules/Geo/tests/Unit/Models/AddressTest.php:13

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
  12  Modules/Geo/tests/Unit/Models/AddressTest.php:13

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
  12  Modules/Geo/tests/Unit/Models/AddressTest.php:13

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
  12  Modules/Geo/tests/Unit/Models/AddressTest.php:13

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
  12  Modules/Geo/tests/Unit/Models/AddressTest.php:13

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
  12  Modules/Geo/tests/Unit/Models/AddressTest.php:13

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
  12  Modules/Geo/tests/Unit/Models/AddressTest.php:13

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
  12  Modules/Geo/tests/Unit/Models/AddressTest.php:13

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
  12  Modules/Geo/tests/Unit/Models/AddressTest.php:13

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
  12  Modules/Geo/tests/Unit/Models/AddressTest.php:13

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\BaseMod…  BindingResolutionException   
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

      [2m+15 vendor frames [22m
  16  Modules/Geo/tests/Unit/Models/BaseModelTest.php:11

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
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_sushi_Comune_data, laravel_cache_illuminate:cache:flexible:created:sushi_Comune_data))

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

      [2m+11 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/ComuneTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_sushi_Comune_data, laravel_cache_illuminate:cache:flexible:created:sushi_Comune_data))

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

      [2m+11 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/ComuneTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_sushi_Comune_data, laravel_cache_illuminate:cache:flexible:created:sushi_Comune_data))

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

      [2m+11 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/ComuneTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_sushi_Comune_data, laravel_cache_illuminate:cache:flexible:created:sushi_Comune_data))

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

      [2m+11 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/ComuneTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_sushi_Comune_data, laravel_cache_illuminate:cache:flexible:created:sushi_Comune_data))

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

      [2m+11 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/ComuneTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_sushi_Comune_data, laravel_cache_illuminate:cache:flexible:created:sushi_Comune_data))

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

      [2m+11 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/ComuneTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_sushi_Comune_data, laravel_cache_illuminate:cache:flexible:created:sushi_Comune_data))

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

      [2m+11 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/ComuneTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_sushi_Comune_data, laravel_cache_illuminate:cache:flexible:created:sushi_Comune_data))

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

      [2m+11 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/ComuneTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_sushi_Comune_data, laravel_cache_illuminate:cache:flexible:created:sushi_Comune_data))

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

      [2m+11 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/ComuneTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_sushi_Comune_data, laravel_cache_illuminate:cache:flexible:created:sushi_Comune_data))

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

      [2m+11 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/ComuneTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_sushi_Comune_data, laravel_cache_illuminate:cache:flexible:created:sushi_Comune_data))

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

      [2m+11 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/ComuneTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_sushi_Comune_data, laravel_cache_illuminate:cache:flexible:created:sushi_Comune_data))

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

      [2m+11 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/ComuneTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_sushi_Comune_data, laravel_cache_illuminate:cache:flexible:created:sushi_Comune_data))

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

      [2m+11 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/ComuneTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_sushi_Comune_data, laravel_cache_illuminate:cache:flexible:created:sushi_Comune_data))

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

      [2m+11 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/ComuneTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_sushi_Comune_data, laravel_cache_illuminate:cache:flexible:created:sushi_Comune_data))

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

      [2m+11 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/ComuneTest.php:14

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\ComuneTest > it can…  QueryException   
  SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quaeris_data_test.cache' doesn't exist (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: quaeris_data_test, SQL: delete from `cache` where `key` in (laravel_cache_sushi_Comune_data, laravel_cache_illuminate:cache:flexible:created:sushi_Comune_data))

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

      [2m+11 vendor frames [22m
  12  Modules/Geo/tests/Unit/Models/ComuneTest.php:14

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

      [2m+15 vendor frames [22m
  16  Modules/Geo/tests/Unit/Models/ProvinceBusinessLogicTest.php:29

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Models\Provinc…  BindingResolutionException   
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

      [2m+16 vendor frames [22m
  17  Modules/Geo/app/Models/Province.php:53
  18  Modules/Geo/tests/Unit/Models/ProvinceBusinessLogicTest.php:41

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


  Tests:    100 failed, 21 warnings, 52 passed (219 assertions)
  Duration: 10.71s

