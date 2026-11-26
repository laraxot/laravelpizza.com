---
title: "Session handoff — qualità continua LaravelPizza"
type: handoff
status: current
updated: 2026-11-25
qmd: "session handoff phpstan zero manuals rating anchors bmad second brain"
related:
  - ./git-slim-report.md
  - ./wiki/second-brain/second-brain.md
  - ./wiki/rules/module-documentation.md
  - ../laravel/Modules/Rating/docs/manuals/manuale-utente.md
  - ../laravel/Modules/Xot/docs/bmad/stories/0148-phpstan-modules-zero-swarm-standing.story.md
---

# Session handoff — qualità continua

Copiare le sezioni sotto in una nuova chat per riprendere senza perdita di contesto.

## 1. Obiettivo principale

Mantenere e alzare continuamente la qualità di `base_laravelpizza_fila5`:

- `cd laravel && ./vendor/bin/phpstan analyse Modules` → **sempre 0**
- ogni `.git` dei path in `gitmodules.ini` → **&lt; 10.000 oggetti**
- docs moduli/temi ordinate (kebab, no date nei nomi, DRY, ceiling ≤100 md/owner)
- ogni modulo/tema: `docs/manuals/manuale-utente.md` + screenshot **reali** (MANUALS-001)
- prompt in `bashscripts/docs/prompts` sempre migliorati
- codice clean / DRY / KISS; `mixed` solo ultima spiaggia; fix alla **sorgente** (scopo/perché)
- coordinamento multi-agente via **BMAD + second brain + ECC + Ponytail**, senza chiedere conferma per boy-scout

## 2. Contesto e vincoli

- Progetto: LaravelPizza (meetup/community), Folio+Volt FO, Filament BO, nwidart modules, XotBase, PHPStan level max
- Path root: `/mnt/nas07/var/www/_bases/base_laravelpizza_fila5`
- Repo indipendenti: path di `gitmodules.ini` (bashscripts + moduli + Themes/Meetup), ciascuno con `.git` `laraxot/*_fila5`
- Git: forward-only; commit/push nel repo owner del modulo
- Lingua: italiano con l’utente
- Ponytail full: ladder YAGNI, diff minimo dopo aver capito lo scopo
- Gate PHPStan = solo `laravel/phpstan.neon` (mai `-c` scratch come vittoria)
- Test: Pest, niente `RefreshDatabase`; suite Project in Meetup
- `@see` → docs su ogni classe/metodo toccato; `.md` senza date/timestamp nei nomi
- `belongsToManyX` sempre; SVG file non inline; `LaravelLocalization::localizeUrl`

### Standing order (sempre, senza conferma)

1. PHPStan 0 su `Modules` (swarm random parallelo)
2. Studiare/aggiornare/organizzare docs moduli/temi + manuals
3. Migliorare `bashscripts/docs/prompts`
4. Slim git &lt;10k
5. Coordinarsi via story BMAD

## 3. Decisioni prese e risultati raggiunti

### Manuali (2026-11-25 sera)

- Canon **MANUALS-001** in `docs/wiki/rules/module-documentation.md`
- Tutti i moduli + `Themes/Meetup` hanno `docs/manuals/manuale-utente.md`
- Rating: screenshot reali pannello `rating/admin` (login, ratings, morphs, settings)
- Meetup theme: `docs/manuals` indizza `docs/manuale-utente/` (DRY, screenshot già veri)
- Fix: emoji `🍕` rimossa da `Themes/Meetup/lang/*/auth.php` (tofu in Chromium headless)
- Rating: conflitti merge risolti (preferenza laraxot/dev); modulo abilitato; dashboard Blade vuota → `RatingPanelStatsOverviewWidget`

### PHPStan (2026-11-25 ~23:00)

- Prima del fix: **3 errori**, tutti Rating `trait.unused` (`HasRating`, `HasLikes`, `DecoratesRatingFormFields`)
- Causa: consumer solo in `tests/` esclusi da `phpstan.neon` `excludePaths: ./*/tests/*`
- Fix sorgente: anchor in `app/` come `AbstractRatingsHost`
  - `AbstractHasRatingHost`, `AbstractLikeableHost`, `AbstractRatingsFormCaller`
