# ⚡ **Job Module** - Enterprise Queue & Schedule Management

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![PHPStan level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![Queue Engine](https://img.shields.io/badge/Engine-Redis%20%7C%20Database%20%7C%20Soketi-blue.svg)](https://laravel.com/docs/11.x/queues)

> **🚀 Modulo Job**: Il sistema nervoso della gestione asincrona per Laraxot. Gestisce con precisione chirurgica code multiple, task schedulati complessi e processi batch massivi, garantendo monitoraggio real-time e reportistica avanzata.

## 📋 **Panoramica**

Il modulo **Job** trasforma il background processing in un asset strategico per l'applicazione.

- 🧵 **Multi-Queue Mastery**: Gestione di code differenziate (high, default, low) con priorità dinamiche.
- 🕒 **Precision Scheduling**: Task manager integrato con supporto per espressioni cron e prevenzione sovrapposizioni.
- 📊 **Real-Time Insight**: Dashboard Soketi-powered per osservare i job mentre lavorano.
- 📄 **Insight Analytics**: Generazione automatica di report PDF sulle performance del sistema di code.
- 🛡️ **Failure Resilience**: Sistema di retry intelligente e notifiche immediate su errori critici.

## ⚡ **Funzionalità Core**

### 🧩 **Schedulazione Dinamica**
Non serve toccare il file `crontab`. Ogni task è definibile via database e gestibile tramite l'interfaccia Filament.

### 🧘 **Philosophical Design**
"Un job ben scritto non si accorge di essere in background". Il modulo garantisce che l'ambiente di esecuzione sia coerente e tracciabile.

## 🚀 **Quick Start**

### 📦 **Dispatch di un Job**
```php
ProcessDataJob::dispatch($data)->onQueue('high');
```

### ⚙️ **Verifica Stato Code**
Accedere alla sezione **Job Monitor** in Filament per visualizzare grafici di throughput e job falliti.

## 📚 **Documentazione Centrale**

- 📖 **[Indice Documentazione](./00-index.md)** - Navigazione rapida.
- 🙏 **[Filosofia Code](./philosophy.md)** - La gestione asincrona secondo Laraxot.
- 🗺️ **[Roadmap](./roadmap.md)** - Verso lo scheduling basato su AI.
- 📄 **[Report PDF Guide](./job-reports.md)** - Come interpretare i log di sistema.

---

**🔄 
**📦 Versione**: 2.3.0
**✅ PHPStan level 10**: Compliance nativa garantita

## 🚀 Release su GitHub
Le release sono basate su tag Git e possono includere release notes generate automaticamente.
Workflow locale: `.github/workflows/release.yml`.


## 📄 License & Authors

**Authors:**
- Marco Sottana <marco.sottana@gmail.com>

**License:** MIT