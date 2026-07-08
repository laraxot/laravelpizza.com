# Framework Specifics and Integrations

## 🏗️ Framework Architecture

### Filament 4.x Integration

**CRITICAL**: Never extend Filament classes directly. Always use Xot base classes.

```php
// ✅ CORRECT - Extend Xot base classes
class UserResource extends XotBaseResource
class UserPage extends XotBasePage
class UserWidget extends XotBaseWidget

// ❌ WRONG - Direct Filament extension
class UserResource extends Filament\Resources\Resource
```

### Livewire 3.x Components

```php
<?php
declare(strict_types=1);

namespace Modules\ModuleName\Http\Livewire;

use Livewire\Component;
use Modules\ModuleName\Data\UserData;

class UserForm extends Component
{
    public string $name = '';
    public string $email = '';

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ];
    }

    public function save(): void
    {
        $this->validate();

        $userData = new UserData(
            name: $this->name,
            email: $this->email,
        );

        app(CreateUserAction::class)->execute($userData);

        session()->flash('success', __('User created successfully'));
        $this->reset();
    }

    public function render()
    {
        return view('modulename::livewire.user-form');
    }
}
```

### Tailwind CSS 4.x Styling

Use utility-first approach with consistent design tokens:

```blade
{{-- Consistent spacing and colors --}}
<div class="bg-white rounded-lg shadow-sm p-6 space-y-4">
    <h2 class="text-xl font-semibold text-gray-900">{{ $title }}</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">
                {{ __('Name') }}
            </label>
            <input type="text"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
        </div>
    </div>
</div>
```

## 🔧 Laravel Boost Optimizations

### Performance Enhancements

```php
// Optimized Eloquent queries
$users = User::with(['posts' => function ($query) {
    $query->latest()->limit(5);
}])->get();

// Use chunking for large datasets
User::chunk(1000, function ($users) {
    foreach ($users as $user) {
        // Process in batches
    }
});

// Cache expensive operations
Cache::remember('stats', 3600, function () {
    return DB::table('users')
        ->selectRaw('COUNT(*) as total, AVG(age) as avg_age')
        ->first();
});
```

### Database Optimizations

```php
// Efficient indexing
Schema::table('users', function (Blueprint $table) {
    $table->index(['status', 'created_at']);
    $table->index('email'); // For login queries
});

// Query optimization
$activeUsers = User::where('status', 'active')
    ->where('last_login', '>', now()->subDays(30))
    ->select(['id', 'name', 'email']) // Only needed columns
    ->get();
```

## 🎨 UI Component Patterns

### Filament Form Components

```php
<?php
declare(strict_types=1);

class UserResource extends XotBaseResource
{
    public static function getFormSchema(): array
    {
        return [
            Section::make('Personal Information')
                ->columnSpanFull()
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('first_name')
                            ->required(),
                        TextInput::make('last_name')
                            ->required(),
                    ]),

                    TextInput::make('email')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true),

                    DatePicker::make('birth_date')
                        ->native(false)
                        ->displayFormat('d/m/Y'),
                ]),

            Section::make('Professional Information')
                ->columnSpanFull()
                ->schema([
                    Select::make('department_id')
                        ->relationship('department', 'name')
                        ->searchable()
                        ->preload(),

                    TextInput::make('position')
                        ->required(),

                    MoneyInput::make('salary')
                        ->currency('EUR')
                        ->locale('it_IT'),
                ]),
        ];
    }
}
```

### Table Components

```php
public function getTableColumns(): array
{
    return [
        TextColumn::make('name')
            ->searchable()
            ->sortable(),

        TextColumn::make('email')
            ->searchable()
            ->copyable(),

        BadgeColumn::make('status')
            ->colors([
                'success' => 'active',
                'danger' => 'inactive',
            ]),

        TextColumn::make('created_at')
            ->dateTime()
            ->sortable()
            ->toggleable(),
    ];
}
```

## 🔗 Integration Patterns

### API Resource Classes

```php
<?php
declare(strict_types=1);

namespace Modules\Api\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->when(
                $request->user()?->can('view-user-email', $this->resource),
                $this->email
            ),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
```

### Event-Driven Architecture

```php
<?php
declare(strict_types=1);

namespace Modules\ModuleName\Events;

class UserCreated
{
    public function __construct(
        public readonly User $user,
        public readonly array $metadata = [],
    ) {}
}

<?php
declare(strict_types=1);

namespace Modules\ModuleName\Listeners;

class SendWelcomeEmail
{
    public function handle(UserCreated $event): void
    {
        // Send welcome email logic
        Mail::to($event->user->email)
            ->send(new WelcomeEmail($event->user));
    }
}
```

---

**See Also**: [Eloquent Properties](eloquent-properties.md) | [Schemaless Attributes](schemaless-attributes.md)
