---
title: UserMassSeeder getConsoleCommand e tipo nullable
status: completed
module: User
created: 2026-10-21
---

# UserMassSeeder getConsoleCommand e tipo nullable

## Problema
PHPStan segnala `return.unusedType` su `UserMassSeeder::getConsoleCommand(): ?Command`: suggerisce di togliere il `null`.

## Scopo del codice
`getConsoleCommand()` restituisce la console del seeder per scrivere messaggi (`info`, `error`). Un seeder puo' girare
senza console (test, chiamate programmatiche): il `null` e' un caso reale.

## Evidenza
- Laravel dichiara `Illuminate\Database\Seeder::$command` come `Command|null` (vendor/laravel/framework/src/Illuminate/Database/Seeder.php).
- I chiamanti usano gia' l'accesso null-safe (`$command?->info(...)`).

## Decisione
Non rimuovere il `?`: sarebbe un tipo falso che nasconde il caso reale. Capire perche' PHPStan inferisce non-null
nel contesto della classe (flusso o assunzione sulla proprieta') e correggere la causa, non il sintomo.

## Passi
1. Riprodurre: `TMPDIR=/tmp/claude-1000/phpstan-tmp-user ./vendor/bin/phpstan analyse Modules/User/database/seeders/UserMassSeeder.php`.
2. Test Pest che fissa il comportamento con e senza console (quando il DB guard lo permette).
3. Correzione minima senza `@var` ne' ignore.

## Verifica
- PHPStan sul file: 0 errori. Test: verde o blocco documentato (guard DB).
- Esito 2026-10-27: il contratto `?Command` + `?->` (vedi `docs/bmad/stories/user-seeder-contract-fix.story.md`) era stato riportato a `Command` non null da un commit automatico; con Laravel 13.38 (`Seeder::$command` e' `Command|null`) PHPStan dava `return.type` su `RolesSeeder` e `UserMassSeeder`. Ripristinato `?Command` con chiamanti null-safe; `tests/Unit/Seeders/SeedersWithoutConsoleTest.php` fissa il comportamento (3 test verdi); PHPStan su `database/seeders` e sul test: 0.
