# ⚠️ REGOLA CRITICA: NO `declare(strict_types=1);` nei File Blade

## 🎯 Principio Fondamentale

**NEI FILE BLADE NON SI USA MAI `declare(strict_types=1);`!**

Questa è una regola **CRITICA** che deve essere sempre rispettata.

## ❌ VIETATO ASSOLUTO

### Errore Comune

```blade
{{-- Commenti Blade --}}
@php
declare(strict_types=1); // ❌ VIETATO! Causa errore fatale
use Modules\Meetup\Models\Event;
@endphp
```

**Errore che si verifica:**
```
FatalError: strict_types declaration must be the very first statement in the script
```

## 🔍 Perché è Vietato?

### 1. Blade Processa Prima i Commenti

Quando Laravel compila un file Blade:
1. Prima processa i commenti Blade (`{{-- ... --}}`)
2. Poi processa i blocchi `@php`
3. Il `declare(strict_types=1);` deve essere la **prima istruzione PHP** nel file compilato
4. Ma i commenti Blade vengono convertiti in output HTML prima del blocco PHP

### 2. Struttura File Compilato

Quando Blade compila il file, la struttura diventa:

```php
<?php echo $__env->make('layouts.app', ...)->render(); ?>
{{-- Commenti Blade --}}  // ← Questo diventa output HTML
<?php
declare(strict_types=1); // ❌ ERRORE! Non è la prima istruzione PHP
```

## ✅ CORRETTO

### Opzione 1: Nessun `declare(strict_types=1);` nel Blade

```blade
{{-- Commenti Blade --}}
@php
// ✅ CORRETTO: Nessun declare(strict_types=1);
use Modules\Meetup\Models\Event;
use Illuminate\Support\Carbon;

$eventModel = Event::where('slug', $slug0)->first();
@endphp
```

### Opzione 2: Helper Class in File PHP Separato

Se hai bisogno di `strict_types=1;`, sposta la classe in un file PHP separato:

**File**: `app/Helpers/EventDetailHelper.php`
```php
<?php
declare(strict_types=1); // ✅ CORRETTO: Prima istruzione nel file PHP

namespace App\Helpers;

use Modules\Meetup\Models\Event;

class EventDetailHelper
{
    public function __construct(
        public ?Event $event = null,
        public ?string $slug0 = null,
    ) {}
    
    public function getEventModel(): ?Event
    {
        // Logica qui
    }
}
```

**File Blade**: `components/blocks/events/detail.blade.php`
```blade
@php
use App\Helpers\EventDetailHelper;

$helper = new EventDetailHelper(event: $event, slug0: $slug0);
$eventData = $helper->getEventData();
@endphp
```

## 📋 Regole per File Blade

### ✅ Consentito

- ✅ Blocchi `@php` senza `declare(strict_types=1);`
- ✅ `use` statements per importare classi
- ✅ Logica PHP semplice
- ✅ Variabili e calcoli
- ✅ Helper classes istanziate (senza `declare` nel Blade)

### ❌ Vietato

- ❌ `declare(strict_types=1);` in file Blade
- ❌ Classi PHP complesse definite inline nel Blade
- ❌ Namespace declarations nel Blade (usare file PHP separati)

## 🔄 Best Practice

### Per Logica Complessa

**Sposta la logica in file PHP separati:**

1. **Helper Class** → `app/Helpers/EventDetailHelper.php` (con `declare(strict_types=1);`)
2. **Service Class** → `app/Services/EventService.php` (con `declare(strict_types=1);`)
3. **Action Class** → `app/Actions/CreateEventAction.php` (con `declare(strict_types=1);`)

**Nel Blade:**
```blade
@php
use App\Helpers\EventDetailHelper;

$helper = new EventDetailHelper(...);
$data = $helper->getData();
@endphp
```

### Per Logica Semplice

**Mantieni la logica nel Blade senza `declare(strict_types=1);`:**

```blade
@php
use Modules\Meetup\Models\Event;

$eventModel = Event::where('slug', $slug0)->first();
$eventData = [
    'title' => $eventModel->title,
    'date' => $eventModel->start_date->format('Y-m-d'),
];
@endphp
```

## 🔗 Riferimenti

- [Filament Widgets NOT Livewire Critical Rule](filament-widgets-not-livewire-critical-rule.md)
- [Events Detail Helper Class Pattern](events-detail-volt-class-pattern.md)
- [PHP declare() Documentation](https://www.php.net/manual/en/control-structures.declare.php)
