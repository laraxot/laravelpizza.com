---
title: "Pagine Filament del Modulo Notify"
type: concept
tags: [filament, pages]
created: 2026-07-14
updated: 2026-07-14
qmd: "filament-pages-1 pagine filament del modulo notify"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
status: draft
---

# Pagine Filament del Modulo Notify

## Panoramica

Le pagine Filament del modulo Notify estendono le classi base del modulo Xot e implementano le funzionalità specifiche per la gestione dei template delle notifiche.

## Struttura delle Pagine

### ListNotificationTemplates

```php
namespace Modules\Notify\Filament\Resources\NotificationTemplateResource\Pages;

use Modules\Notify\Filament\Resources\NotificationTemplateResource;
use Modules\Xot\Filament\Pages\XotBaseListRecords;

class ListNotificationTemplates extends XotBaseListRecords
{
    protected static string $resource = NotificationTemplateResource::class;
}
```

### CreateNotificationTemplate

```php
namespace Modules\Notify\Filament\Resources\NotificationTemplateResource\Pages;

use Modules\Notify\Filament\Resources\NotificationTemplateResource;
use Modules\Xot\Filament\Pages\XotBaseCreateRecord;

class CreateNotificationTemplate extends XotBaseCreateRecord
{
    protected static string $resource = NotificationTemplateResource::class;
}
```

### EditNotificationTemplate

```php
namespace Modules\Notify\Filament\Resources\NotificationTemplateResource\Pages;

use Modules\Notify\Filament\Resources\NotificationTemplateResource;
use Modules\Xot\Filament\Pages\XotBaseEditRecord;

class EditNotificationTemplate extends XotBaseEditRecord
{
    protected static string $resource = NotificationTemplateResource::class;
}
```

## Best Practices Seguite

1. **Estensione Corretta**
   - Estendono le classi base dal modulo Xot
   - Non sovrascrivono metodi non necessari
   - Mantengono la struttura standard

2. **Namespace**
   - Seguono la struttura standard dei moduli
   - Non includono `app` nel namespace
   - Mantengono coerenza con altri componenti

3. **Configurazione**
   - Definiscono correttamente la risorsa associata
   - Non duplicano funzionalità delle classi base
   - Mantengono la semplicità

## Collegamenti Bidirezionali

### Collegamenti nella Root
- [Architettura Filament](../../../../../docs/project/architecture/filament.md)
- [Gestione Pagine](../../../../../docs/project/architecture/pages.md)

### Collegamenti ai Moduli
- [XotBaseListRecords](../../Xot/project_docs/filament-pages.md#XotBaseListRecords)
- [XotBaseCreateRecord](../../Xot/project_docs/filament-pages.md#XotBaseCreateRecord)
- [XotBaseEditRecord](../../Xot/project_docs/filament-pages.md#XotBaseEditRecord)
- [NotificationTemplateResource](./filament-resources.md)

## Note Importanti

1. Le pagine estendono sempre le classi base appropriate
2. Non si sovrascrivono metodi se non necessario
3. Si mantiene la coerenza con il resto del sistema
4. La documentazione va mantenuta aggiornata
5. I namespace seguono le convenzioni standard 