# Roadmap Progetto LaravelPizza - 2026-01-30

**Progetto**: LaravelPizza.com
**Stato PHPStan**: Level 10 - 0 errori su 3,983 file
**Suppressioni Inline**: 204 totali in app/ (da ridurre)

---

## Panoramica Moduli

| Modulo | Stato | PHP Files | Suppress | Tests | Docs | Priorita' |
|--------|-------|-----------|----------|-------|------|-----------|
| **Xot** | 85% | 496 | 60 | 6 | 806 | Core |
| **User** | 80% | 493 | 39 | 73 | 664 | Core |
| **Lang** | 85% | 53 | 7 | 6 | 273 | Core |
| **UI** | 80% | 100 | 28 | 21 | 272 | Core |
| **Activity** | 90% | 41 | 0 | 46 | 130 | Business |
| **Cms** | 75% | 111 | 10 | 91 | 315 | Business |
| **Geo** | 75% | 175 | 37 | 40 | 357 | Business |
| **Job** | 90% | 119 | 0 | 14 | 113 | Support |
| **Media** | 80% | 73 | 19 | 9 | 130 | Support |
| **Notify** | 85% | 191 | 4 | 39 | 749 | Business |
| **Tenant** | 90% | 43 | 0 | 13 | 90 | Support |
| **Meetup** | 60% | 21 | 0 | 0 | 126 | Business |
| **Gdpr** | 85% | 46 | 0 | 8 | 101 | Support |
| **Seo** | 50% | 7 | 0 | 1 | 15 | Support |
| **Tema Meetup** | 55% | - | - | - | 138 | Frontend |

---

## Aree Prioritarie

### 1. Ridurre Suppressioni PHPStan (204 inline)
- Xot: 60, User: 39, Geo: 37, UI: 28, Media: 19, Cms: 10, Lang: 7, Notify: 4
- Target: ridurre da 204 a max 50

### 2. Copertura Test
- **Critici** (0 test): Meetup
- **Bassi** (<15 test): Xot (6), Lang (6), Gdpr (8), Media (9), Seo (1)
- Target: ogni modulo con almeno 15 test

### 3. Sviluppo Business Core
- Meetup: sistema eventi, RSVP, speaker, calendario
- Seo: sitemap, Schema.org, metatag automatici
- Tema Meetup: pagine, blocks, design system

### 4. Consolidamento Documentazione
- Totale: ~4,379 file docs
- Target: ridurre a max 1,500 docs attivi rimuovendo duplicati

---

## Roadmap Per-Modulo

Ogni modulo ha il proprio roadmap con task dettagliati:

| Modulo | Roadmap |
|--------|---------|
| Xot | `Modules/Xot/docs/roadmap-2026-01-30.md` |
| User | `Modules/User/docs/roadmap-2026-01-30.md` |
| Lang | `Modules/Lang/docs/roadmap-2026-01-30.md` |
| UI | `Modules/UI/docs/roadmap-2026-01-30.md` |
| Activity | `Modules/Activity/docs/roadmap-2026-01-30.md` |
| Cms | `Modules/Cms/docs/roadmap-2026-01-30.md` |
| Geo | `Modules/Geo/docs/roadmap-2026-01-30.md` |
| Job | `Modules/Job/docs/roadmap-2026-01-30.md` |
| Media | `Modules/Media/docs/roadmap-2026-01-30.md` |
| Notify | `Modules/Notify/docs/roadmap-2026-01-30.md` |
| Tenant | `Modules/Tenant/docs/roadmap-2026-01-30.md` |
| Meetup | `Modules/Meetup/docs/roadmap-2026-01-30.md` |
| Gdpr | `Modules/Gdpr/docs/roadmap-2026-01-30.md` |
| Seo | `Modules/Seo/docs/roadmap-2026-01-30.md` |
| Tema Meetup | `Themes/Meetup/docs/roadmap-2026-01-30.md` |
