# Filament v4 Infolists Migration Guide

## Breaking Changes

### 1. Component Imports
Some component classes have moved.

**Before v3:**
```php
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
```

**After v4:**
```php
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
```

### 2. Section/Fieldset Behavior
Layout components now only consume one column by default.

**Before v3:**
```php
Section::make('Details')->schema([...]) // Full width
```

**After v4:**
```php
Section::make('Details')
    ->columnSpanFull()
    ->schema([...]) // Must explicitly span full width
```

## Infolist Schema Pattern

### Correct v4 Pattern
```php
protected function getInfolistSchema(): array
{
    return [
        Section::make('Personal Information')
            ->schema([
                'name' => TextEntry::make('name'),
                'email' => TextEntry::make('email'),
                'created_at' => TextEntry::make('created_at')->dateTime(),
            ]),
            
        Section::make('Details')
            ->schema([
                'bio' => TextEntry::make('bio')
                ->columnSpanFull(),
            ]),
    ];
}
```

## Infolist Components

### 1. Text Entry
```php
TextEntry::make('name')
    ->label('Name')
    ->default('Not provided'),
```

### 2. Image Entry
```php
ImageEntry::make('avatar')
    ->label('Avatar')
    ->size('xl')
    ->circular()
    ->visibility('public'), // Default in v4
```

### 3. Icon Entry
```php
IconEntry::make('status')
    ->icon('heroicon-o-check-circle')
    ->color('success'),
```

### 4. KeyValue Entry
```php
KeyValueEntry::make('metadata')
    ->label('Metadata')
    ->columnSpanFull(),
```

### 5. Textarea Entry
```php
TextareaEntry::make('description')
    ->columnSpanFull(),
```

### 6. Grid Entry
```php
GridEntry::make('contact_info')
    ->schema([
        'phone' => TextEntry::make('phone'),
        'email' => TextEntry->make('email'),
    ]),
```

## Advanced Features

### 1. Conditional Display
```php
TextEntry::make('secret_key')
    ->visible(fn (): bool => auth()->user()->isAdmin()),
```

### 2. Custom Formatting
```php
TextEntry::make('amount')
    ->formatStateUsing(fn ($state): string => '$' . number_format($state, 2)),
```

### 3. Actions
```php
TextEntry::make('status')
    ->action('copy')
    ->copyable()
    ->copyMessage('Status copied to clipboard'),
```

## Image Entry Specifics

### 1. Limited Remaining Text
```php
ImageEntry::make('gallery')
    ->limitedRemainingText(length: 10)
    ->isStacked(true), // Now default behavior
```

### 2. Image Collection
```php
ImageEntry::make('images')
    ->getState(function (array $state): Collection {
        return $this->record->getMedia('images');
    })
    ->height('100%')
    ->columnSpanFull(),
```

## Common Patterns

### 1. Model Relationships
```php
TextEntry::make('related_posts')
    ->getState(function (array $state): Collection {
        return $this->record->relatedPosts()->limit(5);
    })
```

### 2. Computed Properties
```php
TextEntry::make('full_name')
    ->getState(function (array $state): string {
        return ($state['first_name'] ?? '') . ' ' . ($state['last_name'] ?? '');
    })
```

### 3. Date Formatting
```php
TextEntry::make('created_at')
    ->dateTime()
    ->format('Y-m-d H:i:s'),
```

### 4. Currency Formatting
```php
TextEntry::make('price')
    ->money('EUR')
    ->formatStateUsing(fn ($state): string => '€' . number_format($state / 100, 2)),
```

## Infolist Actions

### 1. Copy Action
```php
TextEntry::make('api_key')
    ->copyable()
    ->copyMessage('API Key copied to clipboard'),
```

### 2. URL Action
```php
TextEntry::make('website')
    ->url()
    ->openUrlInNewTab(),
```

### 3. Color Coding
```php
TextEntry::make('priority')
    ->color(fn ($state): string => match($state) {
        'high' => 'danger',
        'medium' => 'warning',
        'low' => 'success',
        default => 'gray',
    }),
```

## Testing Infolists

### 1. Entry Display Test
```php
test('displays user information correctly', function () {
    $user = User::factory()->create();
    
    Livewire::test(ViewUser::class, ['record' => $user])
        ->assertSeeInfolist('name', $user->name)
        ->assertSeeInfolist('email', $user->email);
});
```

### 2. Conditional Display Test
```php
test('sensitive information only visible to admins', function () {
    $user = User::factory()->create(['role' => 'user']);
    $admin = User::factory()->create(['role' => 'admin']);
    
    Livewire::actingAs($admin)
        ->test(ViewUser::class, ['record' => $user])
        ->assertSeeInfolist('secret_key')
        ->assertDontSeeInfolist('api_key');
});
```

### 3. Image Entry Test
```php
test('displays user avatar correctly', function () {
    $user = User::factory()->create([
        'avatar' => 'avatars/user.jpg',
    ]);
    
    Livewire::test(ViewUser::class, ['record' => $user])
        ->assertSeeInfolist('avatar')
        ->assertSeeInfolist('avatar_url');
});
```