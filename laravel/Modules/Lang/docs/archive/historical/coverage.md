# Code Coverage: Lang

**Lines Coverage:** 0.0% (Failed to parse)
**Test Exit Code:** 2

## Output

```text
──────────────────────────────────────────────────  
   FAILED  Modules\Lang\tests\Feature\LangBusinessLogicTest > `Lang Business Lo…  Error   
  Call to a member function connection() on null

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:1980
    1976▕      * @return \Illuminate\Database\Connection
    1977▕      */
    1978▕     public static function resolveConnection($connection = null)
    1979▕     {
  ➜ 1980▕         return static::$resolver->connection($connection);
    1981▕     }
    1982▕ 
    1983▕     /**
    1984▕      * Get the connection resolver instance.

      [2m+9 vendor frames [22m
  10  Modules/Lang/tests/Feature/LangBusinessLogicTest.php:329

  ──────────────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Lang\tests\Feature\LangBusinessLogicTest > `Lang Business Lo…  Error   
  Call to a member function connection() on null

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:1980
    1976▕      * @return \Illuminate\Database\Connection
    1977▕      */
    1978▕     public static function resolveConnection($connection = null)
    1979▕     {
  ➜ 1980▕         return static::$resolver->connection($connection);
    1981▕     }
    1982▕ 
    1983▕     /**
    1984▕      * Get the connection resolver instance.

      [2m+9 vendor frames [22m
  10  Modules/Lang/tests/Feature/LangBusinessLogicTest.php:349

  ──────────────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Lang\tests\Unit\Actions\ReadTranslationFileActionTest > `ReadTransl…   
  Failed asserting that exception of type "Error" matches expected exception "Exception". Message was: "Call to undefined method Illuminate\Container\Container::storagePath()" at
/var/www/_bases/base_healthcare_app_fila5_mono/laravel/vendor/laravel/framework/src/Illuminate/Foundation/helpers.php:933
/var/www/_bases/base_healthcare_app_fila5_mono/laravel/Modules/Lang/tests/Unit/Actions/ReadTranslationFileActionTest.php:58
.

  ──────────────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Lang\tests\Unit\Actions\ReadTranslationFileActionTest > `ReadTransl…   
  Expected: <?php\n
  \n
  return [\n
  ... (6 more lines)

  To contain: Text with\nnewlines

  at Modules/Lang/tests/Unit/Actions/ReadTranslationFileActionTest.php:105
    101▕         $phpContent = $this->action->toPhp($translations);
    102▕ 
    103▕         expect($phpContent)->toContain("Text with \\'single\\' and \\\"double\\\" quotes");
    104▕         expect($phpContent)->toContain('Text with \\\\ backslashes');
  ➜ 105▕         expect($phpContent)->toContain('Text with\\nnewlines');
    106▕     });
    107▕ 
    108▕     test('handles deeply nested arrays', function () {
    109▕         $translations = [

  1   Modules/Lang/tests/Unit/Actions/ReadTranslationFileActionTest.php:105


  Tests:    16 failed, 14 passed (37 assertions)
  Duration: 1.44s


```
