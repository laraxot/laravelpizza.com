# Template Classi Base - Modulo Xot

## 🎯 Panoramica

Template standardizzati per tutte le classi del sistema Laraxot, seguendo i principi DRY + KISS.

## 🏗️ Template Modello Base

### **BaseModel Standard**
```php
<?php

declare(strict_types=1);

namespace Modules\{ModuleName}\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * {Description} model.
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, RelatedModel> $relatedModels
 */
class {ModelName} extends BaseModel
{
    /** @var list<string> */
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    /** @var list<string> */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get related models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<RelatedModel>
     */
    public function relatedModels(): HasMany
    {
        return $this->hasMany(RelatedModel::class);
    }
}
```

## 🎨 Template Resource Filament

### **Resource Standard**
```php
<?php

declare(strict_types=1);

namespace Modules\{ModuleName}\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Modules\Xot\Filament\Resources\XotBaseResource;

class {ModelName}Resource extends XotBaseResource
{
    protected static ?string $model = \Modules\{ModuleName}\Models\{ModelName}::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = '{ModuleName}';

    protected static ?int $navigationSort = 1;

    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public static function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('description')
                ->maxLength(65535)
                ->columnSpanFull(),

            Forms\Components\Toggle::make('is_active')
                ->required(),
        ];
    }

    /**
     * @return array<int, \Filament\Tables\Columns\Column>
     */
    public static function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('description')
                ->limit(50),

            Tables\Columns\IconColumn::make('is_active')
                ->boolean()
                ->sortable(),

            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * @return array<string, \Filament\Tables\Actions\Action>
     */
    public static function getTableActions(): array
    {
        return [
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ];
    }

    /**
     * @return array<string, \Filament\Tables\Actions\BulkAction>
     */
    public static function getTableBulkActions(): array
    {
        return [
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ];
    }
}
```

## 🔗 Template Relation Manager

### **RelationManager Standard**
```php
<?php

declare(strict_types=1);

namespace Modules\{ModuleName}\Filament\Resources\{ModelName}Resource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\EditAction;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class {RelatedModel}RelationManager extends XotBaseRelationManager
{
    protected static string $relationship = '{relationship}';

    protected static ?string $recordTitleAttribute = 'name';

    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('role')
                ->required()
                ->maxLength(255),
        ];
    }

    /**
     * @return array<int, \Filament\Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('role')
                ->searchable(),

            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * @return array<string, \Filament\Tables\Actions\Action>
     */
    public function getTableHeaderActions(): array
    {
        return [
            'attach' => AttachAction::make()
                ->modalHeading(__('{modulename}::{relationship}.actions.attach.modal.heading'))
                ->form(fn (AttachAction $action): array => [
                    $action->getRecordSelect(),
                    Forms\Components\TextInput::make('role')
                        ->default('member')
                        ->required(),
                ]),
        ];
    }

    /**
     * @return array<string, \Filament\Tables\Actions\Action>
     */
    public function getTableActions(): array
    {
        return [
            'edit' => EditAction::make()
                ->modalHeading(__('{modulename}::{relationship}.actions.edit.modal.heading')),

            'detach' => DetachAction::make()
                ->modalHeading(__('{modulename}::{relationship}.actions.detach.modal.heading')),
        ];
    }
}
```

## 🔧 Template Service Provider

### **ServiceProvider Standard**
```php
<?php

declare(strict_types=1);

namespace Modules\{ModuleName}\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class {ModuleName}ServiceProvider extends XotBaseServiceProvider
{
    protected string $module_name = '{ModuleName}';

    public function boot(): void
    {
        parent::boot();

        // Configurazioni specifiche del modulo
    }

    public function register(): void
    {
        parent::register();

        // Registrazioni specifiche del modulo
    }
}
```

## 📝 Template Action

### **Action Standard**
```php
<?php

declare(strict_types=1);

namespace Modules\{ModuleName}\Actions;

use Spatie\QueueableAction\QueueableAction;
use Modules\{ModuleName}\Data\{ModelName}Data;
use Modules\{ModuleName}\Models\{ModelName};

class Create{ModelName}Action
{
    use QueueableAction;

    public function execute({ModelName}Data $data): {ModelName}
    {
        return {ModelName}::create($data->toArray());
    }
}
```

## 🔗 Collegamenti

- [Architettura Modulo Xot](../core/architecture.md)
- [Convenzioni di Naming](../core/naming-conventions.md)
- [Best Practices Filament](../filament/best-practices.md)
- [PHPStan Guide](../development/phpstan-guide.md)

---

**Ultimo aggiornamento:** Gennaio 2025  
**Versione:** 2.0 - Consolidata DRY + KISS
