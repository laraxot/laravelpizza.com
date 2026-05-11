# Location Spinner UX Pattern

## Overview

The AddressInput component provides **immediate visual feedback** when the user clicks "Use your position" by showing a spinner icon. This prevents the "did it work?" uncertainty that leads to double-clicks, frustration, and poor UX.

---

## Philosophy

### The Problem (Before)

1. User clicks "Use your position"
2. Browser asks for permission → user grants
3. GPS takes 2-5 seconds to resolve
4. Reverse geocoding takes 1-3 seconds
5. **Total: 3-8 seconds of nothing happening**
6. User thinks it's broken → clicks again → double request → bad UX

### The Solution (After)

1. User clicks "Use your position"
2. **Spinner appears IMMEDIATELY** (0ms delay)
3. User sees "it's working" → waits patiently
4. GPS resolves → address fills in
5. **Spinner disappears** → task complete

### Zen Principle

> **"Never leave the user wondering."**
> 
> Every async action MUST show a loading state.
> If the user can't tell whether the system is working, the UX is broken.

---

## Technical Implementation

### Architecture

```
Alpine v3 Component (x-data)
    ↓
x-on:click → getLocation()
    ↓
loading = true (spinner appears via x-if)
    ↓
navigator.geolocation.getCurrentPosition()
    ↓
fetch() → reverse geocoding
    ↓
livewire.set() → update address field
    ↓
finally { loading = false } (spinner disappears)
```

### Key Files

| File | Purpose |
|------|---------|
| `Modules/Geo/resources/views/filament/forms/components/address-input.blade.php` | Main view with Alpine component |
| `Modules/Geo/app/Filament/Forms/Components/AddressInput.php` | PHP Filament component |
| `Modules/Geo/lang/{it,en}/address.php` | Translation keys for errors |

### Alpine v3 Pattern

```blade
<a
    x-data="{ loading: false, _lw: null, _path: '{{ $statePath }}' }"
    x-init="_lw = @this"
    x-on:click.prevent="getLocation(_lw, _path)"
    :class="{ 'opacity-50 pointer-events-none': loading }"
>
    <template x-if="loading">
        <!-- Spinner SVG -->
    </template>
    <template x-if="!loading">
        <!-- Normal icon -->
    </template>
</a>
```

### Why This Pattern?

1. **`x-data` inline object**: Alpine v3 component pattern, not global function
2. **`x-init` captures `@this`**: `@this` is a Blade directive that resolves to the current Livewire component instance. Must be captured in `x-init` because it's only available in Blade template scope.
3. **`getLocation(_lw, _path)`**: Pass Livewire reference and state path as parameters
4. **`:class` binding**: Disables button during loading to prevent double-clicks
5. **`finally { loading = false }`**: **Always** resets loading state, even on error

---

## Spinner Design

### SVG Structure

```html
<svg class="icon icon-sm icon-primary mb-1 animate-spin">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
```

### Classes Explained

| Class | Purpose |
|-------|---------|
| `icon icon-sm` | Bootstrap Italia icon sizing (small) |
| `icon-primary` | Primary color (blue) |
| `mb-1` | Margin bottom for spacing |
| `animate-spin` | **Tailwind** CSS animation (compositor-only, GPU-accelerated) |

### Design Comuni Compliance

- Uses Bootstrap Italia `icon-*` classes for sizing
- Uses Tailwind `animate-spin` for animation (not custom CSS)
- SVG structure matches Design Comuni icon patterns
- Color uses `icon-primary` (theme-aware)

---

## Error Handling

### Error Types

| Error Code | Message (IT) | Message (EN) |
|------------|--------------|--------------|
| `PERMISSION_DENIED` | "Permesso di geolocalizzazione negato." | "Geolocation permission denied." |
| `TIMEOUT` | "Timeout durante il rilevamento della posizione." | "Location detection timed out." |
| `POSITION_UNAVAILABLE` | "Posizione non disponibile al momento." | "Location is currently unavailable." |
| Not supported | "Geolocalizzazione non supportata dal browser." | "Geolocation is not supported by your browser." |
| Address not found | "Indirizzo non trovato." | "Address not found." |
| Network error | "Errore durante la geolocalizzazione." | "Error during geolocation." |

