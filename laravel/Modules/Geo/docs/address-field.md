# Address Field Component — Geolocalizzazione con Reverse Geocoding

**Status**: ✅ Production
**View Path**: `resources/views/filament/components/address-field.blade.php`
**Namespace**: `geo::filament.components.address-field`

## Cos'è

Un componente Blade riutilizzabile che fornisce:
- Input field per indirizzo con `wire:model.live="data.address"`
- Pulsante "Usa la mia posizione" con geolocalizzazione browser
- **Reverse geocoding** via Nominatim (OpenStreetMap) — gratuito, senza API key
- Integrazione Livewire per aggiornare lo stato del componente padre

## Filosofia

> "La geolocalizzazione appartiene al dominio Geo. Chiunque abbia bisogno di un indirizzo geolocalizzato, chieda a Geo."

Questo componente è **cross-cutting**: qualsiasi modulo può usarlo senza accoppiarsi a un dominio specifico.

## Busy Feedback Rule

- `Usa la tua posizione` è una azione asincrona con permessi browser + rete.
- Il componente deve quindi mostrare uno stato busy visibile e accessibile durante:
  - richiesta geolocalizzazione
  - eventuale reverse geocoding
- Lo stato busy appartiene a Geo, non ai moduli consumatori.
- Fixcity o altri moduli non devono duplicare spinner o JS per questo flusso.
- Testo e stato runtime devono arrivare da chiavi `geo::address.*`, non da stringhe hardcoded.

### Dependency Direction

```
Fixcity → Geo    ✅ Fixcity dipende da Geo (dominio specifico → dominio generico)
Geo → Fixcity    ❌ Geo NON deve mai dipendere da Fixcity
Geo → Xot        ✅ Geo dipende da Xot (dominio generico → base classes)
```

## Utilizzo

### In un Filament Widget/Resource

```php
use Filament\Forms\Components\Placeholder;
use Illuminate\Support\HtmlString;

protected function getAddressComponent(): Component
{
    return Placeholder::make('address_section')
        ->label('')
        ->content(new HtmlString(
            \Blade::render('geo::filament.components.address-field', [
                'sprite' => '/themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg',
            ])
        ));
}
```

### Nel Form Schema

```php
public function getFormSchema(): array
{
    return [
        Wizard::make([
            $this->makeStepPrivacy(),
            $this->makeStepData(), // ← qui si usa getAddressComponent()
            $this->makeStepSummary(),
        ]),
    ];
}
```

## Traduzioni

Le chiavi sono nel namespace `geo::address.*`:

### Italiano (`lang/it/address.php`)

```php
return [
    'fields' => [
        'address' => [
            'label' => 'Luogo del disservizio',
            'placeholder' => 'Inserisci il luogo del disservizio',
        ],
        'use_my_location' => [
            'label' => 'Usa la tua posizione',
        ],
    ],
    'geolocation' => [
        'not_supported' => 'Geolocalizzazione non supportata dal browser.',
        'address_not_found' => 'Indirizzo non trovato.',
        'error' => 'Errore durante la geolocalizzazione.',
        'permission_denied' => 'Permesso di geolocalizzazione negato.',
    ],
];
```

### English (`lang/en/address.php`)

```php
return [
    'fields' => [
        'address' => [
            'label' => 'Issue location',
            'placeholder' => 'Enter the issue location',
        ],
        'use_my_location' => [
            'label' => 'Use my location',
        ],
    ],
    'geolocation' => [
        'not_supported' => 'Geolocation is not supported by your browser.',
        'address_not_found' => 'Address not found.',
        'error' => 'Error during geolocation.',
        'permission_denied' => 'Geolocation permission denied.',
    ],
];
```

## Architettura Tecnica

### Livewire State Update

Il componente aggiorna lo stato del widget padre usando `window.Livewire` (non `@this`):

```javascript
const component = window.Livewire?.components?.components()?.find(c =>
    c.el.closest('.fi-sch-step') !== null || c.el.querySelector('#wizard-address') !== null
);
if (component) {
    component.set('data.address', data.display_name);
}
```

**Perché non `@this`**: Il componente viene renderizzato tramite `Blade::render()` fuori dal contesto Livewire del widget padre, quindi `@this` (che compila a `$_instance`) sarebbe undefined.

### Reverse Geocoding

```
Utente clicca "Usa la mia posizione"
    ↓
navigator.geolocation.getCurrentPosition()
    ↓
lat/lng ottenuti dal browser
    ↓
fetch() → Nominatim API (OpenStreetMap)
    ↓
display_name → aggiorna wire:model="data.address"
```

### Nominatim (OpenStreetMap)

- **Gratuito**, nessun API key richiesto
- Supporto multilingua tramite `accept-language` parameter
- Rate limit: 1 request/second (rispettato da Usage Policy)
- Alternative: Google Geocoding, Mapbox, LocationIQ (configurati in Geo Actions)

## Componenti Correlati

| Componente | Path | Scopo |
|------------|------|-------|
| `address-field.blade.php` | `views/filament/components/` | Input indirizzo + geolocalizzazione |
| `google-address-lookup.blade.php` | `views/components/` | Autocomplete con Google Places |
| `AddressSection.php` | `app/Filament/Forms/Components/` | Sezione Filament per indirizzo strutturato |
| `AddressesField.php` | `app/Filament/Forms/Components/` | Campo multiplo indirizzi |
| `AddressColumn.php` | `app/Filament/Tables/Columns/` | Colonna tabella per indirizzi |

## Moduli Che Lo Usano

| Modulo | Widget | Scopo |
|--------|--------|-------|
| **Fixcity** | `CreateTicketWizardWidget` | Indirizzo per segnalazione |
| *(altri moduli possono usarlo)* | | |

## Regola Architetturale

> **MAI** copiare questo componente in un altro modulo.
> **SEMPRE** usare `geo::filament.components.address-field`.
>
> Vedi: [`MODULE-BOUNDARY-PHILOSOPHY.md`](../../Fixcity/docs/MODULE-BOUNDARY-PHILOSOPHY.md)
