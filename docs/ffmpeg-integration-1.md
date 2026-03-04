# Integrazione di FFmpeg nel Modulo Media

Questa guida documenta l'integrazione del pacchetto [protonemedia/laravel-ffmpeg](https://github.com/protonemedia/laravel-ffmpeg) all'interno del modulo Media, basandosi sulle seguenti risorse:

- GitHub: https://github.com/protonemedia/laravel-ffmpeg
- Protone Media Blog: https://protone.media/en/blog/how-to-use-ffmpeg-in-your-laravel-projects
- Laracasts Discuss: https://laracasts.com/discuss/channels/laravel/laravel-ffmpeg
- Laravel News: https://laravel-news.com/laravel-ffmpeg-tools
- Medium: https://medium.com/@rlmc/converting-videos-with-ffmpeg-and-laravel-workflow-eb1d8eb0ef7b
- Laracasts Discuss: https://laracasts.com/discuss/channels/laravel/in-regards-to-laravel-ffmpeg
- StackOverflow: https://stackoverflow.com/questions/65087821/how-to-use-or-import-ffmpeg-in-a-laravel-controller
- ElegantLaravel: https://www.elegantlaravel.com/article/integrate-ffmpeg-into-laravel-a-step-by-step-guide
- StackOverflow: https://stackoverflow.com/questions/59264745/how-can-i-use-ffmpeg-in-laravel-6-with-this-config

## 1. Installazione
```bash
composer require protonemedia/laravel-ffmpeg
php artisan vendor:publish --provider="ProtoneMedia\LaravelFFMpeg\Support\ServiceProvider"
```

## 2. Configurazione
Il file di configurazione `config/laravel-ffmpeg.php` permette di definire i dischi, i formati e le opzioni di conversione.

## 3. Utilizzo Base
```php
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

FFMpeg::open('path/to/video.mp4')
    ->export()
    ->toDisk('videos')
    ->inFormat(new \ProtoneMedia\LaravelFFMpeg\Format\Video\X264)
    ->save('exported-video.mp4');
```

### Esempio in Action
```php
namespace Modules\Media\Actions;

use Spatie\QueueableAction\QueueableAction;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ConvertVideoAction extends QueueableAction
{
    public function handle(string $path): void
    {
        FFMpeg::open($path)
            ->export()
            ->toDisk('s3')
            ->inFormat(new \ProtoneMedia\LaravelFFMpeg\Format\Audio\Mp3)
            ->save($this->getOutputPath($path));
    }
}
```

## 4. Best Practices
- Eseguire le conversioni in background con Spatie QueueableActions.
- Gestire le eccezioni e monitorare il progresso.
- Scegliere formati e bitrate adeguati.

## 5. Risorse Esterne

- **GitHub**: [protonemedia/laravel-ffmpeg](https://github.com/protonemedia/laravel-ffmpeg) – Codice sorgente e documentazione ufficiale.
- **Protone Media Blog**: Guida dettagliata all'uso in Laravel con esempi pratici (https://protone.media/en/blog/how-to-use-ffmpeg-in-your-laravel-projects).
- **Laracasts Discuss (1)**: Discussione su import e utilizzo di FFMpeg in Laravel (https://laracasts.com/discuss/channels/laravel/laravel-ffmpeg).
- **Laravel News**: Panoramica degli strumenti Laravel FFmpeg Tools (https://laravel-news.com/laravel-ffmpeg-tools).
- **Medium**: Workflow di conversione video con job in Laravel (https://medium.com/@rlmc/converting-videos-with-ffmpeg-and-laravel-workflow-eb1d8eb0ef7b).
- **Laracasts Discuss (2)**: Approfondimenti e best practice per l'integrazione (https://laracasts.com/discuss/channels/laravel/in-regards-to-laravel-ffmpeg).
- **StackOverflow (1)**: Esempio di import in controller con facade FFMpeg (https://stackoverflow.com/questions/65087821/how-to-use-or-import-ffmpeg-in-a-laravel-controller).
- **ElegantLaravel**: Guida step-by-step all'integrazione nel progetto (https://www.elegantlaravel.com/article/integrate-ffmpeg-into-laravel-a-step-by-step-guide).
- **StackOverflow (2)**: Configurazioni specifiche per Laravel 6 (https://stackoverflow.com/questions/59264745/how-can-i-use-ffmpeg-in-laravel-6-with-this-config).

## Collegamenti Utili
- [Guida GitHub](https://github.com/protonemedia/laravel-ffmpeg)
- [Report PHPStan livello 1](phpstan/level_1.md)
- [Documentazione Modulo Media](module_media.md)
