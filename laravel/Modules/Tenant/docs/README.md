# 🏢 **Tenant Module** - Multi-Tenancy & Isolamento Dati

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![PHPStan level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![Multi-Tenancy](https://img.shields.io/badge/Multi--Tenancy-Domain%20%7C%20Connection-blue.svg)](https://tenancyforlaravel.com/)

> **🚀 Modulo Tenant**: L'architrave del multi-tenancy nell'ecosistema Laraxot. Garantisce la "Sovranità Digitale" ad ogni organizzazione tramite un isolamento strutturale basato su connessioni database e domini dedicati.

## 📋 **Panoramica**

Il modulo **Tenant** permette di gestire multiple istanze applicative (Tenant) su un unico codebase, assicurando che i dati rimangano rigorosamente separati e sicuri.

- 🛡️ **Isolation by Connection**: Ogni query utilizza automaticamente la connessione `tenant`, eliminando il rischio di data leakage.
- 🌐 **Domain-Based Identification**: I tenant vengono identificati automaticamente tramite il dominio (es. `acme.ptvx.it`).
- ⚙️ **Tenant-Specific Config**: Supporto per override delle configurazioni Laravel per singolo tenant via `config/{tenant_name}/`.
- 🍣 **Sushi Models**: Uso di modelli in-memory per configurazioni statiche e domini, garantendo performance e controllo versione.

## ⚡ **Funzionalità Core**

### 🧩 **Tenant & Domain Management**
Gestione completa delle organizzazioni e dei relativi domini tramite Filament UI. Supporto per domini multipli puntanti allo stesso tenant.

### 🧘 **Philosophical Isolation**
Seguiamo il principio dell'invisibilità: se lo sviluppatore deve pensare al tenant mentre scrive logica business, l'architettura ha fallito. L'isolamento è gestito a livello di `BaseModel`.

## 🚀 **Quick Start**

### 📦 **Abilitazione Connessione**
Assicurarsi che i modelli business estendano la logica corretta per l'isolamento:
```php
class MyModel extends BaseModel {
    protected $connection = 'tenant';
}
```

### ⚙️ **Identificazione Tenant**
L'identificazione avviene automaticamente via middleware, ma è possibile recuperare il tenant corrente via:
```php
$tenant = app(TenantService::class)->getCurrent();
```

## 📚 **Documentazione Completa**

- 📖 **[Indice Documentazione](./00-index.md)** - Mappa completa di tutti i documenti.
- 🗺️ **[Roadmap](./roadmap.md)** - Visione e obiettivi futuri.
- 🙏 **[Filosofia](./philosophy.md)** - I dogmi della sovranità digitale distribuita.
- 🏗️ **[Business Logic Deep Dive](./business-logic-deep-dive.md)** - Analisi tecnica del funzionamento interno.

---

**🔄 Ultimo aggiornamento**: 31 Gennaio 2026
**📦 Versione**: 1.2.0
**✅ PHPStan level 10**: Compliance verificata (0 errori)

## 🚀 Release su GitHub
Le release sono basate su tag Git e possono includere release notes generate automaticamente.
Workflow locale: `.github/workflows/release.yml`.


## 📄 License & Authors

**Authors:**
- Marco Xot <marco.sottana@gmail.com>

**License:** MIT
