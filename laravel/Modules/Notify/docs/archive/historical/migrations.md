# Database Migrations

## Email Templates

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('event')->unique();
            $table->json('subject');
            $table->json('body');
            $table->string('layout')->nullable();
            $table->json('variables')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('delay')->default(0);
            $table->json('cc')->nullable();
            $table->json('bcc')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
```

## Email Logs

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')
                ->nullable()
                ->constrained('email_templates')
                ->nullOnDelete();
            $table->string('event');
            $table->string('recipient');
            $table->string('subject');
            $table->text('body');
            $table->json('variables')->nullable();
            $table->string('status');
            $table->text('error')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
```

## Email Attachments

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')
                ->constrained('email_templates')
                ->cascadeOnDelete();
            $table->string('name');
            $table->string('file_path');
            $table->string('mime_type');
            $table->integer('size');
            $table->timestamps();
        });
    }
};
```

## Email Queue

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_queue', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')
                ->nullable()
                ->constrained('email_templates')
                ->nullOnDelete();
            $table->string('recipient');
            $table->json('variables')->nullable();
            $table->timestamp('scheduled_for');
            $table->timestamp('processed_at')->nullable();
            $table->string('status');
            $table->text('error')->nullable();
            $table->timestamps();
        });
    }
};
```

## Email Layouts

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_layouts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->json('content');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
```

## Stati Email

Gli stati possibili per le email sono:

### Queue Status
- `pending`: In attesa di invio
- `processing`: In fase di invio
- `sent`: Inviata con successo
- `failed`: Invio fallito
- `cancelled`: Invio annullato

### Log Status
- `queued`: Messa in coda
- `sending`: In fase di invio
- `bounced`: Email rimbalzata
- `spam`: Segnalata come spam
- `opened`: Email aperta
- `clicked`: Link cliccato

## Indici

Per ottimizzare le performance, sono stati aggiunti i seguenti indici:

```php
// email_templates
$table->index('event');
$table->index('is_active');

// email_logs
$table->index('status');
$table->index('sent_at');

// email_queue
$table->index('scheduled_for');
$table->index('processed_at');
```

## Relazioni

Le relazioni tra le tabelle sono:

```php
// EmailTemplate
public function logs(): HasMany
{
    return $this->hasMany(EmailLog::class);
}

public function attachments(): HasMany
{
    return $this->hasMany(EmailAttachment::class);
}

public function layout(): BelongsTo
{
    return $this->belongsTo(EmailLayout::class);
}

// EmailLog
public function template(): BelongsTo
{
    return $this->belongsTo(EmailTemplate::class);
}

// EmailQueue
{
}
```

## Vedi Anche

- [Laravel Migrations](https://laravel.com/docs/migrations)
- [Database Mail](database-mail.md)
### Versione HEAD

- [Email Events](events.md)

### Versione Incoming

## Collegamenti tra versioni di migrations.md
* [migrations.md](../../Gdpr/docs/migrations.md)
* [migrations.md](../../Activity/docs/database/migrations.md)

---
