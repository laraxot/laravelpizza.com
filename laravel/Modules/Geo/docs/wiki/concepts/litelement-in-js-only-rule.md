# litelement in js only rule

## Regola

Nei field Blade del modulo Geo non si definiscono classi Lit (`class ... extends LitElement`).

- Blade: solo markup host (`<geo-map-picker>` / `<map-picker-lit>`) e binding Filament/Livewire.
- JavaScript: tutta la logica Web Component Lit dentro `resources/js/components/*`
  o `resources/js/filament/*`, poi importata dal bundle tema (`Themes/Sixteen/resources/js/app.js`).

## Motivazione

- evita duplicazione runtime tra Blade inline script e bundle Vite
- evita mismatch modulo ES (`@lit/reactive-element`) nel browser
- mantiene DRY e ownership chiara tra view e component logic

## Applicazione pratica

- rimosso script Lit inline da `resources/views/filament/forms/components/map-picker.blade.php`
- registrazione componente/bridge demandata a `resources/js/filament/map-picker.js`
- import aggiunto nel bundle tema: `@modules/Geo/resources/js/filament/map-picker.js`
