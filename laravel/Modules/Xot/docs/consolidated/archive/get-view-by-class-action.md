# GetViewByClassAction

## Panoramica
`GetViewByClassAction` è una classe che fornisce un'azione per risolvere il percorso della view basato sul namespace della classe. Questa classe è utilizzata principalmente da `XotBasePage` per determinare automaticamente il percorso della view da utilizzare.

## Caratteristiche Principali

### 1. Risoluzione Automatica
- Converte il namespace della classe in un percorso di view
- Supporta la convenzione di naming delle view di Laravel
- Gestisce automaticamente la conversione in kebab-case

### 2. Validazione
- Verifica che la classe sia nel namespace `Modules`
- Valida la struttura del namespace
- Fornisce messaggi di errore chiari

### 3. Integrazione
- Utilizza il trait `QueueableAction` per supporto asincrono
- Integra con il sistema di view di Laravel
- Supporta il pattern di risoluzione delle view dei moduli

## Utilizzo

```php
use Modules\Xot\Actions\GetViewByClassAction;

$action = app(GetViewByClassAction::class);
$view = $action->execute(YourPage::class);
// Restituisce: 'your-module::pages.your-page'
```

## Best Practices

1. **Namespace**
   - Le classi devono essere nel namespace `Modules\{ModuleName}`
   - I nomi delle classi devono essere descrittivi
   - Seguire le convenzioni PSR-4

2. **View**
   - Le view devono essere nella directory `resources/views/pages` del modulo
   - I nomi delle view devono essere in kebab-case
   - Utilizzare il namespace del modulo per le view

3. **Errori**
   - Gestire correttamente le eccezioni
   - Fornire messaggi di errore chiari
   - Loggare gli errori appropriatamente

## Note Tecniche

1. **Dipendenza**
   - Richiede il trait `QueueableAction`
   - Utilizza `Illuminate\Support\Str`
   - Utilizza `Webmozart\Assert\Assert`

2. **Compatibilità**
   - Compatibile con Laravel 10.x
   - Richiede PHP 8.1+

## Link Correlati

- [Documentazione XotBasePage](../filament/pages/xot-base-page.md)
- [Best Practices Views](../../best-practices/views.md)
- [Guida Namespace](../../namespace-guide.md) 