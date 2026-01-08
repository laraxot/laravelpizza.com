# Risoluzione dei Conflitti Git nel Modulo Media

## Panoramica

Questo documento descrive i conflitti di merge Git risolti nel modulo Media e fornisce esempi delle soluzioni adottate. La risoluzione dei conflitti è stata effettuata seguendo le linee guida generali del progetto, con particolare attenzione alla tipizzazione forte, alla documentazione completa e alla coerenza del codice.

## Collegamenti con la Documentazione Principale

Per una panoramica generale sulla risoluzione dei conflitti Git nel progetto, consultare:

- [Risoluzione Conflitti Git](../../../../docs/risoluzione_conflitti_git.md)
- [Report completo di intervento](../../../../docs/logs/conflict_resolution_report.md)
- [Gestione Git con Script Bash](../../../../docs/bashscripts/gestione_git.md)

## Collegamenti alle Risoluzioni Specifiche

- [Risoluzione conflitto VideoEntry](./risoluzione_conflitti_video_entry.md)
- [Risoluzione conflitto MediaConvertResource](../../../../docs/media_convert_resource_conflict.md)

## File Risolti

### 1. TemporaryUploadPathGenerator.php

**Problema**: Conflitto nella definizione dei metodi e nella gestione dei percorsi dei file temporanei.

**Soluzione**: È stata mantenuta l'implementazione più recente con percorsi basati su ID e prefissi configurabili, aggiungendo documentazione PHPDoc completa.

```php
/**
 * Ottiene un percorso base univoco per il media dato.
 *
 * @param \Modules\Media\Models\Media $media Il modello media per cui generare il percorso base
 */
protected function getBasePath(Media $media): string
{
    Assert::string($prefix = config('media-library.prefix', ''));
    Assert::string($id = $media->getKey());
    $key = md5($media->uuid.$id);

    if ($prefix !== '') {
        return $prefix.'/'.$key;
    }

    return $key;
}
```

### 2. ConvertVideoByMediaConvertAction.php

**Problema**: Conflitto nell'implementazione del metodo `execute()` con differenze nel ritorno della funzione e nella gestione delle notifiche.

**Soluzione**: È stata combinata l'implementazione che include le notifiche Filament con la documentazione PHPDoc completa e il controllo degli errori più dettagliato.

```php
/**
 * Esegue la conversione del video.
 *
 * @param ConvertData $data I dati di configurazione per la conversione
 * @param MediaConvert $record Il record MediaConvert che tiene traccia della conversione
 * 
 * @throws \Exception Se il file non esiste o se mancano parametri essenziali
 * 
 * @return string|null L'URL del file convertito o null in caso di errore
 */
public function execute(ConvertData $data, MediaConvert $record): ?string
{
    $starting_time = microtime(true);
    
    if (!$data->exists()) {
        throw new \Exception('Il file non esiste');
    }

    // Resto dell'implementazione...
}
```

### 3. MediaConvert.php

**Problema**: Conflitto nei metodi getter che accedono alle proprietà del media collegato.

**Soluzione**: È stata adottata la sintassi con l'operatore di accesso sicuro alle proprietà nullable (`?->`) per una maggiore leggibilità e robustezza, aggiungendo documentazione PHPDoc chiara.

```php
/**
 * Ottiene il disco di storage dal media collegato.
 */
public function getDiskAttribute(?string $value): ?string
{
    return $this->media?->disk;
}

/**
 * Ottiene il percorso del file originale dal media collegato.
 */
public function getFileAttribute(?string $value): ?string
{
    return $this->media?->id.'/'.$this->media?->file_name;
}
```

### 4. ConvertVideoByConvertDataAction.php

**Problema**: Conflitto nell'implementazione del metodo principale con differenze nella gestione dell'output e nelle notifiche.

**Soluzione**: È stata integrata la versione con le notifiche Filament e il tracciamento del progresso, mantenendo i controlli di validità più rigorosi.

### 5. SubtitleService.php

**Problema**: Conflitto nella modalità di aggiornamento del modello Eloquent nel metodo `upateModel()`. Le versioni in conflitto differivano nella gestione dell'assegnazione e nell'utilizzo di `tap($this->model)->update($up)`.

**Intento funzionale**: Garantire che il modello venga aggiornato in modo atomico e che l'istanza aggiornata venga sempre assegnata correttamente alla proprietà. L'obiettivo è mantenere la robustezza, evitare duplicazioni e assicurare coerenza con il resto della codebase.

