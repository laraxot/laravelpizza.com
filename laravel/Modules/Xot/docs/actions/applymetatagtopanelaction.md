# ApplyMetatagToPanelAction

## Descrizione
L'azione `ApplyMetatagToPanelAction` è responsabile di applicare i metatag al panel Filament, configurando l'aspetto visivo dell'interfaccia amministrativa.

## Funzionalità
- Applica i colori del tema al panel
- Configura il logo del brand
- Imposta il nome del brand
- Configura il logo per la modalità scura
- Imposta l'altezza del logo
- Configura il favicon

## Utilizzo
```php
use Modules\Xot\Actions\Panel\ApplyMetatagToPanelAction;

$panel = new Panel();
$action = new ApplyMetatagToPanelAction();
$panel = $action->execute($panel);
```

## Metodi

### execute(Panel $panel): Panel
Applica i metatag al panel Filament.

#### Parametri
- `$panel`: Il panel Filament da configurare

#### Return
- `Panel`: Il panel configurato con i metatag

## Gestione Errori
In caso di errore durante l'applicazione dei metatag:
- L'errore viene registrato nel log
- Il panel originale viene restituito senza modifiche
- L'applicazione continua a funzionare

## Collegamenti
- [MetatagData](../datas/MetatagData.md)
- [Filament Panel Documentation](https://filamentphp.com/docs/panels)

## Note
- Questa azione utilizza il trait `QueueableAction` di Spatie
- Tutti i metodi sono fortemente tipizzati per PHPStan livello 10
- La documentazione è mantenuta aggiornata nella cartella docs 