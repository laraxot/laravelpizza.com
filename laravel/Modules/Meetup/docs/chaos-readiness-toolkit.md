# Chaos Readiness Toolkit - Meetup Module

## Runner

```bash
bashscripts/quality/chaos-readiness-check.sh --tenant=laravelpizza
```

## Focus Meetup

1. Integrita rendering `events` e `events.view`.
2. Verifica URL localizzate in blocchi dinamici eventi.
3. Verifica regressioni dovute a dipendenze Filament/Livewire.

## Baseline

- Script: `PASSED with warnings`.
- Nessun errore bloccante su JSON/view mapping eventi.

## Remediation prioritarie

1. Ridurre uso `route()` nelle view tema frontoffice correlate.
2. Eliminare manual label/placeholder/helperText in componenti Filament modulo.
