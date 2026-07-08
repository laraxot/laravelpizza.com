# Spatie Laravel Translatable - Guida Completa

## Introduzione

**Spatie Laravel Translatable** è il package standard per gestire campi translatable in Laravel. È utilizzato in tutto il progetto PTVX per gestire contenuti multilingua.

## Installazione

```bash
composer require spatie/laravel-translatable
```

## Configurazione

### Migrazione

```php
Schema::create('posts', function (Blueprint $table) {
    $table->id();
    $table->json('name'); // Campo translatable
    $table->json('description'); // Campo translatable
    $table->timestamps();
});
```

### Modello

```php
<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    use HasTranslations;

    // Campi che possono essere tradotti
    public $translatable = ['name', 'description'];

    protected $fillable = ['name', 'description'];
}
```

## Utilizzo Base

### Creazione Record con Traduzioni

```php
$post = new Post();

// Imposta traduzioni
$post->setTranslation('name', 'en', 'Hello World');
$post->setTranslation('name', 'it', 'Ciao Mondo');
$post->setTranslation('description', 'en', 'This is a description');
$post->setTranslation('description', 'it', 'Questa è una descrizione');

$post->save();
```

### Lettura Traduzioni

```php
// Ottieni traduzione specifica
$nameInEnglish = $post->getTranslation('name', 'en');
$nameInItalian = $post->getTranslation('name', 'it');

// Ottieni tutte le traduzioni per un campo
$allNames = $post->getTranslations('name');

// Ottieni campo nella lingua corrente
$currentName = $post->name; // Usa la lingua dell'app
```

### Aggiornamento Traduzioni

```php
// Aggiorna traduzione esistente
$post->setTranslation('name', 'en', 'Updated Hello World');

// Aggiungi nuova lingua
$post->setTranslation('name', 'fr', 'Bonjour le Monde');

$post->save();
```

## Utilizzo Avanzato

### Lingua di Default

```php
// Imposta lingua di default nel modello
public function getDefaultLocale(): string
{
    return 'it'; // Italiano come default
}
```

### Traduzioni Automatiche

```php
// Il modello gestisce automaticamente la lingua corrente
app()->setLocale('en');
echo $post->name; // Restituisce la traduzione inglese

app()->setLocale('it');
echo $post->name; // Restituisce la traduzione italiana
```

### Validazione

```php
$request->validate([
    'name' => 'required|array',
    'name.en' => 'required|string|max:255',
    'name.it' => 'required|string|max:255',
    'description' => 'array',
    'description.*' => 'string|max:1000',
]);
```

## Integrazione con Filament

### Form Components

```php
use Filament\Forms\Components\TextInput;

TextInput::make('name')
    ->required()
    ->translatable(), // Abilita traduzioni multiple

TextInput::make('description')
    ->translatable(),
```

### Table Columns

```php
use Filament\Tables\Columns\TextColumn;

TextColumn::make('name')
    ->translatable(),

TextColumn::make('description')
    ->translatable()
    ->limit(50),
```

## Best Practices

### 1. Struttura Database

```php
// ✅ CORRETTO - Usa JSON per campi translatable
$table->json('name');
$table->json('description');

// ❌ SBAGLIATO - Non usare stringhe separate per lingue
$table->string('name_it');
$table->string('name_en');
```

### 2. Nomi Campi

```php
// ✅ CORRETTO
public $translatable = ['title', 'content', 'excerpt'];

// ❌ SBAGLIATO - Non usare underscore per separare lingue
public $translatable = ['title_it', 'title_en'];
```

### 3. Validazione

```php
// ✅ CORRETTO
'name' => 'required|array',
'name.*' => 'required|string|max:255',

// ❌ SBAGLIATO - Validazione separata per lingue
'name_it' => 'required|string|max:255',
'name_en' => 'required|string|max:255',
```

### 4. Performance

```php
// ✅ CORRETTO - Carica solo la lingua necessaria
Post::where('name->en', 'Hello')->first();

// ❌ SBAGLIATO - Carica tutte le traduzioni
Post::withTranslations()->get();
```

## Troubleshooting

### Errore: "Plugin [spatie-translatable] is not registered"

**Causa**: Il plugin Spatie Translatable non è registrato nel Panel Filament.

**Soluzione**:
```php
// Nel Panel Provider
use LaraZeus\SpatieTranslatable\TranslatablePlugin;

$panel->plugins([
    TranslatablePlugin::make(),
]);
```

