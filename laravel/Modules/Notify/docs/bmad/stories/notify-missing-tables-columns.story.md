---
title: "Notify: tabelle e colonne mancanti (schema drift round 2)"
status: review
module: Notify
created: 2026-11-05
updated: 2026-11-05
qmd: "notify mail_template_logs notification_template_versions notification_channels schema drift migration mancante"
---

# Notify — schema drift round 2

## Problema

Il consolidamento `notification-logs-schema-drift` ha fixato `notification_logs`.
L'audit (`notify-test-suite-collects.story.md`, `docs/bmad/architecture/migrations.md`)
documenta ulteriore drift: tabelle **mai create** e colonne mancanti, con ~125
failure di test.

### Tabelle mancanti (modello+factory+test esistono, migrazione no)

| Modello | Tabella | Priorità |
|---|---|---|
| `MailTemplateLog` | `mail_template_logs` | HIGH — 12 test feature + seeder |
| `NotificationChannel` | `notification_channels` | HIGH |
| `NotificationTemplateVersion` | `notification_template_versions` | MEDIUM |

### Colonne segnalate mancanti (da verificare una a una)

- `mail_templates.whatsapp_template` — in `$fillable` e Filament Infolist,
  mai presente in nessuna migrazione → gap reale.
- `mail_templates.type` / `is_active` — **mai esistite** nel canonico 2018;
  sono cruft di `MailTemplateFactory` copiato da `NotificationTemplateFactory`
  → fix factory, non schema.
- `mail_template_versions.template_id` — verificare: la colonna reale è
  `mail_template_id`; potrebbe essere errore di test.
- `notifications.message` / `status` — doppio model Notation (decisione
  dominio aperta nella story round 1).
- `notification_types.slug`, `notify_themeables.themeable_type`,
  `notify_themes.json_path`, `contacts.email`/`survey_pdf_id`/`mobile_phone`.

## Regole

- Solo migration additive `XotBaseMigration`, solo `up()`, guard `hasTable`/
  `hasColumn`, `$model_class` esplicito, docblock di intent.
- Dati sacri: niente drop, niente rename distruttivo.
- Verificare ogni colonna contro modello/factory/test PRIMA di decidere
  se è gap di schema o cruft di test.
- Gate: `module:migrate Notify --env=testing`, `phpstan Modules/Notify`,
  Pest scope toccato.

## Esito (2026-11-05)

### Migration create (tutte `XotBaseMigration`, solo `up()`, `$model_class`,
### guard `tableExists`/`hasColumn`, `updateTimestamps`)

| File | Tabella | Esito |
|---|---|---|
| `2026_11_05_150000_create_mail_template_logs_table.php` | `mail_template_logs` | DONE — morph `mailable_type`/`mailable_id` come `string` (convenzione `notification_logs`, copre id int e UUID); `created_by`/`updated_by` stringa (test scrivono `'string'`) |
| `2026_11_05_150001_create_notification_template_versions_table.php` | `notification_template_versions` | DONE — `template_id` `uuid` nullable (padre `notification_templates.id` e' UUID); `channels`/`variables`/`conditions` JSON |
| `2026_11_05_150002_create_notification_channels_table.php` | `notification_channels` | DONE — `config` JSON, `is_enabled` bool, `priority` int |
| `2026_11_05_150003_update_mail_templates_table.php` | `mail_templates.whatsapp_template` | DONE — `json` nullable |
| `2026_11_05_150004_update_notification_types_table.php` | `notification_types` | DONE — `slug` (idx), `category`, `is_active` bool, `channels`/`settings` JSON |

`php artisan module:migrate Notify --env=testing`: **5/5 DONE, 0 errori**.
`phpstan analyse Modules/Notify`: **0 errori**.

### Fix mirati (cruft / errore test-factory, non schema)

| File | Fix |
|---|---|
| `database/factories/MailTemplateFactory.php` | rimossi `type` e `is_active` (mai canoniche, cruft da NotificationTemplateFactory) |
| `database/factories/NotifyThemeableFactory.php` | `themeable_type`/`themeable_id` → `model_type`/`model_id` (canonico modello+pivot) |
| `database/factories/NotificationChannelFactory.php` | `config` da `json_encode(...)` a array nativo (cast `array` del modello) |
| `app/Models/MailTemplateVersion.php` + `Traits/MailTemplateVersionRelations.php` | `$fillable` e FK `template_id` → `mail_template_id` (colonna canonica con FK); rimossa `mailable` non-colonna |
| `tests/Feature/MailTemplateVersionBusinessLogicTest.php` | 9 occorrenze `template_id` → `mail_template_id` |
| `tests/Feature/NotificationManagementBusinessLogicTest.php` | 1 occorrenza `template_id` → `mail_template_id` (MailTemplateVersion) |
| `tests/Feature/MailTemplateLogBusinessLogicTest.php` | fix test contraddittorio: timestamp futuri (+1/+3/+5 min) poi asseriva `<= now()` → fixture spostata nel passato, ordine cronologico invariato |

### Tabella decisioni gap vs cruft

| Voce | Decisione | Motivo |
|---|---|---|
| `mail_templates.whatsapp_template` | **GAP** → colonna aggiunta | `$fillable` + `MailTemplateInfolist` |
| `mail_templates.type`/`is_active` | **CRUFT** → fix factory | mai canoniche nello schema |
| `mail_template_versions.template_id` | **ERRORE test/factory** → fix | colonna canonica `mail_template_id` (FK) |
| `notification_types.slug`/`category`/`is_active`/`channels`/`settings` | **GAP** → colonne aggiunte | tutte in `$fillable` + usate dai test Feature |
| `notify_themeables.themeable_type`/`themeable_id` | **CRUFT** → fix factory | canonico `model_type`/`model_id` (modello, pivot, test) |
| `notify_themes.json_path` | **NESSUN USO** → skip | zero occorrenze in model/factory/test/Filament |
| `contacts.email`/`survey_pdf_id`/`mobile_phone` | **CRUFT test** → nessuna colonna | assenti da `$fillable`, factory e uso app; solo `ContactTest*` li persistono. `ContactResource` (name/email/phone) e' scaffold generico non allineato al modello `contact_type`/`value`: serve decisione di dominio, non migrazione |
| `notifications.message`/`status` | non toccato | decisione dominio aperta (story round 1) |

### Gate Pest

`./vendor/bin/pest Modules/Notify/tests/Feature/MailTemplateTest.php Modules/Notify/tests/Feature/MailTemplateLogBusinessLogicTest.php`:
**15 passed, 0 failed (77 assertions)** — era 1 failed prima del fix timestamp.

### NOTA blocco esterno

`Modules/Xot/app/Providers/Filament/XotBasePanelProvider.php` era in merge
conflitto (marker `<<<<<<<`) all'avvio e poi e' stato riscritto da un altro
agente lasciando un ParseError temporaneo (edit concorrente, file `M` nel
working tree). Le 4 suite Filament-backed (`MailTemplateVersion`,
`NotificationTemplateVersion`, `NotificationType`, `NotifyThemeable`
BusinessLogic) non sono eseguibili finche' il file resta rotto: **blocco
esterno a Xot, non del modulo Notify**. Riverificare quando il file torna
`php -l`-clean.
