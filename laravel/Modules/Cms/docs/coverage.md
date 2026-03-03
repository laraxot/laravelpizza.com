# Cms Coverage Report

- Generated: 2026-03-03T16:05:25Z
- Threshold: 100%
- Exit code: 2

```text

  ⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯
  ⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯
  ⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯
  ⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯
  ⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯⨯
  ⨯⨯⨯⨯
  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\AuthenticationTest >…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\AuthenticationTest >…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginTest > `Fronten…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginTest > `Fronten…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginTest > `Fronten…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginTest > `Fronten…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginTest > `Fronten…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginTest > `Fronten…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginTest > `Fronten…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginTest > `Fronten…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginTest > `Fronten…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginTest > `Fronten…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginTest > `Fronten…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginVoltTest > logi…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginVoltTest > logi…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginVoltTest > logi…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginVoltTest > user…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginVoltTest > user…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginVoltTest > user…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginVoltTest > user…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginVoltTest > form…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginVoltTest > pass…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginWidgetTest > wi…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginWidgetTest > wi…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginWidgetTest > wi…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginWidgetTest > ca…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginWidgetTest > au…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginWidgetTest > ha…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginWidgetTest > au…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginWidgetTest > ge…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\LoginWidgetTest > cr…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\PasswordConfirmation…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\PasswordConfirmation…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\PasswordConfirmation…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\PasswordResetTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\PasswordResetTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\PasswordResetTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\PasswordResetTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\PasswordUpdateTest >…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\PasswordUpdateTest >…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\ProfileUpdateTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\ProfileUpdateTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\ProfileUpdateTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\ProfileUpdateTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\ProfileUpdateTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\ProfileUpdateTest >…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\RegisterTest > `Regi…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\RegisterTest > `Regi…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\RegisterTypeTest > g…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\RegisterTypeTest > g…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\RegisterTypeTest > a…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\RegisterTypeTest > a…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\RegisterTypeTest > :…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\RegisterTypeTest > :…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\RegisterTypeTest > :…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\RegisterTypeTest > :…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\RegisterTypeTest > :…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\RegisterTypeTest > :…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\RegisterTypeTest > :…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\RegisterTypeTest > :…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\RegisterTypeWidgetTe…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\RegisterTypeWidgetTe…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\RegisterTypeWidgetTe…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\RegisterTypeWidgetTe…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\RegisterTypeWidgetTe…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\RegisterTypeWidgetTe…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\RegisterTypeWidgetTe…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\RegisterTypeWidgetTe…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Auth\RegisterTypeWidgetTe…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\CmsContentManagementTest…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\CmsContentManagementTest…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\CmsContentManagementTest…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\CmsContentManagementTest…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\CmsContentManagementTest…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\CmsContentManagementTest…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\FilamentBlocksIntegration…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\FilamentBlocksIntegration…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\FilamentBlocksIntegration…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\FilamentBlocksIntegration…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\FilamentBlocksIntegration…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\FilamentBlocksIntegration…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\FilamentBlocksIntegration…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\FilamentBlocksIntegration…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\FilamentBlocksIntegration…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\FilamentBlocksIntegration…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\FilamentBlocksIntegration…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\FilamentBuilderBlocksTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\FilamentBuilderBlocksTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\FilamentBuilderBlocksTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\FilamentBuilderBlocksTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\FilamentBuilderBlocksTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\FilamentBuilderBlocksTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\FilamentBuilderBlocksTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\FilamentBuilderBlocksTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\FilamentBuilderBlocksTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\FilamentBuilderBlocksTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\FilamentBuilderBlocksTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\A…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\A…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\A…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\A…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\A…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\A…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\A…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\A…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\A…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\A…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\A…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\A…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\C…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\D…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\E…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\G…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\G…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\I…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\L…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\P…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\P…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\P…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\P…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\P…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\P…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\P…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\R…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\R…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutes\S…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\FolioRoutesTe…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\HomepageRouti…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\Frontoffice\HomepageRouti…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**


  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\HomepageContentManagement…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\HomepageContentManagement…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\HomepageContentManagement…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\HomepageContentManagement…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\HomepageContentManagement…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\HomepageContentManagement…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\HomepageContentManagement…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\HomepageContentManagement…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\HomepageContentManagement…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\HomepageContentManagement…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\HomepageContentManagement…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\HomepageFilamentBlocksArc…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\HomepageFilamentBlocksArc…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\HomepageFilamentBlocksArc…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\HomepageFilamentBlocksArc…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\HomepageFilamentBlocksArc…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\HomepageFilamentBlocksArc…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\HomepageFilamentBlocksArc…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\HomepageFilamentBlocksArc…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\HomepageFilamentBlocksArc…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\HomepageFilamentBlocksArc…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\HomepageFilamentBlocksArc…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\HomepageFilamentBlocksArc…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\IndividualFolioRoutesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\PageManagementBusinessLog…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\PageManagementBusinessLog…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\PageManagementBusinessLog…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\PageManagementBusinessLog…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\PageManagementBusinessLog…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\PageManagementBusinessLog…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\PageManagementBusinessLog…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\PageManagementBusinessLog…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\PageManagementBusinessLog…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\PageManagementBusinessLog…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\PageManagementBusinessLog…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Feature\PageManagementBusinessLog…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Actions\GetStyleClassActionT…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Actions\GetStyleClassActionT…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Actions\GetStyleClassActionT…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Actions\GetViewThemeByViewAc…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Actions\GetViewThemeByViewAc…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Actions\GetViewThemeByViewAc…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Actions\GetViewThemeByViewAc…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Actions\Module\FixJigSawByMo…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Actions\Module\FixJigSawByMo…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Actions\SaveFooterConfigActi…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Actions\SaveFooterConfigActi…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Actions\SaveHeadernavConfigA…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Actions\SaveHeadernavConfigA…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Actions\View\GetCmsViewActio…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Actions\View\GetCmsViewActio…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Actions\View\GetCmsViewActio…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\DashboardTest > route home returns success…   
  Expected response status code [>=200, <300] but received 302.
