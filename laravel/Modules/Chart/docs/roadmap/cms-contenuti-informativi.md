# CMS per Contenuti Informativi ed Educativi

> [Torna alla Roadmap Principale](../roadmap.md#q3-2024-luglio-settembre)

## Stato Attuale

Il CMS per contenuti informativi ed educativi è attualmente completato al 20%. Questo componente è fondamentale per gestire e presentare i contenuti di carattere informativo, educativo e divulgativo all'interno della piattaforma il progetto, offrendo risorse utili sia ai pazienti che agli operatori sanitari.

## Obiettivi dell'Implementazione

L'implementazione del CMS per contenuti informativi ed educativi mira a:

1. Fornire una piattaforma centralizzata per la gestione dei contenuti informativi
2. Supportare contenuti multimediali educativi sul tema della salute odontoiatrica
3. Facilitare la comunicazione di informazioni rilevanti ai pazienti
4. Implementare un sistema di knowledge base per gli operatori sanitari
5. Strutturare i contenuti per ottimizzare l'accessibilità e la SEO

## Componenti Implementati (20%)

- ✅ Struttura base del modulo CMS
- ✅ Modello dati per articoli e contenuti
- ✅ Editor di base per contenuti testuali
- ✅ Integrazione con il sistema di storage media
- ✅ Categorizzazione semplice dei contenuti

## Componenti da Implementare (80%)

- 🚧 Gestione contenuti avanzata (25%)
  - 🚧 Editor WYSIWYG avanzato con componenti specializzati
  - 🚧 Sistema di revisione e approvazione contenuti
  - 🚧 Versionamento e storico modifiche
  - 📅 Workflow editoriale completo
- 🚧 Supporto multimediale (15%)
  - 🚧 Gallerie di immagini ottimizzate
  - 🚧 Integrazione video e audio
  - 📅 Contenuti interattivi (quiz, sondaggi)
  - 📅 Infografiche dinamiche
- 🚧 Organizzazione contenuti (25%)
  - 🚧 Tassonomie avanzate (categorie, tag, argomenti)
  - 🚧 Relazioni tra contenuti per navigazione contestuale
  - 📅 Raccolte e percorsi di apprendimento
- 📅 Distribuzione e accessibilità
  - 📅 API contenuti per integrazione frontend
  - 📅 Ottimizzazione SEO automatica
  - 📅 Supporto multi-device e responsive
  - 📅 Esportazione contenuti in formati multipli (PDF, print)

## Architettura del Sistema

Il CMS è progettato secondo un'architettura modulare che separa contenuti, presentazione e distribuzione:

```
┌───────────────────┐       ┌───────────────────┐       ┌───────────────────┐
│                   │       │                   │       │                   │
│  Creazione        │       │  Gestione         │       │  Storage          │
│  Contenuti        │─────►│  Contenuti        │◄─────►│  e Versionamento  │
│                   │       │                   │       │                   │
└───────────────────┘       └───────────────────┘       └───────────────────┘
                                      │
                                      │
                                      ▼
┌───────────────────┐       ┌───────────────────┐       ┌───────────────────┐
│                   │       │                   │       │                   │
│  API              │◄─────►│  Presentazione    │◄─────►│  SEO e            │
│  Contenuti        │       │  Frontend         │       │  Analytics        │
│                   │       │                   │       │                   │
└───────────────────┘       └───────────────────┘       └───────────────────┘
```

## Modello dei Dati

```php
// Modules/Cms/Models/Content.php
namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Content extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    
    /**
     * Attributi assegnabili.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'meta_description',
        'meta_keywords',
        'author_id',
        'status',
        'published_at',
        'content_type',
        'template',
        'featured_image_id',
        'tenant_id',
        'is_featured',
        'reading_time',
        'custom_fields',
    ];
    
    /**
     * Gli attributi da castare.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'datetime',
        'custom_fields' => 'array',
        'is_featured' => 'boolean',
    ];
    
    /**
     * Stati del contenuto.
     */
    public const STATUS_DRAFT = 'draft';
    public const STATUS_REVIEW = 'review';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_ARCHIVED = 'archived';
    
    /**
     * Tipi di contenuto.
     */
    public const TYPE_ARTICLE = 'article';
    public const TYPE_PAGE = 'page';
    public const TYPE_FAQ = 'faq';
    public const TYPE_GUIDE = 'guide';
    public const TYPE_VIDEO = 'video';
    
    /**
     * L'autore del contenuto.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }
    
    /**
     * L'immagine in evidenza.
     */
    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(config('media.model', \Modules\Media\Models\Media::class), 'featured_image_id');
    }
    
    /**
     * Le categorie associate al contenuto.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
    
    /**
     * I tag associati al contenuto.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
    
    /**
     * Le revisioni del contenuto.
     */
    public function revisions(): MorphMany
    {
        return $this->morphMany(Revision::class, 'revisionable');
    }
    
    /**
     * Contenuti correlati.
     */
    public function relatedContent(): BelongsToMany
    {
        return $this->belongsToMany(Content::class, 'content_related', 'content_id', 'related_content_id');
    }
    
    /**
     * Registra i media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery')
            ->useDisk('public');
            
        $this->addMediaCollection('downloads')
            ->useDisk('protected');
    }
    
    /**
     * Genera un excerpt dal corpo del contenuto.
     */
    public function generateExcerpt(int $length = 160): string
    {
        if (!empty($this->excerpt)) {
            return $this->excerpt;
        }
        
        $text = strip_tags($this->body);
        
        return \Str::limit($text, $length);
    }
    
    /**
     * Calcola il tempo di lettura.
     */
    public function calculateReadingTime(): int
    {
        $wordCount = str_word_count(strip_tags($this->body));
        
        // Assumiamo una velocità media di lettura di 200 parole al minuto
        $minutes = ceil($wordCount / 200);
        
        return max(1, $minutes);
    }
    
    /**
     * Scope per i contenuti pubblicati.
     */
    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
    
    /**
     * Scope per i contenuti in evidenza.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
    
    /**
     * Scope per filtrare per tipo di contenuto.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('content_type', $type);
    }
}
```

## Implementazione con Action Pattern

Seguendo la regola di utilizzo di Spatie Laravel-Queueable-Action invece di Service Classes, implementiamo le funzionalità principali tramite Action Pattern:

```php
// Modules/Cms/Actions/PublishContentAction.php
namespace Modules\Cms\Actions;

use Modules\Cms\Models\Content;
use Spatie\QueueableAction\QueueableAction;

class PublishContentAction
{
    use QueueableAction;
    
    /**
     * Pubblica un contenuto.
     *
     * @param \Modules\Cms\Models\Content $content Il contenuto da pubblicare
     * @param \DateTimeInterface|null $publishAt Data di pubblicazione (default: now)
     * 
     * @return \Modules\Cms\Models\Content
     */
    public function execute(Content $content, ?\DateTimeInterface $publishAt = null): Content
    {
        // Verifica se il contenuto può essere pubblicato
        if ($content->status === Content::STATUS_DRAFT) {
            // Crea una revisione prima di pubblicare
            app(CreateContentRevisionAction::class)->execute(
                $content,
                'Revisione pre-pubblicazione'
            );
            
            // Aggiorna lo stato e la data di pubblicazione
            $content->update([
                'status' => Content::STATUS_PUBLISHED,
                'published_at' => $publishAt ?? now(),
                'reading_time' => $content->calculateReadingTime(),
            ]);
            
            // Registra l'attività
            activity()
                ->performedOn($content)
                ->causedBy(auth()->user())
                ->withProperties([
                    'title' => $content->title,
                    'type' => $content->content_type,
                ])
                ->log('Contenuto pubblicato');
        }
        
        return $content;
    }
}

// Modules/Cms/Actions/CreateContentRevisionAction.php
namespace Modules\Cms\Actions;

use Modules\Cms\Models\Content;
use Modules\Cms\Models\Revision;
use Spatie\QueueableAction\QueueableAction;

class CreateContentRevisionAction
{
    use QueueableAction;
    
    /**
     * Crea una nuova revisione per un contenuto.
     *
     * @param \Modules\Cms\Models\Content $content Il contenuto
     * @param string $comment Commento sulla revisione
     * 
     * @return \Modules\Cms\Models\Revision
     */
    public function execute(Content $content, string $comment = ''): Revision
    {
        return Revision::create([
            'revisionable_type' => get_class($content),
            'revisionable_id' => $content->id,
            'user_id' => auth()->id(),
            'data' => [
                'title' => $content->title,
                'body' => $content->body,
                'excerpt' => $content->excerpt,
                'meta_description' => $content->meta_description,
                'meta_keywords' => $content->meta_keywords,
                'status' => $content->status,
                'custom_fields' => $content->custom_fields,
            ],
            'comment' => $comment,
        ]);
    }
}
```

## Implementazione in Filament

L'interfaccia di gestione contenuti utilizza esclusivamente Filament, seguendo la regola fondamentale del progetto:

```php
// Modules/Cms/Filament/Resources/ContentResource.php
namespace Modules\Cms\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Modules\Cms\Models\Content;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Illuminate\Support\Str;

class ContentResource extends XotBaseResource
{
    protected static ?string $model = Content::class;
    
    public static function getFormSchema(): array
    {
        return [
            'main' => Forms\Components\Section::make('Informazioni Principali')
                ->schema([
                    'title' => Forms\Components\TextInput::make('title')
                        ->label('Titolo')
                        ->required()
                        ->maxLength(200)
                        ->reactive()
                        ->afterStateUpdated(function (Forms\Set $set, $state) {
                            if (!$set('slug')) {
                                $set('slug', Str::slug($state));
                            }
                        }),
                    'slug' => Forms\Components\TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->maxLength(200)
                        ->unique(ignoreRecord: true),
                    'excerpt' => Forms\Components\Textarea::make('excerpt')
                        ->label('Estratto')
                        ->rows(3)
                        ->maxLength(500)
                        ->helperText('Breve descrizione del contenuto (massimo 500 caratteri)'),
                    'content_type' => Forms\Components\Select::make('content_type')
                        ->label('Tipo Contenuto')
                        ->options([
                            Content::TYPE_ARTICLE => 'Articolo',
                            Content::TYPE_PAGE => 'Pagina',
                            Content::TYPE_FAQ => 'FAQ',
                            Content::TYPE_GUIDE => 'Guida',
                            Content::TYPE_VIDEO => 'Video',
                        ])
                        ->required(),
                    'status' => Forms\Components\Select::make('status')
                        ->label('Stato')
                        ->options([
                            Content::STATUS_DRAFT => 'Bozza',
                            Content::STATUS_REVIEW => 'In revisione',
                            Content::STATUS_PUBLISHED => 'Pubblicato',
                            Content::STATUS_ARCHIVED => 'Archiviato',
                        ])
                        ->default(Content::STATUS_DRAFT)
                        ->required(),
                    'published_at' => Forms\Components\DateTimePicker::make('published_at')
                        ->label('Data Pubblicazione')
                        ->default(now()),
                    'is_featured' => Forms\Components\Toggle::make('is_featured')
                        ->label('In Evidenza')
                        ->default(false),
                ])
                ->columns(2),
                
            'content' => Forms\Components\Section::make('Contenuto')
                ->schema([
                    'body' => Forms\Components\RichEditor::make('body')
                        ->label('Corpo del Contenuto')
                        ->required()
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsDirectory('cms-uploads')
                        ->toolbarButtons([
                            'blockquote',
                            'bold',
                            'bulletList',
                            'codeBlock',
                            'h2',
                            'h3',
                            'italic',
                            'link',
                            'orderedList',
                            'redo',
                            'strike',
                            'underline',
                            'undo',
                        ]),
                ]),
                
            'media' => Forms\Components\Section::make('Media')
                ->schema([
                    'featured_image_id' => Forms\Components\Select::make('featured_image_id')
                        ->label('Immagine in Evidenza')
                        ->relationship('featuredImage', 'name')
                        ->searchable()
                        ->preload(),
                    'media' => Forms\Components\FileUpload::make('media')
                        ->label('Galleria Immagini')
                        ->multiple()
                        ->disk('public')
                        ->directory('cms-gallery')
                        ->image()
                        ->maxFiles(10)
                        ->enableReordering(),
                ]),
                
            'categorization' => Forms\Components\Section::make('Categorizzazione')
                ->schema([
                    'categories' => Forms\Components\Select::make('categories')
                        ->label('Categorie')
                        ->relationship('categories', 'name')
                        ->multiple()
                        ->preload(),
                    'tags' => Forms\Components\Select::make('tags')
                        ->label('Tags')
                        ->relationship('tags', 'name')
                        ->multiple()
                        ->createOptionForm([
                            Forms\Components\TextInput::make('name')
                                ->required(),
                        ])
                        ->preload(),
                ]),
                
            'seo' => Forms\Components\Section::make('SEO')
                ->schema([
                    'meta_description' => Forms\Components\Textarea::make('meta_description')
                        ->label('Meta Description')
                        ->rows(2)
                        ->maxLength(160)
                        ->helperText('Massimo 160 caratteri per ottimizzazione SEO'),
                    'meta_keywords' => Forms\Components\TagsInput::make('meta_keywords')
                        ->label('Meta Keywords')
                        ->helperText('Inserire parole chiave separate da virgola'),
                ]),
        ];
    }
    
    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Titolo')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('content_type')
                    ->label('Tipo')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Stato')
                    ->badge()
                    ->colors([
                        'danger' => Content::STATUS_DRAFT,
                        'warning' => Content::STATUS_REVIEW,
                        'success' => Content::STATUS_PUBLISHED,
                        'gray' => Content::STATUS_ARCHIVED,
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('author.name')
                    ->label('Autore')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Pubblicato')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('In Evidenza')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('content_type')
                    ->options([
                        Content::TYPE_ARTICLE => 'Articolo',
                        Content::TYPE_PAGE => 'Pagina',
                        Content::TYPE_FAQ => 'FAQ',
                        Content::TYPE_GUIDE => 'Guida',
                        Content::TYPE_VIDEO => 'Video',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        Content::STATUS_DRAFT => 'Bozza',
                        Content::STATUS_REVIEW => 'In revisione',
                        Content::STATUS_PUBLISHED => 'Pubblicato',
                        Content::STATUS_ARCHIVED => 'Archiviato',
                    ]),
                Tables\Filters\Filter::make('published')
                    ->query(fn ($query) => $query->whereNotNull('published_at')->where('published_at', '<=', now())),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('publish')
                    ->label('Pubblica')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->visible(fn (Content $record) => $record->status !== Content::STATUS_PUBLISHED)
                    ->action(fn (Content $record) => app(\Modules\Cms\Actions\PublishContentAction::class)->execute($record)),
                Tables\Actions\Action::make('preview')
                    ->label('Anteprima')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Content $record) => route('cms.content.preview', $record)),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('publish')
                    ->label('Pubblica')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->action(fn (mixed $records) => $records->each(
                        fn (Content $record) => app(\Modules\Cms\Actions\PublishContentAction::class)->execute($record)
                    )),
                Tables\Actions\BulkAction::make('archive')
                    ->label('Archivia')
                    ->icon('heroicon-o-archive-box')
                    ->action(fn (mixed $records) => $records->each->update(['status' => Content::STATUS_ARCHIVED])),
            ]);
    }
}
```

## API per Contenuti

Per esporre i contenuti al frontend, implementiamo un'API dedicata:

```php
// Modules/Cms/Http/Controllers/Api/ContentController.php
namespace Modules\Cms\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Cms\Models\Content;
use Modules\Cms\Http\Resources\ContentResource;
use Modules\Cms\Http\Resources\ContentCollection;

class ContentController extends Controller
{
    /**
     * Display a listing of published content.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = Content::published();
        
        // Filtri
        if ($request->has('type')) {
            $query->ofType($request->type);
        }
        
        if ($request->has('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        if ($request->has('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }
        
        if ($request->has('featured')) {
            $query->featured();
        }
        
        // Ordinamento
        $query->orderBy($request->get('sort', 'published_at'), $request->get('order', 'desc'));
        
        // Paginazione
        $perPage = min(100, $request->get('per_page', 15));
        
        return new ContentCollection(
            $query->paginate($perPage)
        );
    }
    
    /**
     * Display the specified content.
     */
    public function show(string $slug): JsonResource
    {
        $content = Content::published()
            ->where('slug', $slug)
            ->firstOrFail();
            
        // Incrementa contatore visualizzazioni
        $content->increment('view_count');
        
        return new ContentResource($content);
    }
    
    /**
     * Display featured content.
     */
    public function featured(): ResourceCollection
    {
        $featured = Content::published()
            ->featured()
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();
            
        return new ContentCollection($featured);
    }
    
    /**
     * Search for content.
     */
    public function search(Request $request): ResourceCollection
    {
        $query = $request->get('q');
        
        if (empty($query)) {
            return new ContentCollection(collect());
        }
        
        $results = Content::published()
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('excerpt', 'like', "%{$query}%")
                  ->orWhere('body', 'like', "%{$query}%");
            })
            ->orderBy('published_at', 'desc')
            ->paginate(15);
            
        return new ContentCollection($results);
    }
}
```

## Integrazione con Altri Moduli

### 1. Integrazione con Modulo Patient

```php
// Modules/Patient/Traits/HasRecommendedContent.php
namespace Modules\Patient\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\Cms\Models\Content;

trait HasRecommendedContent
{
    /**
     * Contenuti raccomandati per il paziente.
     */
    public function recommendedContent(): MorphToMany
    {
        return $this->morphToMany(Content::class, 'contentable', 'content_recommendations')
            ->withTimestamps()
            ->withPivot('priority', 'reason');
    }
    
    /**
     * Aggiunge un contenuto raccomandato.
     */
    public function addRecommendedContent(Content $content, int $priority = 1, string $reason = null): void
    {
        $this->recommendedContent()->syncWithoutDetaching([
            $content->id => [
                'priority' => $priority,
                'reason' => $reason,
            ],
        ]);
    }
    
    /**
     * Rimuove un contenuto raccomandato.
     */
    public function removeRecommendedContent(Content $content): void
    {
        $this->recommendedContent()->detach($content->id);
    }
}
```

### 2. Integrazione con Modulo Dental

```php
// Modules/Dental/Models/DentalTreatment.php
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\Cms\Models\Content;

// Nel modello DentalTreatment
public function educationalContent(): MorphToMany
{
    return $this->morphToMany(Content::class, 'contentable', 'content_associations')
        ->withTimestamps()
        ->withPivot('association_type');
}

// Per associare contenuti educativi a un trattamento
public function associateEducationalContent(Content $content, string $associationType = 'general'): void
{
    $this->educationalContent()->syncWithoutDetaching([
        $content->id => [
            'association_type' => $associationType,
        ],
    ]);
}
```

## Calendario di Completamento

| Funzionalità | Completamento Previsto | Priorità |
|--------------|------------------------|----------|
| Editor WYSIWYG avanzato | Luglio 2024 | Alta |
| Sistema di revisione | Luglio 2024 | Alta |
| Versionamento | Agosto 2024 | Media |
| Supporto multimediale | Agosto 2024 | Alta |
| Tassonomie avanzate | Agosto 2024 | Media |
| API contenuti | Agosto 2024 | Alta |
| Workflow editoriale | Settembre 2024 | Bassa |
| Contenuti interattivi | Settembre 2024 | Bassa |

## Metriche di Successo

- Tempo medio creazione contenuto < 20 minuti
- Engagement utenti con contenuti educativi > 40%
- Copertura SEO (risultati prime 10 posizioni) > 30%
- Riduzione richieste informazioni ripetitive del 50%
- Soddisfazione utenti con i contenuti > 4.2/5
