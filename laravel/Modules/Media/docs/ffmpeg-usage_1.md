# Utilizzo di Laravel-FFMpeg nel Modulo Media

## Introduzione

Il modulo Media utilizza la libreria [Laravel-FFMpeg](https://github.com/protonemedia/laravel-ffmpeg) versione 8.7.1 per gestire la conversione e la manipolazione di file video e audio. Questa libreria è un wrapper intorno a FFmpeg che si integra perfettamente con Laravel, sfruttando il sistema di gestione dei file di Laravel.

## Struttura e Namespace

La versione 8.7.1 di Laravel-FFMpeg utilizza i seguenti namespace principali:

```php
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use ProtoneMedia\LaravelFFMpeg\MediaOpener;
use ProtoneMedia\LaravelFFMpeg\Exporters\MediaExporter;
use ProtoneMedia\LaravelFFMpeg\Exporters\EncodingException;
```

**Nota importante**: Nelle versioni precedenti, alcune classi come `MediaExporter` si trovavano nel namespace `FFMpeg`. Nella versione 8.7.1, queste classi sono state spostate nel namespace `Exporters`.

## Funzionalità Principali

### Conversione di Video

Il modulo Media fornisce la classe `ConvertVideoAction` per convertire facilmente i video da un formato all'altro:

```php
// Iniezione dell'azione in un controller o in un altro servizio
public function __construct(ConvertVideoAction $convertVideoAction)
{
    $this->convertVideoAction = $convertVideoAction;
}

// Utilizzo dell'azione
$videoUrl = $this->convertVideoAction->execute(
    'public',          // nome del disco di storage
    'input/video.mp4', // percorso del file video di input
    'output/video.mp4' // percorso del file video di output
);
```

### Processo di Conversione

La conversione di un video utilizza il seguente flusso:

1. Inizializzazione con `FFMpeg::fromDisk($disk)`
2. Apertura del file con `open($filePath)`
3. Preparazione per l'esportazione con `export()`
4. Configurazione del formato di output
5. Impostazione del disco di output con `toDisk($disk)`
6. Impostazione del formato di output con `inFormat($format)`
7. Salvataggio del file convertito con `save($outputPath)`

## Gestione degli Errori

Laravel-FFMpeg fornisce la classe `EncodingException` per gestire le eccezioni durante il processo di encoding. Questa classe estende `FFMpeg\Exception\RuntimeException` e fornisce metodi utili come `getCommand()` e `getErrorOutput()` per diagnosticare i problemi di conversione.

## Esempio di Utilizzo Avanzato

Per implementare funzionalità più avanzate come l'elaborazione di video HLS (HTTP Live Streaming), il watermarking o l'estrazione di frame, consulta la [documentazione ufficiale](https://github.com/protonemedia/laravel-ffmpeg) della libreria.

### Estrazione di Frame da un Video

```php
FFMpeg::fromDisk('videos')
    ->open('video.mp4')
    ->getFrameFromSeconds(10)
    ->export()
    ->toDisk('thumbnails')
    ->save('frame.png');
```

### Applicazione di Filtri

```php
FFMpeg::fromDisk('videos')
    ->open('video.mp4')
    ->addFilter(function ($filters) {
        $filters->resize(new \FFMpeg\Coordinate\Dimension(640, 480));
    })
    ->export()
    ->toDisk('converted_videos')
    ->inFormat(new \FFMpeg\Format\Video\X264)
    ->save('resized_video.mp4');
```

## Configurazione

La configurazione di Laravel-FFMpeg si trova nel file `config/laravel-ffmpeg.php`. Questo file viene pubblicato durante l'installazione della libreria.

## Risoluzione dei Problemi Comuni

### Errore: Classe non trovata

Se ricevi un errore "Class not found" per classi come `MediaExporter`, verifica di utilizzare il namespace corretto. In Laravel-FFMpeg 8.7.1, molte classi sono state spostate in namespace specifici come `Exporters`.

### Errore: Encoding Failed

Se la conversione fallisce, utilizza i metodi `getCommand()` e `getErrorOutput()` dell'eccezione `EncodingException` per diagnosticare il problema:

```php
try {
    // codice di conversione
} catch (EncodingException $e) {
    $command = $e->getCommand();    // comando FFmpeg eseguito
    $errorLog = $e->getErrorOutput(); // output completo dell'errore
}
```

## Risorse Utili

- [Documentazione ufficiale di Laravel-FFMpeg](https://github.com/protonemedia/laravel-ffmpeg)
- [Documentazione di FFmpeg](https://ffmpeg.org/documentation.html)
- [Articolo: How to use FFmpeg in your Laravel projects](https://protone.media/en/blog/how-to-use-ffmpeg-in-your-laravel-projects) 