Failed asserting that false is true.

  at Modules/Cms/tests/Unit/DashboardTest.php:12
      8▕ 
      9▕ uses(TestCase::class);
     10▕ 
     11▕ test('route home returns successful response with correct view', function (): void {
  ➜  12▕     get('/')->assertSuccessful()->assertViewIs('pub_theme::home');
     13▕ });
     14▕ 
     15▕ test('route login returns successful response with correct view', function (): void {
     16▕     get('/it/login')->assertSuccessful()->assertViewIs('pub_theme::auth.login');

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\DashboardTest > rout…  AssertionFailedError   
  The response is not a view.

  at Modules/Cms/tests/Unit/DashboardTest.php:16
     12▕     get('/')->assertSuccessful()->assertViewIs('pub_theme::home');
     13▕ });
     14▕ 
     15▕ test('route login returns successful response with correct view', function (): void {
  ➜  16▕     get('/it/login')->assertSuccessful()->assertViewIs('pub_theme::auth.login');
     17▕ });
     18▕

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Datas\BlockDataTest > BlockD…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Datas\BlockDataTest > BlockD…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Datas\BlockDataTest > BlockD…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Datas\BlockDataTest > BlockD…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Datas\BlockDataTest > BlockD…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Datas\BlockDataTest > BlockD…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Datas\BlockDataTest > BlockD…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Datas\BlockDataTest > BlockD…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Datas\DataClassesTest > Bloc…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Datas\DataClassesTest > Foot…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Datas\DataClassesTest > Head…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Datas\DataClassesTest > Link…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Datas\DataClassesTest > Navb…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Datas\DataClassesTest > Them…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Datas\FooterDataTest > Foote…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Datas\FooterDataTest > Foote…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Datas\FooterDataTest > Foote…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Datas\FooterDataTest > Foote…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Datas\FooterDataTest > Foote…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Datas\FooterDataTest > Foote…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Datas\FooterDataTest > Foote…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Datas\FooterDataTest > Foote…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Datas\FooterDataTest > Foote…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Datas\FooterDataTest > Foote…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Enums\AttachmentDiskEnumTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Enums\AttachmentDiskEnumTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Enums\AttachmentDiskEnumTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Enums\AttachmentDiskEnumTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Enums\AttachmentDiskEnumTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Enums\AttachmentDiskEnumTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\ExampleTest > `CMS Module`…  QueryException   
  SQLSTATE[HY000] [2002] Unknown error while connecting (Connection: user, Host: 127.0.0.1, Port: 3306, Database: laravelpizza_user_test, SQL: select * from `roles` where (`team_id` is null or `team_id` is null) and `name` = super-admin and `guard_name` = web limit 1)

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**

      [2m+30 vendor frames [22m
  31  Modules/Cms/tests/TestHelper.php:20
  32  Modules/Cms/tests/Unit/ExampleTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\ExampleTest > `CMS Module`…  QueryException   
  SQLSTATE[HY000] [2002] Unknown error while connecting (Connection: user, Host: 127.0.0.1, Port: 3306, Database: laravelpizza_user_test, SQL: select * from `roles` where (`team_id` is null or `team_id` is null) and `name` = super-admin and `guard_name` = web limit 1)

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**

      [2m+30 vendor frames [22m
  31  Modules/Cms/tests/TestHelper.php:20
  32  Modules/Cms/tests/Unit/ExampleTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\ExampleTest > `CMS Module`…  QueryException   
  SQLSTATE[HY000] [2002] Unknown error while connecting (Connection: user, Host: 127.0.0.1, Port: 3306, Database: laravelpizza_user_test, SQL: select * from `roles` where (`team_id` is null or `team_id` is null) and `name` = super-admin and `guard_name` = web limit 1)

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**

      [2m+30 vendor frames [22m
  31  Modules/Cms/tests/TestHelper.php:20
  32  Modules/Cms/tests/Unit/ExampleTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\ExampleTest > `CMS Module`…  QueryException   
  SQLSTATE[HY000] [2002] Unknown error while connecting (Connection: user, Host: 127.0.0.1, Port: 3306, Database: laravelpizza_user_test, SQL: select * from `roles` where (`team_id` is null or `team_id` is null) and `name` = super-admin and `guard_name` = web limit 1)

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**

      [2m+30 vendor frames [22m
  31  Modules/Cms/tests/TestHelper.php:20
  32  Modules/Cms/tests/Unit/ExampleTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\ExampleTest > `CMS Module`…  QueryException   
  SQLSTATE[HY000] [2002] Unknown error while connecting (Connection: user, Host: 127.0.0.1, Port: 3306, Database: laravelpizza_user_test, SQL: select * from `roles` where (`team_id` is null or `team_id` is null) and `name` = super-admin and `guard_name` = web limit 1)

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**

      [2m+30 vendor frames [22m
  31  Modules/Cms/tests/TestHelper.php:20
  32  Modules/Cms/tests/Unit/ExampleTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\ExampleTest > it user admi…  QueryException   
  SQLSTATE[HY000] [2002] Unknown error while connecting (Connection: user, Host: 127.0.0.1, Port: 3306, Database: laravelpizza_user_test, SQL: select * from `roles` where (`team_id` is null or `team_id` is null) and `name` = super-admin and `guard_name` = web limit 1)

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**

      [2m+30 vendor frames [22m
  31  Modules/Cms/tests/TestHelper.php:20
  32  Modules/Cms/tests/Unit/ExampleTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\ExampleTest > it guest use…  QueryException   
  SQLSTATE[HY000] [2002] Unknown error while connecting (Connection: user, Host: 127.0.0.1, Port: 3306, Database: laravelpizza_user_test, SQL: select * from `roles` where (`team_id` is null or `team_id` is null) and `name` = super-admin and `guard_name` = web limit 1)

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**

      [2m+30 vendor frames [22m
  31  Modules/Cms/tests/TestHelper.php:20
  32  Modules/Cms/tests/Unit/ExampleTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\ExampleTest > it the user…   QueryException   
  SQLSTATE[HY000] [2002] Unknown error while connecting (Connection: user, Host: 127.0.0.1, Port: 3306, Database: laravelpizza_user_test, SQL: select * from `roles` where (`team_id` is null or `team_id` is null) and `name` = super-admin and `guard_name` = web limit 1)

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**

      [2m+30 vendor frames [22m
  31  Modules/Cms/tests/TestHelper.php:20
  32  Modules/Cms/tests/Unit/ExampleTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\ExampleTest > it the user…   QueryException   
  SQLSTATE[HY000] [2002] Unknown error while connecting (Connection: user, Host: 127.0.0.1, Port: 3306, Database: laravelpizza_user_test, SQL: select * from `roles` where (`team_id` is null or `team_id` is null) and `name` = super-admin and `guard_name` = web limit 1)

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**

      [2m+30 vendor frames [22m
  31  Modules/Cms/tests/TestHelper.php:20
  32  Modules/Cms/tests/Unit/ExampleTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\ExampleTest > it user admi…  QueryException   
  SQLSTATE[HY000] [2002] Unknown error while connecting (Connection: user, Host: 127.0.0.1, Port: 3306, Database: laravelpizza_user_test, SQL: select * from `roles` where (`team_id` is null or `team_id` is null) and `name` = super-admin and `guard_name` = web limit 1)

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
     62▕      */
     63▕     protected function createPdoConnection($dsn, $username, #[\SensitiveParameter] $password, $options)
     64▕     {
     65▕         return version_compare(PHP_VERSION, '8.4.0', '<')
  ➜  66▕             ? new PDO($dsn, $username, $password, $options)
     67▕             : PDO::connect($dsn, $username, $password, $options); /** @phpstan-ignore staticMethod.notFound (PHP 8.4) */
     68▕     }
     69▕ 
     70▕     /**

      [2m+30 vendor frames [22m
  31  Modules/Cms/tests/TestHelper.php:20
  32  Modules/Cms/tests/Unit/ExampleTest.php:50

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Filament\Blocks\BlockClasses…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Filament\Blocks\BlockClasses…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Filament\Blocks\BlockClasses…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Filament\Blocks\BlockClasses…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Filament\Blocks\BlockClasses…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Filament\Blocks\BlockClasses…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Filament\Blocks\BlockClasses…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Filament\Blocks\BlockClasses…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Filament\Blocks\BlockClasses…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Filament\Blocks\BlockClasses…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Filament\Fields\PageContentB…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Filament\ResourceExtensionTe…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Filament\ResourceExtensionTe…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Filament\ResourceExtensionTe…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Filament\ResourceExtensionTe…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Filament\ResourceExtensionTe…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Filament\ResourceExtensionTe…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Filament\ResourceExtensionTe…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Filament\ResourceExtensionTe…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Filament\ResourceExtensionTe…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Filament\ResourceExtensionTe…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Filament\ResourceExtensionTe…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Middleware\PageSlugMiddlewar…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Middleware\PageSlugMiddlewar…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\AttachmentTest > Atta…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\AttachmentTest > Atta…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\AttachmentTest > Atta…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\AttachmentTest > Atta…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\BaseModelTest > base…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\BaseModelTest > base…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\BaseModelTest > base…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\BaseModelTest > base…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\BaseModelTest > base…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\BaseTreeModelTest > B…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\BaseTreeModelTest > B…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\BaseTreeModelTest > B…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\BaseTreeModelTest > B…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\ConfBusinessLogicTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\ConfBusinessLogicTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\ConfBusinessLogicTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\ConfBusinessLogicTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\ConfBusinessLogicTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\ConfTest > Conf model…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\ConfTest > Conf model…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\ConfTest > Conf model…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\ConfTest > Conf model…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\MenuBusinessLogicTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\MenuBusinessLogicTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\MenuBusinessLogicTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\MenuBusinessLogicTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\MenuBusinessLogicTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\MenuBusinessLogicTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\MenuBusinessLogicTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\MenuBusinessLogicTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\MenuBusinessLogicTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\MenuBusinessLogicTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\MenuBusinessLogicTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\MenuBusinessLogicTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\MenuTest > Menu model…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\MenuTest > Menu model…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\MenuTest > Menu model…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\MenuTest > Menu model…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\ModuleTest > Module m…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\ModuleTest > Module m…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\ModuleTest > Module m…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\ModuleTest > Module m…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\ModuleTest > Module m…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageBusinessLogicTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageBusinessLogicTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageBusinessLogicTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageBusinessLogicTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageBusinessLogicTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageBusinessLogicTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageBusinessLogicTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageBusinessLogicTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageContentBusinessLo…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageContentBusinessLo…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageContentBusinessLo…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageContentBusinessLo…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageContentBusinessLo…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageContentBusinessLo…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageContentBusinessLo…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageContentBusinessLo…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageContentBusinessLo…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageContentBusinessLo…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageContentBusinessLo…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageContentBusinessLo…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageContentTest > Pag…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageContentTest > Pag…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageContentTest > Pag…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageContentTest > Pag…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageTest > page model…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageTest > page exten…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageTest > page has e…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageTest > page has e…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageTest > page has t…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageTest > page has S…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageTest > page has g…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageTest > page has s…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageTest > page has g…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageTest > page casts…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\PageTest > page casts…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\Policies\PoliciesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\Policies\PoliciesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\Policies\PoliciesTest…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\Policies\PolicyClasse…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\Policies\PolicyClasse…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\Policies\PolicyClasse…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\Policies\PolicyClasse…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\Policies\PolicyClasse…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\Policies\PolicyClasse…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\Policies\PolicyClasse…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\Policies\PolicyClasse…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\SectionBusinessLogicT…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\SectionBusinessLogicT…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\SectionBusinessLogicT…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\SectionBusinessLogicT…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\SectionBusinessLogicT…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\SectionBusinessLogicT…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\SectionBusinessLogicT…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\SectionBusinessLogicT…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\SectionTest > Section…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\SectionTest > Section…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\SectionTest > Section…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\SectionTest > Section…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\Traits\HasBlocksTest…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\Models\Traits\HasBlocksTest…   PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\View\ComponentTest > AppLayo…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\View\ComponentTest > GuestLa…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\View\ComponentTest > Metatag…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\View\ComponentTest > Page ca…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\View\ComponentTest > PageCon…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\View\ComponentTest > Section…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\View\ComponentsTest > Sectio…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\View\ComponentsTest > Page c…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32

  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Cms\tests\Unit\View\ComponentsTest > PageCo…  PDOException   
  SQLSTATE[HY000] [2002] Unknown error while connecting

  at vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:66
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
  9   Modules/Cms/tests/TestCase.php:32


  Tests:    384 failed (3 assertions)
  Duration: 120.91s
```
