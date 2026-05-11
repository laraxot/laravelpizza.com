# AddressInput Component — Filament Field con Geolocalizzazione

**Status**: ✅ Production
**Class**: `Modules\Geo\Filament\Forms\Components\AddressInput`
**View**: `resources/views/filament/forms/components/address-input.blade.php`
**Base Class**: `Filament\Forms\Components\Field`
**Version**: 1.0.0

---

## Cos'è

`AddressInput` è un **campo Filament nativo** che fornisce un input per indirizzo con:
- Pulsante "Usa la mia posizione" con geolocalizzazione browser
- **Reverse geocoding** via Nominatim (OpenStreetMap) — gratuito, senza API key
- Integrazione completa con il sistema di form di Filament (validazione, errori, stato Livewire)
- Styling Design Comuni (cmp-card, form-group, link-wrapper)

## Filosofia — Perché vive in Geo

> "La geolocalizzazione appartiene al dominio Geo. Chiunque abbia bisogno di un indirizzo geolocalizzato, chieda a Geo."

### Dependency Direction (DDD Modular Monolith)

```
┌──────────────────────────────────────┐
│       Geo Module (Generic)           │
│                                      │
│  Ubiquitous Language:                │
│  "address", "coordinates",           │
│  "geocode", "location", "bounds"     │
│                                      │
│  ┌────────────────────────────┐      │
│  │ AddressInput (Field)        │      │
│  │ - Geolocation button        │      │
│  │ - Reverse geocoding         │      │
│  │ - Nominatim integration     │      │
│  │ - Filament state binding    │      │
│  └────────────────────────────┘      │
└──────────────────────────────────────┘
         ↑ consumed by ↑
┌──────────────────────────────────────┐
│    Fixcity Module (Core Domain)       │
│                                      │
│  Ubiquitous Language:                │
│  "ticket", "segnalazione",            │
│  "issue", "resolution", "status"     │
│                                      │
│  ┌────────────────────────────┐      │
│  │ CreateTicketWizardWidget    │      │
│  │ AddressInput::make('addr')  │ ← CONSUMES
│  └────────────────────────────┘      │
└──────────────────────────────────────┘
```

### La Regola

| Principio | Se in Fixcity | Se in Geo |
|---|---|---|
| **SRP** | Fixcity cambia quando cambia Nominatim ❌ | Solo Geo cambia ✅ |
| **DRY** | Ogni modulo reinventa | Uno per tutti ✅ |
| **Riutilizzo** | Logica intrappolata | `use Modules\Geo\...` ✅ |
| **Testabilità** | Fixcity testa geocoding | Geo testa geo, Fixcity testa ticket ✅ |
| **Evoluzione** | Fixcity gonfio | Geo evolve indipendente ✅ |

### La Religione

```
Fixcity → Geo    ✅ Fixcity dipende da Geo (specifico → generico)
Geo → Fixcity    ❌ Geo NON deve mai dipendere da Fixcity
Geo → Xot        ✅ Geo dipende da Xot (generico → base classes)
```

### Lo Zen

> "Un campo indirizzo è un campo geografico. Non esistono 'campi indirizzo di Fixcity'. Esiste UN campo indirizzo, fornito da Geo, usato da tutti."

---

## Utilizzo

### Import e Uso Base

```php
use Modules\Geo\Filament\Forms\Components\AddressInput;

// In un Filament form schema:
AddressInput::make('address')
    ->label('Indirizzo')
    ->placeholder('Inserisci l\'indirizzo')
    ->required();
```

### In un Wizard

```php
use Modules\Geo\Filament\Forms\Components\AddressInput;
use Filament\Schemas\Components\Wizard\Step;

Step::make('data')
    ->label('Dati')
    ->schema([
        AddressInput::make('address')
            ->spritePath('/themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg'),
        // ... altri campi
    ]);
```

### In un Resource

```php
use Modules\Geo\Filament\Forms\Components\AddressInput;

public static function form(Form $form): Form
{
    return $form->schema([
        AddressInput::make('address')
            ->label(__('geo::address.fields.address.label'))
            ->placeholder(__('geo::address.fields.address.placeholder'))
            ->required()
            ->maxLength(255),
    ]);
}
```

### Configurazione Avanzata

```php
AddressInput::make('location')
    ->label('Luogo')
    ->placeholder('Cerca un luogo...')
    ->required()
    ->maxLength(500)
    ->helperText('Inserisci l\'indirizzo completo')
    ->spritePath('/path/to/custom/sprites.svg')
    ->columnSpanFull();
```

