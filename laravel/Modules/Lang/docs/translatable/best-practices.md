# Best Practices per Laravel Translatable

Questo documento raccoglie le migliori pratiche per l'utilizzo del pacchetto `spatie/laravel-translatable` nel contesto del progetto.

## Dichiarazione delle Proprietà Traducibili

### ✅ Approccio Raccomandato

```php
class Page extends Model
{
    use HasTranslations;
    
    /**
     * Gli attributi che sono traducibili.
     *
     * @var array<int, string>
     */
    protected function translatable(): array
    {
        return ['title', 'content', 'meta_description'];
    }
}
```

### ❌ Approccio Deprecato (Laravel < 12)

```php
class Page extends Model
{
    use HasTranslations;
    
    public $translatable = ['title', 'content', 'meta_description'];
}
```

## Gestione Coerente delle Traduzioni Mancanti

### Centralizzazione della Configurazione

Centralizzare tutte le configurazioni di fallback in un unico service provider:

```php
// Modules/Lang/app/Providers/TranslatableServiceProvider.php
namespace Modules\Lang\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Translatable\Facades\Translatable;

class TranslatableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Translatable::fallback(
            fallbackLocale: config('app.fallback_locale'),
            fallbackAny: true,
            missingKeyCallback: function ($model, $key, $locale, $fallback, $fallbackLocale) {
                // Implementazione del callback
            }
        );
    }
}
```

### Fallback a Livello di Modello

Per modelli con esigenze specifiche di fallback:

```php
class MailTemplate extends Model
{
    use HasTranslations;
    
    /**
     * Determina la locale di fallback per questo modello.
     */
    public function getFallbackLocale(): string
    {
        // Logica specifica del modello
        return $this->custom_fallback_locale ?? config('app.fallback_locale');
    }
}
```

## Validazione delle Traduzioni

### Validare Tutte le Lingue Supportate

```php
// Nella classe del request
public function rules()
{
    $rules = [];
    
    foreach (config('app.supported_locales') as $locale) {
        $rules["title.{$locale}"] = 'required|string|max:255';
        $rules["content.{$locale}"] = 'required|string';
    }
    
    return $rules;
}
```

### Validazione Personalizzata

```php
// Estensione del trait HasTranslations
trait HasStrictTranslations
{
    use HasTranslations;
    
    /**
     * Imposta una traduzione con validazione.
     */
    public function setTranslation($key, $locale, $value)
    {
        // Validazione specifica
        if ($key === 'email_subject' && strlen($value) > 100) {
            throw new \InvalidArgumentException("L'oggetto email non può superare 100 caratteri");
        }
        
        return parent::setTranslation($key, $locale, $value);
    }
}
```

## Pattern di Accesso alle Traduzioni

### In Controller e Services

```php
// Ottieni tutte le traduzioni (per form di editing)
$translations = $model->getTranslations('field_name');

// Ottieni nella lingua corrente
$translation = $model->field_name;

// Ottieni in lingua specifica
$translation = $model->getTranslation('field_name', 'en');

// Ottieni con fallback garantito
$translation = $model->getTranslation('field_name', 'fr') 
    ?? $model->getTranslation('field_name', app()->getFallbackLocale()) 
    ?? '';
```

### Nelle Viste (Blade)

```blade
{{-- Versione base --}}
{{ $model->field_name }}

{{-- Lingua specifica con fallback esplicito --}}
{{ $model->getTranslation('field_name', $locale) ?? $model->getTranslation('field_name', 'it') }}

{{-- Helper per supportare HTML --}}
{!! $model->getTranslation('html_content', $locale) !!}
```

## Gestione Efficiente dei Contenuti Multilingua nell'UI

### Form con Tab Linguistiche

```blade
<div class="language-tabs">
    @foreach(config('app.available_locales') as $locale)
        <div class="tab" data-locale="{{ $locale }}">
            <label>{{ $title }} ({{ $locale }})</label>
            <input type="text" 
                   name="title[{{ $locale }}]" 
                   value="{{ $model->getTranslation('title', $locale, false) }}">
        </div>
    @endforeach
</div>
```

### Integrazione con Filament

```php
// Nei form Filament
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Tabs::make('Translations')
                ->tabs([
                    Tab::make('Italiano')
                        ->schema([
                            TextInput::make('title.it')
                                ->label('Titolo'),
                            // ...
                        ]),
                    Tab::make('English')
                        ->schema([
                            TextInput::make('title.en')
                                ->label('Title'),
                            // ...
                        ]),
                ]),
        ]);
}
```

## Ottimizzazione delle Prestazioni

### Caricamento Selettivo delle Traduzioni

```php
// Recupera solo i campi necessari
$model = Model::select(['id', 'translations'])->find($id);

// Elabora solo le lingue necessarie
$currentLocale = app()->getLocale();
$title = $model->getTranslation('title', $currentLocale);
```

### Indicizzazione dei Campi Traducibili

```php
// Nelle migrazioni
Schema::table('pages', function (Blueprint $table) {
    // Indice full-text per ricerche nelle traduzioni
    $table->fullText('translations');
});

// Per ricerche specifiche
Model::whereRaw("JSON_EXTRACT(translations, '$.title.it') LIKE ?", ["%{$search}%"])->get();
```

## Debugging delle Traduzioni

### Visualizzazione di Tutte le Traduzioni

```php
dd($model->getTranslations());
```

### Verifica Traduzione Specifica

```php
$hasTranslation = $model->hasTranslation('field_name', 'en');
```

## Test

### Testing delle Traduzioni

```php
public function testTranslations()
{
    $model = Model::factory()->create();
    
    $model->setTranslations('title', [
        'it' => 'Titolo italiano',
        'en' => 'English title',
    ]);
    
    $this->assertEquals('Titolo italiano', $model->getTranslation('title', 'it'));
    $this->assertEquals('English title', $model->getTranslation('title', 'en'));
    
    // Test fallback
    $this->assertEquals('Titolo italiano', $model->getTranslation('title', 'fr'));
}
```

## Migrazioni da Modelli non Tradotti

```php
// Script di migrazione
$models = OldModel::all();

foreach ($models as $oldModel) {
    $newModel = new NewModel();
    $newModel->setTranslation('title', 'it', $oldModel->title);
    $newModel->setTranslation('title', 'en', $oldModel->title_en ?? $oldModel->title);
    $newModel->save();
}
```

## Risoluzione conflitti e standard
- Il file `lang/it/lang_service.php` è stato risolto manualmente per conflitti git: rimossi duplicati, mantenute solo le chiavi effettive secondo queste best practices.
- Vedi anche: [../README.md](../README.md)
