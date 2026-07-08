# Model/Factory/Seeder Audit

Generated: 2025-08-22 16:29

## Coverage
| Model | Factory | Seeded |
|---|---|---|
| Notification | yes | no |
| MailTemplateLog | yes | no |
| NotificationTemplateVersion | yes | no |
| Contact | yes | no |
| NotifyTheme | yes | no |
| MailTemplateVersion | yes | no |
| NotificationType | yes | no |
| NotificationTemplate | yes | no |
| MailTemplate | yes | yes |
| NotifyThemeable | yes | no |

Seeders:
- `database/seeders/DatabaseSeeder.php`
- `database/seeders/MailTemplateSeeder.php`
- `database/seeders/MailTemplatesSeeder.php`
- `database/seeders/NotifyDatabaseSeeder.php`

## Missing / Actions
- Add exemplar seeding for: NotificationTemplate, NotificationTemplateVersion, NotificationType, Contact, NotifyTheme.
- Keep `MailTemplate*` seeding as is; extend with relationships if needed.

## Likely non-business-critical
- None; all listed are domain entities but some may be configuration-only and safe to seed minimally.
