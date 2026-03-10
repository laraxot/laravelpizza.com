# PHPStan Wave 2026-03-10

## Context

Eseguito `./vendor/bin/phpstan analyse Modules` (3317 file) con risultato `106 errors`.

## Meetup fix applicata

- File: `Modules/Meetup/app/Models/Event.php`
- Errore: concatenazione `'/profile/' . mixed` su route key organizer.
- Fix: cast esplicito route key a stringa prima di comporre URL localizzato.

## Next waves

1. `Cms` (factory `PostFactory`, component `GuestLayout`, `Livewire/Page/Show`).
2. `Notify` (classi modello mancanti nel namespace atteso).
3. `User/Passport` (tipi relation + phpdoc generics + wrappers).

## Tracking

- Issue: aggiornare issue dedicata al batch phpstan moduli.
- Discussion: aggiornare thread qualità con conteggio errori per modulo.
