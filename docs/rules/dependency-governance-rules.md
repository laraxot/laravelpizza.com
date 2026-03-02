# Dependency Governance Rules

## Scope

Regole operative per gestire dipendenze Composer/NPM in modo coerente con architettura modulare Laraxot.

## Regole vincolanti

1. Dichiarare nuove dipendenze nel `composer.json` del modulo corretto, non nel root app, poi usare `composer go`.
2. Validare sempre l'effettiva installazione con `composer show` dopo merge plugin dei moduli.
3. Trattare `filament/*`, `livewire/*`, `laravel/folio`, `mcamara/laravel-localization`, `calebporzio/sushi` come pacchetti critici di rendering.
4. Evitare upgrade simultanei di pacchetti critici durante incidenti chaos monkey: applicare fix minimali e reversibili.
5. Aggiornare `dependency-intelligence.md` del modulo/tema toccato dopo ogni cambiamento dipendenze.

## Guardrail chaos monkey

- Se il frontoffice rompe: verificare prima versioni runtime critiche e namespace tema `pub_theme::`.
- Se rompe admin: verificare cluster Filament/Livewire e compatibilita plugin Filament del modulo.
- Se rompe i18n: verificare `mcamara/laravel-localization` + URL pre-localizzate nel payload.
