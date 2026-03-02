# Chaos Readiness Toolkit - Theme Meetup

## Runner

```bash
bashscripts/quality/chaos-readiness-check.sh --tenant=laravelpizza
```

## Focus tema

1. Namespace view tema: `pub_theme::`.
2. Anti-pattern `route()` in pagine/componenti frontoffice.
3. Integrita blocchi JSON -> file Blade risolti.

## Baseline

- Stato: `PASSED with warnings`.
- Warning aperti:
  - uso esteso di `route()` nelle view tema.

## Hardening recente

- Creata view fallback `contact/main.blade.php` per evitare break su pagina contatti.
- Validata section footer con view `pub_theme::components.blocks.navigation.footer-institutional`.
