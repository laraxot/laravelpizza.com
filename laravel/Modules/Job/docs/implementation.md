# Implementazione Job

## Struttura del Codice

### Convenzioni
- Seguire PSR-12 per lo stile del codice
- Mantenere una lunghezza massima di 120 caratteri per riga
- Utilizzare indentazione di 4 spazi
- Inserire una riga vuota tra i metodi
- Utilizzare parentesi graffe su nuova riga per classi e metodi

### Nomenclatura
- **Classi**: PascalCase (es. `JobResource`)
- **Metodi**: camelCase (es. `validateJob`)
- **Variabili**: camelCase (es. `jobStatus`)
- **Costanti**: UPPER_SNAKE_CASE (es. `MAX_JOBS`)
- **Interfacce**: PascalCase con suffisso Interface (es. `JobServiceInterface`)
- **Trait**: PascalCase con suffisso Trait (es. `JobTrait`)

### Type Hinting
- Utilizzare sempre type hints per parametri e return types
- Utilizzare tipi nullable quando appropriato (es. `?string`)
- Utilizzare union types quando necessario (es. `string|int`)
- Utilizzare mixed solo quando strettamente necessario

## Architettura

### Pattern Utilizzati
- Repository Pattern per l'accesso ai dati
- Service Layer per la logica di business
- Factory Pattern per la creazione di oggetti complessi
- Observer Pattern per eventi e notifiche
- Strategy Pattern per algoritmi variabili

### Directory Structure
```
Job/
├── Console/
├── Database/
│   ├── Migrations/
│   └── Seeders/
├── Filament/
│   ├── Resources/
│   ├── Pages/
│   └── Widgets/
├── Models/
├── Providers/
├── Services/
└── Traits/
```

## Implementazione Filament

### Resource Base
```php
namespace Modules\Job\Filament\Resources;

use Filament\Resources\Resource;

class JobResource extends Resource
{
    protected static ?string $model = null;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Job';

    public static function getNavigationLabel(): string
    {
        return static::$navigationLabel ?? Str::headline(static::getModelLabel());
    }
}
```

### Pages
```php
namespace Modules\Job\Filament\Pages;

use Filament\Pages\Page;

class JobPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Job';
    protected static string $view = 'job::filament.pages.job';

    public function mount()
    {
        $this->form->fill([
            'jobs' => $this->getJobs(),
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('title')
                ->label('Titolo')
                ->required(),
            Forms\Components\Textarea::make('description')
                ->label('Descrizione')
                ->required(),
            Forms\Components\Select::make('status')
                ->label('Stato')
                ->options([
                    'draft' => 'Bozza',
                    'published' => 'Pubblicato',
                    'closed' => 'Chiuso',
                ])
                ->required(),
        ];
    }
}
```

### Widgets
```php
namespace Modules\Job\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class JobStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Lavori', Job::count())
                ->description('Lavori attivi')
                ->descriptionIcon('heroicon-m-briefcase'),
            Stat::make('Candidature', Application::count())
                ->description('Candidature ricevute')
                ->descriptionIcon('heroicon-m-document-text'),
        ];
    }
}
```

## Servizi

### Gestione Lavori
```php
namespace Modules\Job\Services;

interface JobServiceInterface
{
    public function createJob(array $data): void;
    public function updateJob(string $id, array $data): void;
    public function deleteJob(string $id): void;
    public function getJobDetails(string $id): array;
    public function getJobsByStatus(string $status): array;
}
```

### Gestione Candidature
```php
namespace Modules\Job\Services;

interface ApplicationServiceInterface
{
    public function submitApplication(string $jobId, array $data): void;
    public function updateApplicationStatus(string $id, string $status): void;
    public function getApplicationDetails(string $id): array;
    public function getApplicationsByJob(string $jobId): array;
}
```

## Database

### Convenzioni
- Nomi tabelle in snake_case plurale (es. `jobs`)
- Nomi colonne in snake_case (es. `job_status`)
- Chiavi esterne: `{table}_id` (es. `user_id`)
- Timestamps: `created_at`, `updated_at`, `deleted_at`
- Soft deletes per tutte le tabelle principali

### Migrazioni
```php
Schema::create('jobs', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description');
    $table->string('status');
    $table->morphs('owner');
    $table->json('data')->nullable();
    $table->timestamps();
    $table->softDeletes();
});

Schema::create('applications', function (Blueprint $table) {
    $table->id();
    $table->foreignId('job_id')->constrained();
    $table->morphs('applicant');
    $table->string('status');
    $table->json('data')->nullable();
    $table->timestamps();
    $table->softDeletes();
});
```

### Indici
```php
Schema::table('jobs', function (Blueprint $table) {
    $table->index(['status', 'created_at']);
    $table->index(['owner_type', 'owner_id']);
});

Schema::table('applications', function (Blueprint $table) {
    $table->index(['job_id', 'status']);
    $table->index(['applicant_type', 'applicant_id']);
});
```

## Frontend

### Views
```php
// resources/views/job/job.blade.php
<x-filament::page>
    <x-filament::form wire:submit="save">
        <x-filament::card>
            <x-filament::form-section>
                <x-slot name="title">
                    Gestione Lavoro
                </x-slot>

                <x-slot name="description">
                    Gestisci i dettagli del lavoro
                </x-slot>

                {{ $this->form }}
            </x-filament::form-section>
        </x-filament::card>
    </x-filament::form>
</x-filament::page>
```

### Folio
```php
// routes/folio.php
Route::get('/job', \Modules\Job\Filament\Pages\JobPage::class);
```

## Testing

### Convenzioni
- Test unitari per ogni classe
- Test di integrazione per flussi complessi
- Test di feature per Filament e Folio
- Utilizzare data providers quando appropriato
- Seguire il pattern "given-when-then"

### Unit Tests
```php
class JobServiceTest extends TestCase
{
    public function test_create_job()
    {
        $data = [
            'title' => 'Sviluppatore PHP',
            'description' => 'Descrizione lavoro',
            'status' => 'draft'
        ];

        $this->jobService->createJob($data);

        $job = Job::where('title', $data['title'])->first();
        $this->assertNotNull($job);
        $this->assertEquals($data['status'], $job->status);
    }
}
```

### Feature Tests
```php
class JobPageTest extends TestCase
{
    public function test_can_render_job_page()
    {
        $this->get('/job')
            ->assertStatus(200)
            ->assertSee('Gestione Lavoro');
    }

    public function test_can_save_job()
    {
        $this->post('/job', [
            'title' => 'Sviluppatore PHP',
            'description' => 'Descrizione lavoro',
            'status' => 'draft'
        ])
        ->assertStatus(200)
        ->assertSessionHas('success');
    }
}
```
### Versione HEAD

### Versione HEAD

## Collegamenti tra versioni di implementation.md
* [implementation.md](../../../Gdpr/docs/implementation.md)
* [implementation.md](../../../Xot/docs/implementation.md)
* [implementation.md](../../../Job/docs/implementation.md)

### Versione Incoming

---

### Versione Incoming

---
