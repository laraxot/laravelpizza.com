---
title: "Database, migrazioni, factory e seeder"
type: reference
module: Gdpr
updated: 2026-11-25
---

# Database, migrazioni, factory e seeder

## Tabelle

Connessione `gdpr` (`BaseModel`). Le migrazioni estendono `XotBaseMigration` (`tableCreate()` + `tableUpdate()`, solo aggiunte
idempotenti con `hasColumn()`).

| Tabella | Modello | Colonne |
|---|---|---|
| `treatments` | `Treatment` | `id` uuid, `active`, `required`, `name` (unico), `description`, `documentVersion`, `documentUrl`, `weight`, timestamp + soft delete |
| `consents` | `Consent` | `id` uuid, `treatment_id` (uuid, nullable), `subject_id` (string, nullable), morph `user` (`user_id` string + `user_type`), `type`, `accepted_at`, `ip_address` (45), `user_agent`, `metadata` json, `revoked_at` (indicizzata), `revoked_ip_address`, `created_by`/`updated_by`, timestamp + soft delete |
| `gdpr_events` | `Event` | `id` uuid, `treatment_id`, `consent_id`, `subject_id`, `ip` (cifrato), `action`, `payload` (cifrato), timestamp + soft delete |

Nessuna chiave esterna: `treatment_id` e `consent_id` sono colonne uuid senza vincolo. Il significato delle colonne di `consents`
e' in [consents.md](consents.md).

## Migrazioni (ordine reale)

| File | Cosa |
|---|---|
| `2024_01_01_000001_create_treatments_table` (e `000002_create_treatments_table`), `2024_01_01_000001_create_gdpr_events_table` | tabelle `treatments` e `gdpr_events` |
| `2024_01_01_000001`, `000002`, `000005`, `000006` `_create_consents_table` | storia di `consents`: la `000005` e' la canonica (morph `user`, `type`, `accepted_at`, IP, user agent); la `000006` aggiunge `metadata`, `revoked_at`, `revoked_ip_address` |
| `2026_11_11_000001_add_revocation_columns_to_consents_table` | `revoked_at` (indicizzata), `revoked_ip_address` |
| `2026_11_12_000001_add_metadata_to_consents_table` | `metadata` JSON |
| `2026_11_12_000002_add_revocation_columns_to_consents_table` | le tre colonne di revoca, idempotente |

`database/migrations/_archive_redundant/` contiene copie storiche non eseguibili di `create_consents`/`create_treatments`
(`README.md` li dichiara "non eseguire").

### Perche' ci sono tre migrazioni additive datate

Le colonne `metadata`, `revoked_at`, `revoked_ip_address` le creava la `000006`; i mirror del modulo l'hanno cancellata due
volte e su un database nuovo ogni registrazione falliva con `Unknown column 'metadata'`. Le migrazioni 2026 sono additive,
idempotenti (`hasColumn`) e con nome datato per restare distinte dalle `create_consents_table` storiche: non vanno
"consolidate" cancellandole, perche' i database gia' migrati le hanno registrate.

### Regole per chi aggiunge una colonna

- Una nuova migrazione `add_<colonna>_to_consents_table` con `tableUpdate` e `hasColumn`; mai riscrivere una `create_*` esistente.
- Mai `migrate:fresh`, `migrate:refresh` o `--force` su database con dati: i consensi sono prova legale (art. 7).
- `down()` vuoto: non si rimuovono colonne di prova.
- Il filename `create_<modello>_table` deriva dal **modello** (`XotBaseMigration::getModelClass()` lo risolve dal nome).

Debito: quattro file `create_consents_table` (e due `create_treatments_table`) contraddicono "una tabella, una migrazione"; vanno lasciati
finche' esistono database migrati con quei nomi ([code-quality.md](code-quality.md)).

## Factory e seeder

Factory: `ConsentFactory`, `EventFactory`, `ProfileFactory`, `TreatmentFactory`. Seeder: `GdprDatabaseSeeder` (vuoto: nessuna
chiamata attiva), `ConsentSeeder`, `EventSeeder`, `ProfileSeeder`, `TreatmentSeeder`, `TreatmentsTableSeeder`
(sette trattamenti, versione `1.0`: obbligatori `privacy_policy`, `terms_conditions`, `data_processing`; facoltativi `marketing_consent`, `profiling_consent`, `analytics_consent`, `third_party_consent`; li crea o li aggiorna per `name`).
`SaveGdprConsentsAction` non dipende dal seeder: se un trattamento manca lo crea.
