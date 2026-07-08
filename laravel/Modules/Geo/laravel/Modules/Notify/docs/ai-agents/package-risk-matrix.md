# Package Risk Matrix (2026-03-02)

## Fonte
Analisi completa di `composer show --format=json` (312 pacchetti).

## Studio completo package-by-package
- `laravel/Modules/Xot/docs/composer-packages-full-catalog-2026-03-02.md`

## Critical path packages
- `laravel/framework`
- `filament/filament`
- `livewire/livewire`
- `livewire/volt`
- `laravel/folio`
- `nwidart/laravel-modules`
- `mcamara/laravel-localization`
- `spatie/laravel-data`
- `spatie/laravel-queueable-action`
- `spatie/laravel-translatable`

## Ownership map
- `theme/cms rendering`: Folio, Volt, Localization
- `admin runtime`: Filament, Xot base contracts
- `module boundaries`: Laravel Modules, Service Providers
- `actions/data contracts`: Spatie Data + QueueableAction
- `auth/security`: Passport, Socialite, OAuth/JWT libs

## Incident use
Durante Chaos Monkey, mappa il fault al package cluster prima di patchare codice applicativo.
