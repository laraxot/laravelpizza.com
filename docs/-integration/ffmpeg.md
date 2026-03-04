# ffmpeg

## Integrazione FFmpeg in Laraxot/<nome progetto>

Nel framework Laraxot/<nome progetto> l'integrazione con FFmpeg **non è mai diretta** (API C o comandi shell), ma passa sempre attraverso il pacchetto Laravel:

- Repository ufficiale: <https://github.com/protonemedia/laravel-ffmpeg>
- Guida principale: <https://protone.media/en/blog/how-to-use-ffmpeg-in-your-laravel-projects>

Il modulo di riferimento per tutta la business logic media è `Modules/Media`:

- `Modules/Media/docs/ffmpeg-integration.md` → panoramica integrazione e setup
- `Modules/Media/docs/ffmpeg-usage.md` → pattern canonici `FFMpeg::fromDisk()->open()->export()->toDisk()->inFormat()->save()`

### Regole architetturali Xot

- Nessun `shell_exec` / `proc_open` / comandi FFmpeg raw in nessun modulo.
- Tutte le conversioni, estrazioni frame, HLS e watermark passano da azioni del modulo Media (Spatie QueueableActions).
- I moduli consumer (es. `Meetup`, `Cms`) parlano solo con azioni/DTO di Media, mai con la facade `FFMpeg` direttamente.

## Link di studio aggiuntivi

- <https://quantizd.com/transcoding-videos-using-ffmpeg-and-laravel-queues/>
- <https://blog.webnersolutions.com/compress-videos-using-ffmpeg-laravel-shell_exec-method/>
- <https://github.com/waleedahmad/laravel-stream>
- <https://video.aminyazdanpanah.com/start>
- <https://github.com/bbc/html5-video-compositor>