**Decisione architetturale**: È stata adottata la versione che utilizza `tap($this->model)->update($up)`, eliminando linee ridondanti e mantenendo lo stile coerente. Questa scelta garantisce che l'oggetto model sia sempre aggiornato e pronto per un utilizzo successivo.

Per approfondimenti generali sulle strategie di risoluzione dei conflitti, fare riferimento alla [documentazione centrale](../../../../docs/risoluzione_conflitti_git.md).

---

**Collegamento bidirezionale:** questo file è referenziato anche nella documentazione principale in `/docs/risoluzione_conflitti_git.md`.

```php
/**
 * @return array<int, array<string, float|int|string|mixed>>
 *
 * @psalm-return list{0?: array{sentence_i: int<0, max>, item_i: int<0, max>, start: float|int, end: float|int, time: string, text: mixed},...}
 */
public function getFromXml(): array
{
    // Implementazione...
}
```

**Problema**: Conflitto nella definizione dei tipi di ritorno PHPDoc per il metodo `getFromXml()` con diverse versioni di tipizzazione dei dati.

**Soluzione**: È stata adottata la versione con la tipizzazione più dettagliata e completa, preservando anche il commento psalm che fornisce informazioni più specifiche sulla struttura dell'array.

```php
/**
 * @return array<int, array{
 *  start: int,
 *  end: int,
 *  text: string,
 * }>
 *
 * @psalm-return array<int, array{
 *  start: int,
 *  end: int,
 *  text: string,
 * }>
 */
public function getFromXml($xmlFile)
{
    // Implementazione...
}
```

### 6. ConvertVideoAction.php

**Problema**: Conflitto nella gestione degli import e nella struttura del metodo execute. Le versioni in conflitto differivano nell'ordine degli import e nella presenza di linee vuote superflue tra i blocchi di codice.

**Intento funzionale**: Garantire chiarezza e leggibilità, mantenendo la coerenza con il resto del modulo e assicurando che la logica di conversione video sia atomica e facilmente manutenibile.

**Decisione architetturale**: È stata adottata la versione che mantiene gli import ordinati e privi di duplicazioni, eliminando linee vuote inutili e assicurando che la logica del metodo sia compatta e leggibile. Nessuna modifica funzionale è stata introdotta, ma solo miglioramenti di stile e mantenibilità.

Per approfondimenti generali sulle strategie di risoluzione dei conflitti, fare riferimento alla [documentazione centrale](../../../../docs/risoluzione_conflitti_git.md).

---

**Collegamento bidirezionale:** questo file è referenziato anche nella documentazione principale in `/docs/risoluzione_conflitti_git.md`.

### 6. VideoStream.php

**Problema**: Conflitto nella modalità di restituzione del percorso del file convertito. Le versioni in conflitto differivano nell'utilizzo di `Storage::disk()->url()` vs `Storage::disk()->path()`.

**Intento funzionale**: Standardizzare la modalità di restituzione dei percorsi file in tutto il modulo Media.

**Decisione architetturale**: È stata adottata la versione che utilizza `Storage::disk($disk_mp4)->path($file_new)` per mantenere coerenza con le altre azioni di conversione e per evitare la generazione di URL quando non necessaria.

Per approfondimenti generali sulle strategie di risoluzione dei conflitti, fare riferimento alla [documentazione centrale](../../../../docs/risoluzione_conflitti_git.md).

### 7. VideoStream.php

**Problema**: Conflitto nella costruzione e inizializzazione del servizio VideoStream, con differenze nell'implementazione delle tipizzazioni e nel metodo di ottenere il MIME type.

**Soluzione**: È stata adottata la versione più robusta che determina il MIME type in base all'estensione del file anziché utilizzare il metodo `mimeType()` di Laravel. Questo approccio è più efficiente e riduce la dipendenza da metodi esterni potenzialmente instabili.

```php
/**
 * Initialize the video stream.
 *
 * @param  string $disk  The disk storage name
 * @param  string $path  The path to the video file
 *
 * @throws Exception If the file does not exist or other errors
 */
public function __construct(string $disk, string $path)
{
    $filesystem = Storage::disk($disk);

    if (! $filesystem->exists($path)) {
        throw new Exception("File does not exist at path: {$path}");
    }

    // Determina il MIME type in base all'estensione del file
    $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $mime = $this->mimeTypes[$extension] ?? 'application/octet-stream';

    // Resto dell'implementazione...
}
```

