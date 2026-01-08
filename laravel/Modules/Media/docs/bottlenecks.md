# Colli di Bottiglia e Soluzioni - Modulo Media

## Panoramica
Questo documento identifica i principali colli di bottiglia nel modulo Media e fornisce soluzioni dettagliate passo per passo per risolverli.

## 1. Elaborazione Sincrona delle Immagini

### Problema
Il modulo Media elabora le immagini in modo sincrono durante l'upload, causando tempi di attesa lunghi per gli utenti e possibili timeout per immagini di grandi dimensioni.

### Impatto
- Tempi di attesa elevati durante l'upload di immagini
- Timeout per immagini di grandi dimensioni
- Utilizzo eccessivo di CPU durante l'elaborazione
- Esperienze utente degradate durante upload multipli

### Soluzione Passo-Passo

1. **Implementare Elaborazione Asincrona con Code**

```php
// In Modules\Media\Jobs\ProcessImage.php
namespace Modules\Media\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Media\Models\Media;
use Intervention\Image\Facades\Image;

class ProcessImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $mediaId;
    protected $formats;
    
    public function __construct($mediaId, array $formats = [])
    {
        $this->mediaId = $mediaId;
        $this->formats = $formats ?: config('media.formats');
        $this->queue = 'media';
    }
    
    public function handle()
    {
        $media = Media::findOrFail($this->mediaId);
        $originalPath = storage_path('app/public/' . $media->path);
        
        if (!file_exists($originalPath)) {
            return;
        }
        
        foreach ($this->formats as $format => $dimensions) {
            $this->processFormat($media, $format, $dimensions, $originalPath);
        }
        
        // Aggiorna lo stato del media
        $media->update(['status' => 'processed']);
    }
    
    protected function processFormat($media, $format, $dimensions, $originalPath)
    {
        $width = $dimensions['width'] ?? null;
        $height = $dimensions['height'] ?? null;
        $quality = $dimensions['quality'] ?? 90;
        
        $formatPath = $this->getFormatPath($media->path, $format);
        $fullPath = storage_path('app/public/' . $formatPath);
        
        // Crea la directory se non esiste
        $directory = dirname($fullPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        
        // Elabora l'immagine
        $image = Image::make($originalPath);
        
        if ($width && $height) {
            $image->fit($width, $height);
        } elseif ($width) {
            $image->widen($width, function ($constraint) {
                $constraint->upsize();
            });
        } elseif ($height) {
            $image->heighten($height, function ($constraint) {
                $constraint->upsize();
            });
        }
        
        $image->save($fullPath, $quality);
        
        // Salva il percorso del formato nel database
        $media->formats()->updateOrCreate(
            ['format' => $format],
            ['path' => $formatPath]
        );
    }
    
    protected function getFormatPath($originalPath, $format)
    {
        $pathInfo = pathinfo($originalPath);
        return $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '_' . $format . '.' . $pathInfo['extension'];
    }
}
```

2. **Modificare il Controller di Upload**

```php
// In Modules\Media\Http\Controllers\MediaController.php
namespace Modules\Media\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Media\Models\Media;
use Modules\Media\Jobs\ProcessImage;

class MediaController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:10240', // 10MB max
        ]);
        
        $file = $request->file('file');
        $path = $file->store('media', 'public');
        
        // Salva il record nel database con stato 'pending'
        $media = Media::create([
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'status' => 'pending',
        ]);
        
        // Dispatch del job per l'elaborazione asincrona
        ProcessImage::dispatch($media->id)->onQueue('media');
        
        return response()->json([
            'id' => $media->id,
            'name' => $media->name,
            'status' => 'pending',
            'message' => 'Upload completato. L\'immagine sarà elaborata a breve.',
        ]);
    }
    
    public function status($id)
    {
        $media = Media::with('formats')->findOrFail($id);
        
        return response()->json([
            'id' => $media->id,
            'name' => $media->name,
            'status' => $media->status,
            'formats' => $media->formats->pluck('path', 'format'),
        ]);
    }
}
```

3. **Creare un Modello per i Formati**