---

## API del Componente

### Proprietà

| Proprietà | Tipo | Default | Descrizione |
|---|---|---|---|
| `$view` | `string` | `'geo::filament.forms.components.address-input'` | Vista Blade del componente |
| `$spritePath` | `string` | `'/themes/Sixteen/.../sprites.svg'` | Path allo sprite SVG per l'icona |

### Metodi Fluent

| Metodo | Parametri | Return | Descrizione |
|---|---|---|---|
| `spritePath(string $path)` | Path allo sprite | `static` | Configura il path dello sprite SVG |
| `getSpritePath()` | — | `string` | Restituisce il path corrente dello sprite |

### Ereditarietà

Estende `Filament\Forms\Components\Field`, quindi eredita TUTTI i metodi standard:
- `label()`, `placeholder()`, `required()`, `maxLength()`, `helperText()`
- `default()`, `disabled()`, `hidden()`, `visible()`
- `afterStateHydrated()`, `afterStateUpdated()`, `dehydrated()`
- `rules()`, `regex()`, `email()`, `tel()`, etc.
- `columnSpan()`, `columnSpanFull()`, `columns()`

---

## Traduzioni

Namespace: `geo::address.*`

### Chiavi Disponibili

| Chiave | Italiano | English |
|---|---|---------|
| `fields.address.label` | Luogo del disservizio | Issue location |
| `fields.address.placeholder` | Inserisci il luogo del disservizio | Enter the issue location |
| `fields.use_my_location.label` | Usa la tua posizione | Use my location |
| `geolocation.not_supported` | Geolocalizzazione non supportata dal browser. | Geolocation is not supported by your browser. |
| `geolocation.address_not_found` | Indirizzo non trovato. | Address not found. |
| `geolocation.error` | Errore durante la geolocalizzazione. | Error during geolocation. |
| `geolocation.permission_denied` | Permesso di geolocalizzazione negato. | Geolocation permission denied. |
| `geolocation.locating` | Rilevamento posizione in corso... | Detecting your location... |
| `geolocation.timeout` | Timeout durante il rilevamento della posizione. | Location detection timed out. |
| `geolocation.unavailable` | Posizione non disponibile al momento. | Location is currently unavailable. |

### File

- `lang/it/address.php` — Italiano
- `lang/en/address.php` — English
- `lang/de/address.php` — Deutsch

---

## Architettura Tecnica

### Come Funziona

```
1. Utente compila wizard/form
2. AddressInput::make('address') → crea campo Filament
3. Filament renderizza la view nel contesto Livewire
4. Utente clicca "Usa la mia posizione"
5. navigator.geolocation.getCurrentPosition() → ottiene lat/lng
6. fetch() → Nominatim API → reverse geocoding
7. @this.set('address', data.display_name) → aggiorna stato Livewire
8. Filament deidrata lo stato → form submission
```

### Stato di caricamento (spinner)

Durante `getCurrentPosition()` + reverse geocoding, il componente mostra feedback esplicito:

- `loading=true` appena parte il click
- spinner + testo localizzato `geo::address.geolocation.locating`
- bottone temporaneamente disabilitato (`aria-busy`, `aria-disabled`)
- `loading=false` sempre in uscita (successo o errore)

### Perché `@this` Funziona Qui (e non con Blade::render)

Quando `AddressInput` è usato in un form schema Filament:
- La view è renderizzata **dentro** il contesto del componente Livewire
- `@this` risolve correttamente all'istanza del Livewire component
- Lo stato è gestito da Filament tramite `wire:model` e `@this.set()`

**ANTI-PATTERN** (il bug originale):
```php
// ❌ SBAGLIATO — Blade::render() crea un contesto ISOLATO
Placeholder::make('address_section')
    ->content(new HtmlString(
        \Blade::render('geo::filament.components.address-field', [...])
    ));
// @this → $_instance → UNDEFINED!
```

**PATTERN CORRETTO**:
```php
// ✅ CORRETTO — Filament renderizza nel contesto Livewire
AddressInput::make('address')
    ->spritePath('/themes/.../sprites.svg');
// @this → istanza Livewire → FUNZIONA!
```

### Reverse Geocoding

