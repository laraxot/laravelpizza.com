# 📄 **Cms Module** - Enterprise Content Management

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![PHPStan level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![Filament 5.x](https://img.shields.io/badge/Filament-5.x-blue.svg)](https://filamentphp.com/)

> **🚀 Modulo Cms**: Potente sistema di gestione contenuti (CMS) basato su un'architettura a blocchi. Permette la creazione di pagine dinamiche, menu e layout complessi attraverso un'interfaccia intuitiva in Filament.

## 📋 **Panoramica**

Il modulo **Cms** trasforma Laravel in una piattaforma di publishing avanzata, mantenendo la flessibilità dello sviluppo custom.

- 🧱 **Block-Based Content**: Composizione di pagine tramite blocchi riutilizzabili (Testo, Immagini, Video, Form).
- 📄 **Dynamic Pages**: Gestione gerarchica delle pagine con URL SEO-friendly tramite Folio.
- ⚡ **Volt Frontend**: Rendering ultra-veloce dei componenti frontend con Livewire Volt.
- 🌐 **Multi-Tenant SEO**: Metatag e strategie SEO differenziate per tenant.
- 🎨 **Appearance Engine**: Personalizzazione completa di temi e stili dall'area amministrativa.

## ⚡ **Funzionalità Core**

### 🧩 **Modular Blocks**
Ogni pagina è una collezione di `Block`, memorizzati in formato JSON per massima flessibilità e performance.

### 🧘 **XotData Integration**
Uso del pattern `XotData` per garantire che ogni configurazione sia type-safe e conforme ai requisiti di PHPStan Level 10.

## 🚀 **Quick Start**

### 📦 **Rendering di una Pagina**
```blade
{{-- In un file Folio --}}
<livewire:cms::page-show :slug="$slug" />
```

### ⚙️ **Registrazione Manuale Blocchi**
```php
Cms::registerBlock('hero', HeroBlock::class);
```

## 📚 **Documentazione Centrale**

- 📖 **[Indice Documentazione](./00-index.md)** - Navigazione rapida tra i contenuti.
- 🧱 **[Blocks System](./blocks/README.md)** - Guida alla creazione di nuovi blocchi.
- 🗺️ **[Roadmap](./roadmap.md)** - Evoluzione verso il versioning dei contenuti.
- 🏗️ **[Strategy](./content-management-strategy.md)** - Come organizziamo i contenuti.

---

**🔄 Ultimo aggiornamento**: 31 Gennaio 2026
**📦 Versione**: 2.3.0
**✅ PHPStan level 10**: Compliance nativa garantita