```php
// In Modules\Media\Models\MediaFormat.php
namespace Modules\Media\Models;

use Illuminate\Database\Eloquent\Model;

class MediaFormat extends Model
{
    protected $fillable = [
        'media_id', 'format', 'path',
    ];
    
    public function media()
    {
        return $this->belongsTo(Media::class);
    }
}
```

4. **Aggiornare il Modello Media**

```php
// In Modules\Media\Models\Media.php
namespace Modules\Media\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'name', 'path', 'mime_type', 'size', 'status',
    ];
    
    public function formats()
    {
        return $this->hasMany(MediaFormat::class);
    }
    
    public function getUrl($format = null)
    {
        if (!$format) {
            return asset('storage/' . $this->path);
        }
        
        $format = $this->formats()->where('format', $format)->first();
        
        if (!$format) {
            return asset('storage/' . $this->path);
        }
        
        return asset('storage/' . $format->path);
    }
}
```

5. **Configurare le Code**

```php
// In config/queue.php
'connections' => [
    // ...
    'database' => [
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
        'after_commit' => false,
    ],
],
```

6. **Creare un Worker Dedicato per le Immagini**

```bash

# Supervisor config (/etc/supervisor/conf.d/laravel-media-worker.conf)
[program:laravel-media-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/base_<nome progetto>/laravel/artisan queue:work database --queue=media --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/html/base_<nome progetto>/laravel/storage/logs/media-worker.log
```

7. **Implementare Interfaccia per Monitoraggio Stato**

```javascript
// In resources/js/components/MediaUploader.vue
<template>
  <div>
    <input type="file" @change="uploadFile" />
    <div v-if="uploading">Uploading...</div>
    <div v-if="processing">
      Processing image...
      <button @click="checkStatus">Check Status</button>
    </div>
    <div v-if="processed">
      <img :src="thumbnailUrl" alt="Thumbnail" />
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      uploading: false,
      processing: false,
      processed: false,
      mediaId: null,
      thumbnailUrl: null,
    };
  },
  methods: {
    async uploadFile(event) {
      const file = event.target.files[0];
      if (!file) return;
      
      this.uploading = true;
      
      const formData = new FormData();
      formData.append('file', file);
      
      try {
        const response = await axios.post('/api/media/upload', formData);
        this.mediaId = response.data.id;
        this.uploading = false;
        this.processing = true;
        
        // Controlla lo stato automaticamente dopo 5 secondi
        setTimeout(() => {
          this.checkStatus();
        }, 5000);
      } catch (error) {
        console.error('Upload failed', error);
        this.uploading = false;
      }
    },
    async checkStatus() {
      if (!this.mediaId) return;
      
      try {
        const response = await axios.get(`/api/media/${this.mediaId}/status`);
        
        if (response.data.status === 'processed') {
          this.processing = false;
          this.processed = true;
          this.thumbnailUrl = `/storage/${response.data.formats.thumbnail}`;
        } else {
          // Ricontrolla dopo 3 secondi
          setTimeout(() => {
            this.checkStatus();
          }, 3000);
        }
      } catch (error) {
        console.error('Status check failed', error);
      }
    },
  },
};
</script>
```

## 2. Storage Inefficiente

### Problema
Il modulo Media memorizza tutti i file in un'unica directory, causando problemi di performance con l'aumentare del numero di file.

### Impatto
- Rallentamento delle operazioni di filesystem con molti file
- Difficoltà nella gestione e backup dei file
- Problemi di scalabilità con l'aumentare dei media

### Soluzione Passo-Passo

1. **Implementare una Struttura di Directory Gerarchica**

```php
// In Modules\Media\Services\MediaStorageService.php
namespace Modules\Media\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class MediaStorageService
{
    public function store(UploadedFile $file, $directory = 'media')
    {
        // Genera un nome file unico
        $filename = $this->generateFilename($file);
        
        // Crea una struttura di directory basata sulla data
        $datePath = date('Y/m/d');
        $relativePath = "{$directory}/{$datePath}";
        
        // Salva il file
        $path = $file->storeAs($relativePath, $filename, 'public');
        
        return $path;
    }
    
    protected function generateFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $uniqueId = Str::random(10);
        
        return "{$name}_{$uniqueId}.{$extension}";
    }
}
```

