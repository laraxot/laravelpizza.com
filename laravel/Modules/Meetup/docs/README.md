# Laravel Pizza Meetups - Modulo Meetup

## Overview

Il modulo **Meetup** è il core della piattaforma Laravel Pizza Meetups - una community platform per sviluppatori Laravel che organizza eventi tech informali dove si condivide pizza e conoscenza.

**IMPORTANTE**: Questo NON è un sito e-commerce per vendere pizza, ma una metafora per eventi tech dove sviluppatori si incontrano davanti a una pizza.

---

## Stack Tecnologico

### Frontend Architecture
- **Laravel Folio** - File-based routing (NO controllers, NO web.php routes)
- **Laravel Volt** - Declarative components (NO Livewire class components)
- **Tailwind CSS** - Utility-first styling
- **Alpine.js** - JavaScript interactions

### Backend Architecture
- **Laravel 11.x** - PHP framework
- **Laravel Modules** - Modular architecture
- **Filament PHP** - Admin panel (SOLO per admin)
- **Eloquent ORM** - Database abstraction

### Design Principles
- **DRY** - Don't Repeat Yourself
- **KISS** - Keep It Simple, Stupid
- **SOLID** - Object-oriented design principles
- **Robust** - Error handling, validation, safety
- **Laraxot** - Modular patterns and conventions

---

## Struttura del Modulo

```
Modules/Meetup/
├── app/
│   ├── Models/
│   │   ├── Event.php
│   │   ├── EventRegistration.php
│   │   └── User.php (extended)
│   ├── Actions/                    # Business logic
│   │   ├── CreateEvent.php
│   │   ├── RegisterForEvent.php
│   │   └── SendNotification.php
│   ├── Components/                 # Modular components
│   │   ├── EventListComponent.php
│   │   ├── EventCalendarComponent.php
│   │   └── CommunityChatComponent.php
│   ├── Filament/                   # Admin resources
│   │   └── Resources/
│   │       ├── EventResource.php
│   │       └── UserResource.php
│   └── Providers/
│       ├── MeetupServiceProvider.php
│       └── ComponentServiceProvider.php
├── database/
│   ├── migrations/
│   └── seeders/
├── docs/                           # Documentation
│   ├── README.md (this file)
│   ├── project-purpose.md
│   ├── folio-volt-architecture.md
│   ├── implementation-roadmap-final.md
│   └── modern-architecture-patterns.md
└── config/
    └── meetup.php
```

---

## Funzionalità Principali

### Sistema Eventi
- ✅ Creazione e gestione eventi
- ✅ Sistema RSVP con limiti partecipazione
- ✅ Calendario eventi
- ✅ Filtri e ricerca avanzata
- ✅ Notifiche email per eventi

### Community Features
- ✅ Dashboard utente personalizzata
- ✅ Profili sviluppatori
- ✅ Chat community real-time
- ✅ Sistema rating eventi
- ✅ Activity feed

### Admin Panel (Filament)
- ✅ Gestione completa eventi
- ✅ Gestione utenti e permessi
- ✅ Analytics e report
- ✅ Configurazione sistema

### Modular Components
- ✅ Componenti riutilizzabili
- ✅ No-code configuration
- ✅ Drag & drop interface
- ✅ Theme system

---

## Regole Architetturali Assolute

### ❌ COSA NON FARE MAI
1. ❌ **NON** creare controllers tradizionali
2. ❌ **NON** scrivere rotte in `web.php` o `api.php`
3. ❌ **NON** usare Livewire class components
4. ❌ **NON** creare nuove cartelle docs
5. ❌ **NON** usare maiuscole in nomi file .md (eccetto README.md e CHANGELOG.md)
6. ❌ **NON** mettere file .md fuori cartelle docs (eccetto README.md e CHANGELOG.md)

### ✅ COSA FARE SEMPRE
1. ✅ Usare **Folio** per tutte le rotte frontend
2. ✅ Usare **Volt** per tutti i componenti reattivi
3. ✅ Usare **Filament** solo per admin panel
4. ✅ Usare nomi file .md in **lowercase**
5. ✅ Usare **hyphens** invece di underscores: `file-name.md`
6. ✅ Usare cartelle docs **esistenti**, NON crearne di nuove

---

## Implementazione Frontend (Folio + Volt)

### Struttura Pages
```
resources/views/pages/
├── index.blade.php                 # Homepage (/)
├── events/
│   ├── index.blade.php             # Lista eventi (/events)
│   └── [event].blade.php           # Dettaglio evento (/events/{slug})
├── community/
│   ├── index.blade.php             # Community hub (/community)
│   └── [username].blade.php        # Profilo utente (/community/{username})
├── dashboard/
│   └── index.blade.php             # Dashboard utente (/dashboard)
└── auth/
    ├── login.blade.php             # Login (/login)
    └── register.blade.php          # Registrazione (/register)
```

