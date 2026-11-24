---
title: "PHPStan Schedule Schema Return Type"
type: concept
updated: 2026-05-06
tags: [phpstan, filament, schema, schedule]
---

# PHPStan Schedule Schema Return Type

## Problema

`CreateSchedule::getFormSchema()` deve dichiarare un ritorno preciso:

```php
array<Illuminate\Contracts\Support\Htmlable|string>
```

`ScheduleResource::getFormSchema()` puo' essere inferito come `array`, quindi
PHPStan non accetta un semplice ritorno diretto.

## Regola

Quando il metodo delega a una Resource e deve restringere il tipo:

1. verificare che il valore sorgente sia un array;
2. iterare ogni elemento;
3. accettare solo elementi `Htmlable` o `string`;
4. costruire una nuova lista tipizzata;
5. lanciare eccezione se il contratto runtime e' violato.

Non usare `@var` inline per sovrascrivere PHPStan senza validazione runtime.

## Esempio

```php
$components = [];

foreach ($res as $component) {
    if ($component instanceof Htmlable || is_string($component)) {
        $components[] = $component;

        continue;
    }

    throw new UnexpectedValueException(
        'Schedule schema accepts only Htmlable components or strings.',
    );
}

return $components;
```

## Gate eseguiti

- `./vendor/bin/phpstan analyse Modules/Job/app/Filament/Resources/ScheduleResource/Pages/CreateSchedule.php --configuration=phpstan.neon`: OK.
- `php tools/phpmd.phar Modules/Job/app/Filament/Resources/ScheduleResource/Pages/CreateSchedule.php text Modules/Job/phpmd.ruleset.xml`: OK, con deprecation interna del phar su Symfony/PHP 8.3.
- `./vendor/bin/phpinsights analyse Modules/Job/app/Filament/Resources/ScheduleResource/Pages/CreateSchedule.php --no-interaction --format=console`: 100/100/100/100.
