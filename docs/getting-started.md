# 🚀 Guida Rapida - Getting Started

**Ultimo aggiornamento**: 31 Gennaio 2026
**Tempo richiesto**: 30-45 minuti
**Livello**: Intermedio-Avanzato

---

## 📋 Prerequisiti

### Software Richiesto
- **PHP**: 8.3+
- **Composer**: 2.x
- **Node.js**: 18.x+
- **NPM**: 9.x+
- **MySQL**: 8.0+ oppure **SQLite** (per development)
- **Git**: 2.x+

### Conoscenze Richieste
- Laravel intermediario/avanzato
- Conoscenza base di modularità (nwidart/laravel-modules)
- Filament (admin panel)
- Livewire/Volt (frontend components)
- Folio (file-based routing)
- PHPStan (static analysis)

---

## 🎯 1. Clone e Setup Iniziale

```bash
# Clona il repository
git clone git@github.com:laraxot/laravelpizza.com.git base_laravelpizza
cd base_laravelpizza

# Installa dipendenze PHP
cd laravel
composer install

# Installa dipendenze Node
npm install

# Copia .env
cp .env.example .env

# Genera application key
php artisan key:generate

# Configura il database (modifica .env)
# Per development usa SQLite:
touch database/database.sqlite

# Configura .env per SQLite:
# DB_CONNECTION=sqlite
# DB_DATABASE=/var/www/_bases/base_laravelpizza/laravel/database/database.sqlite

# Esegui migrations
php artisan migrate

# Build assets frontend
npm run dev  # Per development
# oppure
npm run build  # Per production
```

---

## 🧱 2. Struttura del Progetto

```bash
base_laravelpizza/
├── laravel/              # Applicazione Laravel
│   ├── Modules/          # Moduli business logic (14 moduli)
│   │   ├── Xot/          # Framework Laraxot (core)
│   │   ├── User/         # Autenticazione & Autorizzazione
│   │   ├── Meetup/       # Business logic meetup
│   │   └── ...
│   │
│   ├── Themes/           # Temi frontend
│   │   └── Meetup/       # Tema frontoffice premium
│   │
│   └── app/              # Core legacy (minimo utilizzo)
│
└── docs/                 # Documentazione root
```

---

## 📚 3. Leggi la Documentazione Critica

### In Ordine di Importanza

1. **Regole Critiche Laraxot**
   ```
   laravel/Modules/Xot/docs/critical-rules-consolidated.md
   ```
   - Fondamentale per capire l'architettura Laraxot
   - Regole obbligatorie per tutto il codice
   - 30 minuti di lettura

2. **Regole Meetup Theme**
   ```
   laravel/Themes/Meetup/docs/critical-rules-consolidated.md
   ```
   - Fondamentale per lavoro frontend
   - Folio + Volt architecture
   - 20 minuti di lettura

3. **PHPStan Level 10**
   ```
   laravel/Modules/Xot/docs/phpstan-code-quality-guide.md
   ```
   - Quality guide per type safety
   - Pattern di correzione errori
   - 45 minuti di lettura

4. **Panoramica Progetto**
   ```
   docs/project-overview.md
   ```
   - Overview completo di tutti i moduli
   - Architettura e dipendenze
   - 30 minuti di lettura

---

## 🧪 4. Verifica Setup

```bash
# Verifica PHPStan Level 10
./vendor/bin/phpstan analyse Modules --level=10 --memory-limit=-1

# Dovresti vedere: [OK] No errors

# Verifica moduli attivi
php artisan module:list

# Verifica tema Meetup
cd ../Themes/Meetup
npm run build && npm run copy
cd ../..

# Avvia server sviluppo
php artisan serve

# Apri browser:
# - http://127.0.0.1:8000/it (frontoffice)
# - http://127.0.0.1:8000/admin (Filament admin)
```

---

## 🔑 5. Credenziali Admin

### Utente Admin di Default
Dopo le migrations, crea un utente admin:

```bash
php artisan tinker

# Esegui in tinker:
use Modules\User\Models\User;
use Illuminate\Support\Facades\Hash;

User::create([
    'email' => 'admin@laravelpizza.com',
    'name' => 'Admin User',
    'password' => Hash::make('password'),
])->assignRole('super_admin');
```

Oppure usa i seeders se disponibili:
```bash
php artisan db:seed --class=AdminUserSeeder
```

---

## 🎨 6. Sviluppo Frontend (Meetup Theme)

### Workflow Sviluppo Frontend

```bash
# Entra nella directory tema
cd laravel/Themes/Meetup

# Watch mode per development
npm run watch

# In un altro terminal, avvia Laravel
cd ../..
php artisan serve
```

### Creare una Nuova Pagina (Folio)