### Esempio Component Volt
```php
// resources/views/livewire/event-list.blade.php
<?php

use function Livewire\Volt\state;
use function Livewire\Volt\computed;

state(['search' => '']);

$events = computed(function () {
    return Event::query()
        ->when($this->search, fn($q, $search) =>
            $q->where('title', 'like', "%{$search}%")
        )
        ->where('status', 'published')
        ->orderBy('start_date')
        ->get();
});

?>

<div>
    <input type="text" wire:model.live="search" placeholder="Cerca eventi...">

    @foreach($this->events as $event)
        <x-events.event-card :event="$event" />
    @endforeach
</div>
```

---

## Implementazione Backend (Modular + Filament)

### Esempio Filament Resource
```php
// Modules/Meetup/Filament/Resources/EventResource.php
class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required(),
                RichEditor::make('description')->required(),
                DateTimePicker::make('start_date')->required(),
                // ... altri campi
            ]);
    }
}
```

### Esempio Modular Component
```php
// Modules/Meetup/Components/EventListComponent.php
class EventListComponent implements ComponentInterface
{
    public function getName(): string
    {
        return 'event-list';
    }

    public function render(array $settings = []): View
    {
        $events = Event::query()
            ->where('status', 'published')
            ->limit($settings['limit'] ?? 6)
            ->get();

        return view('meetup::components.event-list', [
            'events' => $events,
            'settings' => $settings,
        ]);
    }
}
```

---

## Documentazione Completa

### Architettura e Pattern
- [**Scopo del Progetto**](project-purpose.md) - Filosofia e obiettivi
- [**Architettura Folio+Volt**](folio-volt-architecture.md) - Stack frontend
- [**Pattern Moderni**](modern-architecture-patterns.md) - Analisi Genesis + WarriorFolio
- [**Analisi WarriorFolio**](warriorfolio-analysis.md) - Architettura modulare avanzata
- [**Analisi Genesis**](genesis-starter-kit-analysis.md) - TALL Stack con Folio + Volt

### Implementazione e Planning
- [**Roadmap Finale**](implementation-roadmap-final.md) - Piano 8 settimane completo
- [**Regole Naming**](documentation-naming-rules.md) - Convenzioni documentazione
- [**Riassunto Implementazione**](implementation-summary.md) - Sintesi architettura

### Best Practices
- [**Regole Architetturali**](architectural-rules.md) - Linee guida sviluppo
- [**Sistema Componenti**](component-system.md) - Modular architecture
- [**Integration Patterns**](integration-patterns.md) - Comunicazione moduli

---

## Installazione e Setup

### Requisiti
- PHP 8.2+
- Laravel 11.x
- Composer
- Node.js 18+

### Installazione
```bash
# Nel progetto Laravel principale
composer require nwidart/laravel-modules

# Pubblicare configurazione moduli
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"

# Creare modulo Meetup
php artisan module:make Meetup

# Installare dipendenze frontend
npm install
npm run dev
```

### Configurazione
1. Abilitare modulo in `config/modules.php`
2. Configurare database per eventi
3. Setup email per notifiche
4. Configurare Filament panel

---

## Testing

### Test Strategy
```bash
# Unit tests
./vendor/bin/pest Modules/Meetup/tests/Unit

# Feature tests
./vendor/bin/pest Modules/Meetup/tests/Feature

# Browser tests
./vendor/bin/pest Modules/Meetup/tests/Browser
```

### Test Coverage
- ✅ Models e Relationships
- ✅ Actions e Business Logic
- ✅ Folio Pages e Routes
- ✅ Volt Components
- ✅ Filament Resources
- ✅ Integration tra moduli

---

## Deployment

### Production Checklist
- [ ] Compilazione assets: `npm run build`
- [ ] Cache optimization: `php artisan optimize`
- [ ] View cache: `php artisan view:cache`
- [ ] Route cache: `php artisan route:cache`
- [ ] Config cache: `php artisan config:cache`
- [ ] Database migrations: `php artisan migrate`

### Environment Variables
```env
# Meetup Specific
MEETUP_EVENTS_PER_PAGE=12
MEETUP_MAX_ATTENDEES=50
MEETUP_NOTIFICATION_EMAIL=true

# Filament Admin
FILAMENT_PATH=admin
```

---

## Contributing

### Code Standards
- **PSR-12** coding standards
- **PHPStan** level 10 compliance
- **Test coverage** > 80%
- **Documentation** per tutte le feature

### Git Workflow
1. Feature branches da `develop`
2. Code review obbligatoria
3. Testing prima del merge
4. Semantic versioning

---

## Support e Community

### Risorse
- [Documentazione Laravel](https://laravel.com/docs)
- [Folio Documentation](https://laravel.com/docs/folio)
- [Volt Documentation](https://laravel.com/docs/livewire/volt)
- [Filament Documentation](https://filamentphp.com/docs)

### Community
- Join Laravel Pizza Meetups community
- Discord channel per sviluppatori
- GitHub issues per bug reports
- Feature requests via GitHub discussions

---

## Licenza

MIT License - Vedere [LICENSE](../LICENSE) file per dettagli.

---

**Versione**: 1.0
**Ultimo Aggiornamento**: 2025-11-29
**Stato**: ✅ Pronto per Implementazione

**Sviluppato con ❤️ per la Community Laravel** 🍕