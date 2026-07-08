# Analisi Dettagliata del Modulo Notify - Parte 2: Modelli e Relazioni

## 2. Modelli e Relazioni

### 2.1 Template Model

#### 2.1.1 Struttura Base
```php
namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Template extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'templates';

    protected $fillable = [
        'name',              // Nome del template
        'subject',           // Oggetto email
        'content',           // Contenuto template
        'layout',            // Layout utilizzato
        'is_active',         // Stato attivo/inattivo
        'version',           // Versione corrente
        'from_name',         // Nome mittente
        'from_email',        // Email mittente
        'reply_to',          // Email risposta
        'cc',                // Copie conoscenza
        'bcc',               // Copie nascoste
        'attachments',       // Allegati
        'variables',         // Variabili template
        'settings'           // Impostazioni
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'version' => 'integer',
        'attachments' => 'array',
        'variables' => 'array',
        'settings' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $appends = [
        'full_name',
        'status_label',
        'is_latest',
        'has_translations'
    ];
}
```

#### 2.1.2 Relazioni
```php
public function versions()
{
    return $this->hasMany(TemplateVersion::class);
}

public function translations()
{
    return $this->hasMany(TemplateTranslation::class);
}

public function analytics()
{
    return $this->hasMany(TemplateAnalytics::class);
}

public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}

public function updater()
{
    return $this->belongsTo(User::class, 'updated_by');
}

public function latestVersion()
{
    return $this->hasOne(TemplateVersion::class)->latest();
}

public function defaultTranslation()
{
    return $this->hasOne(TemplateTranslation::class)
        ->where('locale', config('app.locale'));
}
```

#### 2.1.3 Accessori e Mutatori
```php
public function getFullNameAttribute()
{
    return "{$this->name} (v{$this->version})";
}

public function getStatusLabelAttribute()
{
    return $this->is_active ? 'Active' : 'Inactive';
}

public function getIsLatestAttribute()
{
    return $this->version === $this->versions()->max('version');
}

public function getHasTranslationsAttribute()
{
    return $this->translations()->count() > 0;
}

public function setVariablesAttribute($value)
{
    $this->attributes['variables'] = json_encode($value);
}

public function getVariablesAttribute($value)
{
    return json_decode($value, true);
}

public function setSettingsAttribute($value)
{
    $this->attributes['settings'] = json_encode($value);
}

public function getSettingsAttribute($value)
{
    return json_decode($value, true);
}
```

#### 2.1.4 Scope Query
```php
public function scopeActive($query)
{
    return $query->where('is_active', true);
}

public function scopeInactive($query)
{
    return $query->where('is_active', false);
}

public function scopeLatest($query)
{
    return $query->orderBy('version', 'desc');
}

public function scopeByLayout($query, $layout)
{
    return $query->where('layout', $layout);
}

public function scopeSearch($query, $term)
{
    return $query->where(function($q) use ($term) {
        $q->where('name', 'like', "%{$term}%")
          ->orWhere('subject', 'like', "%{$term}%")
          ->orWhere('content', 'like', "%{$term}%");
    });
}
```

#### 2.1.5 Eventi del Modello
```php
protected static function booted()
{
    static::creating(function ($template) {
        $template->created_by = auth()->id();
        $template->version = 1;
    });

    static::updating(function ($template) {
        $template->updated_by = auth()->id();
    });

    static::deleting(function ($template) {
        $template->versions()->delete();
        $template->translations()->delete();
        $template->analytics()->delete();
    });

    static::restored(function ($template) {
        $template->versions()->restore();
        $template->translations()->restore();
    });
}
```

### 2.2 TemplateVersion Model

#### 2.2.1 Struttura Base
```php
namespace Modules\Notify\Models;

class TemplateVersion extends Model
{
    use HasFactory;

    protected $table = 'template_versions';

    protected $fillable = [
        'template_id',
        'version',
        'content',
        'created_by',
        'changes',
        'status',
        'notes'
    ];

    protected $casts = [
        'version' => 'integer',
        'changes' => 'array',
        'status' => 'string',
        'created_at' => 'datetime'
    ];

    protected $appends = [
        'diff',
        'creator_name'
    ];
}
```

