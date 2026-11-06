---
title: "index"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-10-14
qmd: "index"
issues: []
discussions: []
status: active
---

# Gdpr — Indice documentazione

Indice organizzato per argomento di tutti i file `.md` sotto `Modules/Gdpr/docs/`. Nessun file esistente è stato rinominato o cancellato per generare questo indice.

Indice operativo canonico del modulo: [00-INDEX.md](./00-index.md) (ruolo delle directory, stato verificato delle promesse, documenti stale). Questo file resta l'elenco per argomento. Limiti e contenuto reale del codice: [README.md](./README.md).

## Panoramica del modulo

- [README.md](README.md) — panoramica, business logic dei consensi, link a documenti correlati
- [CHANGELOG.md](changelog.md) — storico versioni
- [architecture/structure.md](architecture/structure.md) — struttura architetturale del modulo

## Conformità GDPR e consensi

- [consents.md](consents.md) — gestione consensi
- [cookie_consent.md](cookie_consent.md) — cookie consent (modulo)
- [google_analytics.md](google_analytics.md) — integrazione Google Analytics
- [cloudflare.md](cloudflare.md) — integrazione Cloudflare/Turnstile
- [links.md](links.md) — collegamenti e riferimenti esterni
- [repo.md](repo.md) — note sul repository
- [filament.md](filament.md) — risorse Filament del modulo
- [case-variant-collisions.md](case-variant-collisions.md) — collisioni di file per varianti di maiuscole/minuscole (rilevante per i duplicati elencati sotto)
- [_integration/cookie-consent.md](_integration/cookie-consent.md) — integrazione cookie consent con altri moduli
- [concepts/xotbase-never-extend-filament.md](concepts/xotbase-never-extend-filament.md) — regola XotBase applicata al modulo
- [concepts/phpstan-probe-model-removal.md](concepts/phpstan-probe-model-removal.md) — nota tecnica su rimozione probe model
- [stories/blade-i18n-no-hardcoded-text.story.md](stories/blade-i18n-no-hardcoded-text.story.md) — niente testi fissi nelle Blade: chiavi `gdpr::` in it, en, de, es

## Pacchetti integrati (packages/)

- [packages/activity-log.md](packages/activity-log.md)
- [packages/analytics.md](packages/analytics.md)
- [packages/backup.md](packages/backup.md)
- [packages/cookie-consent.md](packages/cookie-consent.md)
- [packages/permissions.md](packages/permissions.md)
- [packages/privacy.md](packages/privacy.md)
- [packages/privacy-policy.md](packages/privacy-policy.md)
- [packages/security.md](packages/security.md)

## Generazione PDF (html2pdf/)

- [html2pdf/README.md](html2pdf/README.md)
- [html2pdf/usage.md](html2pdf/usage.md)
- [html2pdf/advanced.md](html2pdf/advanced.md)
- [html2pdf/laravel.md](html2pdf/laravel.md)
- [html2pdf/security.md](html2pdf/security.md)
- [html2pdf/styling.md](html2pdf/styling.md)

## Qualità del codice e performance

- [phpstan-report.md](phpstan-report.md) — report PHPStan
- [phpmd-report.md](phpmd-report.md) — report PHPMD
- [code-quality-report.md](code-quality-report.md)
- [code-quality-improvement-report.md](code-quality-improvement-report.md)
- [performance/bottlenecks.md](performance/bottlenecks.md)

## Roadmap e pianificazione

- [development/roadmap.md](development/roadmap.md)
- [development/roadmap/backup-dati.md](development/roadmap/backup-dati.md)
- [development/roadmap/cookie-consent.md](development/roadmap/cookie-consent.md)
- [development/roadmap/log-attivita.md](development/roadmap/log-attivita.md)
- [roadmap/README.md](roadmap/README.md)
- [roadmap/index.md](roadmap/index.md)
- [roadmap/overview.md](roadmap/overview.md)
- [roadmap/vision.md](roadmap/vision.md)
- [roadmap/goals.md](roadmap/goals.md)
- [roadmap/current-state.md](roadmap/current-state.md)
- [roadmap/now.md](roadmap/now.md)
- [roadmap/next.md](roadmap/next.md)
- [roadmap/later.md](roadmap/later.md)
- [roadmap/milestones.md](roadmap/milestones.md)
- [roadmap/phases.md](roadmap/phases.md)
- [roadmap/workstreams.md](roadmap/workstreams.md)
- [roadmap/risks.md](roadmap/risks.md)
- [roadmap/quality.md](roadmap/quality.md)
- [roadmap/quality-fixes-log.md](roadmap/quality-fixes-log.md)
- [roadmap/backup-dati.md](roadmap/backup-dati.md)
- [roadmap/cookie-consent.md](roadmap/cookie-consent.md)
- [roadmap/log-attivita.md](roadmap/log-attivita.md)
- [roadmap/roadmap.md](roadmap/roadmap.md)
- [roadmap/roadmap-q4.md](roadmap/roadmap-q4.md)
- [roadmap/-q4-roadmap.md](roadmap/-q4-roadmap.md)
- [roadmap/legacy-roadmap.md](roadmap/legacy-roadmap.md)

