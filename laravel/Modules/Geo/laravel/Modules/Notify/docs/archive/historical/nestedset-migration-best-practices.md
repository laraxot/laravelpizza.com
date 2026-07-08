# NestedSet Migration Best Practices - Notify Module

## Overview

Questo documento descrive le best practices per implementare migrazioni con strutture ad albero (nested sets) nel modulo Notify utilizzando il pacchetto `kalnoy/laravel-nestedset`.

## Pattern per Categorie Notifiche

```php
<?php

use Illuminate\Database\Schema\Blueprint;
use Kalnoy\Nestedset\NestedSet;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Notify\Models\NotificationCategory::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi categoria notifica
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // NestedSet per gerarchia categorie
            NestedSet::columns($table);

            // Metadati categoria
            $table->string('icon')->nullable();
            $table->string('color')->default('#6b7280');
            $table->json('metadata')->nullable();

            // Configurazioni
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }
};
```

## Pattern per Canali di Notifica

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Notify\Models\NotificationChannel::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi canale
            $table->string('name');
            $table->string('code')->unique(); // email, sms, push, webhook
            $table->text('description')->nullable();

            // NestedSet per gerarchia canali
            NestedSet::columns($table);

            // Configurazioni canale
            $table->json('settings')->nullable();
            $table->json('credentials')->nullable(); // Credenziali crittografate
            $table->string('provider')->nullable(); // sendgrid, twilio, firebase

            // Limiti e throttling
            $table->integer('rate_limit')->nullable(); // Limite orario
            $table->integer('daily_limit')->nullable();
            $table->integer('retry_attempts')->default(3);

            // Stato
            $table->boolean('is_active')->default(true);
            $table->boolean('is_test_mode')->default(false);

            $table->timestamps();
        });
    }
};
```

## Pattern per Template Notifiche

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Notify\Models\NotificationTemplate::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi template
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();

            // NestedSet per gerarchia template
            NestedSet::columns($table);

            // Contenuti template
            $table->string('subject')->nullable();
            $table->longText('content');
            $table->json('variables')->nullable(); // Variabili disponibili

            // Localizzazione
            $table->json('translations')->nullable();
            $table->string('default_language')->default('it');

            // Impostazioni
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }
};
```

## Pattern per Eventi Notifica

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Notify\Models\NotificationEvent::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi evento
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();

            // NestedSet per gerarchia eventi
            NestedSet::columns($table);

            // Configurazioni evento
            $table->json('triggers')->nullable(); // Condizioni trigger
            $table->json('actions')->nullable(); // Azioni da eseguire
            $table->json('conditions')->nullable(); // Condizioni aggiuntive

            // Canali associati
            $table->json('channels')->nullable(); // Canali da usare
            $table->json('templates')->nullable(); // Template per lingua

            // Priorità e scheduling
            $table->integer('priority')->default(0);
            $table->boolean('is_async')->default(true);
            $table->integer('delay_seconds')->default(0);

            // Stato
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }
};
```

## Integrazione con Modelli Notify

```php
<?php

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class NotificationCategory extends Model
{
    use NodeTrait;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'metadata',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Relazioni
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Scopes specifici Notify
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // Metodi helper
    public function getAllNotificationsCount(): int
    {
        return $this->descendants()
            ->withCount('notifications')
            ->get()
            ->sum('notifications_count');
    }

    public function getEffectiveChannels(): array
    {
        $channels = $this->channels ?? [];

        foreach ($this->ancestors as $ancestor) {
            $channels = array_merge($channels, $ancestor->channels ?? []);
        }

        return array_unique($channels);
    }
}
```

## Best Practices Specifiche per Notify

### 1. Nomenclatura Coerente

- `NotificationCategory`: Categorizzazione gerarchica notifiche
- `NotificationChannel`: Canali di notifica gerarchici
- `NotificationTemplate`: Template con ereditarietà
- `NotificationEvent`: Eventi con gerarchia di priorità

### 2. Gestione Canali Ereditati

```php
// Canali effettivi ereditati da parent
public function getEffectiveChannels(): array
{
    if ($this->channels) {
        return $this->channels;
    }

    return $this->parent?->getEffectiveChannels() ?? ['email'];
}
```

### 3. Validazioni Template

```php
// Validazione variabili template
public function setVariablesAttribute($value)
{
    if (is_array($value)) {
        // Verifica che le variabili esistano nel contenuto
        $content = $this->content ?? '';
        foreach ($value as $var) {
            if (!str_contains($content, "{{$var}}")) {
                throw new \Exception("Variable {{$var}} not found in content");
            }
        }
    }

    $this->attributes['variables'] = json_encode($value);
}
```

### 4. Indici per Performance Notify

```php
// Indici ottimizzati per query Notify
$table->index(['parent_id', 'is_active']);
$table->index('code');
$table->index('slug');
$table->index('provider');
$table->index(['is_active', 'is_test_mode']);
```

## Pattern per Notifiche Geografiche con AddressItemEnum

Integrazione con AddressItemEnum per notifiche basate su location:

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Notify\Models\LocationNotification::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi notifica
            $table->string('title');
            $table->text('message');
            $table->string('type'); // alert, info, promotion

            // Campi geografici usando AddressItemEnum::columns()
            \Modules\Geo\Enums\AddressItemEnum::columns($table, withLegacy: true);

            // Targeting geografico
            $table->decimal('radius_km', 8, 2)->nullable(); // Raggio area
            $table->json('target_filters')->nullable(); // Filtri target

            // Programmazione
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }
};
```

## Pattern per Struttura Workflow Notifiche

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Notify\Models\NotificationWorkflow::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Campi workflow
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();

            // NestedSet per gerarchia workflow
            NestedSet::columns($table);

            // Configurazioni workflow
            $table->json('steps')->nullable(); // Passi sequenziali
            $table->json('conditions')->nullable(); // Condizioni branching
            $table->json('timeouts')->nullable(); // Timeout per step

            // Trigger e azioni
            $table->json('triggers')->nullable();
            $table->json('actions')->nullable();

            // Priorità e scheduling
            $table->integer('priority')->default(0);
            $table->boolean('is_enabled')->default(true);

            $table->timestamps();
        });
    }
};
```

## Pattern per Preferenze Utente Gerarchiche

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Notify\Models\UserNotificationPreference::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            // Utente
            $table->unsignedBigInteger('user_id');

            // NestedSet per gerarchia preferenze
            NestedSet::columns($table);

            // Preferenze
            $table->string('category'); // email, sms, push, system
            $table->boolean('is_enabled')->default(true);
            $table->json('settings')->nullable(); // Impostazioni specifiche

            // Orari e frequenza
            $table->json('quiet_hours')->nullable(); // Orari silenzio
            $table->string('frequency')->default('immediate'); // immediate, daily, weekly
            $table->json('schedule')->nullable(); // Programmazione personalizzata

            $table->timestamps();

            // Foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
```

## Riferimenti

- [Documentazione principale](/docs/migration/nestedset-best-practices.md)
- [Notify Module Architecture](/docs/architecture/notify-module.md)
- [AddressItemEnum Integration](/docs/address-item-enum-integration.md)
