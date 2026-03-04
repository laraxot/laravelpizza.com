# Migrazione a Laravel 12 e Filament 5

Linee guida critiche per l'aggiornamento e la manutenzione dei moduli.

## 1. PHP 8.3 & Tipi Stretti
- **Regola**: Ogni file DEVE iniziare con `declare(strict_types=1);`.
- **Regola**: Usare i tipi di ritorno nativi e le proprietà tipizzate.

## 2. Filament 5 Updates
- **Visibilità Metodi**: I metodi degli hook delle tabelle (`getTableColumns`, `getTableHeaderActions`, `getTableActions`, `getTableBulkActions`) devono essere `public`.
- **Schema Form**: Personalizzare tramite `getFormSchema()` invece di fare l'override di `form()`.
- **Nested Resources**: Usare il supporto nativo di Filament 5 con `--nested`.

## 3. Livewire 4 & Volt
- **Integrazione**: Volt è ora lo standard per i componenti funzionali.
- **Assets**: Gli asset di Livewire sono gestiti automaticamente da Vite.

## 4. Tailwind CSS v4
- **Engine**: Tailwind v4 non usa più il file di configurazione JS come primario, ma si basa su direttive CSS.
- **Vite**: Assicurarsi che il plugin `@tailwindcss/vite` sia configurato in `vite.config.ts`.
