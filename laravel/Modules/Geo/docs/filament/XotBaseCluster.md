# XotBaseCluster

## Descrizione

`XotBaseCluster` è una classe astratta che estende `Filament\Clusters\Cluster` e serve come base per tutti i cluster Filament nel framework Laraxot. Questa classe implementa funzionalità comuni e standardizzate per garantire coerenza e conformità alle regole di sviluppo del progetto.

## Analisi della Classe Base Filament\Clusters\Cluster

Prima di implementare `XotBaseCluster`, è importante comprendere la classe che stiamo estendendo.

### Proprietà di Filament\Clusters\Cluster

- `protected static ?string $navigationGroup = null`: Gruppo di navigazione del cluster
- `protected static ?string $navigationIcon = null`: Icona di navigazione del cluster
- `protected static ?string $navigationLabel = null`: Etichetta di navigazione del cluster
- `protected static ?int $navigationSort = null`: Ordinamento del cluster nella navigazione
- `protected static ?string $slug = null`: Slug del cluster per gli URL

### Metodi di Filament\Clusters\Cluster

- `public static function getNavigationGroup(): ?string`: Restituisce il gruppo di navigazione
- `public static function getNavigationIcon(): ?string`: Restituisce l'icona di navigazione
- `public static function getNavigationLabel(): string`: Restituisce l'etichetta di navigazione
- `public static function getNavigationSort(): ?int`: Restituisce l'ordinamento nella navigazione
- `public static function getPages(): array`: Restituisce le pagine del cluster
- `public static function getSlug(): string`: Restituisce lo slug del cluster
- `public static function getUrl(array $parameters = []): string`: Restituisce l'URL del cluster

## Implementazione di XotBaseCluster

La classe `XotBaseCluster` estenderà `Filament\Clusters\Cluster` e implementerà le seguenti funzionalità aggiuntive:

1. **Integrazione con il Sistema di Traduzioni**:
   - Sovrascrittura dei metodi `getNavigationLabel()`, `getNavigationGroup()`, e `getNavigationSort()` per utilizzare il sistema di traduzioni di Laraxot
   - Utilizzo di `Illuminate\Support\Facades\Lang` per recuperare le traduzioni dai file di lingua

2. **Standardizzazione della Navigazione**:
   - Rimozione della proprietà `$navigationIcon` dalla classe base, poiché deve essere gestita tramite traduzioni
   - Implementazione di un metodo `getNavigationIcon()` che recupera l'icona dalle traduzioni

3. **Funzionalità Comuni**:
   - Metodi helper per la gestione delle risorse all'interno del cluster
   - Integrazione con il sistema di autorizzazioni

## Esempio di Implementazione

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Clusters;

use Filament\Clusters\Cluster;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

abstract class XotBaseCluster extends Cluster
{
    /**
     * Get the navigation label for this cluster.
     */
    public static function getNavigationLabel(): string
    {
        $key = static::getTranslationKey() . '.cluster.label';
        
        return Lang::has($key) ? Lang::get($key) : static::getDefaultNavigationLabel();
    }

    /**
     * Get the navigation group for this cluster.
     */
    public static function getNavigationGroup(): ?string
    {
        $key = static::getTranslationKey() . '.navigation_group';
        
        return Lang::has($key) ? Lang::get($key) : null;
    }

    /**
     * Get the navigation sort for this cluster.
     */
    public static function getNavigationSort(): ?int
    {
        $key = static::getTranslationKey() . '.navigation_sort';
        
        return Lang::has($key) ? (int) Lang::get($key) : null;
    }

    /**
     * Get the navigation icon for this cluster.
     */
    public static function getNavigationIcon(): ?string
    {
        $key = static::getTranslationKey() . '.cluster.icon';
        
        return Lang::has($key) ? Lang::get($key) : 'heroicon-o-squares-2x2';
    }

    /**
     * Get the default navigation label for this cluster.
     */
    protected static function getDefaultNavigationLabel(): string
    {
        return Str::title(Str::snake(class_basename(static::class), ' '));
    }

    /**
     * Get the translation key for this cluster.
     */
    protected static function getTranslationKey(): string
    {
        $module = Str::lower(explode('\\', static::class)[1]);
        $name = Str::snake(str_replace('Cluster', '', class_basename(static::class)));
        
        return "{$module}::{$name}";
    }
}
```

## Utilizzo

Per utilizzare `XotBaseCluster`, le classi cluster concrete dovrebbero estenderla e implementare solo i metodi necessari:

```php
<?php

declare(strict_types=1);

namespace Modules\Broker\Filament\Clusters;

use Modules\Xot\Filament\Clusters\XotBaseCluster;
use Modules\Broker\Filament\Clusters\ClienteCluster\Pages;

class ClienteCluster extends XotBaseCluster
{
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClientes::route('/'),
        ];
    }
}
```

## File di Traduzione

Per supportare il sistema di traduzioni, è necessario creare file di traduzione appropriati:

```php
// lang/it/cliente.php
return [
    'cluster' => [
        'label' => 'Clienti',
        'icon' => 'heroicon-o-users',
        'tooltip' => 'Gestione clienti',
    ],
    'navigation_group' => 'Gestione',
    'navigation_sort' => 10,
];
```

## Vantaggi

1. **Coerenza**: Tutti i cluster seguiranno lo stesso pattern di implementazione
2. **Manutenibilità**: Le modifiche comuni possono essere implementate in un unico posto
3. **Integrazione con Traduzioni**: Utilizzo coerente del sistema di traduzioni
4. **Conformità alle Regole**: Rispetto delle regole di sviluppo del progetto

## Conclusione

L'implementazione di `XotBaseCluster` garantisce che tutti i cluster nel progetto seguano le stesse convenzioni e regole di sviluppo, facilitando la manutenzione e l'estensione del codice. Questa classe rappresenta un importante passo verso la standardizzazione completa del codice Filament nel framework Laraxot.
