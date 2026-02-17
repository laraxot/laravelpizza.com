# Implementazione del Campo Slug in MailTemplate

## Collegamenti correlati

- [README del modulo Notify](./README.md)
- [Guida all'utilizzo di SpatieEmail](./SPATIE_EMAIL_USAGE_GUIDE.md)
- [Documentazione Template Email](./EMAIL_TEMPLATES.md)
- [Documentazione Root](../../../../docs/collegamenti-documentazione.md)

## Approccio Corretto per l'Implementazione

L'implementazione del campo `slug` nel modello `MailTemplate` deve seguire l'architettura delle migrazioni del progetto, utilizzando il pattern `XotBaseMigration` e il metodo `tableUpdate()`.

### Modificare la Migrazione Esistente

Il modo corretto per aggiungere il campo `slug` è modificare il file di migrazione esistente `/Modules/Notify/database/migrations/2018_10_10_000001_create_mail_templates_table.php`:

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
// ----- bases ----
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Class CreateThemesTable.
 */
return new class () extends XotBaseMigration {
    // use XotBaseMigrationTrait;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->increments('id');
                $table->string('mailable');
                $table->string('slug')->nullable()->index(); // Aggiunto il campo slug
                $table->json('subject')->nullable();
                $table->json('html_template')->nullable();
                $table->json('text_template')->nullable();
            }
        );

         // -- UPDATE --
         $this->tableUpdate(
            function (Blueprint $table): void {
                if(in_array($this->getColumnType('subject'),['text'])){
                    $table->json('subject')->nullable()->change();
                }
                if(in_array($this->getColumnType('html_template'),['text'])){
                    $table->json('html_template')->nullable()->change();
                }
                if(in_array($this->getColumnType('text_template'),['text'])){
                    $table->json('text_template')->nullable()->change();
                }
                
                // Aggiungere il campo slug se non esiste già
                if(!$this->hasColumn('slug')){
                    $table->string('slug')->nullable()->after('mailable')->index();
                }
                
                $this->updateTimestamps(table: $table, hasSoftDeletes: true);
            }
        );
    }
};
```

### Vantaggi di Questo Approccio

1. **Consistenza**: Mantiene la coerenza con l'architettura del progetto
2. **Manutenibilità**: Tutta la struttura della tabella è definita in un unico file
3. **Semplicità**: Meno file di migrazione da gestire
4. **Affidabilità**: Riduce le probabilità di conflitti tra migrazioni

## Implementazione nel Modello

Il modello `MailTemplate` deve essere aggiornato per supportare completamente il campo `slug`:

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MailTemplates\Interfaces\MailTemplateInterface;
use Spatie\MailTemplates\Models\MailTemplate as SpatieMailTemplate;

/**
 * @property int $id
 * @property string $mailable
 * @property string|null $slug
 * @property string|null $subject
 * @property string $html_template
 * @property string|null $text_template
 * @property int $version
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Notify\Models\MailTemplateVersion> $versions
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Notify\Models\MailTemplateLog> $logs
 */
class MailTemplate extends SpatieMailTemplate implements MailTemplateInterface
{
    use HasTranslations;
    
    /** @var string */
    protected $connection = 'notify';

    /** @var list<string> */
    public array $translatable = ['subject', 'html_template', 'text_template'];

    /** @var list<string> */
    protected $fillable = [
        'mailable',
        'slug',
        'subject',
        'html_template',
        'text_template',
        'version',
    ];
    
    /**
     * Boot del modello per garantire l'impostazione dello slug.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            // Genera automaticamente uno slug se non fornito
            if (empty($model->slug) && !empty($model->mailable)) {
                $mailableClass = class_basename($model->mailable);
                $model->slug = Str::slug($mailableClass);
            }
        });
    }
    
    /**
     * Trova un template per slug.
     *
     * @param string $slug Lo slug del template
     * @return self|null Il template trovato o null
     */
    public static function findBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->first();
    }
}
```

## Aggiornamento della Classe SpatieEmail

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Emails;

use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Models\MailTemplate;
use Spatie\MailTemplates\TemplateMailable;

/**
 * @see https://github.com/spatie/laravel-database-mail-templates
 */
class SpatieEmail extends TemplateMailable
{
    // Use our custom mail template model
    protected static $templateModelClass = MailTemplate::class;
    
    // Slug per identificare il template
    protected static ?string $templateSlug = null;

    public function __construct(Model $record, ?string $slug = null)
    {
        $data = $record->toArray();
        $this->setAdditionalData($data);
        
        if ($slug !== null) {
            static::$templateSlug = $slug;
        }
    }
    
    /**
     * Override per recuperare il template tramite slug quando specificato.
     */
    protected function getTemplateModel(): ?Model
    {
        if (static::$templateSlug !== null) {
            $mailTemplate = MailTemplate::findBySlug(static::$templateSlug);
            
            if ($mailTemplate) {
                return $mailTemplate;
            }
        }
        
        return parent::getTemplateModel();
    }
    
    public function getHtmlLayout(): string
    {
        return '<header>Site name!</header>{{{ body }}}<footer>Copyright 2018</footer>';
    }
}
```

## Raccomandazioni per l'Implementazione

1. **Aggiornare la migrazione esistente** senza creare nuovi file
2. **Aggiungere metodi di supporto** nel modello per lavorare con lo slug
3. **Modificare SpatieEmail** per supportare l'identificazione tramite slug
4. **Mantenere la retrocompatibilità** per assicurare che il codice esistente continui a funzionare

## Conclusione

L'implementazione del campo `slug` nel sistema di templating delle email offrirà maggiore flessibilità e manutenibilità, mantenendo al contempo la coerenza con l'architettura del progetto. Seguendo l'approccio di `XotBaseMigration`, tutte le modifiche allo schema devono essere applicate modificando il file di migrazione esistente piuttosto che creando nuovi file di migrazione separati.
