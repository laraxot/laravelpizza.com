# Migrazioni Modulo GDPR

## Panoramica
Il modulo GDPR utilizza migrazioni per gestire la struttura del database necessaria per il tracciamento dei consensi, l'esportazione dei dati e altre funzionalità GDPR.

## Struttura Database

### Tabella Consensi
```php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        Schema::create('gdpr_consents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('type');
            $table->boolean('value');
            $table->timestamp('expires_at');
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'type']);
            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gdpr_consents');
    }
};
```

### Tabella Esportazioni
```php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        Schema::create('gdpr_data_exports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('format');
            $table->json('data_types');
            $table->string('status');
            $table->string('file_path')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'status']);
            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gdpr_data_exports');
    }
};
```

### Tabella Richieste
```php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        Schema::create('gdpr_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('type');
            $table->string('status');
            $table->json('data');
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gdpr_requests');
    }
};
```

## Seeders

### ConsentSeeder
```php
namespace Modules\Gdpr\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Gdpr\Models\Consent;
use Modules\User\Models\User;

class ConsentSeeder extends Seeder
{
    public function run(): void
    {
        User::all()->each(function (User $user) {
            Consent::factory()
                ->count(2)
                ->create([
                    'user_id' => $user->id,
                ]);
        });
    }
}
```

### DataExportSeeder
```php
namespace Modules\Gdpr\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Gdpr\Models\DataExport;
use Modules\User\Models\User;

class DataExportSeeder extends Seeder
{
    public function run(): void
    {
        User::all()->each(function (User $user) {
            DataExport::factory()
                ->count(1)
                ->create([
                    'user_id' => $user->id,
                ]);
        });
    }
}
```

## Factories

### ConsentFactory
```php
namespace Modules\Gdpr\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Gdpr\Models\Consent;

class ConsentFactory extends Factory
{
    protected $model = Consent::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['marketing', 'analytics']),
            'value' => $this->faker->boolean,
            'expires_at' => now()->addDays(30),
            'metadata' => [
                'ip_address' => $this->faker->ipv4,
                'user_agent' => $this->faker->userAgent,
            ],
        ];
    }

    public function expired(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'expires_at' => now()->subDays(1),
            ];
        });
    }
}
```

### DataExportFactory
```php
namespace Modules\Gdpr\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Gdpr\Models\DataExport;

class DataExportFactory extends Factory
{
    protected $model = DataExport::class;

    public function definition(): array
    {
        return [
            'format' => $this->faker->randomElement(['json', 'csv', 'pdf']),
            'data_types' => ['profile', 'consents'],
            'status' => 'pending',
            'expires_at' => now()->addDays(7),
        ];
    }

    public function completed(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'completed',
                'processed_at' => now(),
                'file_path' => 'exports/data.zip',
            ];
        });
    }
}
```

## Indici e Performance

### Indici Chiave
- `user_id, type` per ricerche frequenti di consensi
- `expires_at` per pulizia automatica
- `status` per monitoraggio esportazioni
- `type, status` per filtraggio richieste

### Ottimizzazioni
- Soft deletes per mantenere storico
- JSON per dati flessibili
- Indici composti per query comuni
- Timestamps per audit trail

## Collegamenti Bidirezionali

### Collegamenti ad Altri Moduli
- [Migrazioni User](../User/docs/migrations.md)
- [Migrazioni Activity](../Activity/docs/migrations.md)
- [Migrazioni Xot](../Xot/docs/migrations.md)

### Collegamenti Interni
- [README Principale](./README.md)
- [Implementazione](./implementation.md)
- [Configurazione](./configuration.md)
- [Testing](./testing.md) 
## Collegamenti tra versioni di migrations.md
* [migrations.md](../../Notify/docs/migrations.md)
* [migrations.md](../../Activity/docs/database/migrations.md)

