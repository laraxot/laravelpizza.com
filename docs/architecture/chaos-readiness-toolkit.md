# Chaos Readiness Toolkit

Toolkit operativo per preparare il progetto a file infetti, regressioni random e bug injection.

## Command center

```bash
bashscripts/quality/chaos-readiness-check.sh --tenant=laravelpizza
```

Strict mode:

```bash
bashscripts/quality/chaos-readiness-check.sh --tenant=laravelpizza --strict
```

## Cosa controlla

1. Bootstrap runtime (`php artisan --version`, `php artisan folio:list`).
2. Anti-pattern frontoffice nel tema (`route()`, namespace non conformi).
3. Anti-pattern Filament su label/placeholder/helperText manuali.
4. Integrita JSON CMS tenant (parse + view mapping `pub_theme::`, `cms::`, `ui::`).
5. Presenza pagine chiave (`home.json`, `events.json`, `events_view.json`).

## Baseline attuale (2026-03-02)

- Stato script: `PASSED with warnings`
- Warning 1: uso diffuso di `route()` in view tema.
- Warning 2: uso diffuso di `->label()/->placeholder()/->helperText()` nei moduli.
- Fix applicati in hardening:
  - `config/local/laravelpizza/database/content/sections/footer.json` ripristinato e validato.
  - `Themes/Meetup/resources/views/components/blocks/contact/main.blade.php` creato come fallback stabile.

## Regola operativa

Eseguire il toolkit prima e dopo ogni sessione chaos monkey; ogni nuovo warning deve produrre un file playbook/issue nel modulo o tema impattato.