### 8. MediaResource.php

**Problema**: Conflitto nella struttura dello schema del form per la risorsa Media, con differenze nell'uso di chiavi nominate vs componenti Filament direttamente.

**Soluzione**: È stata adottata la versione più moderna e conforme alle convenzioni Filament, utilizzando i componenti direttamente senza chiavi nominate, mantenendo l'icona di navigazione e le funzionalità complete.

```php
protected static ?string $model = Media::class;
protected static ?string $navigationIcon = 'fas-photo-film';

/**
 * @return array<string, \Filament\Forms\Components\Component>
 */
public static function getFormSchema(): array
{
    return [
        FileUpload::make('file')
            ->hint(static::trans('fields.file_hint'))
            ->storeFileNamesIn('original_file_name')
            ->visibility('private')
            ->required()
            ->columnSpanFull(),
        Radio::make('attachment_type'),
        TextInput::make('name')
            ->translateLabel()
            ->hint(static::trans('fields.name.hint'))
            ->autocomplete(false)
            ->maxLength(255)
            ->columnSpanFull(),
    ];
}
```

### 9. test.blade.php

**Problema**: Conflitto nelle variabili utilizzate nel template Blade per accedere alle proprietà degli oggetti, con errori di sintassi nelle proprietà.

**Soluzione**: È stata adottata la versione che utilizza correttamente le proprietà dell'oggetto con il riferimento `->id` invece della versione incompleta `->` che causava errori di sintassi.

```blade
<h4>[{{ $change_cat->id }}]{{ $change_cat->title }}</h4>
@foreach ($changes->where('id_cat', $change_cat->id) as $change)
    <h5>[{{ $change->id }}]{{ $change->title }}</h5>
    
    <div class="btn-group btn-group-toggle">
        <x-filament-forms::field-wrapper.label class="btn btn-danger">
            <input type="radio" wire:model="qty.{{ $change_cat->id }}.{{ $change->id }}"
                name="qty[{{ $change_cat->id }}][{{ $change->id }}]" autocomplete="off" value="-1">
            @if (isset($qty[$change_cat->id][$change->id]) && $qty[$change_cat->id][$change->id] == -1)
                [-]
            @else
                -
            @endif
        </label>
        <!-- Resto dell'implementazione... -->
    </div>
@endforeach
```

### 10. MediaConvertResource.php

**Problema**: Conflitto tra tre versioni della stessa risorsa Filament, con differenze nell'implementazione dello schema del form e nella navigazione.

**Soluzione**: È stata adottata la versione che segue le best practice Filament più recenti, unendo la completezza della documentazione PHPDoc di una versione con la struttura moderna della definizione del form dell'altra versione.

```php
protected static ?string $model = MediaConvert::class;
protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

/**
 * Restituisce lo schema del form per la risorsa MediaConvert.
 * @return array<int, \Filament\Forms\Components\Component>
 */
public static function getFormSchema(): array
{
    return [
        Radio::make('format')
            ->options([
                'webm' => 'webm',
                // 'webm02' => 'webm02',
            ])
            ->inline()
            ->inlineLabel(false),
        Radio::make('codec_video')
            ->options([
                'libvpx-vp9' => 'libvpx-vp9',
                'libvpx-vp8' => 'libvpx-vp8',
            ])
            ->inline()
            ->inlineLabel(false),
        // Resto dell'implementazione...
    ];
}
```

Per dettagli completi sulla risoluzione di MediaConvertResource, vedere [documentazione dedicata](../../../../docs/media_convert_resource_conflict.md).

### 11. Merge.php

**Problema**: Conflitti storici nella gestione dei driver di Intervention Image, nella modalità di composizione delle immagini e nella gestione dei parametri di input/output.

**Intento funzionale**: Garantire una composizione orizzontale delle immagini robusta, efficiente e compatibile con la pipeline Media, mantenendo la massima leggibilità e manutenibilità del codice.

**Decisione architetturale**: È stata adottata la versione che utilizza il driver Gd di Intervention Image, con gestione esplicita delle dimensioni della canvas e posizionamento progressivo delle immagini. La soluzione mantiene la compatibilità con l'ecosistema Laravel e assicura la massima chiarezza del flusso di composizione.