Nota: `roadmap/` e `development/roadmap/` contengono coppie con lo stesso nome (`backup-dati.md`, `cookie-consent.md`, `log-attivita.md`) e più varianti di "roadmap" (`roadmap.md`, `roadmap-q4.md`, `-q4-roadmap.md`, `legacy-roadmap.md`, `overview.md`, `index.md`, `README.md`). Vedi sezione "Storico / da consolidare".

## Task e feature in corso

- [tasks/001-gdpr-compliance-system.md](tasks/001-gdpr-compliance-system.md)
- Le voci `tasks-index.md`, `cleanup-gdpr-docs.md`, `gdpr-compliance-audit.md`, `gdpr-compliance-system.md`, `gdpr-filament-v5.md` e `features/data-modification-requests.md`, elencate in una versione precedente di questo indice, non esistono in `tasks/` (verificato 2026-10-14).

## Prompt e automazioni

- [prompts/fix.md](prompts/fix.md)

## Output e materiale grafico

- [charts/README.md](charts/README.md)
- [outputs/README.md](outputs/README.md)
- `screenshots/event-detail-page.png` — screenshot (non `.md`, referenziato per completezza)

## Second brain / wiki interno (wiki/)

- [wiki/README.md](wiki/README.md)
- [wiki/index.md](wiki/index.md)
- [wiki/overview.md](wiki/overview.md)
- [wiki/schema.md](wiki/schema.md)
- [wiki/log.md](wiki/log.md)
- [wiki/bmad-method.md](wiki/bmad-method.md)
- [wiki/agents.md](wiki/AGENTS.md)
- [wiki/commands/index.md](wiki/commands/index.md)
- [wiki/rules/index.md](wiki/rules/index.md)
- [wiki/skills/index.md](wiki/skills/index.md)
- [wiki/memories/index.md](wiki/memories/index.md)
- [wiki/troubleshooting/git-merge-conflict-inventory.md](wiki/troubleshooting/git-merge-conflict-inventory.md)
- [wiki/_templates/concept.md](wiki/_templates/concept.md)
- [wiki/_templates/entity.md](wiki/_templates/entity.md)
- [wiki/_templates/source.md](wiki/_templates/source.md)

### Concetti wiki (wiki/concepts/)

- [wiki/concepts/index.md](wiki/concepts/index.md)
- [wiki/concepts/composer-root-minimal-nwidart.md](wiki/concepts/composer-root-minimal-nwidart.md)
- [wiki/concepts/context-overflow-prevention.md](wiki/concepts/context-overflow-prevention.md)
- [wiki/concepts/method-name-homonyms.md](wiki/concepts/method-name-homonyms.md)
- [wiki/concepts/no-app-support-queueable-actions.md](wiki/concepts/no-app-support-queueable-actions.md)
- [wiki/concepts/no-services-no-support-queueable-actions.md](wiki/concepts/no-services-no-support-queueable-actions.md)
- [wiki/concepts/organizzativa-money.md](wiki/concepts/organizzativa-money.md)
- [wiki/concepts/phpstan-compliance.md](wiki/concepts/phpstan-compliance.md)
- [wiki/concepts/ponytail-audit.md](wiki/concepts/ponytail-audit.md)
- [wiki/concepts/second-brain-local-discipline.md](wiki/concepts/second-brain-local-discipline.md)
- [wiki/concepts/testing.md](wiki/concepts/testing.md)

### Agenti LLM (llm-wiki/)

- [llm-wiki/agents.md](llm-wiki/AGENTS.md)

## Import grezzi (raw/)

- [raw/README.md](raw/README.md)
- [raw/index.md](raw/index.md)
- [raw/root-import/changelog.md](raw/root-import/changelog.md)
- [raw/root-import/cloudflare.md](raw/root-import/cloudflare.md)
- [raw/root-import/consents.md](raw/root-import/consents.md)
- [raw/root-import/cookie-consent.md](raw/root-import/cookie-consent.md)
- [raw/root-import/filament.md](raw/root-import/filament.md)
- [raw/root-import/google-analytics.md](raw/root-import/google-analytics.md)
- [raw/root-import/links.md](raw/root-import/links.md)
- [raw/root-import/repo.md](raw/root-import/repo.md)

Le varianti `*-1.md` in `raw/root-import/` (`cloudflare-1.md`, `consents-1.md`, `cookie-consent.md`, `filament-1.md`, `google-analytics.md`, `links-1.md`, `repo-1.md`) sono duplicati byte-per-byte dei rispettivi file senza suffisso: vedi sezione "Storico / da consolidare".