### Errore: Traduzioni non salvate

**Causa**: Il modello non ha il trait HasTranslations.

**Soluzione**:
```php
use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    use HasTranslations;

    public $translatable = ['name', 'description'];
}
```

### Errore: Lingua non trovata

**Causa**: Lingua non configurata o non esistente.

**Soluzione**:
```php
// Verifica lingue supportate
config('translatable.locales');

// Imposta lingua di default
public function getDefaultLocale(): string
{
    return 'it';
}
```

## Configurazione Completa

### config/translatable.php

```php
<?php

return [
    /*
     * Se le traduzioni dovrebbero essere esportate. Quando false,
     * solo la traduzione nella lingua corrente dell'app viene esportata.
     */
    'export_current_locale' => false,

    /*
     * Le lingue supportate dall'applicazione.
     */
    'locales' => [
        'en',
        'it',
        'de',
        'fr',
    ],

    /*
     * La lingua di default che verrà usata quando non c'è traduzione disponibile.
     */
    'fallback_locale' => 'it',

    /*
     * Se dovremmo usare la lingua di default come fallback quando non c'è
     * traduzione disponibile per la lingua richiesta.
     */
    'use_fallback' => true,

    /*
     * Se dovremmo usare la proprietà del modello come fallback quando non c'è
     * traduzione disponibile per la lingua richiesta.
     */
    'use_property_fallback' => true,

    /*
     * Se dovremmo sempre includere la lingua di default nelle traduzioni
     * anche quando è la stessa della lingua dell'app.
     */
    'always_include_default' => false,
];
```

## Testing

### Test Base

```php
<?php

use Modules\Blog\Models\Post;

it('can set and get translations', function () {
    $post = new Post();

    $post->setTranslation('name', 'en', 'Hello');
    $post->setTranslation('name', 'it', 'Ciao');

    expect($post->getTranslation('name', 'en'))->toBe('Hello');
    expect($post->getTranslation('name', 'it'))->toBe('Ciao');
});
```

### Test con Filament

```php
it('can handle translatable fields in forms', function () {
    $post = Post::factory()->create();

    livewire(CreatePost::class)
        ->fillForm([
            'name' => [
                'en' => 'Test Post',
                'it' => 'Post di Test',
            ],
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(Post::latest()->first()->getTranslation('name', 'en'))->toBe('Test Post');
});
```

## Performance

### Ottimizzazioni

1. **Caricamento Selettivo**: Carica solo le lingue necessarie
2. **Caching**: Usa cache per traduzioni frequenti
3. **Indexing**: Aggiungi indici sui campi JSON
4. **Lazy Loading**: Carica traduzioni solo quando necessario

### Query Optimization

```php
// ✅ Buono - Carica solo la lingua necessaria
Post::where('name->en', 'Hello')->first();

// ❌ Cattivo - Carica tutte le traduzioni
Post::withTranslations()->get();
```

## Integrazione con Altri Package

### Spatie Laravel Permission

```php
class Post extends Model
{
    use HasTranslations, HasRoles;

    public $translatable = ['name'];
}
```

### Spatie Laravel Activity Log

```php
class Post extends Model
{
    use HasTranslations, LogsActivity;

    protected static $logAttributes = ['name', 'description'];

    public $translatable = ['name', 'description'];
}
```

## Migration da Vecchi Sistemi

### Da Campi Separati

```php
// ❌ VECCHIO
$table->string('name_it');
$table->string('name_en');
$table->string('name_de');

// ✅ NUOVO
$table->json('name');
```

### Migrazione Dati

```php
// Migrazione dati da campi separati
foreach (OldPost::all() as $oldPost) {
    $newPost = new Post();
    $newPost->setTranslation('name', 'it', $oldPost->name_it);
    $newPost->setTranslation('name', 'en', $oldPost->name_en);
    $newPost->setTranslation('name', 'de', $oldPost->name_de);
    $newPost->save();
}
```

## Risorse Esterne

- [Documentazione Ufficiale](https://spatie.be/docs/laravel-translatable)
- [Plugin Filament](https://filamentphp.com/plugins/lara-zeus-spatie-translatable)
- [Repository GitHub](https://github.com/spatie/laravel-translatable)

---

*Ultimo aggiornamento: Sistema di documentazione automatica*
