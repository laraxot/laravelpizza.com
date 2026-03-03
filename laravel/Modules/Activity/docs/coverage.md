# Activity Coverage Report

- Generated: 2026-03-03T16:05:25Z
- Threshold: 100%
- Exit code: 2

```text

  ⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯
  ⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯.....
  ...............⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯
  ⨯⨯⨯⨯
  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Activity\tests\Feature\Actions\ListLogActiv…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\Actions\ListLogActiv…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\Actions\ListLogActiv…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\ActivityBusinessLogi…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\ActivityBusinessLogi…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\ActivityBusinessLogi…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\ActivityBusinessLogi…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\ActivityBusinessLogi…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\ActivityBusinessLogi…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\ActivityEventSourcin…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\ActivityEventSourcin…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\ActivityEventSourcin…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\ActivityEventSourcin…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\ActivityEventSourcin…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\ActivityEventSourcin…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\ActivityEventSourcin…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\ActivityEventSourcin…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\ActivityEventSourcin…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\ActivityIntegrationT…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\ActivityIntegrationT…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\ActivityIntegrationT…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\ActivityIntegrationT…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\ActivityIntegrationT…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\ActivityIntegrationT…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\ActivityManagementTe…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\ActivityManagementTe…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\ActivityManagementTe…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\ActivityManagementTe…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\BaseModelBusinessLog…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\CodeQualityTest > al…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\CodeQualityTest > ma…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\CodeQualityTest > co…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\CodeQualityTest > tr…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\CodeQualityTest > vi…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\CodeQualityTest > se…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\CodeQualityTest > do…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\Filament\Actions\Lis…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\Filament\Actions\Lis…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\Filament\Actions\Lis…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\Filament\Actions\Lis…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\PHPStanComplianceTes…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\PHPStanComplianceTes…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\PHPStanComplianceTes…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\PHPStanComplianceTes…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\PHPStanComplianceTes…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\SnapshotBusinessLogi…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\SnapshotBusinessLogi…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\SnapshotBusinessLogi…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\SnapshotBusinessLogi…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\SnapshotBusinessLogi…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\SnapshotBusinessLogi…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\SnapshotBusinessLogi…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\SnapshotBusinessLogi…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\SnapshotBusinessLogi…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\SnapshotBusinessLogi…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\SnapshotBusinessLogi…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\SnapshotBusinessLogi…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\StoredEventBusinessL…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\StoredEventBusinessL…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\StoredEventBusinessL…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\StoredEventBusinessL…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\StoredEventBusinessL…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\StoredEventBusinessL…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\StoredEventBusinessL…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\StoredEventBusinessL…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\StoredEventBusinessL…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\StoredEventBusinessL…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\StoredEventBusinessL…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\StoredEventBusinessL…  PDOException   
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
   FAILED  Modules\Activity\tests\Feature\TempActivityTest > i…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\ActivityLoggerT…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\ActivityLoggerT…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\ActivityLoggerT…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\ActivityLoggerT…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\ActivityLoggerT…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\ActivityLoggerT…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\ActivityLoggerT…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\ActivityLoggerT…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\ActivityLoggerT…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\ActivityLoggerT…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\ActivityLoggerT…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\ActivityLoggerT…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\ActivityLoggerT…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\ActivityLoggerT…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\ActivityLoggerT…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\ActivityLoggerT…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\LogActionsTest…   PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\LogActionsTest…   PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\LogActionsTest…   PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\LogActionsTest…   PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\LogActionsTest…   PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\LogActionsTest…   PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\LogActionsTest…   PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\LogActivityActi…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\LogActivityActi…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\LogModelCreated…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\LogModelCreated…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\LogModelDeleted…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\LogModelUpdated…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\LogUserLoginAct…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\LogUserLogoutAc…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\RestoreActivity…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Actions\RestoreActivity…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Events\ActivityEventTes…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Events\ActivityEventTes…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Filament\ResourceExtens…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Filament\ResourceExtens…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Filament\ResourceExtens…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Filament\ResourceExtens…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Filament\ResourceExtens…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Filament\ResourceExtens…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Filament\ResourceExtens…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Filament\ResourceExtens…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Filament\ResourceExtens…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Filament\ResourceExtens…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Filament\ResourceExtens…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Listeners\ActivityListe…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Listeners\ActivityListe…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Listeners\LoginListener…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Listeners\LoginListener…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Listeners\LoginListener…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Listeners\LoginListener…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Listeners\LogoutListene…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Listeners\LogoutListene…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Listeners\LogoutListene…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Listeners\LogoutListene…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Listeners\LogoutListene…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\ActivityBusiness…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\ActivityBusiness…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\ActivityBusiness…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\ActivityBusiness…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\ActivityTest > a…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\ActivityTest > a…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\ActivityTest > a…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\BaseModelTest >…   PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\BaseModelTest >…   PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\OtherModelsTest…   PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\OtherModelsTest…   PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\OtherModelsTest…   PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\OtherModelsTest…   PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\Policies\Activit…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\Policies\Activit…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\Policies\Activit…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\Policies\Activit…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\Policies\Activit…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\Policies\Activit…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\SnapshotBusiness…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\SnapshotBusiness…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\SnapshotBusiness…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\SnapshotBusiness…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\SnapshotTest > S…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\SnapshotTest > S…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\StoredEventBusin…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\StoredEventBusin…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\StoredEventBusin…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\StoredEventBusin…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\StoredEventBusin…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\StoredEventTest…   PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Models\StoredEventTest…   PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Providers\ProvidersTest…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Providers\ProvidersTest…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Providers\ProvidersTest…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Providers\ProvidersTest…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Providers\ProvidersTest…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Providers\ProvidersTest…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Providers\ProvidersTest…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Providers\ProvidersTest…  PDOException   
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
   FAILED  Modules\Activity\tests\Unit\Providers\ProvidersTest…  PDOException   
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



  Tests:    212 failed, 20 passed (63 assertions)
  Duration: 73.38s
```