2. **Modificare il Controller di Upload**

```php
// In Modules\Media\Http\Controllers\MediaController.php
use Modules\Media\Services\MediaStorageService;

class MediaController extends Controller
{
    protected $mediaStorage;
    
    public function __construct(MediaStorageService $mediaStorage)
    {
        $this->mediaStorage = $mediaStorage;
    }
    
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:10240', // 10MB max
        ]);
        
        $file = $request->file('file');
        
        // Utilizza il servizio di storage
        $path = $this->mediaStorage->store($file);
        
        // Salva il record nel database
        $media = Media::create([
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'status' => 'pending',
        ]);
        
        // Dispatch del job per l'elaborazione asincrona
        ProcessImage::dispatch($media->id)->onQueue('media');
        
        return response()->json([
            'id' => $media->id,
            'name' => $media->name,
            'status' => 'pending',
            'message' => 'Upload completato. L\'immagine sarà elaborata a breve.',
        ]);
    }
}
```

3. **Implementare Migrazione per Supportare la Nuova Struttura**

```php
// Crea una migrazione per aggiungere campi utili
php artisan make:migration add_metadata_to_media_table

// Implementazione
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetadataToMediaTable extends Migration
{
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->json('metadata')->nullable()->after('size');
            $table->string('disk')->default('public')->after('path');
            $table->string('directory')->nullable()->after('disk');
            $table->string('filename')->nullable()->after('directory');
        });
    }
    
    public function down()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn(['metadata', 'disk', 'directory', 'filename']);
        });
    }
}
```

4. **Aggiornare il Modello Media**

```php
// In Modules\Media\Models\Media.php
class Media extends Model
{
    protected $fillable = [
        'name', 'path', 'mime_type', 'size', 'metadata', 'disk', 'directory', 'filename', 'status',
    ];
    
    protected $casts = [
        'metadata' => 'array',
    ];
    
    // ...
    
    public function getUrl($format = null)
    {
        if (!$format) {
            return asset('storage/' . $this->path);
        }
        
        $format = $this->formats()->where('format', $format)->first();
        
        if (!$format) {
            return asset('storage/' . $this->path);
        }
        
        return asset('storage/' . $format->path);
    }
    
    public function setMetadataAttribute($value)
    {
        $this->attributes['metadata'] = json_encode($value);
    }
    
    public function getMetadataAttribute($value)
    {
        return json_decode($value, true);
    }
}
```

5. **Implementare un Comando per Migrare i File Esistenti**

```php
// In Modules\Media\Console\Commands\ReorganizeMediaFiles.php
namespace Modules\Media\Console\Commands;

use Illuminate\Console\Command;
use Modules\Media\Models\Media;
use Modules\Media\Services\MediaStorageService;
use Illuminate\Support\Facades\Storage;

class ReorganizeMediaFiles extends Command
{
    protected $signature = 'media:reorganize {--chunk=100}';
    
    protected $description = 'Reorganize media files into a hierarchical structure';
    
    protected $mediaStorage;
    
    public function __construct(MediaStorageService $mediaStorage)
    {
        parent::__construct();
        $this->mediaStorage = $mediaStorage;
    }
    
    public function handle()
    {
        $chunkSize = $this->option('chunk');
        
        Media::where('directory', null)
            ->chunkById($chunkSize, function ($medias) {
                foreach ($medias as $media) {
                    $this->reorganizeMedia($media);
                }
            });
        
        $this->info('Media files reorganized successfully.');
    }
    
    protected function reorganizeMedia(Media $media)
    {
        $oldPath = $media->path;
        
        if (!Storage::disk('public')->exists($oldPath)) {
            $this->warn("File not found: {$oldPath}");
            return;
        }
        
        // Crea nuova struttura di directory basata sulla data di creazione
        $datePath = $media->created_at->format('Y/m/d');
        $directory = "media/{$datePath}";
        
        // Genera un nuovo nome file
        $filename = pathinfo($oldPath, PATHINFO_BASENAME);
        $newPath = "{$directory}/{$filename}";
        
        // Crea la directory se non esiste
        Storage::disk('public')->makeDirectory($directory);
        
        // Sposta il file
        if (Storage::disk('public')->move($oldPath, $newPath)) {
            // Aggiorna il record nel database
            $media->update([
                'path' => $newPath,
                'directory' => $directory,
                'filename' => $filename,
            ]);
            
            $this->info("Moved: {$oldPath} -> {$newPath}");
        } else {
            $this->error("Failed to move: {$oldPath}");
        }
    }
}
```

