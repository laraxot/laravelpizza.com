# Laravel Framework Conventions

## Basic Requirements

All PHP files in PTVX must follow strict typing and Laraxot standards:

```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Feature;

// All PHP files require:
// - strict_types declaration
// - PSR-12 compliance
// - Complete PHPDoc documentation
// - PHPStan Level 10 compatibility
```

### Service Provider Configuration

```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class ModuleNameServiceProvider extends XotBaseServiceProvider
{
    /**
     * Module name identifier.
     */
    public string $name = 'ModuleName';

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        parent::boot();

        // Only add module-specific customizations here
        // XotBaseServiceProvider handles all standard bootstrapping
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        parent::register();

        // Only register module-specific services
        // XotBaseServiceProvider handles standard registrations
    }
}
```

## Routing and Middleware

### Modular Routes Structure

```php
<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])
    ->prefix('module-name')
    ->name('module-name.')
    ->group(__DIR__.'/routes/web.php');

Route::middleware(['api'])
    ->prefix('api/module-name')
    ->name('api.module-name.')
    ->group(__DIR__.'/routes/api.php');
```

### Controller Authorization

```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\ModuleName\Models\ModelName;

class ModelNameController extends Controller
{
    /**
     * Update the specified resource.
     */
    public function update(Request $request, ModelName $model): RedirectResponse
    {
        $this->authorize('update', $model);

        // Controller logic here
        $model->update($request->validated());

        return redirect()->back()
            ->with('success', __('module-name::messages.updated'));
    }
}
```

## Validation Patterns

### Form Request Classes

```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateModelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', ModelName::class);
    }

    /**
     * Get the validation rules.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'unique:model_names,email',
                'max:255'
            ],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => __('module-name::validation.name.required'),
            'email.unique' => __('module-name::validation.email.unique'),
        ];
    }
}
```

### Inline Validation in Controllers

```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ModelNameController extends Controller
{
    /**
     * Store a new resource.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::unique('model_names', 'email'),
                'max:255'
            ],
        ]);

        // Create model with validated data
        ModelName::create($validated);

        return redirect()->route('module-name.index')
            ->with('success', __('module-name::messages.created'));
    }
}
```

---

**Version**: 4.0
**Last Updated**: December 2025
**Applies to**: Laravel Framework conventions
