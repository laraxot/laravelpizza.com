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