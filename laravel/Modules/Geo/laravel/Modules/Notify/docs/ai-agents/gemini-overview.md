# GEMINI Overview

Panoramica del progetto Laravel per agenti Gemini.

## Progetto

Questo è un progetto Laravel che fornisce un tema "meetup" per Laravel meetups. Usa un'architettura modulare chiamata "Laraxot", dove le feature sono separate in moduli. Il progetto usa tecnologie moderne come Folio (file-based routing) e Volt (single-file Livewire components), e Filament per l'admin panel.

---

## Building and Running

### Setup

```bash
# Dalla cartella laravel
composer run setup
```

Questo installerà:
- Composer dependencies
- Crea .env file
- Genera application key
- Esegue migrazioni database
- Installa NPM dependencies
- Build frontend assets

---

### Development

```bash
# Dalla cartella laravel
composer run dev
```

Avvia:
- Laravel dev server su `http://127.0.0.1:8000`
- Queue listener
- Log watcher
- Vite dev server

---

### Testing

```bash
composer run test
```

---

## Development Conventions

- **Architecture**: "Laraxot" modular architecture
- **Frontend**: Folio + Volt per pagine pubbliche
- **Code Quality**: PHPStan level 10 obbligatorio
- **Documentation**: Ogni modulo/tema ha `docs/` directory

---

## 🔗 Link

- [Indice GEMINI](./gemini-split-index.md)
- [GEMINI.md originale](../../GEMINI.md)
- [Index principale](./index.md)
