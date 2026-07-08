# Analisi PHPStan livello 10 - tema

## Scopo
Mantenere un tracciamento sintetico dell'analisi PHPStan del tema, distinguendo core e aree legacy.

## Quando usare
- Dopo modifiche a logiche PHP del tema.
- Prima di rilasci o refactor del tema.

## Esito (da aggiornare a ogni verifica)
- **Ambito**: core del tema
- **Stato**: da verificare
- **Errori correnti**: da aggiornare

## Artefatti PHPStan per il tema Zero

- Report aggregato cross‑tema: `laravel/docs/phpstan_theme_zero_analysis.json`
- Output tecnico specifico del tema Zero: `laravel/Themes/Zero/phpstan_themes_zero_filtered.json`

Regola:

- nessun file `phpstan_*.json` specifico del tema deve vivere nella root `laravel/`
- i report generici cross‑modulo vanno in `laravel/docs/`
- gli output tecnici legati solo al tema Zero vanno sotto `laravel/Themes/Zero/` (o sue sottocartelle tecniche).

Questi file JSON servono solo come supporto tecnico (analisi, tool automatici) e non come documentazione di business logic.

## Note
Se sono presenti cartelle legacy o extra non in target, specificare le esclusioni e il motivo.

## Collegamenti correlati
- [roadmap](./roadmap.md)
- [code quality improvements](./code-quality-improvements.md)
- [theme documentation](./theme-documentation.md)
- [theme architecture](./theme-architecture-best-practices.md)
- [README](./README.md)