## Storico / da consolidare (duplicati — non cancellati)

I file seguenti sono duplicati o quasi-duplicati individuati durante l'audit. Non sono stati toccati: restano collegati qui per tracciabilità, in attesa di una consolidazione esplicita.

- **Indici concorrenti in root** (aggiornato 2026-10-14): l'indice canonico e' [00-INDEX.md](00-index.md), riscritto con link verificati. [00-index.md](00-index.md) (copia del vecchio 00-INDEX.md) e [INDEX.md](INDEX.md) (stub vuoto) sono segnati `stale` e restano per storia; questo `index.md` e' l'elenco per argomento.
- **README e 00-INDEX** (risolto 2026-10-14): il README descrive ora identita' e limiti del modulo e 00-INDEX.md e' l'indice; non condividono piu' contenuto. `consent-management.md` e `gsd-workflow.md` non esistono nel modulo.
- **`changelog.md` vs `CHANGELOG.md`**: contenuto identico. `CHANGELOG.md` è il nome canonico (maiuscolo, per standard `module-docs`).
- **`cloudflare.md` / `cloudflare.txt` / `root-md-files/cloudflare.md` / `raw/root-import/cloudflare.md` / `raw/root-import/cloudflare-1.md`**: stesso argomento, versioni diverse (root `cloudflare.md` ha front-matter che rimanda al canonico in `Themes/docs/shared-components/cloudflare.md`; `root-md-files/cloudflare.md` contiene solo link grezzi).
- **`consents.md` / `consents.txt` / `root-md-files/consents.md` / `raw/root-import/consents.md` / `raw/root-import/consents-1.md`**: stesso argomento in più formati/import.
- **`cookie_consent.md` / `cookie_consent.txt` / `root-md-files/cookie-consent.md` / `raw/root-import/cookie-consent.md` / `raw/root-import/cookie-consent-1.md` / `_integration/cookie-consent.md` / `packages/cookie-consent.md` / `roadmap/cookie-consent.md` / `development/roadmap/cookie-consent.md`**: argomento "cookie consent" frammentato su 9 file in 6 directory diverse.
- **`filament.md` / `filament.txt` / `root-md-files/filament.md` / `raw/root-import/filament.md` / `raw/root-import/filament-1.md`**: stesso argomento.
- **`google_analytics.md` / `google_analytics.txt` / `root-md-files/google-analytics.md` / `raw/root-import/google-analytics.md` / `raw/root-import/google-analytics-1.md`**: stesso argomento.
- **`links.md` / `links.txt` / `root-md-files/links.md` / `raw/root-import/links.md` / `raw/root-import/links-1.md`**: stesso argomento.
- **`repo.md` / `repo.txt` / `root-md-files/repo.md` / `raw/root-import/repo.md` / `raw/root-import/repo-1.md`**: stesso argomento.
- **`phpmd-report.md` / `phpmd-report.txt`**: stesso report in due formati.
- **`phpstan-report.md` / `phpstan-report.txt`**: stesso report in due formati.
- **`code-quality-report.md` vs `code-quality-improvement-report.md`**: possibile sovrapposizione di ambito, da verificare.
- **Roadmap frammentata**: `roadmap/backup-dati.md` vs `development/roadmap/backup-dati.md`; `roadmap/cookie-consent.md` vs `development/roadmap/cookie-consent.md`; `roadmap/log-attivita.md` vs `development/roadmap/log-attivita.md`; inoltre `roadmap/roadmap.md`, `roadmap/roadmap-q4.md`, `roadmap/-q4-roadmap.md` e `roadmap/legacy-roadmap.md` sembrano variazioni/superseded dello stesso tema roadmap trimestrale.
- **Indici `index.md` / `INDEX.md` duplicati per-cartella** (stesso contenuto, stessa dimensione, entrambi presenti sul filesystem case-sensitive): `wiki/commands/`, `wiki/concepts/`, `wiki/rules/`, `wiki/skills/`, `wiki/memories/`. Il nome canonico minuscolo è `index.md`.
- **Agenti duplicati**: [wiki/agents.md](wiki/AGENTS.md), [llm-wiki/agents.md](llm-wiki/AGENTS.md), [llm-wiki/AGENTS.md](llm-wiki/AGENTS.md) trattano lo stesso argomento in tre file/varianti di maiuscole.
- **`raw/root-import/*.md` vs le sue varianti `*-1.md`**: file duplicati byte-per-byte (stesso import eseguito due volte), elencati sopra.

## Fuori ambito indice (non `.md`)

- `prd.json` — dati strutturati PRD
- `.gitignore` — regole di ignore locali a `docs/`
- `root-code-workspace-files/_gdpr.code-workspace` — file di workspace VS Code
- `screenshots/*.png`, cartelle `raw/*/.gitkeep`, `schema/.gitkeep` — placeholder/asset non testuali
