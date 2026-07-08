---
title: "censimento omonimi metodi — indice progetto"
type: analysis
updated: 2026-06-15
related:
  - ../../bashscripts/docs/method-homonym-census.json
  - ../../laravel/Modules/Sigma/docs/wiki/concepts/method-name-homonyms.md
  - ../../laravel/Modules/Xot/docs/wiki/concepts/redundancy-catalog.md
---

# Censimento omonimi metodi — PTVX

> Metodi con **stesso nome** in **classi/trait diverse** sotto `laravel/Modules` e `laravel/Themes`.
> Generato: **2026-06-15** — **689** nomi omonimi.

## Dati grezzi

- JSON: [method-homonym-census.json](../../bashscripts/docs/method-homonym-census.json)
- Script: `python3 bashscripts/tools/census-method-homonyms.py`

## Riepilogo per categoria

| Categoria | Conteggio |
|-----------|-----------|
| `A_filament_framework` | 38 |
| `B_sigma_relationship_homonym` | 7 |
| `C_sigma_gg_business` | 61 |
| `D_field_metadata_contract` | 5 |
| `E_scheda_stack` | 106 |
| `F_trait_name_collision` | 18 |
| `G_module_local` | 273 |
| `H_cross_module_homonym` | 181 |

## Top business (non framework)

- **`toArray`** (39 classi, `E_scheda_stack`) — moduli: Notify, Pdnd, Progressioni, Seo, Sigma…
- **`before`** (14 classi, `E_scheda_stack`) — moduli: Activity, Gdpr, Job, Lang, Media…
- **`populateFromLastYear`** (14 classi, `E_scheda_stack`) — moduli: Progressioni
- **`via`** (14 classi, `E_scheda_stack`) — moduli: Job, Notify, Progressioni, Ptv, User
- **`annFieldName`** (13 classi, `D_field_metadata_contract`) — moduli: IndennitaCondizioniLavoro, Progressioni, Ptv, Sigma
- **`rangeFromField`** (13 classi, `D_field_metadata_contract`) — moduli: IndennitaCondizioniLavoro, Progressioni, Ptv, Sigma
- **`rangeToField`** (13 classi, `D_field_metadata_contract`) — moduli: IndennitaCondizioniLavoro, Progressioni, Ptv, Sigma
- **`compila`** (13 classi, `E_scheda_stack`) — moduli: IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni
- **`getHeaderWidgets`** (13 classi, `E_scheda_stack`) — moduli: Job, Media, Notify, Ptv, UI…
- **`getView`** (11 classi, `E_scheda_stack`) — moduli: Gdpr, Performance, Ptv, Xot
- **`getModel`** (10 classi, `E_scheda_stack`) — moduli: IndennitaResponsabilita, Media, Ptv, User, Xot
- **`toMail`** (10 classi, `E_scheda_stack`) — moduli: Job, Notify, Progressioni, Ptv, User
- **`validate`** (8 classi, `E_scheda_stack`) — moduli: IndennitaResponsabilita, Job, Pdnd, Progressioni, UI…
- **`anag`** (7 classi, `B_sigma_relationship_homonym`) — moduli: IndennitaResponsabilita, Progressioni, Ptv, Sigma
- **`authorizeAccess`** (7 classi, `E_scheda_stack`) — moduli: IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Ptv…

## Riflessioni (sintesi)

### Omonimo ≠ duplicato

Lo stesso nome in classi diverse è spesso **polimorfismo legittimo**: hook Filament (`getTableColumns`, `definition`), migration `up`/`down`, factory `definition`. La categoria `A_filament_framework` (~38 nomi) non va trattata come debito.

### Debito business reale (priorità refactor)

| Priorità | Cluster | Perché |
|----------|---------|--------|
| P0 | `B_sigma_relationship_homonym` | Relazioni `qua00f`/`rep00f`/`anag` ripetute — centralizzare in `EnteMatrRelationship` + `hasManyByEnteMatr` |
| P0 | `D_field_metadata_contract` | `matrField`/`enteField`/`rangeFromField` — contratto unico, no copy-paste |
| P1 | `C_sigma_gg_business` | `gg`, `giorni`, accessor `getGg*` duplicati su `Qua00f`, `Sto00f`, trait scheda |
| P1 | `E_scheda_stack` | ~106 omonimi tra `SchedaTrait`, `SchedaExtraFieldTrait`, modelli Progressioni/Ptv |
| P2 | `F_trait_name_collision` | Trait diversi con stesso metodo — rischio conflitto `use` multiplo |
| P3 | `G_module_local` / `H_cross_module` | Valutare caso per caso; spesso pattern XotBase |

### Temi (One, Three, Zero)

Scan PHP nei temi: **0 omonimi cross-class**. I temi sono strato presentazione (Blade, asset); la logica duplicata vive nei **moduli**. I documenti tema spiegano il confine e rimandano all'indice moduli.

### Filosofia DRY + KISS

