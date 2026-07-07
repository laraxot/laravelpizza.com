# Testing commands

## Run all tests

```bash
cd laravel && php artisan test
```

## Run a specific test file

```bash
cd laravel && php artisan test tests/Feature/ExampleTest.php
```

## Run by filter/name

```bash
cd laravel && php artisan test --filter=testName
```

## Run tests for a specific module

```bash
cd laravel && php artisan test Modules/User/tests
```

## Create a new test (Pest)

```bash
cd laravel && php artisan make:test --pest FeatureTestName
```

## PHPUnit directly

```bash
cd laravel && vendor/bin/phpunit
```
