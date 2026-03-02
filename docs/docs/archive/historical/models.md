# Modelli e Relazioni del Modulo Notify

## BaseModel

Tutti i modelli del modulo estendono `BaseModel`:

```php
namespace Modules\Notify\Models;

use Modules\Xot\Models\BaseModel as XotBaseModel;

abstract class BaseModel extends XotBaseModel
{
    protected $connection = 'notify';
}
```

## Template

### Struttura Template

```php
final class Template extends BaseModel
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'status',
        'tenant_id',
        'code',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => TemplateStatus::class,
            'type' => TemplateType::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function versions(): HasMany
    {
        return $this->hasMany(TemplateVersion::class);
    }

    public function analytics(): HasMany
    {
        return $this->hasMany(TemplateAnalytics::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(NotificationLog::class);
    }
}
```

### Enum

```php
enum TemplateStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';
}

enum TemplateType: string
{
    case EMAIL = 'email';
    case SMS = 'sms';
    case PUSH = 'push';
}
```

## TemplateVersion

### Struttura TemplateVersion

```php
final class TemplateVersion extends BaseModel
{
    protected $fillable = [
        'template_id',
        'version',
        'content',
        'metadata',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(TemplateTranslation::class);
    }
}
```

## TemplateTranslation

### Struttura TemplateTranslation

```php
final class TemplateTranslation extends BaseModel
{
    protected $fillable = [
        'template_version_id',
        'locale',
        'subject',
        'content',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function version(): BelongsTo
    {
        return $this->belongsTo(TemplateVersion::class, 'template_version_id');
    }
}
```

## NotificationLog

### Struttura NotificationLog

```php
final class NotificationLog extends BaseModel
{
    protected $fillable = [
        'template_id',
        'recipient_id',
        'recipient_type',
        'content',
        'data',
        'channels',
        'status',
        'sent_at',
        'delivered_at',
        'opened_at',
        'clicked_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'data' => 'array',
            'channels' => 'array',
            'sent_at' => 'datetime',
            'delivered_at' => 'datetime',
            'opened_at' => 'datetime',
            'clicked_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function recipient(): MorphTo
    {
        return $this->morphTo();
    }

    public function analytics(): HasMany
    {
        return $this->hasMany(TemplateAnalytics::class);
    }
}
```

## TemplateAnalytics

### Struttura TemplateAnalytics

```php
final class TemplateAnalytics extends BaseModel
{
    protected $fillable = [
        'template_id',
        'notification_id',
        'event_type',
        'event_data',
        'occurred_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'event_data' => 'array',
            'occurred_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function notification(): BelongsTo
    {
        return $this->belongsTo(NotificationLog::class);
    }
}
```

## Relazioni tra Modelli

### Diagramma

```text
Template 1 --- * TemplateVersion
TemplateVersion 1 --- * TemplateTranslation
Template 1 --- * NotificationLog
NotificationLog 1 --- * TemplateAnalytics
```

### Query Examples

#### Recupero Template con Versioni

```php
$template = Template::with(['versions' => function($query) {
    $query->latest('version');
}])->findOrFail($id);
```

#### Recupero Analytics per Periodo

```php
$analytics = TemplateAnalytics::where('template_id', $templateId)
    ->whereBetween('occurred_at', [$startDate, $endDate])
    ->get();
```

## Traits e Scopes

### HasVersions

```php
trait HasVersions
{
    public function latestVersion(): ?TemplateVersion
    {
        return $this->versions()->latest('version')->first();
    }

    public function createNewVersion(array $data): TemplateVersion
    {
        $latestVersion = $this->latestVersion();
        $newVersion = $latestVersion ? $latestVersion->version + 1 : 1;

        return $this->versions()->create([
            'version' => $newVersion,
            'content' => $data['content'],
            'metadata' => $data['metadata'] ?? [],
        ]);
    }
}
```

### TemplateScopes

```php
trait TemplateScopes
{
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', TemplateStatus::PUBLISHED);
    }

    public function scopeByType(Builder $query, TemplateType $type): Builder
    {
        return $query->where('type', $type);
    }
}
```

## Eventi

### Template Events

```php
final class TemplateWasPublished
{
    public function __construct(
        public readonly Template $template
    ) {}
}

final class TemplateWasArchived
{
    public function __construct(
        public readonly Template $template
    ) {}
}
```

## Validazione

### Rules

```php
final class TemplateRules
{
    public static function create(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'type' => ['required', Rule::enum(TemplateType::class)],
            'status' => ['required', Rule::enum(TemplateStatus::class)],
            'code' => ['required', 'string', 'max:50', 'unique:templates,code'],
        ];
    }
}
```
