# Modulo Notify

## Overview

Il modulo **Notify** gestisce il sistema di notifiche dell'applicazione.

## Funzionalità

- Mail notifications
- Database notifications
- Template management
- Queue integration

## Modelli Principali

```php
// Mail Template
Notify\Models\MailTemplate

// Mail Template Version
Notify\Models\MailTemplateVersion

// Notification
Notify\Models\Notification
```

## Trait

```php
use Modules\Notify\Models\Traits\HasNotify;
```

## Collegamenti

- [Documentazione Root](../../../docs/NOTIFY_MODULE.md)
- [Xot Base](../Xot/docs/)
- [User Module](../User/docs/)

## Backlinks

- [Filament Resources](./filament/)
- [PHPStan Config](./phpstan/)

## Documentation

- [On-Demand Pattern](./ON-DEMAND-PATTERN.md) — Pattern per caricamento efficiente
- [QMD Setup](./QMD-SETUP.md) — Configurazione ricerca locale
- [Performance](./PERFORMANCE-OPTIMIZATION.md) — Metriche e best practice
- [Project Structure](./PROJECT-STRUCTURE.md) — Directory layout