Per approfondimenti generali sulle strategie di risoluzione dei conflitti, fare riferimento alla [documentazione centrale](../../../../docs/risoluzione_conflitti_git.md).

---

**Collegamento bidirezionale:** questo file è referenziato anche nella documentazione principale in `/docs/risoluzione_conflitti_git.md`.

### 10. VideoEntry.php

**Decisione architetturale**: È stata adottata la versione che utilizza il driver Gd di Intervention Image, con gestione esplicita delle dimensioni della canvas e posizionamento progressivo delle immagini. La soluzione mantiene la compatibilità con l'ecosistema Laravel e assicura la massima chiarezza del flusso di composizione.

Per approfondimenti generali sulle strategie di risoluzione dei conflitti, fare riferimento alla [documentazione centrale](../../../../docs/risoluzione_conflitti_git.md).

### 12. VideoEntry.php

**Problema**: Conflitto nell'implementazione del componente VideoEntry, con differenze nella gestione dei tipi e nella formattazione.

**Soluzione**: È stata adottata l'implementazione più robusta con controlli di tipo completi e documentazione dettagliata, mantenendo la coerenza stilistica senza linee vuote superflue. Per dettagli completi, vedere [documentazione dedicata](./risoluzione_conflitti_video_entry.md).

## Principi di Risoluzione Applicati

Nella risoluzione dei conflitti sono stati applicati i seguenti principi:

1. **Tipizzazione Forte**: Mantenere e migliorare la tipizzazione dei parametri e dei valori di ritorno.
2. **Documentazione Completa**: Aggiungere o preservare la documentazione PHPDoc dettagliata.
3. **Robustezza**: Preferire implementazioni che gestiscono correttamente i casi limite.
4. **Compatibilità**: Assicurare la compatibilità con il resto del sistema, in particolare con Filament.
5. **Modernità**: Adottare funzionalità moderne di PHP come l'operatore `?->`.
6. **Leggibilità**: Migliorare la leggibilità del codice con nomi descrittivi e commenti utili.

## Verifica e Test

Dopo la risoluzione, i file sono stati verificati con:

1. **Analisi Statica**: Esecuzione di PHPStan per identificare errori di tipo.
2. **Test Funzionali**: Verifica delle funzionalità principali tramite test manuali.

## Best Practices Future

Per prevenire o gestire meglio i conflitti Git in futuro:

1. **Lavoro su File Separati**: Evitare modifiche simultanee agli stessi file da parte di diversi sviluppatori.
2. **Pull Frequenti**: Aggiornare regolarmente la propria copia di lavoro con gli ultimi cambiamenti.
3. **Commit Piccoli e Frequenti**: Preferire commit più piccoli e ben documentati.
4. **Documentazione**: Documentare le decisioni prese durante la risoluzione dei conflitti.
5. **Standardizzazione**: Seguire le convenzioni di codice e documentazione del progetto.

## Riferimenti

- [Documentazione Laravel FFMpeg](https://github.com/protonemedia/laravel-ffmpeg)
- [PHP 8.x Nullsafe Operator](https://www.php.net/manual/en/migration80.new-features.php#migration80.new-features.nullsafe-operator)

- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)

## Conflitti nell'integrazione FFmpeg (15/06/2024)

I problemi di conflitto nei file relativi all'integrazione di FFmpeg erano principalmente legati a:

1. **Duplicazione di importazioni**: Diversi namespace erano importati più volte.
2. **Incoerenza nelle restituzioni**: Alcune azioni convertivano i path in URL, altre restituivano solo il path.
3. **Spazi bianchi e linee vuote eccessive**: Lo stile di codice era inconsistente.

### Azioni intraprese

#### 1. File `Merge.php`
- Rimossi duplicati delle importazioni
- Eliminati spazi e linee vuote eccessive
- Mantenuta una struttura coerente con il pattern utilizzato in altre azioni

#### 2. File `ConvertVideoAction.php`
- Ordinato e deduplicato le importazioni
- Standardizzato a `Storage::disk($disk_mp4)->path($file_new)` per coerenza
- Uniformato lo stile di codice

### Documentazione

Per maggiori dettagli, consultare il [documento dedicato alla risoluzione dei conflitti FFmpeg](risoluzione_conflitti_ffmpeg.md).