```
User click "Use My Location"
        ↓
navigator.geolocation.getCurrentPosition()
        ↓
lat/lng dal browser
        ↓
fetch → Nominatim API (OpenStreetMap)
  GET https://nominatim.openstreetmap.org/reverse
    ?format=json
    &lat=45.4642
    &lon=9.1900
    &accept-language=it
        ↓
{ "display_name": "Via Roma 1, Milano, Italia" }
        ↓
@this.set('address', display_name)
        ↓
Filament aggiorna il campo e lo stato del form
```

### Nominatim (OpenStreetMap)

- **Gratuito**, nessun API key richiesto
- Supporto multilingua (`accept-language`)
- Rate limit: 1 request/second (Usage Policy)
- Alternative nel Geo module: Google Maps, Mapbox, HERE, LocationIQ, OpenCage, Photon, Bing

---

## Componenti Correlati nel Geo Module

| Componente | Tipo | Scopo | Differenza da AddressInput |
|---|---|---|---|
| **AddressInput** | `Field` | Singolo indirizzo + geolocalizzazione | ✅ Questo componente |
| **AddressField** | `Section` | Multi-campo (route, locality, province, CAP) | Per indirizzi strutturati completi |
| **AddressSection** | `XotBaseSection` | Tutti i campi enum (phone, email, fax, lat, lng) | Per contatti completi |
| **AddressesField** | `Repeater` | Multi-indirizzi con primary esclusivo | Per entità con più indirizzi |
| **AddressColumn** | `ViewColumn` | Colonna tabella per indirizzi | Per list views |

### Quando Usare Quale

| Scenario | Componente |
|---|---|
| "Dove è successo?" (singolo indirizzo testuale) | `AddressInput` |
| "Qual è l'indirizzo completo?" (via, città, provincia, CAP) | `AddressField` |
| "Tutti i contatti" (telefono, email, PEC, indirizzo, lat/lng) | `AddressSection` |
| "Quali sono le sedi?" (più indirizzi con tipo) | `AddressesField` |
| "Mostra indirizzo in tabella" | `AddressColumn` |

---

## Moduli Che Lo Usano

| Modulo | Widget/Resource | Scopo |
|---|---|---|
| **Fixcity** | `CreateTicketWizardWidget` | Indirizzo per segnalazione cittadina |

---

## File Structure

```
Modules/Geo/
├── app/Filament/Forms/Components/
│   └── AddressInput.php                    ← Classe PHP (Field)
├── resources/views/filament/forms/components/
│   └── address-input.blade.php             ← Vista Blade
├── lang/
│   ├── it/address.php                      ← Italiano
│   ├── en/address.php                      ← English
│   └── de/address.php                      ← Deutsch
└── docs/
    └── address-input-component.md          ← Questa documentazione
```

---

## Anti-Patterns — Cosa NON Fare

### ❌ NON copiare in un altro modulo

```
Modules/Fixcity/resources/views/filament/widgets/components/address-field.blade.php
↑ Questo file NON deve esistere. Usa geo::filament.forms.components.address-input
```

### ❌ NON usare Blade::render()

```php
// ❌ SBAGLIATO — bypassa il sistema form di Filament
Placeholder::make('address_section')
    ->content(new HtmlString(
        \Blade::render('geo::filament.components.address-field', [...])
    ));

// ✅ CORRETTO — usa il componente Filament nativo
AddressInput::make('address')
    ->spritePath('/themes/.../sprites.svg');
```

### ❌ NON duplicare la logica di geolocalizzazione

```php
// ❌ SBAGLIATO — Fixcity sa di Nominatim
function useMyLocation() {
    fetch('https://nominatim.openstreetmap.org/reverse?...')
}

// ✅ CORRETTO — Fixcity consuma, Geo fornisce
AddressInput::make('address');  // Geo gestisce tutto
```

---

## Riferimenti

- **Storia BMad 1-10**: `.planning/stories/1-10-extract-address-input-to-geo-module.md`
- **Storia BMad 2-1**: `.planning/stories/2-1-geo-module-address-input.md`
- **Module Boundary Philosophy**: `../../Fixcity/docs/MODULE-BOUNDARY-PHILOSOPHY.md`
- **Geo Philosophy**: `./philosophy.md`
- **Geo Index**: `./00-index.md`
- **Components Index**: `./components/INDEX.md`
- **CreateTicketWizardWidget**: `../../Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- **Filament v5 Fields**: https://filamentphp.com/docs/5.x/forms/fields
- **DDD Bounded Contexts**: https://martinfowler.com/bliki/BoundedContext.html
