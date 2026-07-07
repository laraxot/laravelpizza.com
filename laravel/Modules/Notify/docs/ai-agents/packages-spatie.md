# Spatie Packages Reference

Pacchetti Spatie installati in Quaeris Fila5 Mono.

## Versioni installate

| Pacchetto | Versione | Scopo |
|-----------|----------|-------|
| spatie/laravel-data | 4.19.1 | DTOs, validazione, trasformazione |
| spatie/laravel-queueable-action | 2.17.0 | Pattern Action (regola del progetto) |
| spatie/laravel-event-sourcing | 7.15.0 | Event sourcing (modulo Activity) |
| spatie/laravel-activitylog | 4.12.1 | Log attività utente |
| spatie/laravel-medialibrary | 11.21.0 | File/media associati a model |
| spatie/laravel-permission | 7.2.2 | Ruoli e permessi |
| spatie/laravel-model-states | 2.12.1 | State machine per model |
| spatie/laravel-database-mail-templates | 3.7.2 | Template email in DB |
| spatie/laravel-translatable | 6.13.0 | Traduzioni JSON su colonne model |
| spatie/laravel-health | 1.38.0 | Health check applicazione |
| spatie/laravel-responsecache | 7.7.2 | Cache risposte HTTP |
| spatie/laravel-tags | 4.11.0 | Sistema tag per model |
| spatie/laravel-sluggable | 3.8.0 | Generazione slug automatica |
| spatie/laravel-personal-data-export | 4.3.2 | Export GDPR dati personali |
| spatie/laravel-schemaless-attributes | 2.6.0 | JSON attributes NoSQL-like |
| spatie/eloquent-sortable | 5.0.1 | Ordinamento model |
| spatie/laravel-model-status | 1.20.0 | Status tracking model |

---

## spatie/laravel-data 4.19.1

**Uso**: DTOs tipizzati per validazione, API response, TypeScript generation.

```php
// Creazione DTO
class SurveyFilterData extends Data
{
    public function __construct(
        public string $tenant,
        public ?int $survey_id = null,
        public ?string $period = 'month',
    ) {}
}

// Uso
$data = SurveyFilterData::from($request);
$data = SurveyFilterData::from(['tenant' => 'acme', 'survey_id' => 42]);
```

**Lazy properties** (caricamento ritardato):
```php
class PostData extends Data
{
    public string $title;

    #[Lazy]
    public UserData $author;
}
```

**Validazione automatica** dai type hints:
- `string` → `required|string`
- `?string` → `nullable|string`
- `int` → `required|integer`

---

## spatie/laravel-queueable-action 2.17.0

**REGOLA CRITICA**: Questo progetto NON usa Service classes. Tutto la business logic va in Action classes con questo trait.

```php
class SendNotificationAction
{
    use QueueableAction;

    public function __construct(
        protected NotifyService $service,
    ) {}

    public function execute(User $user, NotificationData $data): void
    {
        $this->service->send($user, $data);
    }

    public function tags(): array { return ['notification']; }

    public function backoff(): array { return [1, 5, 10]; }
}

// Sync
(new SendNotificationAction($service))->execute($user, $data);

// Async
(new SendNotificationAction($service))->onQueue()->execute($user, $data);
(new SendNotificationAction($service))->onQueue('notifications')->execute($user, $data);
```

**Testing**:
```php
Queue::fake();
(new MyAction)->onQueue()->execute();
QueueableActionFake::assertPushed(MyAction::class);
```

**Allineamento importante con il package ufficiale**:
- constructor injection supportata e ricostruita correttamente quando il job gira in coda
- `execute()` e `__invoke()` sono entrambi supportati; nel progetto preferiamo `execute()`
- hook supportati: `tags()`, `middleware()`, `backoff()`, `retryUntil()`, `failed()`
- chaining via `Spatie\QueueableAction\ActionJob`
- chiave config ufficiale del package: `queuableaction`, non `queueableaction`

Vedi il riferimento operativo completo: [`spatie-queueable-action.md`](./spatie-queueable-action.md)

---

## spatie/laravel-event-sourcing 7.15.0

Usato nel modulo Activity.

**Modelli del progetto**:
- `Modules/Activity/app/Models/StoredEvent.php` — estende `SpatieStoredEvent`
- `Modules/Activity/app/Models/Snapshot.php` — estende `SpatieSnapshot`

```php
// Evento
class UserCreated implements ShouldBeStored
{
    public function __construct(
        public string $uuid,
        public string $email,
    ) {}
}

// Aggregate Root
class UserAggregate extends AggregateRoot
{
    public function create(string $email): self
    {
        $this->recordThat(new UserCreated($this->uuid, $email));
        return $this;
    }

    protected function applyUserCreated(UserCreated $event): void
    {
        $this->email = $event->email;
    }
}

// Projector (read model)
class UserProjector extends Projector
{
    public function onUserCreated(UserCreated $event): void
    {
        User::create(['uuid' => $event->uuid, 'email' => $event->email]);
    }
}
```

---

## spatie/laravel-medialibrary 11.21.0

Usato nel modulo Media.

```php
class News extends BaseModel
{
    use HasMedia;

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 300, 300);
    }
}

// Upload
$model->addMedia($request->file('image'))->toMediaCollection('images');

// Recupero
$model->getFirstMediaUrl('images', 'thumb');
```

---

## spatie/laravel-permission 7.2.2

```php
$user->givePermissionTo('edit articles');
$user->assignRole('writer');
$user->can('edit articles');

$role = Role::create(['name' => 'writer']);
$role->givePermissionTo('edit articles');
```

---

## spatie/laravel-model-states 2.12.1

```php
abstract class PaymentState extends State
{
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            ->allowTransition(Pending::class, Paid::class)
            ->allowTransition(Pending::class, Failed::class);
    }
}

// Model
class Payment extends BaseModel
{
    use HasStates;
    protected $casts = ['state' => PaymentState::class];
}

// Uso
$payment->state->transitionTo(Paid::class);
$payment->save();
```

---

## spatie/laravel-database-mail-templates 3.7.2

Usato nel modulo Notify (`MailTemplate` model).

```php
// Template in DB con Mustache syntax
MailTemplate::create([
    'mailable' => WelcomeMail::class,
    'subject' => 'Welcome, {{ name }}',
    'html_template' => '<p>Hello, {{ name }}.</p>',
]);

// Mailable
class WelcomeMail extends TemplateMailable
{
    public string $name;
    public function __construct(User $user) { $this->name = $user->name; }
}
```

---

## spatie/laravel-translatable 6.13.0

JSON translations senza tabelle extra.

```php
use Spatie\Translatable\HasTranslations;

class NewsItem extends BaseModel
{
    use HasTranslations;
    public array $translatable = ['name', 'description'];
}

$item->setTranslation('name', 'it', 'Nome italiano')->save();
$item->getTranslation('name', 'en'); // English name
$item->name; // Current locale
```

---

## spatie/laravel-sluggable 3.8.0

```php
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Article extends BaseModel
{
    use HasSlug;

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
}
```

---

## spatie/laravel-schemaless-attributes 2.6.0

```php
$model->extra_attributes->name = 'value';
$model->extra_attributes->get('settings.theme', 'light');
$model->extra_attributes->set('config.debug', true);
$model->save();
```

---

## Flusso dati pattern (tutti i pacchetti)

```
Request → Data (Validazione) → Action (Business Logic) → Model → Event/Activity
```
