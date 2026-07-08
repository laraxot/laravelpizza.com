# Chaos Monkey Readiness - LaravelPizza

## Obiettivo
Garantire risposta rapida e disciplinata a fault randomizzati senza violare regole architetturali Laraxot/LaravelPizza.

## Golden Rules
1. Root cause prima di qualsiasi fix.
2. Fix minimo durante incidente, refactor dopo.
3. Nessuna deroga alle regole core: `XotBase*`, `pub_theme::`, no `->label()`, no controller frontoffice.
4. Ogni incidente genera aggiornamento docs + test anti-regressione.

## Triage Pipeline
1. Classificare fault: `theme`, `cms`, `lang`, `tenant`, `xot`.
2. Riprodurre su URL localizzato.
3. Verificare invarianti del layer.
4. Applicare fix minimo.
5. Eseguire smoke checks e quality gates mirati.

## Smoke Checks Minimi
```bash
php artisan optimize:clear
php artisan test --compact
./vendor/bin/phpstan analyze Modules --level=10
bashscripts/ai/chaos-readiness-check.sh
```

## Runbook Per Layer
- CMS: `laravel/Modules/Cms/docs/chaos-monkey-recovery-playbook.md`
- Meetup: `laravel/Modules/Meetup/docs/chaos-monkey-readiness.md`
- Xot: `laravel/Modules/Xot/docs/chaos-monkey-operability-rules.md`
- Lang: `laravel/Modules/Lang/docs/chaos-monkey-translation-fallbacks.md`
- Tenant: `laravel/Modules/Tenant/docs/chaos-monkey-tenant-isolation-checklist.md`
- Theme: `laravel/Themes/Meetup/docs/chaos-monkey-incident-playbook.md`

## Package Intelligence
- Global package risk map: `./package-risk-matrix-2026-03-02.md`
- Full package inventory: `laravel/Modules/Xot/docs/composer-packages-deep-study-2026-03-02.md`
