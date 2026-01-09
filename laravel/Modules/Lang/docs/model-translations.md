# Model Translations in `<nome progetto>`

## Overview
In a healthcare application like `<nome progetto>`, translating model data such as medical content, patient information, or service descriptions is critical for user accessibility across different languages. This document outlines how to implement model translations without packages and explores package-based solutions for more complex needs.

## Approach 1: Manual Model Translations (Without Packages)

This approach involves creating separate tables for translatable content, ensuring full control over the database structure and translation logic.

### Database Structure
- **Base Table**: Stores non-translatable data (e.g., IDs, dates).
- **Translation Table**: Stores translatable fields linked to the base table by ID and locale.

Example for a `Service` model in a healthcare context:
```php
// Migration for services table
Schema::create('services', function (Blueprint $table) {
    $table->id();
    $table->dateTime('created_at')->nullable();
    $table->softDeletes();
    $table->timestamps();
});

// Migration for service_translations table
Schema::create('service_translations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('service_id')->constrained()->cascadeOnDelete();
    $table->string('locale');
    $table->string('name');
    $table->text('description');
    $table->softDeletes();
    $table->timestamps();
});
```

### Model Setup
- **Base Model**: Defines relationships and attribute accessors to fetch translations automatically based on the current locale.
- **Translation Model**: Manages the translated content.

```php
// app/Models/Service.php
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [];

    protected $with = ['defaultTranslation'];

    public function name(): Attribute
    {
        return new Attribute(get: fn() => $this->defaultTranslation->name);
    }

    public function description(): Attribute
    {
        return new Attribute(get: fn() => $this->defaultTranslation->description);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(ServiceTranslation::class);
    }

    public function defaultTranslation(): HasOne
    {
        return $this->translations()->one()->where('locale', app()->getLocale());
    }
}

// app/Models/ServiceTranslation.php
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceTranslation extends Model
{
    use SoftDeletes;

    protected $fillable = ['service_id', 'locale', 'name', 'description'];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
```

### Controller Logic
Handle creation and updates by managing translations for each supported locale:

```php
// app/Http/Controllers/ServiceController.php
public function store(Request $request): RedirectResponse
{
    $rules = [];
    foreach (config('app.available_locales') as $locale) {
        $rules += [
            'name.' . $locale => ['required', 'string'],
            'description.' . $locale => ['required', 'string'],
        ];
    }
    $this->validate($request, $rules);

    $service = Service::create([]);
    foreach (config('app.available_locales') as $locale) {
        $service->translations()->create([
            'locale' => $locale,
            'name' => $request->input('name.' . $locale),
            'description' => $request->input('description.' . $locale),
        ]);
    }
    return redirect()->route('services.index');
}
```

### View Integration
Create forms that allow input for each language:

```php
// resources/views/services/create.blade.php
<form action="{{ route('services.store') }}" method="POST">
    @csrf
    @foreach(config('app.available_locales') as $locale)
        <fieldset class="border-2 w-full p-4 rounded-lg mb-4">
            <legend>Content for {{ strtoupper($locale) }}</legend>
            <div class="mb-4">
                <label for="name[{{$locale}}]">Name</label>
                <input type="text" name="name[{{$locale}}]" id="name[{{$locale}}]" class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="{{ old('name.'.$locale) }}">
                @error('name.'.$locale)
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="description[{{$locale}}]">Description</label>
                <textarea name="description[{{$locale}}]" id="description[{{$locale}}]" cols="30" rows="4" class="bg-gray-100 border-2 w-full p-4 rounded-lg">{{ old('description.'.$locale) }}</textarea>
                @error('description.'.$locale)
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </fieldset>
    @endforeach
    <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">Create Service</button>
</form>
```

## Approach 2: Using Packages for Model Translations

### Spatie Laravel Translatable
- **Purpose**: Simplifies model translations by storing translations in a JSON column.
- **Key Features**:
  - JSON-based storage for translations
  - Easy attribute access with current locale
  - Fallback locale support
- **Implementation**:
  ```bash
  composer require spatie/laravel-translatable
  ```
  Add the `HasTranslations` trait to models:
  ```php
  // app/Models/Service.php
  use Spatie\Translatable\HasTranslations;
  class Service extends Model
  {
      use HasTranslations;
      public $translatable = ['name', 'description'];
  }
  ```
  Store translations:
  ```php
  $service = new Service();
  $service->setTranslation('name', 'en', 'Medical Consultation');
  $service->setTranslation('name', 'it', 'Consultazione Medica');
  $service->save();
  ```
  Retrieve:
  ```php
  echo $service->name; // Returns based on current locale
  ```

### Astrotomic Laravel Translatable
- **Purpose**: Uses a separate translation table per model, similar to the manual approach but with built-in helpers.
- **Key Features**:
  - Dedicated translation tables
  - Automatic relationship management
  - Fallback support
- **Implementation**:
  ```bash
  composer require astrotomic/laravel-translatable
  php artisan vendor:publish --provider="Astrotomic\Translatable\TranslatableServiceProvider"
  php artisan migrate
  ```
  Configure models with `Translatable` contract and trait, defining translatable fields.

## Recommendation for `<nome progetto>`
- **Primary Approach**: Start with **Spatie Laravel Translatable** for its simplicity and efficiency with JSON columns. This is ideal for most healthcare content models where quick setup and maintenance are priorities.
- **Fallback**: For complex models requiring detailed translation tracking or separate table structures (e.g., for audit purposes), consider the manual approach or **Astrotomic Laravel Translatable**.

This strategy ensures flexibility to adapt based on model complexity while maintaining ease of use for developers and translators in a healthcare setting.
