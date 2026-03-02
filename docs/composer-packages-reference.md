# Riferimento Pacchetti Composer - LaravelPizza

Mappatura completa dei pacchetti Composer per modulo. Il progetto usa `wikimedia/composer-merge-plugin` per unire `laravel/composer.json` con `Modules/*/composer.json`.

Inventario installato (source-of-truth, da `composer show -f json`):

- [packages/index.md](./packages/index.md)

Nota: `dependencies.md` è lock-based (da `composer.lock`) e può divergere dallo stato installato se c'è drift.

## Comando aggiornamento dipendenze

```bash
cd laravel
composer go   # Merge moduli + update + migrate + serve
```

**Regola**: Le dipendenze vanno aggiunte nel `composer.json` del modulo competente, NON in `laravel/composer.json`.

---

## Root (laravel/composer.json)

| Pacchetto | Versione | Scopo |
|-----------|----------|-------|
| filament/filament | ^5.0 | Admin panel Filament 5 |
| laravel/folio | * | File-based routing |
| laravel/framework | ^12.0 | Framework Laravel |
| laravel/passport | ^13 | OAuth2 API authentication |
| livewire/livewire | ^4.0 | Frontend reattivo |
| livewire/volt | * | Single-file Livewire components |
| nwidart/laravel-modules | ^12.0 | Modular architecture |

---

## Modulo Xot (core Laraxot)

Dipendenze principali del framework interno. Tutti i moduli dipendono da Xot.

| Pacchetto | Scopo |
|-----------|-------|
| aaronfrancis/fast-paginate | Paginazione performante per tabelle grandi |
| calebporzio/sushi | Eloquent array driver (modelli in-memory) |
| coolsam/panel-modules | Integrazione nwidart-modules con Filament |
| doctrine/dbal | Schema introspection, migrazioni avanzate |
| fidum/laravel-eloquent-morph-to-one | Relazione MorphToOne |
| filament/spatie-laravel-media-library-plugin | Media library in Filament |
| flowframe/laravel-trend | Trend/statistiche temporali |
| laravel/pennant | Feature flags |
| laravel/pulse | Monitoring applicazione |
| maatwebsite/excel | Export Excel |
| predis/predis | Client Redis |
| spatie/laravel-data | DTO e Data objects |
| spatie/laravel-model-states | State machine modelli |
| spatie/laravel-model-status | Status modelli |
| spatie/laravel-permission | Ruoli e permessi |
| spatie/laravel-queueable-action | QueueableAction pattern |
| spatie/laravel-responsecache | Cache risposte HTTP |
| spatie/laravel-schemaless-attributes | Attributi JSON schemaless |
| spatie/laravel-sluggable | Slug automatici |
| spatie/laravel-tags | Tagging modelli |
| spipu/html2pdf | Generazione PDF da HTML |
| staudenmeir/eloquent-has-many-deep | Relazioni has-many-deep |
| staudenmeir/laravel-adjacency-list | Alberi gerarchici |
| thecodingmachine/safe | Funzioni PHP safe (throw invece di false) |
| tightenco/parental | Single Table Inheritance |

---

## Modulo Activity

| Pacchetto | Scopo |
|-----------|-------|
| spatie/laravel-activitylog | Audit trail, log azioni utente |
| spatie/laravel-event-sourcing | Event sourcing, CQRS |

---

## Modulo User

| Pacchetto | Scopo |
|-----------|-------|
| flowframe/laravel-trend | Statistiche utenti |
| jenssegers/agent | User-Agent parsing (desktop/mobile) |
| laravel/passport | OAuth2 API |
| socialiteproviders/auth0 | OAuth Auth0 |
| socialiteproviders/microsoft | OAuth Microsoft |
| spatie/laravel-personal-data-export | Export dati personali GDPR |

---

## Modulo Lang

| Pacchetto | Scopo |
|-----------|-------|
| mcamara/laravel-localization | URL localizzati, routing multilingua |
| lara-zeus/spatie-translatable | Plugin Filament per campi tradotti |
| rinvex/countries | Dati paesi (nomi, codici, fusi) |
| spatie/laravel-sluggable | Slug multilingua |

---

## Modulo Media

| Pacchetto | Scopo |
|-----------|-------|
| pbmedia/laravel-ffmpeg | Elaborazione video FFmpeg |
| intervention/image | Elaborazione immagini |

---

## Modulo Notify

| Pacchetto | Scopo |
|-----------|-------|
| aws/aws-sdk-php | SES, SNS (email, SMS) |
| irazasyed/telegram-bot-sdk | Bot Telegram |
| laravel-notification-channels/telegram | Notifiche Telegram |
| laravel-notification-channels/fcm | Push FCM |
| kreait/laravel-firebase | Firebase |
| spatie/laravel-database-mail-templates | Template email in DB |
| symfony/postmark-mailer | Postmark email |
| symfony/http-client | HTTP client |
| phpdocumentor/type-resolver | Type resolution |

---

## Modulo Gdpr

| Pacchetto | Scopo |
|-----------|-------|
| statikbe/laravel-cookie-consent | Banner cookie consent |

---

## Modulo Meetup

| Pacchetto | Scopo |
|-----------|-------|
| saade/filament-fullcalendar | Calendario eventi FullCalendar |

---

## Modulo UI

| Pacchetto | Scopo |
|-----------|-------|
| owenvoke/blade-fontawesome | Icone FontAwesome in Blade |

---

## Moduli senza dipendenze dirette

- **Cms** – usa Xot, Tenant, UI
- **Geo** – usa Xot, Tenant, UI (pacchetti mappe in require_comment)
- **Job** – usa Xot, Tenant
- **Seo** – usa Xot, Tenant, UI
- **Tenant** – usa Xot

---

## Pacchetti dev (Xot)

| Pacchetto | Scopo |
|-----------|-------|
| barryvdh/laravel-debugbar | Debug bar |
| barryvdh/laravel-ide-helper | PHPDoc per IDE |
| larastan/larastan | PHPStan per Laravel |
| laravel/pint | Formattazione PSR-12 |
| laravel/boost | MCP Laravel Boost |
| pestphp/pest | Testing |
| pestphp/pest-plugin-type-coverage | Type coverage |
| thecodingmachine/phpstan-safe-rule | PHPStan Safe rule |

---

## Inventario Completo (312 pacchetti)

[composer-packages-full-inventory.md](architecture/composer-packages-full-inventory.md) - Tutti i pacchetti con versione, direct/transitive, descrizione

## Collegamenti

- [AGENTS.md](../../AGENTS.md) - Guida sviluppo
- [CLAUDE.md](../../CLAUDE.md) - Regole architetturali
- [roadmap/00-index](roadmap/00-index.md) - Roadmap progetto
