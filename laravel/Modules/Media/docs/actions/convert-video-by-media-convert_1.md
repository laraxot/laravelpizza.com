# ConvertVideoByMediaConvertAction

## Panoramica
Azione per la conversione di video utilizzando FFMpeg con tracciamento del progresso tramite il modello MediaConvert.

## Caratteristiche
- Conversione video con FFMpeg
- Tracciamento del progresso in tempo reale
- Notifiche Filament integrate
- Logging dettagliato
- Gestione delle code con QueueableAction
- Validazione dei dati di input

## Miglioramenti PHPStan Livello 9
Le seguenti modifiche sono state apportate per soddisfare PHPStan livello 9:

1. Tipizzazione stretta dei parametri
2. Gestione type-safe dei formati video
3. Validazione dei dati di input in metodo dedicato
4. Gestione del progresso in metodo dedicato
5. Documentazione PHPDoc completa

## Metodo Execute
```php
public function execute(ConvertData $data, MediaConvert $record): string
```

### Parametri
- `$data`: Oggetto ConvertData contenente:
  - `disk`: Il disco di storage
  - `file`: Il file video da convertire
  - `format`: Il formato di output desiderato
- `$record`: Modello MediaConvert per il tracciamento del progresso

### Return
- `string`: Il percorso del file convertito

### Eccezioni
- `\Exception`: Se il file non esiste o il nome del file convertito non è specificato

## Tracciamento del Progresso
Il progresso della conversione viene tracciato attraverso:
1. Aggiornamento del record MediaConvert
2. Logging con Laravel Log
3. Notifiche Filament (quando disponibili)

## Best Practices
1. Validare sempre i dati di input
2. Utilizzare formati video appropriati
3. Monitorare il progresso della conversione
4. Implementare logging appropriato
5. Gestire le eccezioni FFMpeg

## Esempi di Utilizzo
```php
use Modules\Media\Actions\Video\ConvertVideoByMediaConvertAction;
use Modules\Media\Datas\ConvertData;
use Modules\Media\Models\MediaConvert;

$data = new ConvertData([
    'disk' => 'local',
    'file' => 'videos/input.mp4',
    'format' => 'mp4'
]);

$record = MediaConvert::create([
    'converted_file' => 'videos/output.mp4',
    'status' => 'pending'
]);

$action = new ConvertVideoByMediaConvertAction();
$convertedPath = $action->execute($data, $record);
```

[Torna alla documentazione Media](/docs/modules/module_media.md#actions) 