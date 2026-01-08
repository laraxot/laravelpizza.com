# ModuleService

La classe `ModuleService` fornisce funzionalità per la gestione dei moduli nell'applicazione.

## Caratteristiche Principali

- Pattern Singleton per l'istanza del servizio
- Gestione dei modelli all'interno dei moduli
- Supporto per il caricamento dinamico dei file
- Gestione delle riflessioni delle classi

## Metodi Principali

### getInstance()

```php
public static function getInstance(): self
```

Implementa il pattern Singleton per garantire una singola istanza del servizio.

### make()

```php
public static function make(): self
```

Factory method alternativo che utilizza getInstance().

### setName()

```php
public function setName(string $name): self
```

Imposta il nome del modulo da gestire.

### getModels()

```php
public function getModels(): array
```

Recupera tutti i modelli definiti nel modulo specificato.

## Best Practices

1. **Utilizzo del Servizio**
   ```php
   use Modules\Xot\Services\ModuleService;

   $service = ModuleService::make()->setName('YourModule');
   $models = $service->getModels();
   ```

2. **Gestione dei Modelli**
   - I modelli devono essere nella directory `Models` del modulo
   - I file devono avere estensione `.php`
   - Le classi non devono essere astratte

3. **Gestione degli Errori**
   - Gestione sicura delle eccezioni di riflessione
   - Validazione dei percorsi e delle classi
   - Controllo dell'esistenza dei moduli

4. **Convenzioni di Naming**
   - Utilizzo di snake_case per i nomi dei modelli
   - Namespace coerente con la struttura dei moduli
   - Gestione corretta delle estensioni dei file

## Dipendenze

- Illuminate Support
- Nwidart Modules
- PHP Reflection

## Note di Sviluppo

- Il servizio utilizza il pattern Singleton
- Supporta il caricamento dinamico dei file
- Gestisce automaticamente le classi astratte
- Implementa una gestione sicura delle eccezioni

## Link Correlati

- [Documentazione Moduli](../../../docs/modules/index.md)
- [Gestione Modelli](../../../docs/models/index.md)
- [Pattern Singleton](../../../docs/patterns/singleton.md) 