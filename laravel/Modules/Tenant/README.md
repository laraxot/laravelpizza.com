# Tenant Module

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![Filament 5.x](https://img.shields.io/badge/Filament-5.x-blue.svg)](https://filamentphp.com/)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![PHP 8.3+](https://img.shields.io/badge/PHP-8.3+-blue.svg)](https://php.net)
[![Multi-Tenant](https://img.shields.io/badge/Multi--Tenant-Connection%20Based-orange.svg)](#architettura)

> **Multi-tenancy basata su connessione**: isolamento dati per tenant tramite connessioni database automatiche, identificazione via dominio, configurazioni tenant-specific, gestione domini multipli.

---

## Cosa fa

Il modulo Tenant gestisce la multi-tenancy dell'applicazione. Ogni tenant ha il proprio dominio (o sottodominio), le proprie configurazioni e i propri dati isolati. L'isolamento avviene a livello di connessione database: ogni modulo usa automaticamente la connessione corretta basandosi sul namespace del modello.

```php
// L'identificazione del tenant avviene via dominio
// https://acme.quaeris.it -> tenant "acme"
// https://beta.quaeris.it -> tenant "beta"

// La connessione database si auto-risolve dal namespace
// Modules\User\Models\User -> connessione "user"
// Modules\Quaeris\Models\Survey -> connessione "quaeris"

// Config tenant-specific
// config/acme/app.php sovrascrive config/app.php per tenant "acme"
```

---

## Architettura

```
Richiesta HTTP
    |
    v
Domain Resolution (TenantDomain -> Tenant)
    |
    v
Config Override (config/{tenant_name}/ sovrascrive config/)
    |
    v
Connection-based Isolation
    +-- Ogni modulo ha la sua connessione DB
    +-- Auto-scoperta dal namespace del modello
    +-- Dati isolati per tenant senza query extra
```

---

## Modelli (6)

| Modello | Funzione |
|---------|----------|
| **Tenant** | Entita tenant con nome, slug, impostazioni |
| **TenantDomain** | Dominio associato al tenant |
| **Domain** | Dominio con configurazione DNS |
| **TenantSetting** | Impostazioni key-value per tenant |
| **TenantSubscription** | Abbonamento/piano del tenant |
| **BaseModelJsons** | Modello Sushi per dati da JSON |

---

## Azioni (13)

| Action | Funzione |
|--------|----------|
| **ResolveTenantByDomainAction** | Identifica tenant dal dominio HTTP |
| **LoadTenantConfigAction** | Carica config tenant-specific |
| **ResolveTenantModelAction** | Risolve modello per il tenant attivo |
| **ManageTenantModulesAction** | Abilita/disabilita moduli per tenant |
| **LocalizeMarkdownAction** | Traduzioni markdown per tenant |
| **ManageTranslationsAction** | Gestione traduzioni tenant-specific |

---

## Filament Integration

| Resource | Funzione |
|----------|----------|
| **DomainResource** | CRUD domini con associazione tenant |

---

## Configurazione per Tenant

```
config/                    # Config globale (default)
config/acme/              # Override per tenant "acme"
    app.php               # Sovrascrive config('app.*')
    mail.php              # SMTP diverso per tenant
    services.php          # API key diverse per tenant
```

```php
// In runtime, il tenant attivo determina quale config caricare
// Se config/acme/mail.php esiste, sovrascrive config/mail.php
// Altrimenti usa il default globale
```

---

## Multi-Dominio

```php
// Un tenant puo avere piu domini
$tenant = Tenant::where('slug', 'acme')->first();
$tenant->domains; // ['acme.quaeris.it', 'survey.acme.com']

// Il primo dominio e il primario
// Gli altri sono alias che risolvono allo stesso tenant
```

---

## Integrazione con altri moduli

```
Tenant ──> User       (utenti per tenant, team per tenant)
Tenant ──> Quaeris    (survey e dashboard per tenant)
Tenant ──> Limesurvey (survey isolati per tenant)
Tenant ──> Notify     (comunicazioni per tenant)
Tenant ──> UI         (tema per tenant)
Tenant ──> Activity   (audit trail isolato per tenant)
```

Tutti i moduli ereditano l'isolamento tenant tramite il pattern di auto-scoperta della connessione.

---

## Quick Start

```bash
php artisan module:enable Tenant
php artisan migrate

# Accedi al pannello admin
# Il tenant viene identificato automaticamente dal dominio
```

---

## Metriche

| Metrica | Valore |
|---------|--------|
| **Modelli** | 6 |
| **Azioni** | 13 |
| **Resource Filament** | 1 |
| **Isolamento** | Connection-based (auto-discovery) |
| **PHPStan Level** | 10 |

---

**Module Type**: Multi-Tenancy Infrastructure
**Architecture**: Connection-based isolation, domain identification, config override
**Quality**: PHPStan Level 10

*Isolamento dati trasparente: ogni tenant ha il suo dominio, le sue config e i suoi dati, senza query extra.*
