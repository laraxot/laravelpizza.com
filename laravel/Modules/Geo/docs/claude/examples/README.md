# Code Examples

## Filament Patterns

### Resource with Custom Filters

```php
<?php
declare(strict_types=1);

use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\TextColumn;

public function getTableFilters(): array
{
    return [
        SelectFilter::make('status')
            ->options([
                'active' => 'Active',
                'inactive' => 'Inactive',
            ]),
            
        SelectFilter::make('role')
            ->options(function () {
                return Role::pluck('name', 'id')->toArray();
            }),
    ];
}
```

### Custom Form Components

```php
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;

public static function getFormSchema(): array
{
    return [
        Section::make('User Details')
            ->description('Enter user information')
            ->schema([
                Textarea::make('bio')
                    ->rows(3)
                    ->columnSpanFull(),
            ]),
    ];
}
```

## Model Patterns

### Model with Relationships

```php
<?php
declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends BaseModel
{
    /**
     * @return HasMany<Post>
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * @return BelongsTo<Team>
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
```

### Model with Scopes

```php
use Illuminate\Database\Eloquent\Builder;

/**
 * @param Builder<User> $query
 */
public function scopeActive(Builder $query): Builder
{
    return $query->where('status', 'active');
}

/**
 * @param Builder<User> $query
 */
public function scopeByTeam(Builder $query, int $teamId): Builder
{
    return $query->where('team_id', $teamId);
}
```

## Action Patterns

### Action with Validation

```php
<?php
declare(strict_types=1);

namespace Modules\User\Actions;

use Illuminate\Validation\ValidationException;
use Modules\User\Datas\UserData;
use Modules\User\Models\User;

class UpdateUserAction
{
    public function execute(User $user, UserData $data): User
    {
        // Validate business rules
        if ($user->email !== $data->email && User::whereEmail($data->email)->exists()) {
            throw ValidationException::withMessages([
                'email' => 'Email already exists',
            ]);
        }

        $user->update([
            'name' => $data->name,
            'email' => $data->email,
            'phone' => $data->phone,
        ]);

        return $user;
    }
}
```

### Chainable Actions

```php
// Chain multiple actions
$user = app(CreateUserAction::class)
    ->execute($userData)
    ->pipe(fn ($user) => app(SendWelcomeEmailAction::class)->execute($user))
    ->pipe(fn ($user) => app(LogUserActivityAction::class)->execute($user, 'created'));
```

## Migration Patterns

### Migration with Relationships

```php
<?php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        if ($this->hasTable('users')) {
            return;
        }

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->foreignId('team_id')->constrained();
            $table->timestamps();
        });

        $this->tableComment('users', 'System users');
    }
};
```

## Testing Patterns

### Testing Filament Resources

```php
test('can create user via resource', function () {
    $userData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ];

    Livewire::test(CreateUser::class)
        ->fillForm($userData)
        ->call('create')
        ->assertHasNoFormErrors()
        ->assertRedirect('/users');
});

test('validates user email uniqueness', function () {
    User::factory()->create(['email' => 'test@example.com']);

    Livewire::test(CreateUser::class)
        ->fillForm(['email' => 'test@example.com'])
        ->call('create')
        ->assertHasFormErrors(['email' => 'unique']);
});
```

### Testing Actions

```php
test('create user action works', function () {
    $userData = new UserData(
        name: 'John Doe',
        email: 'john@example.com'
    );

    $user = app(CreateUserAction::class)->execute($userData);

    expect($user)
        ->toBeInstanceOf(User::class)
        ->name->toBe('John Doe')
        ->email->toBe('john@example.com');
});
```