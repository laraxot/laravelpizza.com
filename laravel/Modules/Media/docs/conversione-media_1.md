# Conversione Media

## Risorse Utili

### Conversione Video
- [Guida alla conversione video in Laravel](https://tobyokeke.com/how-to-convert-uploaded-videos-in-laravel-1d605baf5033)
- [Conversione di file video di grandi dimensioni con PHP FFmpeg](https://stackoverflow.com/questions/76302960/convert-large-video-files-with-php-ffmpeg)
- [Esempio di implementazione FFmpeg](https://gist.github.com/Nks/b3b1cd7398a560eda8ddb7e37901869e?permalink_comment_id=3450216)

### Streaming e Gestione File Temporanei
- [Gestione directory temporanee in Laravel](https://laravel-news.com/temporary-directory)

```php
use Illuminate\Support\Facades\Http;
use Spatie\TemporaryDirectory\TemporaryDirectory;

// Normalizzazione URL video e ottenimento filename
$videoUrl = str($videoUrl)->replace(' ', '%20');
$tmpFile = $videoUrl->afterLast('/');

// Creazione directory temporanea e download file
$tmpDir = TemporaryDirectory::make();
$tmpPath = $tmpDir->path($tmpFile);
Http::sink($tmpPath)->throw()->get($videoUrl->toString());

// Elaborazione file
// ...

// Pulizia file temporaneo
$tmpFile->delete();
```

### AWS MediaConvert
- [Lambda Transcoder per AWS](https://github.com/kefabean/lambda-transcoder/blob/master/transcoder/transcode.js)

## Note Tecniche

### Filtri Audio
Per il rilevamento del volume audio:
```php
->addFilter(['-filter:a', 'volumedetect', '-f', 'null'])
``` 