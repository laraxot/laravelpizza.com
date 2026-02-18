# ⚠️ REGOLA CRITICA: Filament Widgets, NON Livewire Diretto

## 🎯 Principio Fondamentale

**NEL PROGETTO NON USIAMO LIVEWIRE DIRETTAMENTE - USIAMO SOLO WIDGET FILAMENT!**

Questa è una regola **ASSOLUTA** e **CRITICA** che deve essere sempre rispettata.

Vedi anche: [Themes/Meetup/docs/filament-widgets-not-livewire-critical-rule.md](../../Themes/Meetup/docs/filament-widgets-not-livewire-critical-rule.md)

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
```

## 🔗 Riferimenti

- [Filament Widgets NOT Livewire Critical Rule](../../Themes/Meetup/docs/filament-widgets-not-livewire-critical-rule.md)
- [Livewire to Filament Widget Migration](../User/docs/livewire-to-filament-widget-migration.md)
- [Auth Widget Rules](../User/docs/auth-widget-rules.md)
- [AGENTS.md](../../../AGENTS.md) - Sezione "CRITICAL RULE: Always Use Filament Widgets"
