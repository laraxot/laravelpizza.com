# Filament v4 Forms Migration Guide

## Breaking Changes

### 1. Method Signature Changes
The `make()` method signature has changed for many components.

**Before:**
```php
public static function make(string $name): static
```

**After:**
```php
public static function make(?string $name = null): static
```

**Alternative Pattern:**
```php
// Use getDefaultName() instead
public static function getDefaultName(): ?string
{
    return 'field_name';
}

// Use setUp() for default configuration
protected function setUp(): void
{
    parent::setUp();
    $this->label('Field Label');
}
```

### 2. Layout Components Behavior
Grid, Section, and Fieldset no longer span full width by default.

**Before v3:**
```php
Section::make('Title')->schema([...]) // Full width by default
```

**After v4:**
```php
Section::make('Title')
    ->columnSpanFull()
    ->schema([...]) // Must explicitly span full width
```

### 3. unique() Validation Rule
Now ignores current record by default.

**Before v3:**
```php
TextInput::make('email')->unique()
```

**After v4:**
```php
TextInput::make('email')->unique() // Ignores record by default
TextInput::make('email')->unique(ignoreRecord: false) // Old behavior
```

## Form Schema Pattern

### Correct v4 Pattern
```php
public static function getFormSchema(): array
{
    return [
        'personal_info' => Section::make('Personal Information')
            ->columnSpanFull()
            ->schema([
                'name_email_grid' => Grid::make(2)
                    ->schema([
                        'name' => TextInput::make('name')
                            ->required(),
                        'email' => TextInput::make('email')
                            ->email()
                            ->required(),
                    ]),
            ]),
            
        'details_section' => Section::make('Details')
            ->columnSpanFull()
            ->schema([
                'bio' => Textarea::make('bio')
                    ->rows(3),
            ]),
    ];
}
```

## Field Updates

### 1. Text Input
```php
TextInput::make('name')
    ->required()
    ->maxLength(255)
    ->placeholder('Enter name')
```

### 2. Select with Enums
```php
Select::make('status')
    ->options(Status::class)
    ->required()
// Field state is always enum instance now
```

### 3. Checkbox List
```php
CheckboxList::make('permissions')
    ->options(Permission::class)
    ->bulkToggleable()
```

### 4. Radio Buttons
```php
Radio::make('type')
    ->options([
        'type_a' => 'Type A',
        'type_b' => 'Type B',
    ])
    ->inline() // Only affects buttons, not labels
    ->inlineLabel() // Buttons + labels inline (v3 behavior)
```

### 5. File Upload
```php
FileUpload::make('attachment')
    ->directory('attachments')
    ->visibility('private') // Default in v4
    ->acceptedFileTypes(['pdf', 'doc', 'docx'])
```

## Form Actions

### 1. Submit Action
```php
protected function getFormActions(): array
{
    return [
        Actions\Action::make('Save')
            ->action('save')
            ->requiresConfirmation()
            ->color('primary'),
    ];
}
```

### 2. Custom Actions
```php
protected function getFormActions(): array
{
    return [
        Actions\Action::make('send_email')
            ->action('sendEmail')
            ->icon('heroicon-o-envelope')
            ->requiresConfirmation()
            ->visible(fn (): bool => $this->record->canSendEmail()),
    ];
}
```

## Validation

### 1. Field Validation
```php
TextInput::make('email')
    ->email()
    ->required()
    ->rules(['email', 'unique:users,email,'.$this->record->id']),
```

### 2. Custom Validation
```php
TextInput::make('password')
    ->required()
    ->rules([
        'required',
        'min:8',
        'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!#%&*?])(?=.*[A-Za-z0-9])/',
    ])
    ->validationAttribute('password', 'Password must be complex'),
```

### 3. Conditional Validation
```php
TextInput::make('confirm_password')
    ->required()
    ->password()
    ->rules(['required', 'confirmed'])
    ->visible(fn (Get $get): bool => $get('password') !== ''),
```

## File Generation Configuration

### Enable Embedded Schemas
```php
// In config/filament.php
'file_generation' => [
    'flags' => [
        \Filament\Support\Commands\FileGenerators\FileGenerationFlag::EMBEDDED_PANEL_RESOURCE_SCHEMAS,
    ],
],
```

## Common Patterns

### 1. Dependent Fields
```php
TextInput::make('confirm_password')
    ->password()
    ->required(fn (Get $get): bool => $get('password') !== ''),
```

### 2. Reactive Fields
```php
TextInput::make('category')
    ->reactive()
    ->afterStateUpdated(function ($state, callable $set) {
        if ($state) {
            $set('subcategory', []);
        }
    }),
```

### 3. Hidden Fields
```php
Hidden::make('user_id')
    ->default(fn () => auth()->id()),
```

## Testing Forms

### 1. Form Submission Test
```php
test('can create user with valid data', function () {
    Livewire::test(CreateUser::class)
        ->fillForm([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ])
        ->call('create')
        ->assertHasNoFormErrors();
});
```

### 2. Validation Test
```php
test('email validation works', function () {
    Livewire::test(CreateUser::class)
        ->fillForm([
            'email' => 'invalid-email',
        ])
        ->call('create')
        ->assertHasFormErrors(['email']);
});
```

### 3. Reactive Field Test
```php
test('dependent fields work correctly', function () {
    Livewire::test(CreateUser::class)
        ->fillForm(['password' => 'secret123'])
        ->assertFormFieldIsVisible('confirm_password')
        ->fillForm(['password' => null])
        ->assertFormFieldIsNotVisible('confirm_password');
});
```