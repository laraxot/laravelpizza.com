# Schedule Crud Component

## Panoramica
Componente Livewire per la gestione dei task schedulati nel modulo Job.

## Caratteristiche
- Visualizzazione dei task schedulati
- Creazione di nuovi task
- Esecuzione manuale dei task
- Integrazione con Artisan commands
- Gestione delle frequenze di esecuzione

## Miglioramenti PHPStan Livello 9
Le seguenti modifiche sono state apportate per soddisfare PHPStan livello 9:

1. Tipizzazione stretta dei parametri e return types
2. Gestione null-safe dei comandi Artisan
3. Rimozione di codice commentato non utilizzato
4. Correzione dei type hints per le Collection
5. Implementazione corretta delle interfacce

## Metodi Principali

### getFrequencies()
```php
public static function getFrequencies(): array
```
Restituisce le frequenze disponibili per la schedulazione dei task.

### getCommands()
```php
public function getCommands(): Collection
```
Restituisce la collezione dei comandi Artisan disponibili, ordinati alfabeticamente.

### executeTask()
```php
public function executeTask(string $task_id): void
```
Esegue manualmente un task specifico.

## Best Practices
1. Utilizzare type hints per tutti i parametri e return types
2. Gestire correttamente le eccezioni
3. Validare i dati di input
4. Mantenere la documentazione aggiornata

## Esempi di Utilizzo
```php
use Modules\Job\Http\Livewire\Schedule\Crud;

class MyComponent extends Component
{
    public function mount()
    {
        $frequencies = Crud::getFrequencies();
        // ...
    }
}
```

[Torna alla documentazione Job](/docs/modules/module_job.md#components) 