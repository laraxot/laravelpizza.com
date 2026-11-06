---
title: "Notify: tabelle e colonne mancanti (schema drift round 2)"
status: in-progress
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