#### 2.2.2 Relazioni
```php
public function template()
{
    return $this->belongsTo(Template::class);
}

public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}

public function previousVersion()
{
    return $this->template->versions()
        ->where('version', '<', $this->version)
        ->latest('version')
        ->first();
}
```

#### 2.2.3 Accessori e Mutatori
```php
public function getDiffAttribute()
{
    if (!$this->previousVersion) {
        return null;
    }

    return $this->compareVersions(
        $this->previousVersion->content,
        $this->content
    );
}

public function getCreatorNameAttribute()
{
    return $this->creator ? $this->creator->name : 'System';
}

public function setChangesAttribute($value)
{
    $this->attributes['changes'] = json_encode($value);
}

public function getChangesAttribute($value)
{
    return json_decode($value, true);
}
```

#### 2.2.4 Metodi di Confronto
```php
protected function compareVersions($old, $new)
{
    return [
        'added' => $this->getAddedLines($old, $new),
        'removed' => $this->getRemovedLines($old, $new),
        'modified' => $this->getModifiedLines($old, $new)
    ];
}

protected function getAddedLines($old, $new)
{
    $oldLines = explode("\n", $old);
    $newLines = explode("\n", $new);
    return array_diff($newLines, $oldLines);
}

protected function getRemovedLines($old, $new)
{
    $oldLines = explode("\n", $old);
    $newLines = explode("\n", $new);
    return array_diff($oldLines, $newLines);
}

protected function getModifiedLines($old, $new)
{
    $oldLines = explode("\n", $old);
    $newLines = explode("\n", $new);
    $modified = [];

    foreach ($oldLines as $index => $line) {
        if (isset($newLines[$index]) && $line !== $newLines[$index]) {
            $modified[] = [
                'old' => $line,
                'new' => $newLines[$index]
            ];
        }
    }

    return $modified;
}
```

### 2.3 TemplateTranslation Model

#### 2.3.1 Struttura Base
```php
namespace Modules\Notify\Models;

class TemplateTranslation extends Model
{
    use HasFactory;

    protected $table = 'template_translations';

    protected $fillable = [
        'template_id',
        'locale',
        'content',
        'subject',
        'from_name',
        'variables'
    ];

    protected $casts = [
        'variables' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $appends = [
        'is_complete',
        'missing_variables'
    ];
}
```

#### 2.3.2 Relazioni
```php
public function template()
{
    return $this->belongsTo(Template::class);
}

public function translator()
{
    return $this->belongsTo(User::class, 'translated_by');
}
```

#### 2.3.3 Accessori e Mutatori
```php
public function getIsCompleteAttribute()
{
    return $this->validateVariables();
}

public function getMissingVariablesAttribute()
{
    $required = $this->template->variables;
    $provided = $this->variables ?? [];
    return array_diff($required, array_keys($provided));
}

public function setVariablesAttribute($value)
{
    $this->attributes['variables'] = json_encode($value);
}

public function getVariablesAttribute($value)
{
    return json_decode($value, true);
}
```

#### 2.3.4 Validazione
```php
public function validateVariables()
{
    $required = $this->template->variables;
    $provided = $this->variables ?? [];

    foreach ($required as $variable) {
        if (!isset($provided[$variable])) {
            throw new MissingVariableException(
                "Missing required variable: {$variable}"
            );
        }
    }

    return true;
}

public function validateContent()
{
    // Validazione HTML
    $validator = new HtmlValidator();
    $result = $validator->validate($this->content);

    if (!$result->isValid()) {
        throw new InvalidContentException(
            "Invalid HTML content: " . implode(', ', $result->getErrors())
        );
    }

    return true;
}

public function validateSubject()
{
    if (empty($this->subject)) {
        throw new InvalidSubjectException(
            "Subject cannot be empty"
        );
    }

    if (strlen($this->subject) > 255) {
        throw new InvalidSubjectException(
            "Subject cannot be longer than 255 characters"
        );
    }

    return true;
}
```

### 2.4 TemplateAnalytics Model