## 3. Caricamento Inefficiente di Gallerie di Immagini

### Problema
Il modulo Media carica tutte le immagini di una galleria contemporaneamente, causando tempi di caricamento lunghi per gallerie con molte immagini.

### Impatto
- Tempi di caricamento pagina elevati per gallerie con molte immagini
- Utilizzo eccessivo di banda
- Esperienze utente degradate su dispositivi mobili

### Soluzione Passo-Passo

1. **Implementare Caricamento Lazy per Gallerie**

```php
// In Modules\Media\Http\Controllers\GalleryController.php
namespace Modules\Media\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Media\Models\Gallery;

class GalleryController extends Controller
{
    public function show($id)
    {
        $gallery = Gallery::with(['media' => function ($query) {
            $query->select('id', 'name', 'path', 'mime_type')
                  ->where('status', 'processed')
                  ->orderBy('position')
                  ->limit(12); // Carica solo le prime 12 immagini
        }])->findOrFail($id);
        
        return view('media::galleries.show', compact('gallery'));
    }
    
    public function loadMore(Request $request, $id)
    {
        $request->validate([
            'offset' => 'required|integer|min:0',
            'limit' => 'required|integer|min:1|max:24',
        ]);
        
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        
        $gallery = Gallery::findOrFail($id);
        
        $media = $gallery->media()
            ->select('id', 'name', 'path', 'mime_type')
            ->where('status', 'processed')
            ->orderBy('position')
            ->offset($offset)
            ->limit($limit)
            ->get();
        
        return response()->json([
            'media' => $media->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'thumbnail' => $item->getUrl('thumbnail'),
                    'medium' => $item->getUrl('medium'),
                    'large' => $item->getUrl('large'),
                ];
            }),
            'has_more' => $gallery->media()->count() > ($offset + $limit),
        ]);
    }
}
```

2. **Implementare Interfaccia Frontend con Lazy Loading**

```javascript
// In resources/js/components/Gallery.vue
<template>
  <div class="gallery">
    <div class="gallery-grid">
      <div v-for="item in items" :key="item.id" class="gallery-item">
        <img 
          :data-src="item.thumbnail" 
          class="lazyload" 
          :alt="item.name" 
          @click="openLightbox(item)" 
        />
      </div>
    </div>
    
    <div v-if="hasMore" class="load-more">
      <button @click="loadMore" :disabled="loading">
        {{ loading ? 'Loading...' : 'Load More' }}
      </button>
    </div>
    
    <div v-if="lightbox.open" class="lightbox">
      <button class="close" @click="closeLightbox">&times;</button>
      <img :src="lightbox.current.large" :alt="lightbox.current.name" />
    </div>
  </div>
</template>

<script>
export default {
  props: {
    galleryId: {
      type: Number,
      required: true
    },
    initialItems: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      items: this.initialItems,
      offset: this.initialItems.length,
      limit: 12,
      hasMore: true,
      loading: false,
      lightbox: {
        open: false,
        current: null
      }
    };
  },
  mounted() {
    // Inizializza lazysizes
    if (window.lazySizes) {
      window.lazySizes.init();
    }
  },
  methods: {
    async loadMore() {
      if (this.loading) return;
      
      this.loading = true;
      
      try {
        const response = await axios.get(`/api/galleries/${this.galleryId}/load-more`, {
          params: {
            offset: this.offset,
            limit: this.limit
          }
        });
        
        this.items = [...this.items, ...response.data.media];
        this.offset += response.data.media.length;
        this.hasMore = response.data.has_more;
        
        // Reinizializza lazysizes per le nuove immagini
        this.$nextTick(() => {
          if (window.lazySizes) {
            window.lazySizes.autoSizer.checkElems();
          }
        });
      } catch (error) {
        console.error('Failed to load more images', error);
      } finally {
        this.loading = false;
      }
    },
    openLightbox(item) {
      this.lightbox.current = item;
      this.lightbox.open = true;
      
      // Disabilita lo scroll della pagina
      document.body.style.overflow = 'hidden';
    },
    closeLightbox() {
      this.lightbox.open = false;
      this.lightbox.current = null;
      
      // Riabilita lo scroll della pagina
      document.body.style.overflow = '';
    }
  }
};
</script>
```

