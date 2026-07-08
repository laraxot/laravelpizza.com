# Lowercase Filename Duplicates — Lista File da Rimuovere

> **Regola**: I file PHP devono usare PascalCase (PSR-4). Quando esiste sia la versione PascalCase
> che quella lowercase, il file lowercase è **SBAGLIATO** e va cancellato.
>
> Ultimo aggiornamento: scansione completa `laravel/Modules` — tutti i file `app/` e `tests/`

---

## Priorità ALTA — File PHP (classi, test)

### Gdpr Module
| File lowercase (DA CANCELLARE) | File PascalCase (CORRETTO) | Stato |
|---|---|---|
| `tests/Feature/conflictresolutiontest.php` | `tests/Feature/ConflictResolutionTest.php` | Rinominato in `.old` su filesystem — rimuovere da git |

### Media Module
| File lowercase | File PascalCase (CORRETTO) | Stato |
|---|---|---|
| `tests/Filament/Resources/mediaconvertresourcetest.php` | `tests/Filament/Resources/MediaConvertResourceTest.php` | Rinominato in `.old` su filesystem — rimuovere da git |

### Tenant Module
| File lowercase | File PascalCase (CORRETTO) | Stato |
|---|---|---|
| `tests/Unit/domaintest.php` | `tests/Unit/DomainTest.php` | Rinominato in `.old` su filesystem — rimuovere da git |

### Xot Module
| File lowercase (DA CANCELLARE) | File PascalCase (CORRETTO) | Stato |
|---|---|---|
| `app/Http/Http/Controllers/xotbasecontroller.php` | `app/Http/Http/Controllers/XotBaseController.php` | CONFERMATO su filesystem |
| `tests/Unit/metatagdatatest.php` | `tests/Unit/MetatagDataTest.php` | CONFERMATO su filesystem |
| `tests/pest.php` | `tests/Pest.php` | CONFERMATO su filesystem |

### Legge104 Module
| File (da valutare) | Note |
|---|---|
| `app/docs/bootstrap.php` | File di configurazione docs dentro `app/` — posizione non standard |
| `app/docs/config.php` | File di configurazione docs dentro `app/` — posizione non standard |
| `app/docs/config.production.php` | File di configurazione docs dentro `app/` — posizione non standard |
| `app/docs/navigation.php` | File di configurazione docs dentro `app/` — posizione non standard |

### Performance Module
| File lowercase (DA CANCELLARE) | Note |
|---|---|
| `app/Models/Traits/test.php` | File con nome generico — probabilmente da rimuovere |

### Progressioni Module
| File (da valutare) | Note |
|---|---|
| `fix_factories.php` | Script temporaneo — probabilmente da rimuovere |

### User Module
| File (da valutare) | Note |
|---|---|
| `tests/Feature/user-management-business-logic.php` | kebab-case — non standard, da rinominare |

---

## Priorità MEDIA — File `.php.up` (backup/diff Notify)

Tutti nel modulo **Notify** — probabilmente generati da agenti AI come backup prima di modifiche:

| File lowercase (DA CANCELLARE) | File PascalCase (CORRETTO) |
|---|---|
| `app/Models/notificationlog.php.up` | `app/Models/NotificationLog.php` |
| `app/Models/notificationtemplateversion.php.up` | `app/Models/NotificationTemplateVersion.php` |
| `app/Filament/Resources/notificationtemplateresource.php.up` | `app/Filament/Resources/NotificationTemplateResource.php` |
| `app/Filament/Resources/MailTemplateResource/RelationManagers/versionsrelationmanager.php.up` | `...VersionsRelationManager.php` | Rinominato in `.old` su filesystem |
| `app/Filament/Resources/MailTemplateResource/RelationManagers/logsrelationmanager.php.up` | `...LogsRelationManager.php` | Rinominato in `.old` su filesystem |

---

## Priorità MEDIA — File `.test` (snapshot/diff Notify e altri)

### Notify Module
| File lowercase (DA CANCELLARE) | Note |
|---|---|
| `app/Notifications/testnotification.test` | Snapshot lowercase |
| `app/Notifications/Channels/smschannel.test` | Snapshot lowercase |
| `app/Services/MailEngines/duocircleengine.test` | Snapshot lowercase |
| `app/Filament/Resources/notificationlogresource.test` | Snapshot lowercase |
| `app/Filament/Resources/NotificationLogResource/Pages/editnotificationlog.php.test` | Snapshot lowercase |
| `app/Filament/Resources/NotificationLogResource/Pages/createnotificationlog.test` | Snapshot lowercase |
| `app/Filament/Resources/NotificationLogResource/Pages/listnotificationlogs.php.test` | Snapshot lowercase |
| `app/Filament/Resources/NotificationLogResource/Pages/viewnotificationlog.php.test` | Snapshot lowercase |

### Xot Module
| File (da valutare) | Note |
|---|---|
| `tests/Unit/hasxottabletest.test` | Snapshot lowercase |
| `app/Services/trend.test` | Snapshot lowercase |
| `phpstan.neon.test` | Config test — probabilmente da rimuovere |

### Job Module
| File (da valutare) | Note |
|---|---|
| `.github/workflows/code-improvement.test` | Workflow test — probabilmente da rimuovere |

### Performance Module (Views)
| File (da valutare) | Note |
|---|---|
| `resources/views/admin/individuale_dips/show/pdf.test` | Blade view test/snapshot |
| `resources/views/admin/individuale/compila.test` | Blade view test/snapshot |
| `resources/views/admin/individuale_dip/show/pdf.test` | Blade view test/snapshot |
| `resources/views/admin/individuales/compila.test` | Blade view test/snapshot |

### Ptv Module
| File (da valutare) | Note |
|---|---|
| `resources/views/nav/stabi_repar_anno.blade.test` | Blade view test/snapshot |

---

## File Speciali (Template con Variabili)

Nel modulo **Xot** esistono file con nomi che contengono sintassi Blade (non validi come filename):
- `app/Resources/views/factory-generator/class {{ $reflection->getShortName() }}Factory extends Factory.php`
- `app/Resources/views/factory-generator/class {{ $reflection-_getShortName() }}Factory extends Factory.php`

Questi sono **template** usati per la generazione di factory — non sono file PHP reali. Da valutare se sono necessari o da rimuovere.

---

## Come Procedere

Per ogni file nella lista:

```bash
# 1. Verificare che esista il file PascalCase corretto
ls -la laravel/Modules/{Module}/path/to/PascalCaseFile.php

# 2. Leggere il file lowercase per capire se ha contenuto diverso
cat laravel/Modules/{Module}/path/to/lowercasefile.php

# 3. Se il file PascalCase è aggiornato e completo, cancellare il lowercase
rm laravel/Modules/{Module}/path/to/lowercasefile.php
# oppure se è tracked da git:
git rm laravel/Modules/{Module}/path/to/lowercasefile.php

# 4. Verificare dopo
ls -la laravel/Modules/{Module}/path/to/
```

---

## Regola Generale

> **Un file PHP = un nome PascalCase = una classe.**
> Mai avere due file con lo stesso nome in case diverso nella stessa directory.

Vedi anche: [AGENTS.md](../AGENTS.md) — sezione "Naming Conventions"
