# Pacchetti Altri — Riferimento

Riferimento per i pacchetti non-Spatie, non-Filament del progetto.

## Moduli e architettura

### nwidart/laravel-modules 12.0.4

Struttura moduli del progetto:

```
Modules/
  Activity/   — event sourcing, activity log
  Chart/      — chart rendering (Chart.js + JpGraph)
  Cms/        — content management
  Gdpr/       — GDPR compliance
  Geo/        — dati geografici (comuni)
  Job/        — job queue management
  Lang/       — traduzioni
  Limesurvey/ — integrazione LimeSurvey
  Media/      — file e media
  Notify/     — notifiche (email, SMS, Telegram, WhatsApp)
  Quaeris/    — survey management
  Tenant/     — multi-tenancy
  UI/         — componenti UI
  User/       — autenticazione, Passport, Socialite
  Xot/        — core module (XotBase, traits, utilities)
```

**Regole namespace** (v12, già configurato):
- `"Modules\\": "Modules/"` NON piu richiesto (auto-discovery)
- `merge-plugin` include: `["Modules/*/composer.json"]`
- `allow-plugins: wikimedia/composer-merge-plugin: true` OBBLIGATORIO

**Comandi**:
```bash
php artisan module:list
php artisan module:enable ModuleName
php artisan module:disable ModuleName
php artisan module:make-model MyModel --module=Job
php artisan module:make-action MyAction --module=Job
```

---

## File e media

### pbmedia/laravel-ffmpeg 8.8.0

Usato nel modulo Media per conversione video.

```php
// Actions in Modules/Media/app/Actions/
FFMpeg::fromDisk('videos')
    ->open('video.mp4')
    ->export()
    ->inFormat(new X264)
    ->save('output.mp4');

// Con progress callback
FFMpeg::fromDisk('videos')
    ->open('video.mp4')
    ->export()
    ->onProgress(function (float $percentage) {
        // ...
    })
    ->save('output.mp4');
```

**Modelli**: `MediaConvert` — traccia le conversion jobs.
**Actions**: `ConvertVideoAction`, `GetVideoDurationAction`, `GetVideoFrameContentAction`

### intervention/image 3.11.7

Manipolazione immagini (resize, crop, filter, watermark):

```php
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

$manager = new ImageManager(new Driver());
$image = $manager->read('image.jpg');
$image->resize(300, 200)->save('thumbnail.jpg');
$image->toWebp(80)->save('image.webp');
```

---

## Export / Import

### maatwebsite/excel 3.1.67

Usato in `Modules/Xot/app/Exports/` per export Excel/CSV.

```php
// Export da query
class QueryExport implements FromQuery, WithHeadings, WithMapping, ShouldQueue
{
    use Exportable;

    public function query() { return Task::where('is_active', true); }
    public function headings(): array { return ['ID', 'Name', 'Status']; }
    public function map($row): array { return [$row->id, $row->name, $row->status]; }
    public function chunkSize(): int { return 200; }
}

// Download
return Excel::download(new QueryExport, 'tasks.xlsx');
// Store
Excel::store(new QueryExport, 'tasks.xlsx', 'local');
// Queue
Excel::queue(new QueryExport, 'tasks.xlsx', 's3');
```

---

## Chart generation

### amenadiel/jpgraph 4.1.1

Generazione chart PHP lato server (per PDF e Excel).

Usato via `phpoffice/phpspreadsheet` per chart in export Excel e direttamente nel modulo Chart per generazione immagini chart:

```php
// In Modules/Chart/app/Actions/JpGraph/V1/BarAction.php
$graph = new Graph(800, 400);
$graph->SetScale('textlin');
$barplot = new BarPlot($data);
$graph->Add($barplot);
$graph->Stroke('/path/to/output.png');
```

---

## Autenticazione

### laravel/passport 13.5.0

OAuth2 server per API (configurato in `Modules/User/`).

```php
// Token scopes configurati
'view-user' => 'View user information',
'core-technicians' => 'Access to core technician features',

// Expiration (via .env)
PASSPORT_ACCESS_TOKEN_EXPIRATION_DAYS=15
PASSPORT_REFRESH_TOKEN_EXPIRATION_DAYS=30
PASSPORT_PERSONAL_ACCESS_TOKEN_EXPIRATION_MONTHS=6
```

### laravel/socialite 5.24.3

OAuth social login. Provider attivi:
- `socialiteproviders/microsoft` — Entra ID / Office 365
- `socialiteproviders/auth0` — Auth0

```php
return Socialite::driver('microsoft')->redirect();
$user = Socialite::driver('microsoft')->user();
```

---

## Analytics e trend

### flowframe/laravel-trend 0.4.0

