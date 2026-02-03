# ConvertVideoByConvertDataAction

## Panoramica
Azione per la conversione di video utilizzando FFMpeg e dati di conversione specificati.

## Caratteristiche
- Conversione video con FFMpeg
- Supporto per formati video personalizzati
- Monitoraggio del progresso della conversione
- Gestione delle code con QueueableAction
- Validazione dei dati di input

## Miglioramenti PHPStan Livello 9
Le seguenti modifiche sono state apportate per soddisfare PHPStan livello 9:

1. Tipizzazione stretta dei parametri
2. Gestione type-safe dei formati video
3. Validazione dei dati di input
4. Gestione corretta delle eccezioni
5. Implementazione delle interfacce FFMpeg

## Metodo Execute
```php
public function execute(ConvertData $data): string
```

### Parametri
- `$data`: Oggetto ConvertData contenente:
  - `disk`: Il disco di storage
  - `file`: Il file video da convertire
  - `format`: Il formato di output desiderato

### Return
- `string`: Il percorso del file convertito

### Eccezioni
- `\Exception`: Se il file non esiste o il nome del file convertito non è specificato

## Best Practices
1. Validare sempre i dati di input
2. Utilizzare formati video appropriati
3. Gestire il progresso della conversione
4. Implementare logging appropriato
5. Gestire le eccezioni FFMpeg

## Esempi di Utilizzo
```php
use Modules\Media\Actions\Video\ConvertVideoByConvertDataAction;
use Modules\Media\Datas\ConvertData;

$data = new ConvertData([
    'disk' => 'local',
    'file' => 'videos/input.mp4',
    'format' => 'mp4'
]);

$action = new ConvertVideoByConvertDataAction();
$convertedPath = $action->execute($data);
```

[Torna alla documentazione Media](/docs/modules/module_media.md#actions) 