#### 2.4.1 Struttura Base
```php
namespace Modules\Notify\Models;

class TemplateAnalytics extends Model
{
    use HasFactory;

    protected $table = 'template_analytics';

    protected $fillable = [
        'template_id',
        'event',
        'metadata',
        'user_agent',
        'ip_address',
        'session_id'
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime'
    ];

    protected $appends = [
        'event_label',
        'formatted_metadata'
    ];
}
```

#### 2.4.2 Relazioni
```php
public function template()
{
    return $this->belongsTo(Template::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
```

#### 2.4.3 Accessori e Mutatori
```php
public function getEventLabelAttribute()
{
    return [
        'email.sent' => 'Email Sent',
        'email.opened' => 'Email Opened',
        'email.clicked' => 'Email Clicked',
        'email.bounced' => 'Email Bounced',
        'email.complained' => 'Email Complained',
        'email.unsubscribed' => 'Email Unsubscribed'
    ][$this->event] ?? $this->event;
}

public function getFormattedMetadataAttribute()
{
    return collect($this->metadata)->map(function ($value, $key) {
        return [
            'key' => $key,
            'value' => $value,
            'type' => gettype($value)
        ];
    })->values();
}

public function setMetadataAttribute($value)
{
    $this->attributes['metadata'] = json_encode($value);
}

public function getMetadataAttribute($value)
{
    return json_decode($value, true);
}
```

#### 2.4.4 Scope Query
```php
public function scopeByEvent($query, $event)
{
    return $query->where('event', $event);
}

public function scopeByDateRange($query, $start, $end)
{
    return $query->whereBetween('created_at', [$start, $end]);
}

public function scopeByTemplate($query, $templateId)
{
    return $query->where('template_id', $templateId);
}

public function scopeByUser($query, $userId)
{
    return $query->where('user_id', $userId);
}
```

### 2.5 Migrations

#### 2.5.1 Templates Table
```php
Schema::create('templates', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('subject');
    $table->text('content');
    $table->string('layout')->default('default');
    $table->boolean('is_active')->default(true);
    $table->integer('version')->default(1);
    $table->string('from_name')->nullable();
    $table->string('from_email')->nullable();
    $table->string('reply_to')->nullable();
    $table->json('cc')->nullable();
    $table->json('bcc')->nullable();
    $table->json('attachments')->nullable();
    $table->json('variables')->nullable();
    $table->json('settings')->nullable();
    $table->foreignId('created_by')->constrained('users');
    $table->foreignId('updated_by')->nullable()->constrained('users');
    $table->timestamps();
    $table->softDeletes();

    $table->index('name');
    $table->index('is_active');
    $table->index('version');
});
```

#### 2.5.2 Template Versions Table
```php
Schema::create('template_versions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('template_id')->constrained()->onDelete('cascade');
    $table->integer('version');
    $table->text('content');
    $table->foreignId('created_by')->constrained('users');
    $table->json('changes')->nullable();
    $table->string('status')->default('draft');
    $table->text('notes')->nullable();
    $table->timestamps();

    $table->unique(['template_id', 'version']);
    $table->index('status');
});
```

#### 2.5.3 Template Translations Table
```php
Schema::create('template_translations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('template_id')->constrained()->onDelete('cascade');
    $table->string('locale', 5);
    $table->text('content');
    $table->string('subject');
    $table->string('from_name')->nullable();
    $table->json('variables')->nullable();
    $table->foreignId('translated_by')->constrained('users');
    $table->timestamps();

    $table->unique(['template_id', 'locale']);
    $table->index('locale');
});
```

#### 2.5.4 Template Analytics Table
```php
Schema::create('template_analytics', function (Blueprint $table) {
    $table->id();
    $table->foreignId('template_id')->constrained()->onDelete('cascade');
    $table->string('event');
    $table->json('metadata')->nullable();
    $table->string('user_agent')->nullable();
    $table->string('ip_address', 45)->nullable();
    $table->string('session_id')->nullable();
    $table->foreignId('user_id')->nullable()->constrained('users');
    $table->timestamps();

    $table->index('event');
    $table->index('created_at');
    $table->index(['template_id', 'event']);
});
``` 
