# TableLayoutToggleTableAction

## Panoramica
Azione Filament per il toggle del layout delle tabelle tra vista griglia e lista.

## Caratteristiche
- Supporto per layout griglia e lista
- Integrazione con Livewire
- Persistenza dello stato del layout
- Supporto per tooltip e icone dinamiche

## Miglioramenti PHPStan Livello 9
Le seguenti modifiche sono state apportate per soddisfare PHPStan livello 9:

1. Tipizzazione stretta dei parametri
2. Utilizzo di tipi unione per i componenti Livewire
3. Implementazione corretta delle interfacce
4. Gestione type-safe degli enum
5. Rimozione di type casting non necessari

## Interfaccia HasTableLayout
```php
interface HasTableLayout
{
    public function getLayoutView(): TableLayoutEnum;
    public function setLayoutView(TableLayoutEnum $layout): void;
    public function resetTable(): void;
}
```

## Utilizzo
```php
use Modules\UI\app\Filament\Actions\Table\TableLayoutToggleTableAction;

class MyListRecords extends ListRecords
{
    protected function getTableActions(): array
    {
        return [
            TableLayoutToggleTableAction::make(),
        ];
    }
}
```

## Best Practices
1. Implementare l'interfaccia HasTableLayout nei componenti che utilizzano l'azione
2. Utilizzare gli enum per i tipi di layout
3. Gestire correttamente gli eventi di refresh
4. Mantenere la persistenza dello stato

## Collegamenti alla Documentazione
- [Risoluzione Conflitti UI](../CONFLITTI_MERGE_RISOLTI.md): Documentazione dei conflitti risolti
- [Test di Risoluzione Conflitti](../test_conflicts_resolution.md): Test automatici che verificano la corretta risoluzione

[Torna alla documentazione UI](/docs/modules/module_ui.md#actions)
# TableLayoutToggleTableAction

## Panoramica
Azione Filament per il toggle del layout delle tabelle tra vista griglia e lista.

## Caratteristiche
- Supporto per layout griglia e lista
- Integrazione con Livewire
- Persistenza dello stato del layout
- Supporto per tooltip e icone dinamiche

## Miglioramenti PHPStan Livello 9
Le seguenti modifiche sono state apportate per soddisfare PHPStan livello 9:

1. Tipizzazione stretta dei parametri
2. Utilizzo di tipi unione per i componenti Livewire
3. Implementazione corretta delle interfacce
4. Gestione type-safe degli enum
5. Rimozione di type casting non necessari

## Interfaccia HasTableLayout
```php
interface HasTableLayout
{
    public function getLayoutView(): TableLayoutEnum;
    public function setLayoutView(TableLayoutEnum $layout): void;
    public function resetTable(): void;
}
```

## Utilizzo
```php
use Modules\UI\app\Filament\Actions\Table\TableLayoutToggleTableAction;

class MyListRecords extends ListRecords
{
    protected function getTableActions(): array
    {
        return [
            TableLayoutToggleTableAction::make(),
        ];
    }
}
```

## Best Practices
1. Implementare l'interfaccia HasTableLayout nei componenti che utilizzano l'azione
2. Utilizzare gli enum per i tipi di layout
3. Gestire correttamente gli eventi di refresh
4. Mantenere la persistenza dello stato

## Collegamenti alla Documentazione
- [Risoluzione Conflitti UI](../CONFLITTI_MERGE_RISOLTI.md): Documentazione dei conflitti risolti
- [Test di Risoluzione Conflitti](../test_conflicts_resolution.md): Test automatici che verificano la corretta risoluzione

[Torna alla documentazione UI](/docs/modules/module_ui.md#actions)