### Translation Keys

All error messages use the `geo::address.geolocation.*` namespace:

```php
// Modules/Geo/lang/it/address.php
'geolocation' => [
    'not_supported' => 'Geolocalizzazione non supportata dal browser.',
    'address_not_found' => 'Indirizzo non trovato.',
    'error' => 'Errore durante la geolocalizzazione.',
    'permission_denied' => 'Permesso di geolocalizzazione negato.',
    'timeout' => 'Timeout durante il rilevamento della posizione.',
    'unavailable' => 'Posizione non disponibile al momento.',
],
```

---

## Configuration

### Geolocation Options

```javascript
{
    enableHighAccuracy: true,  // Use GPS if available
    timeout: 20000,            // 20 seconds max wait
    maximumAge: 0              // Don't use cached position
}
```

| Option | Value | Reason |
|--------|-------|--------|
| `enableHighAccuracy` | `true` | Best precision for address lookup |
| `timeout` | `20000` | 20s max (prevents infinite wait) |
| `maximumAge` | `0` | Always get fresh position |

---

## Testing

### Manual Test Flow

1. Go to `/it/tests/segnalazione-crea`
2. Complete step 1 (privacy acceptance)
3. Go to step 2 (ticket data form)
4. Find the "Luogo" (address) field
5. Click "Usa la tua posizione"

### Expected Behavior

| Step | What Should Happen |
|------|-------------------|
| Click | Spinner appears **immediately** |
| Browser prompt | User grants/denies permission |
| Grant | Spinner stays visible during GPS fix |
| GPS fix | Spinner stays visible during reverse geocoding |
| Success | Address field fills with location, spinner disappears |
| Deny | Alert shows, spinner disappears |
| Timeout | Timeout alert shows, spinner disappears |

### Pass/Fail Criteria

- **PASS**: Spinner appears within 100ms of click
- **PASS**: Spinner stays visible until result (success or error)
- **PASS**: Spinner disappears after result
- **PASS**: Button is disabled during loading (`pointer-events-none`)
- **FAIL**: Button clickable during loading (double-click possible)
- **FAIL**: Spinner never appears
- **FAIL**: Spinner stays visible after result

---

## Related Patterns

### Other Loading States in Ticket Wizard

| Component | Loading Pattern | File |
|-----------|-----------------|------|
| Submit button | `wire:loading.attr="disabled"` | Fixcity ticket-create-wizard view |
| Form fields | `opacity-50 pointer-events-none` | This file |
| Wizard navigation | Filament Wizard built-in state management | XotBaseWizardWidget |

### Sixteen Theme Spinner Components

The theme provides reusable spinner components:

- `Themes/Sixteen/resources/views/components/feedback/spinner.blade.php` (Bootstrap Italia)
- `Themes/Sixteen/resources/views/components/blocks/feedback/spinner.blade.php` (Tailwind)

For consistency, **prefer** these components in new Blade views. The AddressInput uses inline SVG because it's a micro-interaction (icon replacement), not a full-page loading state.

---

## History

| Date | Change | Reason |
|------|--------|--------|
| 2026-04-14 | Initial implementation with spinner UX | User feedback: "non capisci se sta facendo qualcosa" |
| 2026-04-14 | Alpine v3 compatible pattern | `el.__x.$data` is v2 API, unreliable in v3 |
| 2026-04-14 | Added specific error messages | Generic "error" message unhelpful for users |
| 2026-04-14 | Increased timeout to 20s | 10s too short for indoor GPS acquisition |

---

## See Also

- [Design Comuni Components](../../../Themes/Sixteen/resources/views/components/feedback/)
- [Alpine.js Documentation](https://alpinejs.dev/start-here)
- [Tailwind Animations](https://tailwindcss.com/docs/animation)
- [Geolocation API](https://developer.mozilla.org/en-US/docs/Web/API/Geolocation_API)
- [Nominatim Reverse Geocoding](https://nominatim.org/release-docs/develop/api/Reverse/)
