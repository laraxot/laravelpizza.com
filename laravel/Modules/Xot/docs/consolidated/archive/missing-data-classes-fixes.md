# Correzione Classi Data Mancanti in Laraxot

## Analisi del Problema

La classe `XotData` fa riferimento a diverse classi Data che non sembrano essere definite nel namespace `Modules\Xot\Datas`:

- `RouteData`
- `CookieData`
- `MailData`
- `FilemanagerData`
- `SearchEngineData`
- `PwaData`
- `ArticleData`
- `AuthData`
- `SubscriptionData`
- `NotificationData`
- `OptionData`

Queste classi sono utilizzate come proprietà readonly nella dichiarazione del costruttore di `XotData`, ma non sono state implementate o importate correttamente, causando errori durante l'analisi statica con PHPStan.

## Approccio alla Soluzione

Per risolvere questo problema in modo coerente con l'architettura Filament-first del progetto, abbiamo due possibili soluzioni:

### 1. Implementare le classi Data mancanti

Creare ogni classe Data come una struttura dati semplice che estende `Spatie\LaravelData\Data`, mantenendo il design orientato ai dati di Filament:

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Datas;

use Spatie\LaravelData\Data;

class RouteData extends Data
{
    public function __construct(
        public readonly string $prefix = '',
        public readonly array $middleware = [],
        // altre proprietà necessarie
    ) {
    }
}
```

### 2. Semplificare XotData usando tipi primitivi o array

Modificare `XotData` per utilizzare tipi primitivi o array invece di classi Data separate:

```php
public function __construct(
    // ...
    public readonly array $route = [],
    // ...
) {
}
```

## Soluzione Scelta

La prima soluzione è preferibile perché:

1. **Mantiene il pattern Data Object** - In linea con l'approccio orientato ai dati di Filament
2. **Migliora la type safety** - Le classi dedicate offrono migliore validazione e autocompletamento
3. **Segue le best practices** - Ogni Data class ha una singola responsabilità
4. **Facilita l'estensione** - Nuove proprietà possono essere aggiunte alle singole classi senza modificare XotData

Implementeremo quindi le classi Data mancanti, iniziando da RouteData che sembra essere la più utilizzata.

## Impatto sulle Dipendenze

Poiché il progetto utilizza esclusivamente Filament senza controller o Blade, queste classi Data servono principalmente come strutture per configurazione e trasferimento dati tra componenti Filament, non impattando l'architettura generale ma migliorando la manutenibilità del codice.
