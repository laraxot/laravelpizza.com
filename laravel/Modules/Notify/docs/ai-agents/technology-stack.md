# Technology Stack

Vedi [index](index.md) per navigazione completa.

## Core

- **PHP**: 8.3.x (strict typing required)
- **Laravel**: 12.x (v12.53.0)
- **Filament**: 5.x (v5.2.2)
- **Livewire**: 4.x (v4.1.4) + Volt 1.x (v1.10.3)
- **PHPStan**: Level 10 (mandatory - zero tolerance)
- **Laravel Pint**: PSR-12 formatting

## Key Packages (v12.x Compatible)

### Laravel Official

| Package | Version | Description |
|---------|---------|-------------|
| laravel/framework | v12.53.0 | Core framework |
| laravel/pulse | v1.6.0 | Application monitoring |
| laravel/pennant | v1.20.0 | Feature flags |
| laravel/folio | v1.1.13 | File-based routing |
| laravel/passport | v13.5.0 | OAuth2 server |
| laravel/socialite | v5.24.3 | OAuth authentication |
| laravel/mcp | v0.5.9 | MCP runtime per tool server e integrazioni IDE |
| laravel/boost | v2.2.0 | Tooling avanzato per docs, QA e integrazione IDE |
| laravel/roster | v0.5.0 | Rilevamento pacchetti e capability mapping |
| laravel/sail | v1.53.0 | Ambiente Docker di sviluppo |
| laravel/pail | v1.2.6 | Analisi e navigazione dei log applicativi |
| laravel/tinker | v2.11.1 | REPL interattivo per Laravel |

### Filament 5

| Package | Version | Description |
|---------|---------|-------------|
| filament/filament | v5.2.2 | Admin panel |
| filament/actions | v5.2.2 | Action modals |
| filament/forms | v5.2.2 | Form components |
| filament/tables | v5.2.2 | Table components |
| filament/infolists | v5.2.2 | Read-only infolists |
| filament/notifications | v5.2.2 | Notifications |
| filament/widgets | v5.2.2 | Dashboard widgets |
| filament/schemas | v5.2.2 | Schema components |
| filament/support | v5.2.2 | Support utilities |

### Spatie

| Package | Version | Description |
|---------|---------|-------------|
| spatie/laravel-permission | 7.2.2 | RBAC permissions |
| spatie/laravel-data | 4.19.1 | Data transfer objects |
| spatie/laravel-medialibrary | 11.21.0 | Media management |
| spatie/laravel-event-sourcing | 7.15.0 | Event sourcing |
| spatie/laravel-activitylog | * | Activity logging |

### Notifications

| Package | Version | Description |
|---------|---------|-------------|
| laravel-notification-channels/fcm | 6.0.1 | Firebase Cloud Messaging |
| laravel-notification-channels/telegram | 6.0.0 | Telegram notifications |
| kreait/laravel-firebase | 7.0.0 | Firebase integration |
| irazasyed/telegram-bot-sdk | v3.15.0 | Telegram Bot API |

### Cloud & Storage

| Package | Version | Description |
|---------|---------|-------------|
| aws/aws-sdk-php | 3.371.0 | AWS SDK |
| google/apiclient | v2.19.0 | Google API Client |
| league/flysystem-google-cloud-storage | 3.31.0 | GCS adapter |

### Media & Images

| Package | Version | Description |
|---------|---------|-------------|
| intervention/image | 3.11.7 | Image processing |
| maatwebsite/excel | 3.1.67 | Excel import/export |
| pbmedia/laravel-ffmpeg | 8.8.0 | Video processing |

### Utilities

| Package | Version | Description |
|---------|---------|-------------|
| mcamara/laravel-localization | v2.3.0 | i18n routing |
| jenssegers/agent | v2.6.4 | User agent detection |
| doctrine/dbal | 4.4.1 | Database abstraction |
| nwidart/laravel-modules | v12.0.4 | Module management |

## Module System

- **Nwidart Laravel Modules**: Modular architecture
- **Custom XotBase Classes**: Extended functionality
- **Zero Theme**: Primary UI theme

## Riferimenti

- [index](index.md)
- [critical-rules](critical-rules.md)
