# Task: Ridurre Suppressioni PHPStan Inline - Cms

**Modulo**: Cms
**Priorita'**: Alta
**Completamento**: 0%

---

## File Coinvolti

| File | Suppressioni | Tipo |
|------|-------------|------|
| `app/View/Components/PageContent.php` | 2 | mixed type su blocks |
| `app/View/Components/Page.php` | 2 | mixed type su model |
| `app/View/Components/Metatags.php` | 1 | return type |
| `app/View/Components/GuestLayout.php` | 1 | return type |
| `app/View/Components/AppLayout.php` | 1 | return type |
| `app/Filament/Resources/SectionResource/Pages/ViewSection.php` | 1 | return type |
| `app/Filament/Resources/AttachmentResource/Pages/CreateAttachment.php` | 1 | return type |
| `app/Filament/Forms/Components/DownloadAttachmentPlaceHolder.php` | 1 | return type |

## Criteri di Completamento

- [ ] Tutte le 10 suppressioni analizzate
- [ ] Almeno 7 risolte senza suppress
- [ ] PHPStan 0 errori mantenuto