```bash
# Crea file pagina in Folio
touch laravel/Themes/Meetup/resources/views/pages/test-page.blade.php
```

```php
<!-- laravel/Themes/Meetup/resources/views/pages/test-page.blade.php -->
<x-meetup-layouts.app>
    <x-slot:title>Test Page</x-slot:title>

    <div class="container mx-auto py-12">
        <h1 class="text-4xl font-bold">Test Page</h1>
        <p>Questa è una pagina di test con Folio.</p>
    </div>
</x-meetup-layouts.app>
```

### Creare un Componente Volt

```bash
# Crea file componente Volt
touch laravel/Themes/Meetup/resources/views/livewire/test-component.blade.php
```

```php
<!-- laravel/Themes/Meetup/resources/views/livewire/test-component.blade.php -->
<?php

use Livewire\Volt\Component;

new class extends Component {
    public int $count = 0;

    public function increment(): void
    {
        $this->count++;
    }
?>

<div>
    <h1>Count: {{ $count }}</h1>
    <button wire:click="increment">Increment</button>
</div>
```

### Importante: Dopo Modifiche CSS/JS

```bash
# OBBLIGATORIO dopo ogni modifica CSS/JS
cd laravel/Themes/Meetup
npm run build && npm run copy
```

---

## 🛠️ 7. Sviluppo Backend (Moduli)

### Esempio: Creare una nuova Action

```php
<?php

// Modules/Meetup/app/Actions/CreateEventAction.php

declare(strict_types=1);

namespace Modules\Meetup\Actions;

use Modules\Meetup\Models\Event;
use Modules\Meetup\Data\EventData;
use Spatie\QueueableAction\QueueableAction;

class CreateEventAction
{
    use QueueableAction;

    public function execute(EventData $data): Event
    {
        return Event::create([
            'title' => $data->title,
            'description' => $data->description,
            'event_date' => $data->eventDate,
            'location' => $data->location,
        ]);
    }
}
```

### Esempio: Usare l'Action

```php
<?php

// In un controller o Volt component

use Modules\Meetup\Actions\CreateEventAction;
use Modules\Meetup\Data\EventData;

class CreateEventComponent extends Component
{
    public string $title = '';
    public string $description = '';
    public ?string $eventDate = null;
    public string $location = '';

    public function create(): void
    {
        $data = EventData::from([
            'title' => $this->title,
            'description' => $this->description,
            'eventDate' => $this->eventDate,
            'location' => $this->location,
        ]);

        $event = CreateEventAction::dispatch($data);

        session()->flash('message', 'Evento creato con successo!');
    }
}
```

---

## ✅ 8. PHPStan Compliance

### Verifica Prima di Commit

```bash
# Analisi completa
./vendor/bin/phpstan analyse Modules --level=10 --memory-limit=-1

# Analisi singolo modulo
./vendor/bin/phpstan analyse Modules/Meetup --level=10

# Analisi file specifico
./vendor/bin/phpstan analyse Modules/Meetup/app/Actions/CreateEventAction.php --level=10
```

### Pattern Comuni PHPStan

#### Type Narrowing
```php
// ❌ SBAGLIATO
public function process($data)
{
    return $data['key'];
}

// ✅ CORRETTO
public function process(array $data): string
{
    $value = $data['key'] ?? '';
    /** @var string $value */
    return $value;
}
```

#### Eloquent Magic Properties
```php
// ❌ SBAGLIATO - property_exists() non funziona con magic attributes
if (property_exists($model, 'attribute')) {
    return $model->attribute;
}

// ✅ CORRETTO - usa isset()
if (isset($model->attribute)) {
    return $model->attribute;
}

// ✅ ANCHE CORRETTO - usa hasAttribute()
if ($model->hasAttribute('attribute')) {
    return $model->attribute;
}
```

---

## 🧪 9. Testing

### Esegui Test

```bash
# Tutti i test
./vendor/bin/pest

# Test specifico modulo
./vendor/bin/pest Modules/User/tests

# Test specifico file
./vendor/bin/pest Modules/Meetup/tests/Feature/EventTest.php

# Test con coverage
./vendor/bin/pest --coverage
```

### Esempio Test Feature

```php
<?php

// Modules/Meetup/tests/Feature/EventTest.php

use Modules\Meetup\Models\Event;
use Modules\User\Models\User;
use function Pest\Laravel\actingAs;

it('can create an event', function () {
    $user = User::factory()->create();
    actingAs($user)
        ->post('/admin/events', [
            'title' => 'Test Event',
            'description' => 'Test Description',
            'event_date' => now()->addWeek(),
        ])
        ->assertStatus(302);

    expect(Event::where('title', 'Test Event')->exists())->toBeTrue();
});
```

---

