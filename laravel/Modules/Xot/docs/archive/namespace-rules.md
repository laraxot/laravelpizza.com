# Regole per i Namespace nei Moduli Laraxot

Questo documento definisce le regole ufficiali per l'utilizzo dei namespace all'interno dei moduli Laraxot.

## Struttura Corretta dei Namespace

La struttura corretta dei namespace nei moduli **NON** include il segmento `app` anche se il file è fisicamente posizionato nella directory `app`.

### ✅ CORRETTO

```php
namespace Modules\NomeModulo\Providers;
namespace Modules\NomeModulo\Http\Controllers;
```

### ❌ ERRATO

```php
namespace Modules\NomeModulo\app\Providers;
namespace Modules\NomeModulo\app\Http\Controllers;
```

## Regole per RouteServiceProvider

Il `RouteServiceProvider` di ogni modulo deve seguire questa struttura:

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Providers;

use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     */
    protected string $moduleNamespace = 'Modules\NomeModulo\Http\Controllers';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    public string $name = 'NomeModulo';
}
```

## Punti importanti da ricordare

1. I namespace NON devono includere il segmento `app` anche se i file sono fisicamente nella directory `app`
2. I controller devono avere il namespace `Modules\NomeModulo\Http\Controllers`
3. I provider devono avere il namespace `Modules\NomeModulo\Providers`
4. La proprietà `$name` nel RouteServiceProvider è obbligatoria e deve essere impostata al nome del modulo
5. La proprietà `$moduleNamespace` deve puntare a `Modules\NomeModulo\Http\Controllers`

## Motivo di questa regola

Questa struttura di namespace mantiene compatibilità con la convenzione di Laravel e il sistema di moduli Nwidart, anche se i file sono fisicamente organizzati in modo diverso.

## Verifica e correzione

Se incontri errori come `name is empty on [Modules\NomeModulo\Providers\RouteServiceProvider]`, verifica:

1. Che il namespace sia corretto (senza `app`)
2. Che la proprietà `$name` sia definita e valorizzata
3. Che il `$moduleNamespace` punti alla posizione corretta dei controller
# Regole Namespace PSR-4 per Tutti i Moduli (Regola Globale)

## Regola Fondamentale
- **Mai** usare il segmento `App` nel namespace delle classi di un modulo.
- Il namespace deve essere sempre:
  ```php
  namespace Modules\<NomeModulo>\<Directory>;
  ```
  Anche se la classe si trova in `app/`, il namespace NON deve includere `App`.

## Regola PSR-4
- Il namespace riflette la struttura delle directory a partire da `Modules/<NomeModulo>/app/`, senza includere `app`.
- Esempio:
  - File: `Modules/Notify/app/Console/Commands/AnalyzeTranslationFiles.php`
  - Namespace: `Modules\Notify\Console\Commands`

## Applicazione
- Questa regola si applica a **tutti** i moduli (Notify, Cms, Xot, ecc.), **inclusi i modelli**.
- Evitare l'uso di proprietà deprecate come `protected $casts` nei modelli: preferire override tramite metodo `casts()`.
- Per esempi specifici, vedere la documentazione nei singoli moduli:
  - [Patient: Regole Modelli](../../Patient/docs/models.md)
  - [Notify Namespace Rules](../../Notify/docs/NAMESPACE_RULES.md)

## Collegamenti
- [Regole Namespace Moduli - Root Docs](../../../docs/namespace-moduli.md)

---

**Ultimo aggiornamento:** 2025-05-13

**Link bidirezionale:** Aggiornare anche la root docs e la docs dei moduli coinvolti.
