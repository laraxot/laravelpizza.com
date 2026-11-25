# ⚠️ REGOLA CRITICA: Filament Widgets, NON Livewire Diretto

## 🎯 Principio Fondamentale

**NEL PROGETTO NON USIAMO LIVEWIRE DIRETTAMENTE - USIAMO SOLO WIDGET FILAMENT!**

Questa è una regola **ASSOLUTA** e **CRITICA** che deve essere sempre rispettata.

## ❌ VIETATO ASSOLUTO

### 1. Componenti Livewire Puri

```php
// ❌ MAI creare componenti Livewire puri
namespace Modules\Meetup\Http\Livewire;

use Livewire\Component;

class EventDetail extends Component
{
    // ❌ VIETATO!
}
```

### 2. Volt per Componenti Complessi

```blade
{{-- ❌ NON usare Volt per form complessi o interattività server-side --}}
@volt('events.detail')
<form wire:submit="save">
    {{-- ❌ VIETATO per form complessi! --}}
</form>
@endvolt
```

### 3. Livewire Diretto nelle View

```blade
{{-- ❌ NON usare Livewire direttamente --}}
@livewire('events.detail')
<livewire:events.detail />
```

## ✅ OBBLIGATORIO

### 1. Filament Widgets per Interattività

**Per QUALSIASI componente dinamico che richiede interazione server-side:**

```php
// ✅ CORRETTO: Creare Filament Widget
namespace Modules\Meetup\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

class EventDetailWidget extends XotBaseWidget
{
    protected static string $view = 'meetup::filament.widgets.event-detail';
    
    // Logica del widget qui
}
```

### 2. Utilizzo Widget nelle View

```blade
{{-- ✅ CORRETTO: Usare Filament Widget --}}
@livewire(\Modules\Meetup\Filament\Widgets\EventDetailWidget::class)

{{-- Oppure con componente Blade --}}
<x-filament-widgets::widget :widget="\Modules\Meetup\Filament\Widgets\EventDetailWidget::class" />
```

### 3. Helper Class per Logica Statica

**Per componenti Blade statici che hanno solo bisogno di organizzare codice:**

```php
// ✅ CORRETTO: Helper Class PHP per organizzazione codice
class EventDetailHelper
{
    public function getEventData(): array
    {
        // Logica di trasformazione dati
    }
}
```

## 📋 Quando Usare Cosa

### ✅ Filament Widgets

Usa Filament Widgets per:
- ✅ Form con validazione server-side
- ✅ Componenti che richiedono interazione server
- ✅ Dropdown dinamici con dati dal database
- ✅ Modali con form
- ✅ Componenti che gestiscono stato
- ✅ Componenti che fanno chiamate AJAX

**Esempi:**
- Login/Register forms → `LoginWidget`, `RegisterWidget`
- Event registration → `EventRegistrationWidget`
- User dropdown → `UserDropdownWidget`
- Search components → `SearchWidget`

### ✅ Helper Class PHP

Usa Helper Class per:
- ✅ Trasformazione dati per rendering
- ✅ Calcoli e logica di business
- ✅ Preparazione dati per view
- ✅ Organizzazione codice complesso

**Esempi:**
- `EventDetailHelper` → Trasforma Event model in array per rendering
- `EventStatsHelper` → Calcola statistiche eventi
- `EventFormatterHelper` → Formatta date, location, ecc.

### ⚠️ Volt (SOLO per UI Semplice)

Volt può essere usato SOLO per:
- ⚠️ Pagine Folio con logica UI semplice
- ⚠️ Componenti di navigazione
- ⚠️ Pagine statiche con logica minima
- ⚠️ Componenti senza form complessi

**NON usare Volt per:**
- ❌ Form di autenticazione (usa Filament Widgets)
- ❌ Form complessi (usa Filament Widgets)
- ❌ Componenti con validazione server-side (usa Filament Widgets)

## 🏗️ Struttura Corretta

### Filament Widget

```
Modules/Meetup/app/Filament/Widgets/
├── EventDetailWidget.php          ✅ Widget per dettaglio evento interattivo
├── EventRegistrationWidget.php     ✅ Widget per registrazione evento
└── EventSearchWidget.php           ✅ Widget per ricerca eventi
```

### Helper Class

```
Themes/Meetup/resources/views/components/blocks/events/
└── detail.blade.php                ✅ View con EventDetailHelper per logica statica
```

## 🔄 Esempio: Event Detail Component

### ❌ SBAGLIATO: Livewire Component

```php
// ❌ NON FARE MAI QUESTO
namespace Modules\Meetup\Http\Livewire;

use Livewire\Component;

class EventDetail extends Component
{
    public function render()
    {
        return view('livewire.event-detail');
    }
}
```

### ✅ CORRETTO: Filament Widget (se serve interattività)

```php
// ✅ CORRETTO: Filament Widget
namespace Modules\Meetup\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

class EventDetailWidget extends XotBaseWidget
{
    protected static string $view = 'meetup::filament.widgets.event-detail';
    
    public ?Event $event = null;
    
    public function mount(?Event $event = null): void
    {
        $this->event = $event;
    }
}
```

### ✅ CORRETTO: Helper Class (per logica statica)

```php
// ✅ CORRETTO: Helper Class per organizzazione codice
class EventDetailHelper
{
    public function getEventData(): array
    {
        // Trasforma Event model in array per rendering
    }
}
```

```blade
{{-- View Blade con Helper Class --}}
<?php
$helper = new EventDetailHelper(event: $event);
$eventData = $helper->getEventData();
?>

<div>
    <h1>{{ $eventData['title'] }}</h1>
    {{-- Rendering statico --}}
</div>
```

## 🎯 Regola d'Oro

**Se hai bisogno di interattività server-side → Filament Widget**
**Se hai solo bisogno di organizzare codice → Helper Class PHP**
**Se hai bisogno di UI semplice in Folio → Volt (con cautela)**

## 🔗 Riferimenti

- [Filament Widgets Frontend](../modules/ui/docs/filament-widgets-frontend.md)
- [Livewire to Filament Widget Migration](../modules/user/docs/livewire-to-filament-widget-migration.md)
- [Auth Widget Rules](../../../Modules/User/docs/auth-widget-rules-2.md)
- [Folio Filament Widgets Integration](folio-filament-widgets-integration.md)
- [AGENTS.md](../../agents.md) - Sezione "CRITICAL RULE: Always Use Filament Widgets"