1. **Un owner per concetto**: relazione ente/matr → Sigma `BaseModel`; scheda → `BaseScheda` / trait unico.
2. **Override mirato**: es. `Rep00f::qua00f()` con `ofRangeDate` — non copiare l'intera relazione.
3. **Non rinominare per “pulizia”**: `matrField()` resta metadata (parallelo a `rangeFromField()`), non accessor `get*`.
4. **Rigenerare dopo refactor**: `python3 bashscripts/tools/census-method-homonyms.py` aggiorna JSON + tutti i `.md`.


## Schede per modulo

- [Activity](../../laravel/Modules/Activity/docs/wiki/concepts/method-name-homonyms.md)
- [Badge](../../laravel/Modules/Badge/docs/wiki/concepts/method-name-homonyms.md)
- [CertFisc](../../laravel/Modules/CertFisc/docs/wiki/concepts/method-name-homonyms.md)
- [ContoAnnuale](../../laravel/Modules/ContoAnnuale/docs/wiki/concepts/method-name-homonyms.md)
- [DbForge](../../laravel/Modules/DbForge/docs/wiki/concepts/method-name-homonyms.md)
- [Europa](../../laravel/Modules/Europa/docs/wiki/concepts/method-name-homonyms.md)
- [Gdpr](../../laravel/Modules/Gdpr/docs/wiki/concepts/method-name-homonyms.md)
- [Inail](../../laravel/Modules/Inail/docs/wiki/concepts/method-name-homonyms.md)
- [Incentivi](../../laravel/Modules/Incentivi/docs/wiki/concepts/method-name-homonyms.md)
- [IndennitaCondizioniLavoro](../../laravel/Modules/IndennitaCondizioniLavoro/docs/wiki/concepts/method-name-homonyms.md)
- [IndennitaResponsabilita](../../laravel/Modules/IndennitaResponsabilita/docs/wiki/concepts/method-name-homonyms.md)
- [Job](../../laravel/Modules/Job/docs/wiki/concepts/method-name-homonyms.md)
- [Lang](../../laravel/Modules/Lang/docs/wiki/concepts/method-name-homonyms.md)
- [Legge104](../../laravel/Modules/Legge104/docs/wiki/concepts/method-name-homonyms.md)
- [Legge109](../../laravel/Modules/Legge109/docs/wiki/concepts/method-name-homonyms.md)
- [Media](../../laravel/Modules/Media/docs/wiki/concepts/method-name-homonyms.md)
- [Mensa](../../laravel/Modules/Mensa/docs/wiki/concepts/method-name-homonyms.md)
- [MobilitaVolontaria](../../laravel/Modules/MobilitaVolontaria/docs/wiki/concepts/method-name-homonyms.md)
- [Notify](../../laravel/Modules/Notify/docs/wiki/concepts/method-name-homonyms.md)
- [Pdnd](../../laravel/Modules/Pdnd/docs/wiki/concepts/method-name-homonyms.md)
- [Performance](../../laravel/Modules/Performance/docs/wiki/concepts/method-name-homonyms.md)
- [Prenotazioni](../../laravel/Modules/Prenotazioni/docs/wiki/concepts/method-name-homonyms.md)
- [PresenzeAssenze](../../laravel/Modules/PresenzeAssenze/docs/wiki/concepts/method-name-homonyms.md)
- [Progressioni](../../laravel/Modules/Progressioni/docs/wiki/concepts/method-name-homonyms.md)
- [Ptv](../../laravel/Modules/Ptv/docs/wiki/concepts/method-name-homonyms.md)
- [Questionari](../../laravel/Modules/Questionari/docs/wiki/concepts/method-name-homonyms.md)
- [Rating](../../laravel/Modules/Rating/docs/wiki/concepts/method-name-homonyms.md)
- [Seo](../../laravel/Modules/Seo/docs/wiki/concepts/method-name-homonyms.md)
- [Setting](../../laravel/Modules/Setting/docs/wiki/concepts/method-name-homonyms.md)
- [Sigma](../../laravel/Modules/Sigma/docs/wiki/concepts/method-name-homonyms.md)
- [Sindacati](../../laravel/Modules/Sindacati/docs/wiki/concepts/method-name-homonyms.md)
- [Tenant](../../laravel/Modules/Tenant/docs/wiki/concepts/method-name-homonyms.md)
- [UI](../../laravel/Modules/UI/docs/wiki/concepts/method-name-homonyms.md)
- [User](../../laravel/Modules/User/docs/wiki/concepts/method-name-homonyms.md)
- [Xot](../../laravel/Modules/Xot/docs/wiki/concepts/method-name-homonyms.md)

## Schede per tema

- [Theme One](../../laravel/Themes/One/docs/wiki/concepts/method-name-homonyms.md)
- [Theme Three](../../laravel/Themes/Three/docs/wiki/concepts/method-name-homonyms.md)
- [Theme Zero](../../laravel/Themes/Zero/docs/wiki/concepts/method-name-homonyms.md)
