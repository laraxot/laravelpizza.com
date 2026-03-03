# Meetup Coverage Report

- Generated: 2026-03-03T16:05:25Z
- Threshold: 100%
- Exit code: 2

```text

  ⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯
  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Meetup\tests\Feature\Auth\AuthTest > it log…  PDOException   
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
  9   Modules/Meetup/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Meetup\tests\Feature\Auth\AuthTest > it log…  PDOException   
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
  9   Modules/Meetup/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Meetup\tests\Feature\Auth\AuthTest > it log…  PDOException   
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
  9   Modules/Meetup/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Meetup\tests\Feature\Auth\AuthTest > it reg…  PDOException   
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
  9   Modules/Meetup/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Meetup\tests\Feature\Auth\AuthTest > it reg…  PDOException   
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
  9   Modules/Meetup/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Meetup\tests\Feature\Auth\AuthTest > it reg…  PDOException   
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
  9   Modules/Meetup/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Meetup\tests\Feature\Auth\AuthTest > it reg…  PDOException   
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
  9   Modules/Meetup/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Meetup\tests\Feature\Auth\AuthTest > it use…  PDOException   
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
  9   Modules/Meetup/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Meetup\tests\Feature\Auth\AuthTest > it use…  PDOException   
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
  9   Modules/Meetup/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Meetup\tests\Feature\Auth\AuthTest > it use…  PDOException   
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
  9   Modules/Meetup/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Meetup\tests\Feature\Auth\AuthTest > it reg…  PDOException   
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
  9   Modules/Meetup/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Meetup\tests\Feature\Auth\AuthTest > it reg…  PDOException   
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
  9   Modules/Meetup/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Meetup\tests\Feature\Auth\AuthTest > it reg…  PDOException   
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
  9   Modules/Meetup/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Meetup\tests\Feature\Auth\AuthTest > it aut…  PDOException   
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
  9   Modules/Meetup/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Meetup\tests\Feature\Auth\AuthTest > it log…  PDOException   
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
  9   Modules/Meetup/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Meetup\tests\Feature\Auth\LoginTest > it ca…  PDOException   
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
   FAILED  Modules\Meetup\tests\Feature\Auth\LoginTest > it ca…  PDOException   
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
   FAILED  Modules\Meetup\tests\Feature\Auth\LoginTest > it ca…  PDOException   
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
   FAILED  Modules\Meetup\tests\Feature\Auth\LoginTest > it ca…  PDOException   
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
   FAILED  Modules\Meetup\tests\Feature\Auth\LoginTest > it sh…  PDOException   
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
   FAILED  Modules\Meetup\tests\Feature\Auth\LoginTest > it sh…  PDOException   
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
   FAILED  Modules\Meetup\tests\Feature\Auth\LoginTest > it re…  PDOException   
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
   FAILED  Modules\Meetup\tests\Feature\Auth\LoginTest > it lo…  PDOException   
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
   FAILED  Modules\Meetup\tests\Feature\Auth\SimpleAuthTest >…   PDOException   
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
   FAILED  Modules\Meetup\tests\Feature\Auth\SimpleAuthTest >…   PDOException   
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
   FAILED  Modules\Meetup\tests\Feature\AuthTest > login route…  PDOException   
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
  9   Modules/Meetup/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Meetup\tests\Feature\AuthTest > register ro…  PDOException   
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
  9   Modules/Meetup/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Meetup\tests\Feature\HeaderNavigationTest >…  PDOException   
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
  9   Modules/Meetup/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Meetup\tests\Feature\HeaderNavigationTest >…  PDOException   
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
  9   Modules/Meetup/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Meetup\Tests\Unit\SeedEventsTest > events…  QueryException   
  SQLSTATE[HY000] [2002] Unknown error while connecting (Connection: meetup, Host: 127.0.0.1, Port: 3306, Database: laravelpizza_data_test, SQL: truncate table `events`)

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

      [2m+15 vendor frames [22m
  16  Modules/Meetup/tests/Unit/SeedEventsTest.php:19


  Tests:    30 failed (0 assertions)
  Duration: 10.12s
```
