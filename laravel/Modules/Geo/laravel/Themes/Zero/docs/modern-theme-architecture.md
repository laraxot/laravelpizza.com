# Architettura Moderna dei Temi - Zero Theme

Il tema Zero segue i principi di modularità e performance introdotti con Laravel 12 e Filament 5.

## 1. Asset Management (Vite + Tailwind CSS v4)
Il tema utilizza Vite per il build degli asset e Tailwind CSS v4 per il design system.
- **Vantaggio**: Build ultra-veloci e runtime ridotto.
- **Integrazione**: Gli asset sono registrati tramite `XotBaseThemeServiceProvider`.

## 2. Integrazione Livewire 4 & Volt
Il tema favorisce l'uso di Livewire Volt per i componenti UI del frontend.
- **Best Practice**: Mantenere la logica di presentazione dentro i file Volt per una manutenzione "colocated".

## 3. Flux UI Integration
Zero integra Flux UI per componenti base (button, modals, inputs) garantendo:
- Accessibilità WCAG out-of-the-box.
- Stile coerente con il brand <nome progetto>.

## 4. Visualizzazione Dati & Grafici
Per i dashboard, Zero utilizza:
- **Filament Widgets** per l'area admin.
- **Chart.js** con configurazione centralizzata in `Modules/Chart`.
- **JpGraph 4.4.2** per la generazione di immagini grafiche per i report PDF.

## 5. Performance & Caching
- **Redis**: Usato per il caching dei frammenti di view più pesanti.
- **Responsive Images**: Gestite tramite Spatie MediaLibrary per ottimizzare il caricamento mobile.
