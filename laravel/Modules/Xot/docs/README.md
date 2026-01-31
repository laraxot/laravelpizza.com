# 🏗️ **Xot Module** - Il Cuore del Framework Laraxot

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![Filament 5.x](https://img.shields.io/badge/Filament-5.x-blue.svg)](https://filamentphp.com/)
[![PHP 8.3](https://img.shields.io/badge/PHP-8.3-blueviolet.svg)](https://www.php.net/)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![Modular Architecture](https://img.shields.io/badge/Architecture-Modular%20Monolith-yellow.svg)](https://martinfowler.com/articles/modular-monolith.html)

> **🚀 Modulo Xot**: Framework base e cuore architetturale di Laraxot - fornisce classi base, traits, convenzioni e infrastruttura core per tutti i moduli dell'ecosistema.

## 📋 **Panoramica**

Il modulo **Xot** è il **framework base** di Laraxot PTVX, un ecosistema modulare basato su **Laravel 12** e **Filament 5**, progettato per applicazioni enterprise. Fornisce gli strumenti fondamentali e i pattern architetturali per garantire coerenza, estensibilità e manutenibilità in tutto il progetto.

### Principi Fondamentali
- **Modularità**: Ogni funzionalità è organizzata in moduli indipendenti e autoconsistenti.
- **Coerenza**: Adozione di una struttura uniforme, convenzioni di naming e best practice standardizzate.
- **Estensibilità**: Progettato per facilitare l'aggiunta di nuovi moduli e l'espansione delle funzionalità esistenti.
- **Manutenibilità**: Codice pulito, ben documentato e supportato da strumenti di analisi statica.

## ⚡ **Architettura Core**

### 🏗️ **Base Classes Pattern**
Tutti i componenti principali dei moduli devono estendere le classi base fornite da Xot per ereditare funzionalità comuni e garantire coerenza.

```php
// Esempio di una Resource Filament
use Modules\Xot\Filament\Resources\XotBaseResource;

class UserResource extends XotBaseResource
{
    protected static ?string $model = User::class;

    // Il metodo table() e form() NON devono essere sovrascritti
    // se non per aggiungere logica specifica, ma la base
    // è già fornita da XotBaseResource.
}
```

### 🔧 **Traits Ecosystem**
Xot fornisce un ricco ecosistema di Trait per aggiungere funzionalità comuni ai modelli e ad altre classi.
- **HasXotTable**: Aggiunge funzionalità avanzate alle tabelle Filament.
- **HasUuid**: Gestisce automaticamente UUID come chiavi primarie.
- **HasMedia**: Integra Spatie Media Library con convenzioni standard.
- **HasStates**: Fornisce una gestione degli stati per i modelli.
- **TransTrait**: Semplifica le traduzioni dinamiche.

### 📦 **Service Provider Pattern**
I Service Provider di ogni modulo estendono `XotBaseServiceProvider`, che automatizza la registrazione di:
- Migrations, Views, Translations, e Config
- Routes (web.php, api.php)
- Filament Resources, Pages, e Widgets
- Comandi Artisan e Policies

## 🎯 **Funzionalità Principali**

### ⚡ **Actions Framework**
Un pattern standardizzato per incapsulare la business logic in classi riutilizzabili e testabili.
```php
use Modules\Xot\Actions\XotBaseAction;

class CreateUserAction extends XotBaseAction
{
    public function execute(array $data): User
    {
        $user = User::create($data);
        $this->logActivity('user.created', $user); // Logging automatico
        event(new UserCreated($user)); // Dispatching eventi
        return $user;
    }
}
```

### 🏷️ **Enums System**
Le Enum di Xot implementano `XotBaseEnum`, che fornisce traduzioni automatiche e altri helper.
```php
use Modules\Xot\Enums\XotBaseEnum;

enum UserStatus: string implements XotBaseEnum
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public function getLabel(): string
    {
        // Traduzione gestita centralmente
        return __('xot::enums.user_status.'.$this->value);
    }
}
```

## 🛠️ **Sviluppo e Qualità**

### Convenzioni
- **Namespace**: I namespace dei moduli **NON** devono includere il segmento `app`.
- **Tipizzazione Forte**: Utilizzo di `declare(strict_types=1);` e type hints rigorosi in tutto il codice.
- **File di Traduzione**: Seguire la struttura espansa `['label' => '...', 'tooltip' => '...']`.

### Strumenti di Qualità
- **PHPStan**: Livello 10. La configurazione è in `phpstan.neon`.
- **Pest**: Utilizzato per i test della business logic nei moduli core.
- **Laravel Pint**: Formattazione del codice secondo lo standard PSR-12 e le convenzioni Laraxot.

Esegui i controlli di qualità dalla root del progetto Laravel:
```bash
./vendor/bin/phpstan analyse Modules/Xot --level=max
./vendor/bin/pest Modules/Xot/tests
./vendor/bin/pint
```

### 🏆 PHPStan Level 10 Compliance (Dicembre 2025)

**Status**: ✅ **0 Errori** (16 → 0)
**Approccio**: Fix, Don't Ignore
**Baseline**: Nessuno

Il modulo Xot ha raggiunto la piena conformità PHPStan Level 10 senza compromessi:
- Zero baseline entries
- Nessuna modifica a phpstan.neon
- Solo correzioni reali del codice
- Type safety al 100%

**Documentazione dettagliata**:
- [PHPStan Patterns Dec 2025](./phpstan-patterns-dec-2025.md)
- [PHPStan Level 10 Success](../../../docs/phpstan-level-10-success.md)

## 🗺️ **Roadmap**
1.  **Consolidamento Documentazione**: Unificare e semplificare la documentazione di tutti i moduli (obiettivo: 500 → 120 file).
2.  **Automazione Script di Merge**: Creare script per la gestione automatica dei conflitti comuni e la validazione pre-commit.
3.  **Aumento Test Coverage**: Portare la copertura dei test per i moduli core sopra il 90%.
4.  **Dashboard Health Check**: Introdurre una dashboard per monitorare lo stato di salute e la compliance di tutti i moduli.

## 🔗 **Link Utili**
- [CHANGELOG](./CHANGELOG.md)
- [Guida alla Risoluzione dei Conflitti Git](../../../bashscripts/docs/git-conflict-resolution-guide.md)
- [Convenzioni sui Namespace](./namespace_conventions.md)
- [Linee Guida per il Testing](./testing.md)
