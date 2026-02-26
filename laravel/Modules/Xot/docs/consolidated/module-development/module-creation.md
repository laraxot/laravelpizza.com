# Creazione di Nuovi Moduli

## Introduzione

Questo documento descrive il processo di creazione di nuovi moduli nel sistema, seguendo le best practices e le convenzioni stabilite.

## Prerequisiti

1. Laravel installato
2. Modulo Xot installato e configurato
3. nwidart/laravel-modules installato

## Processo di Creazione

### 1. Creazione del Modulo

```bash
php artisan module:make NomeModulo
```

Questo comando creerà la struttura base del modulo con i seguenti file:
- `Providers/NomeModuloServiceProvider.php`
- `Providers/RouteServiceProvider.php`
- `Providers/EventServiceProvider.php`

### 2. ServiceProvider

Il ServiceProvider del modulo estenderà `XotBaseServiceProvider`:

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class NomeModuloServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'NomeModulo';
    public string $nameLower = 'nomemodulo';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;

    public function boot(): void
    {
        parent::boot();
        // Aggiungi qui solo logica specifica del modulo
    }
}
```

### 3. RouteServiceProvider

Il RouteServiceProvider estenderà `XotBaseRouteServiceProvider`:

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Providers;

use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    public string $name = 'NomeModulo';
    public string $nameLower = 'nomemodulo';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;

    public function boot(): void
    {
        parent::boot();
        // Aggiungi qui solo logica specifica del modulo
    }
}
```

### 4. EventServiceProvider

L'EventServiceProvider estenderà `XotBaseEventServiceProvider`:

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Providers;

use Modules\Xot\Providers\XotBaseEventServiceProvider;

class EventServiceProvider extends XotBaseEventServiceProvider
{
    public string $name = 'NomeModulo';
    public string $nameLower = 'nomemodulo';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;

    protected $listen = [
        // Aggiungi qui gli eventi e i listener specifici del modulo
    ];

    protected $subscribe = [
        // Aggiungi qui i subscriber specifici del modulo
    ];
}
```

## Struttura Directory

```
NomeModulo/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   ├── Providers/
│   │   ├── NomeModuloServiceProvider.php
│   │   ├── RouteServiceProvider.php
│   │   └── EventServiceProvider.php
│   └── View/
│       └── Components/
├── config/
│   └── config.php
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   └── components/
│   └── lang/
│       ├── en/
│       └── it/
├── routes/
│   ├── web.php
│   └── api.php
└── module.json
```

## Best Practices

1. **Naming**
   - Usare PascalCase per il nome del modulo
   - Usare lowercase per il nome in minuscolo
   - Mantenere coerenza nei namespace

2. **ServiceProvider**
   - Estendere sempre le classi base appropriate
   - Definire tutte le proprietà richieste
   - Chiamare sempre i metodi parent

3. **Componenti**
   - Seguire la struttura directory standard
   - Usare nomi descrittivi
   - Mantenere i componenti piccoli e riutilizzabili

4. **Traduzioni**
   - Usare file di traduzione separati per ogni contesto
   - Seguire il formato standard per le chiavi
   - Fornire traduzioni per tutte le lingue supportate

## Troubleshooting

### Modulo Non Rilevato
- Verificare che il modulo sia elencato in `modules_statuses.json`
- Verificare che il namespace sia corretto
- Verificare che il ServiceProvider sia registrato

### Route Non Funzionanti
- Verificare che il RouteServiceProvider sia registrato
- Verificare che le route siano nel file corretto
- Verificare che i middleware siano configurati

### Eventi Non Ascoltati
- Verificare che l'EventServiceProvider sia registrato
- Verificare che gli eventi e i listener siano mappati
- Verificare che i namespace siano corretti

## Link Utili
- [service-provider-best-practices.md](service-provider-best-practices.md)
- [blade-component-registration.md](blade-component-registration.md)
- [XotBaseServiceProvider.md](XotBaseServiceProvider.md)
- [XotBaseRouteServiceProvider.md](XotBaseRouteServiceProvider.md)
- [XotBaseEventServiceProvider.md](XotBaseEventServiceProvider.md) 