## 📝 10. Flusso di Lavoro Consigliato

### Per Nuova Funzionalità

1. **Leggi la documentazione** del modulo pertinente
2. **Crea/Aggiorna docs** per la nuova funzionalità
3. **Scrivi test** prima del codice (TDD)
4. **Implementa codice** seguendo regole Laraxot
5. **Verifica PHPStan Level 10**
6. **Esegui test**
7. **Formatta codice** con Pint
8. **Commit e push**

### Comandi Utili

```bash
# Verifica PHPStan
./vendor/bin/phpstan analyse Modules --level=10

# Formatta codice
./vendor/bin/pint --dirty

# Verifica test
./vendor/bin/pest

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Build assets tema
cd laravel/Themes/Meetup
npm run build && npm run copy
```

---

## 🐛 11. Troubleshooting Comune

### Problema: PHPStan Errors
```bash
# Analisi dettagliata
./vendor/bin/phpstan analyse Modules --level=10 --error-format=table

# Controlla pattern comuni nel code quality guide
cat laravel/Modules/Xot/docs/phpstan-code-quality-guide.md
```

### Problema: Assets Non Funzionano
```bash
# Rebuild assets tema
cd laravel/Themes/Meetup
npm run build && npm run copy

# Clear cache
cd ../..
php artisan view:clear
php artisan cache:clear
```

### Problema: Folio Routes Non Trovate
```bash
# Clear route cache
php artisan route:clear

# Verifica file Folmino esistono
ls -la laravel/Themes/Meetup/resources/views/pages/
```

### Problema: Moduli Non Caricati
```bash
# Verifica moduli attivi
php artisan module:list

# Verifica modules_statuses.json
cat laravel/modules_statuses.json

# Clear cache
php artisan config:clear
composer dump-autoload
```

---

## 📚 12. Risorse Aggiuntive

### Documentazione Essenziale
- [Panoramica Progetto](project-overview.md)
- [Regole Critiche Xot](../laravel/Modules/Xot/docs/critical-rules-consolidated.md)
- [Regole Critiche Meetup Theme](../laravel/Themes/Meetup/docs/critical-rules-consolidated.md)
- [PHPStan Code Quality Guide](../laravel/Modules/Xot/docs/phpstan-code-quality-guide.md)
- [Filament v5 Study](filament-v5-study-summary.md)

### Documentazione Moduli
- [Xot Module](../laravel/Modules/Xot/docs/README.md)
- [User Module](../laravel/Modules/User/docs/README.md)
- [Meetup Module](../laravel/Modules/Meetup/docs/README.md)
- [Meetup Theme](../laravel/Themes/Meetup/docs/README.md)

### Documentazione Esterna
- [Laravel 12.x Documentation](https://laravel.com/docs/12.x)
- [Filament 5.x Documentation](https://filamentphp.com/docs/5.x)
- [Livewire 4.x Documentation](https://livewire.laravel.com/docs/4.x)
- [Laravel Volt Documentation](https://laravel.com/docs/12.x/volt)
- [Laravel Folio Documentation](https://laravel.com/docs/12.x/folio)
- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)

---

## 🎯 Checklist Primo Commit

Prima di fare il tuo primo commit, verifica:

- [ ] Ho letto le regole critiche Laraxot
- [ ] Ho letto le regole critiche Meetup Theme
- [ ] Ho capito l'architettura DRY+KISS+SOLID
- [ ] PHPStan Level 10 passa (0 errori)
- [ ] Tutti i test passano
- [ ] Codice formattato con Pint
- [ ] Ho aggiornato/creato documentazione
- [ ] Ho aggiunto test per nuove funzionalità
- [ ] Assets tema rebuilt (se modifiche CSS/JS)
- [ ] Commit message segue convention

---

## 🚀 Primi Passi Suggeriti

### Per Sviluppatori Frontend
1. Esplora `Themes/Meetup/resources/views/pages/`
2. Studia componenti in `Themes/Meetup/resources/views/components/`
3. Crea una pagina di test con Folio
4. Crea un componente Volt semplice
5. Integrazione con layout Meetup

### Per Sviluppatori Backend
1. Esplora `Modules/Xot/` per capire architettura base
2. Studia `Modules/User/` per pattern RBAC
3. Esplora `Modules/Meetup/` per business logic
4. Crea una nuova Action
5. Crea un nuovo Resource Filament

### Per Sviluppatori Full-Stack
1. Segui entrambi i percorsi sopra
2. Integrazione frontend-backend
3. Creazione feature end-to-end
4. Testing completo
5. PHPStan compliance

---

**Buon coding! 🍕**

Se hai domande o problemi, controlla prima la documentazione del modulo pertinente. Se non trovi risposta, apri un issue su GitHub.