3. **Aggiungere Script Lazy Loading**

```html
<!-- In layouts/app.blade.php -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>
```

4. **Ottimizzare il Modello Gallery**

```php
// In Modules\Media\Models\Gallery.php
namespace Modules\Media\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'name', 'description', 'slug',
    ];
    
    public function media()
    {
        return $this->belongsToMany(Media::class, 'gallery_media')
            ->withPivot('position')
            ->orderBy('position');
    }
    
    public function getCoverImage()
    {
        return $this->media()
            ->where('status', 'processed')
            ->orderBy('pivot_position')
            ->first();
    }
    
    public function getCoverUrl($format = 'medium')
    {
        $cover = $this->getCoverImage();
        
        if (!$cover) {
            return asset('images/no-image.jpg');
        }
        
        return $cover->getUrl($format);
    }
}
```

## Conclusione

Implementando queste soluzioni, il modulo Media potrà superare i principali colli di bottiglia e migliorare significativamente le performance dell'applicazione. È consigliabile implementare le soluzioni in modo incrementale, misurando l'impatto di ciascuna modifica per garantire miglioramenti effettivi.

## Collegamenti
- [Roadmap Principale](./roadmap.md)
- [Sintesi Colli di Bottiglia](../../docs/PERFORMANCE_BOTTLENECKS.md)
- [Best Practices](../Xot/docs/BEST-PRACTICES.md)
- [Struttura Moduli](../Xot/docs/MODULE_STRUCTURE.md)

## Collegamenti tra versioni di BOTTLENECKS.md
* [BOTTLENECKS.md](../../../Xot/docs/BOTTLENECKS.md)
* [BOTTLENECKS.md](../../../User/docs/BOTTLENECKS.md)
* [BOTTLENECKS.md](../../../Media/docs/BOTTLENECKS.md)
* [BOTTLENECKS.md](../../../Cms/docs/BOTTLENECKS.md)


## Collegamenti tra versioni di bottlenecks.md
* [bottlenecks.md](../../../../bashscripts/docs/bottlenecks.md)
* [bottlenecks.md](../../Chart/docs/bottlenecks.md)
* [bottlenecks.md](../../Chart/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Gdpr/docs/bottlenecks.md)
* [bottlenecks.md](../../Gdpr/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Xot/docs/bottlenecks.md)
* [bottlenecks.md](../../Xot/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Xot/docs/roadmap/bottlenecks.md)
* [bottlenecks.md](../../Dental/docs/bottlenecks.md)
* [bottlenecks.md](../../User/docs/bottlenecks.md)
* [bottlenecks.md](../../User/docs/roadmap/bottlenecks.md)
* [bottlenecks.md](../../UI/docs/bottlenecks.md)
* [bottlenecks.md](../../UI/docs/roadmap/bottlenecks.md)
* [bottlenecks.md](../../Lang/docs/bottlenecks.md)
* [bottlenecks.md](../../Lang/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Job/docs/performance/bottlenecks.md)
* [bottlenecks.md](performance/bottlenecks.md)
* [bottlenecks.md](../../Activity/docs/bottlenecks.md)
* [bottlenecks.md](../../Patient/docs/roadmap/bottlenecks.md)
* [bottlenecks.md](../../Cms/docs/bottlenecks.md)