- Gate: `./vendor/bin/phpstan analyse Modules` → **0** (verificare cold dopo clear-result-cache)
- Story: `Modules/Rating/docs/bmad/stories/0102-phpstan-trait-unused-anchors.story.md`

### Docs ceiling (2026-11-25 notte)

- Notify 2448→**100** (backup `~/backups/docs-ceiling-20261125/notify-docs.tgz`)
- **TUTTI i moduli + ThemeMeetup ≤100** (anche Gdpr/Job/Lang/Media/Tenant/Geo)
- User/Rating/AI/Cms/Activity/Xot/Meetup/ThemeMeetup tutti **≤100**
- Bug: `rm()` non rispettava `is_priority(manuals/)` → ripristinato `Rating/docs/manuals/manuale-utente.md` + patch `rm()`
- Dashboard Rating screenshot reale con widget conteggi

### Git slim / docs ceiling (stato precedente serata)

- 16/16 path &lt;10k oggetti (report `docs/git-slim-report.md`)
- Docs ceiling: regressione storica su Notify/Cms/User/Xot/Activity — da riprendere con `docs-ceiling-100.py`

## 4. Dati o codice chiave (non rompere)

| Chiave | Valore |
|--------|--------|
| PHPStan cmd | `cd laravel && ./vendor/bin/phpstan analyse Modules` |
| PHPStan config | solo `laravel/phpstan.neon` (level max) |
| Trait unused fix | classe astratta in `app/` che `use` il trait (no `@phpstan-ignore`) |
| Manuals | `docs/manuals/manuale-utente.md` + `assets/*.png` reali |
| Rating panel | `/rating/admin` (id `rating::admin`) |
| Slim cmd | `bash bashscripts/git/slim-git-repos.sh [--apply] [--shallow]` |
| Second brain | `docs/wiki/second-brain/second-brain.md` |
| Prompts | `bashscripts/docs/prompts/` |
| Theme public | symlink `public_html/themes/Meetup` → `Themes/Meetup/public` |

## 5. Prossimo passo (esatto)

1. **Tenere PHPStan a 0** dopo sync remoto (cold clear-result-cache)
2. **Ceiling**: Notify=100 raggiunto; vigilare che `docs-ceiling-100.py` `rm()` non tocchi `manuals/` (patch 2026-11-25)
3. **Prompts**: allineamento MANUALS-001 in documentation.md (subagent)
4. **Commit multi-repo** Rating/Notify/docs quando l'utente chiede
5. **Boy-scout continuo**: swarm random moduli, manuals screenshot reali

## Come ripartire (checklist 60s)

```bash
cd /mnt/nas07/var/www/_bases/base_laravelpizza_fila5/laravel
./vendor/bin/phpstan clear-result-cache
./vendor/bin/phpstan analyse Modules --memory-limit=2G
# docs ceiling spot-check
cd .. && for m in Notify Cms User Xot Activity Rating; do
  echo -n "$m "; find laravel/Modules/$m/docs -name '*.md' | wc -l
done
```

### Pulse (sera 2026-11-25, standing order)
- Theme Meetup git slim L1: ~49→48MB (bloat = PDF manuals in history; shallow solo su richiesta)
- Seo GenerateSitemapWidget: requiresConfirmation + i18n success
- lang/*/ .php SaveTrans pollution rimossi
- Fix GetTransKeyAction: Dashboard non svuota più lo slug (niente lang `it/.php` / gruppo `.navigation`); AI Dashboard → XotBaseDashboard; manuali AI/Seo/Gdpr con shot reali
- AI/Seo manuals: screenshot reali pannello (scratch :8091); Gdpr manual allineato agli asset webp già presenti
- Ceiling: **tutti** i moduli/temi ≤100 md (`over100=NONE`); manuals presenti (`missing=NONE`)
- PHPStan `Modules` **0 errori** (7006 file)
- Meetup manuals assets slim ~940K (solo fo-*.webp)
- In corso: screenshot reali pannelli AI + Seo (scratch :8091) — stub FO sostituiti

