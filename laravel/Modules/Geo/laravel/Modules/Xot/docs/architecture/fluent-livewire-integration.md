# Integrazione Livewire 4, Volt e Flux UI

Con il passaggio a Laravel 12 e Filament 5, l'integrazione del frontend segue il paradigma "Functional & Component-First".

## 1. Livewire Volt (Functional API)
Volt permette di definire componenti Livewire in un unico file Blade.
- **Utilizzo**: Preferire Volt per componenti UI atomici o logiche specifiche di una sola pagina.
- **Pattern**:
  ```blade
  <?php
  use function Livewire\Volt\{state};
  state(['count' => 0]);
  $increment = fn() => $this->count++;
  ?>
  <div>
      <button wire:click="increment">{{ $count }}</button>
  </div>
  ```

## 2. Flux UI
La library ufficiale Flux fornisce componenti accessibili e stilizzati con Tailwind CSS v4.
- **Standard**: Usare sempre i componenti Flux (`<flux:button>`, `<flux:input>`) invece di markup HTML raw per garantire coerenza visuale e accessibilità (ARIA).

## 3. Filament 5 Widgets
I widget interattivi devono sfruttare le nuove API di Filament 5.
- **Visibilità**: I metodi `getTableActions`, `getTableHeaderActions`, ecc. DEVONO essere `public`.
- **Datalabels**: Per i grafici, seguire il pattern stacking con `offset` per le etichette verticali.

## 4. Tailwind CSS v4 via Vite
Il build system è basato su Vite con il nuovo engine di Tailwind v4.
- **Configurazione**: Gestita tramite `vite.config.ts` e il CSS entry point. Non modificare i file legacy `tailwind.config.js` se non strettamente necessario per compatibilità.