Trend data per grafici dashboard. Usato in `Modules/Xot/app/Filament/Widgets/ModelTrendChartWidget.php`.

```php
$results = Trend::model(User::class)
    ->between(start: now()->subDays(30), end: now())
    ->perDay()
    ->count();

// Returns array of TrendValue objects with date and aggregate
// Chart.js labels: $results->pluck('date')
// Chart.js data:   $results->pluck('aggregate')
```

### aaronfrancis/fast-paginate 2.0.0

Paginazione ottimizzata per tabelle grandi via deferred join:

```php
// Usa fastPaginate() invece di paginate() su tabelle grandi
User::where('active', true)->fastPaginate(15);
```

---

## Modelli speciali

### calebporzio/sushi 2.5.4

Model Eloquent con dati da array/JSON (senza tabella DB).

Usato in `Modules/Tenant/app/Models/TestSushiModel.php` con trait custom `SushiToJson`:

```php
class TestSushiModel extends BaseModel
{
    use \Sushi\Sushi;

    protected $rows = [
        ['id' => 1, 'name' => 'Test 1'],
        ['id' => 2, 'name' => 'Test 2'],
    ];
}

// Oppure dinamico
public function getRows(): array
{
    return json_decode(file_get_contents('data.json'), true);
}

// Uso identico a Eloquent
TestSushiModel::where('name', 'Test 1')->first();
TestSushiModel::all();
```

### genealabs/laravel-model-caching 12.0.4

Cache automatica query Eloquent:

```php
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class ExpensiveModel extends BaseModel
{
    use Cachable;
    protected $cacheDurationInSeconds = 3600;
}

// Le query sono automaticamente cachate
ExpensiveModel::where('active', true)->get();
```

---

## Localizzazione

### mcamara/laravel-localization 2.3.0

Routing multi-lingua con prefix URL:

```
/it/survey/123  → Italiano
/en/survey/123  → English
```

Usato nel modulo Lang.

---

## Relazioni avanzate

### staudenmeir/eloquent-has-many-deep 1.21.2

Relazioni nested multi-livello:

```php
// Relazione profonda: Author → Posts → Comments
public function comments(): HasManyDeep
{
    return $this->hasManyDeep(Comment::class, [Post::class]);
}

Author::whereHas('posts.comments')->get();
```

### kirschbaum-development/eloquent-power-joins 4.2.11

JOIN fluenti su relazioni Eloquent:

```php
// Standard: join manuale
User::join('posts', 'posts.user_id', '=', 'users.id')

// Power joins: via relazione definita
User::joinRelation('posts')
    ->where('posts.published', true)
    ->get();
```

---

## Comunicazione

### irazasyed/telegram-bot-sdk 3.15.0

SDK Telegram per notifiche (modulo Notify). Usato in `SendNutgramTelegramAction`.

### kreait/laravel-firebase 7.0.0

Firebase Admin SDK per push notification e realtime data:

```php
use Kreait\Laravel\Firebase\Facades\Firebase;

$auth = Firebase::auth();
$db = Firebase::database();
$messaging = Firebase::messaging();

// Push notification
$message = CloudMessage::withTarget('token', $deviceToken)
    ->withNotification(Notification::create('Title', 'Body'));
$messaging->send($message);
```

---

## QR Code

### chillerlan/php-qrcode 5.0.5

Generazione QR code:

```php
use chillerlan\QRCode\QRCode;

$qrcode = (new QRCode)->render('https://example.com/survey/123');
// Output: base64 PNG o SVG
```

---

## Performance

### doctrine/dbal 4.4.1

Astrazione DB per schema inspection. Usato da Laravel migrations per operazioni DDL avanzate.

### predis/predis 3.4.1

Client Redis puro PHP per cache e session.

---

## Architettura moduli — riferimento rapido

```
Xot (Core)
├── Exports/* → maatwebsite/excel
├── Widgets/ModelTrendChartWidget → flowframe/laravel-trend
├── Actions/* → spatie/laravel-queueable-action
└── Models/BaseModel (tutti i modelli ereditano da qui)

Media
├── Actions/ConvertVideo* → pbmedia/laravel-ffmpeg
└── Models/Media → spatie/laravel-medialibrary

Job
├── Models/Export, Import → maatwebsite/excel
└── Models/Task, Schedule → Filament scheduling

Tenant
├── Models/TestSushiModel → calebporzio/sushi
└── SushiToJson trait → JSON file persistence

User
├── Passport → laravel/passport
└── Socialite → laravel/socialite + microsoft + auth0

Activity
├── StoredEvent → spatie/laravel-event-sourcing
└── Activity → spatie/laravel-activitylog

Lang
└── Localization → mcamara/laravel-localization
```
