# Validation Conventions

## Form Request Classes

### Complete Form Request Implementation

```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Form request for creating a new user.
 *
 * Validates user creation data and ensures proper authorization.
 */
class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Check if user can create users in general
        // or specific business logic
        return $this->user()->can('create', User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            // Basic field validations
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                'regex:/^[a-zA-Z\s\-\'\.]+$/u'
            ],

            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
                Rule::unique('users', 'email')
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'max:255',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
                'confirmed'
            ],

            'password_confirmation' => [
                'required',
                'string'
            ],

            // Conditional validations
            'company_id' => [
                'nullable',
                'integer',
                'exists:companies,id',
                Rule::requiredIf(function (): bool {
                    return $this->input('user_type') === 'employee';
                })
            ],

            'department_id' => [
                'nullable',
                'integer',
                Rule::requiredIf(function (): bool {
                    return !is_null($this->input('company_id'));
                }),
                Rule::exists('departments', 'id')->where(function ($query) {
                    $query->where('company_id', $this->input('company_id'));
                })
            ],

            // Array validations
            'roles' => [
                'nullable',
                'array',
                'min:1',
                'max:5'
            ],

            'roles.*' => [
                'integer',
                'exists:roles,id',
                'distinct'
            ],

            // File validations
            'avatar' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:2048', // 2MB
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
            ],

            // Date validations
            'birth_date' => [
                'nullable',
                'date',
                'before:today',
                'after:1900-01-01'
            ],

            'start_date' => [
                'nullable',
                'date',
                'after_or_equal:today',
                'before:' . now()->addYears(2)->format('Y-m-d')
            ],
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
            'name.required' => __('validation.name.required'),
            'name.regex' => __('validation.name.invalid_characters'),
            'email.unique' => __('validation.email.already_exists'),
            'password.min' => __('validation.password.too_short'),
            'password.regex' => __('validation.password.weak'),
            'password.confirmed' => __('validation.password.confirmation_mismatch'),
            'company_id.required' => __('validation.company.required_for_employees'),
            'department_id.required' => __('validation.department.required'),
            'roles.min' => __('validation.roles.at_least_one'),
            'roles.max' => __('validation.roles.too_many'),
            'avatar.image' => __('validation.avatar.must_be_image'),
            'avatar.max' => __('validation.avatar.too_large'),
            'avatar.dimensions' => __('validation.avatar.invalid_dimensions'),
            'birth_date.before' => __('validation.birth_date.must_be_past'),
            'start_date.after_or_equal' => __('validation.start_date.must_be_future'),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => __('fields.name.label'),
            'email' => __('fields.email.label'),
            'password' => __('fields.password.label'),
            'company_id' => __('fields.company.label'),
            'department_id' => __('fields.department.label'),
            'roles' => __('fields.roles.label'),
            'avatar' => __('fields.avatar.label'),
            'birth_date' => __('fields.birth_date.label'),
            'start_date' => __('fields.start_date.label'),
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            // Custom validation logic after all other validations pass
            if ($this->hasValidRolesForCompany()) {
                $validator->errors()->add('roles', __('validation.roles.invalid_for_company'));
            }
        });
    }

    /**
     * Check if selected roles are valid for the chosen company.
     */
    private function hasValidRolesForCompany(): bool
    {
        $companyId = $this->input('company_id');
        $roleIds = $this->input('roles', []);

        if (!$companyId || empty($roleIds)) {
            return false;
        }

        return Role::where('company_id', $companyId)
            ->whereIn('id', $roleIds)
            ->count() === count($roleIds);
    }
}
```

## Model Validation Rules

### Validation in Models

```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

/**
 * User model with validation rules.
 */
class User extends BaseModel
{
    /**
     * Get validation rules for this model.
     *
     * @param array<string, mixed> $data
     * @param bool $isCreating
     * @return array<string, array<int, mixed>>
     */
    public static function getValidationRules(array $data = [], bool $isCreating = true): array
    {
        $userId = $isCreating ? null : ($data['id'] ?? null);

        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId)
            ],
            'password' => $isCreating ? ['required', 'string', 'min:8'] : ['nullable', 'string', 'min:8'],
            'company_id' => ['nullable', 'integer', 'exists:companies,id'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
        ];
    }

    /**
     * Validate model data before saving.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::saving(function (self $model): void {
            $rules = self::getValidationRules($model->toArray(), $model->exists);

            $validator = validator($model->toArray(), $rules);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
        });
    }
}
```

## API Validation

### API Resource Validation

```php
<?php

declare(strict_types=1);

namespace Modules\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * API request for user creation/update.
 */
class UserApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // API authentication handled by middleware
    }

    /**
     * Get the validation rules.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'data' => ['required', 'array'],
            'data.name' => ['required', 'string', 'max:255'],
            'data.email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->route('user'))
            ],
            'data.password' => [
                $this->isMethod('post') ? 'required' : 'nullable',
                'string',
                'min:8'
            ],
            'data.roles' => ['array'],
            'data.roles.*' => ['integer', 'exists:roles,id'],
        ];
    }

    /**
     * Get validated data with proper structure.
     *
     * @return array<string, mixed>
     */
    public function validatedData(): array
    {
        $validated = parent::validated();

        return [
            'name' => $validated['data']['name'],
            'email' => $validated['data']['email'],
            'password' => $validated['data']['password'] ?? null,
            'roles' => $validated['data']['roles'] ?? [],
        ];
    }
}
```

## Custom Validation Rules

### Creating Custom Rules

```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Custom validation rule for strong passwords.
 */
class StrongPassword implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)) {
            $fail(__('validation.password.must_be_string'));
            return;
        }

        if (strlen($value) < 8) {
            $fail(__('validation.password.too_short'));
            return;
        }

        if (!preg_match('/[a-z]/', $value)) {
            $fail(__('validation.password.missing_lowercase'));
            return;
        }

        if (!preg_match('/[A-Z]/', $value)) {
            $fail(__('validation.password.missing_uppercase'));
            return;
        }

        if (!preg_match('/[0-9]/', $value)) {
            $fail(__('validation.password.missing_number'));
            return;
        }

        if (!preg_match('/[^a-zA-Z0-9]/', $value)) {
            $fail(__('validation.password.missing_special'));
            return;
        }
    }
}
```

### Using Custom Rules

```php
<?php

declare(strict_types=1);

use Modules\ModuleName\Rules\StrongPassword;

class CreateUserRequest extends FormRequest
{
    /**
     * Get the validation rules.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'password' => ['required', 'string', new StrongPassword()],
            // Other rules...
        ];
    }
}
```

## Validation in Livewire Components

### Livewire Validation

```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Http\Livewire;

use Livewire\Component;
use Modules\ModuleName\Models\User;

/**
 * User creation component with real-time validation.
 */
class CreateUser extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Validation rules.
     *
     * @return array<string, array<int, string>>
     */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'name.required' => __('user::validation.name.required'),
            'email.unique' => __('user::validation.email.unique'),
            'password.confirmed' => __('user::validation.password.confirmed'),
        ];
    }

    /**
     * Real-time validation for specific fields.
     */
    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Create the user.
     */
    public function save(): void
    {
        $validatedData = $this->validate();

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        $this->reset();
        $this->dispatch('user-created');
    }

    /**
     * Render the component.
     */
    public function render(): View
    {
        return view('module-name::livewire.create-user');
    }
}
```

---

**Version**: 4.0
**Last Updated**: December 2025
**Focus**: Comprehensive validation patterns
