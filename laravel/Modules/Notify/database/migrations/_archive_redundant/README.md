# Migration archiviate (Notify)

Queste migration **non devono essere eseguite** su installazione pulita (`migrate` / fresh install). Laravel carica solo i file in `database/migrations/` (non le sottocartelle); restano qui per storico e confronto.

## Tabella `mail_templates`

| Stato | File |
|-------|------|
| **Canonica** | `../2018_10_10_000007_create_mail_templates_table.php` |
| Archiviate | `2018_10_10_000000` … `000006` (CREATE ridondanti della stessa tabella) |

La canonica unisce CREATE + UPDATE (params, sms_template, counter, html_layout_path, soft delete).

## Tabella `mail_template_versions`

| Stato | File |
|-------|------|
| **Canonica** | `../2025_04_20_000001_create_mail_template_versions_table.php` |
| Archiviata | `2024_04_20_000001_create_mail_template_versions_table.php` (duplicato) |

## Regola

Una tabella = una migration attiva in `database/migrations/`. Evoluzioni schema solo nella migration canonica (pattern `XotBaseMigration`).
