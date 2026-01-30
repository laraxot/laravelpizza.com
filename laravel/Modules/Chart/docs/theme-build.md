# Theme Build & Publish Guide

## Installazione dipendenze

All'interno di `Modules/Chart`, installa le dipendenze frontend richieste (Filament v5 + Tailwind CSS v4) con:

```bash
npm install
```

Per compilare e pubblicare gli asset del modulo **Chart**, eseguire i seguenti passi all'interno della cartella del modulo:

```bash
# 1. Compilare asset (Tailwind, JavaScript, CSS):
npm run build
# 2. Pubblicare asset nella cartella pubblica:
npm run copy
```

> **Requisito:** Filament v5 usa Tailwind CSS v4 (via `@tailwindcss/vite`). Verificare in `package.json` di avere `"tailwindcss": "^4.x"` e `"@tailwindcss/vite"` come dipendenze.

Se è la prima volta, verificare di aver eseguito `npm install` per le dipendenze.
