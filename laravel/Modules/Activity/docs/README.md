# 📊 **Activity Module** - Tracking, Audit & Event Sourcing

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![PHPStan level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![Event Sourcing](https://img.shields.io/badge/Architecture-Event%20Sourcing-orange.svg)](https://martinfowler.com/eaaDev/EventSourcing.html)

> **🚀 Modulo Activity**: Il sistema di "scatola nera" dell'applicazione. Traccia ogni azione utente, mutamento di stato e evento di dominio, fornendo una cronologia immutabile e analizzabile.

## 📋 **Panoramica**

Il modulo **Activity** non è un semplice logger, ma un'infrastruttura completa per la conformità, la sicurezza e la business intelligence.

- 🛠️ **Audit Trail Completo**: Tracciamento di creazione, modifica e cancellazione (Laravel Activitylog style).
- 🎯 **Event Sourcing Ready**: Registrazione di eventi di dominio per ricostituire lo stato del sistema.
- 📉 **Analytics Dashboard**: Integrazione profonda con Filament per la visualizzazione di trend e statistiche.
-  GDPR **Compliance**: Rispetto delle normative sulla tracciabilità delle operazioni sui dati sensibili.

## ⚡ **Funzionalità Core**

### 🧩 **Logging Automatico**
Integrazione trasparente con i modelli Eloquent tramite trait dedicati per loggare variazioni di attributi.

### 📊 **Dashboard Analytics**
Widget pronti all'uso per monitorare l'attività degli utenti in tempo reale e identificare anomalie o picchi di carico.

## 🚀 **Quick Start**

### 📦 **Logging Manuale**
```php
activity()
    ->performedOn($model)
    ->causedBy(auth()->user())
    ->withProperties(['status' => 'approved'])
    ->log('Document was approved');
```

### ⚙️ **Logging Automatico sui Modelli**
```php
use Spatie\Activitylog\Traits\LogsActivity;

class Project extends Model {
    use LogsActivity;
    protected static $logAttributes = ['name', 'budget'];
}
```

## 📚 **Documentazione Completa**

- 📖 **[Indice Documentazione](./00-index.md)** - Mappa di tutti i contenuti.
- 🗺️ **[Roadmap](./roadmap.md)** - Evoluzione e feature future (AI Analytics).
- 🔬 **[Testing Structure](./testing-strategy-implementation.md)** - Come verifichiamo la fedeltà dei log.
- 🛠️ **[Troubleshooting](./bottlenecks.md)** - Gestione delle performance con volumi elevati.

---

**🔄 Ultimo aggiornamento**: 31 Gennaio 2026
**📦 Versione**: 2.3.0
**✅ PHPStan level 10**: Compliance nativa garantita
