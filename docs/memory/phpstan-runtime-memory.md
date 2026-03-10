# Memory: PHPStan Runtime

- PHPStan nel progetto non deve usare `/tmp/phpstan`;
- il `tmpDir` canonico va tenuto nel repo, sotto `laravel/storage/app/phpstan`;
- in questo ambiente il crash `Failed to listen on tcp://127.0.0.1:0` e' un blocker infrastrutturale noto;
- il primo workaround ammesso e' `XDEBUG_MODE=off ./vendor/bin/phpstan analyse ...`;
- se il crash resta, va documentato e comunicato esplicitamente, non mascherato come successo del tool.
