# Chaos Readiness Toolkit - CMS

## Runner

```bash
bashscripts/quality/chaos-readiness-check.sh --tenant=laravelpizza
```

## Focus CMS

1. JSON pages/sections parseable.
2. `data.view` risolvibile su namespace noti (`pub_theme::`, `cms::`, `ui::`).
3. Presenza pagine baseline: `home.json`, `events.json`, `events_view.json`.

## Hardening applicato

- Footer section JSON riparata e normalizzata:
  - `config/local/laravelpizza/database/content/sections/footer.json`
- Fallback contact block view aggiunta:
  - `Themes/Meetup/resources/views/components/blocks/contact/main.blade.php`

## Uso in incident

1. Eseguire script.
2. Se `FAIL`, correggere prima JSON/view mapping.
3. Se `WARN`, aprire remediation task con file e linea.
