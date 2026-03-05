# Gdpr Coverage Report

- Generated: 2026-03-05T08:11:39Z
- Threshold: 100%
- Exit code: 255

```text
PHP Warning:  require(/var/www/_bases/base_laravelpizza/laravel/vendor/composer/../laravel/prompts/src/helpers.php): Failed to open stream: No such file or directory in /var/www/_bases/base_laravelpizza/laravel/vendor/composer/autoload_real.php on line 41
PHP Fatal error:  Uncaught Error: Failed opening required '/var/www/_bases/base_laravelpizza/laravel/vendor/composer/../laravel/prompts/src/helpers.php' (include_path='.:/usr/share/php') in /var/www/_bases/base_laravelpizza/laravel/vendor/composer/autoload_real.php:41
Stack trace:
#0 /var/www/_bases/base_laravelpizza/laravel/vendor/composer/autoload_real.php(45): {closure}()
#1 /var/www/_bases/base_laravelpizza/laravel/vendor/autoload.php(22): ComposerAutoloaderInit88e5174b7db31ee743d448f32379defd::getLoader()
#2 /var/www/_bases/base_laravelpizza/laravel/vendor/pestphp/pest/bin/pest(129): include_once('...')
#3 /var/www/_bases/base_laravelpizza/laravel/vendor/pestphp/pest/bin/pest(192): {closure}()
#4 /var/www/_bases/base_laravelpizza/laravel/vendor/bin/pest(119): include('...')
#5 {main}
  thrown in /var/www/_bases/base_laravelpizza/laravel/vendor/composer/autoload_real.php on line 41
```
