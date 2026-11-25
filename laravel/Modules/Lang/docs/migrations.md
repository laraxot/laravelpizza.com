---
title: "Migrazioni del modulo Lang"
type: reference
module: Lang
updated: 2026-11-25
qmd: "migrazioni lang XotBaseMigration language_lines posts translations user_id uuid convertUserIdToUuidIfLegacyBigint tableCreate tableUpdate ledger forward-only"
related:
  - ./bmad/stories/0030-user-id-uuid-migration-convention.story.md
  - ./model-translations.md
---
# Migrazioni del modulo Lang

`Modules/Lang/database/migrations/`: undici file su tre tabelle, tutti su `XotBaseMigration` con `$model_class` esplicito.

## Tabelle

| Tabella | Modello | Colonne principali |
|---|---|---|
| `language_lines` | `LanguageLine` | `id`, `group` (indice), `key`, `text` (json), `locale` (indice); unica su `(group, key, locale)`; timestamp e audit |
| `posts` | `Post` | `id` stringa (primaria), `user_id`, `post_id`, `lang`, `guid` (unica), `title`, `subtitle`, `post_type`, `txt`, `content`, `excerpt`, `slug`, `status`, `published_at`, `locale`, `category`, `image_*`, `meta_*`, `author_id`, `url`, `url_lang` (json); timestamp e audit |
| `translations` | `Translation` | `id`, `lang`, `value`, `namespace`, `group`, `item`, `key`, `locale`, `user_id`; indici su lang, namespace, group, key, locale; timestamp e audit |

`TranslationFile` non ha migrazione: e' un modello Sushi in memoria.

## File, nell'ordine di esecuzione

| File | Effetto |
|---|---|
| `2024_03_20_000001_create_language_lines_table` | crea `language_lines` |
| `2026_01_21_211814_create_posts_table` | crea `posts` |
| `2026_01_21_211815_create_translations_table` | crea `translations` |
| `2026_08_06_190000_create_posts_table` | seconda "create": `tableCreate()` non fa niente se la tabella esiste; `tableUpdate()` aggiunge solo le colonne mancanti (`excerpt`, `slug`, `status`, `published_at`...) |
| `2026_08_06_190100_create_translations_table` | come sopra per `translations` (`key`, `locale`, `user_id`) |
| `2026_11_05_100000_create_posts_table` | "owner canonico": se la tabella esiste converte `user_id` da bigint a UUID **conservando** i valori legacy come stringhe (`preserveLegacyValues: true`) |
| `2026_11_05_100000_update_posts_table` | `convertUserIdToUuidIfLegacyBigint()` senza conservazione: si ferma con eccezione se trova righe con `user_id` bigint |
| `2026_11_05_100000_update_user_id_uuid_on_posts_table` | `change()` a `uuid` se la colonna e' ancora bigint |
| `2026_11_05_100001_{create,update,update_user_id_uuid_on}_translations_table` | le stesse tre per `translations` |

Le tre di novembre sono ridondanti per costruzione: la prima che trova la colonna ancora bigint la converte, le altre trovano gia' una colonna non bigint e non fanno niente
(il helper e' idempotente). Il piano `create_*` + `update_*` per lo stesso modello non rispetta "una tabella, una migrazione": le duplicate **non si cancellano ne' si rinominano**
(il nome file e' parte della chiave del ledger degli ambienti gia' migrati); un eventuale consolidamento e' solo in avanti e dopo aver confrontato i ledger di tutti gli ambienti
(story [0030](bmad/stories/0030-user-id-uuid-migration-convention.story.md)).

## Perche' `user_id` e' UUID

Gli id di `Modules\User\Models\User` sono UUID; `user_id` nasceva `bigint` e ogni insert con un utente reale falliva con `Incorrect integer value`.
`XotBaseMigration::convertUserIdToUuidIfLegacyBigint($table, $nullable = true, $preserveLegacyValues = false)`:

1. non fa niente se la colonna non esiste o non e' bigint;
2. con righe `user_id` non nulle e senza `preserveLegacyValues` lancia `RuntimeException` (serve un mapping esplicito verso gli UUID);
3. con `preserveLegacyValues` converte in `char(36)` mantenendo i numeri come stringhe, risolvibili in seguito con un mapping verificato.

Ogni migrazione di novembre controlla `tableExists()` prima di `tableUpdate()`, cosi' non crea una tabella vuota quando manca il bersaglio.

## Regole

- Mai `migrate:fresh`, `migrate:refresh` o `--force` decisi da un agente; mai `down()` con drop; mai rimuovere colonne: solo aggiunte idempotenti (`hasColumn()` in `tableUpdate()`).
- Nome file: `{timestamp}_{azione}_{modello_plurale}_table.php`. `XotBaseMigration::getModelClass()` risolve il modello dal nome file solo per `create_*_table`: per `update_*` il
  `protected ?string $model_class` e' obbligatorio.
- Timestamp e audit con `$this->updateTimestamps($table, false)` (nessun modello Lang usa soft delete): aggiunge `created_at`, `updated_at`, `created_by`, `updated_by` se mancano.
- Una nuova modifica di schema e' un nuovo file `add_<colonna>_to_<tabella>` o `update_<tabella>`, mai la modifica di un file gia' applicato.
- I test usano un database gia' migrato (`php artisan migrate --env=testing` una volta): [testing.md](testing.md).
