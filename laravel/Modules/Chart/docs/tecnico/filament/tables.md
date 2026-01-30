# Tables Filament

## XotBaseTable

La classe base per tutte le tabelle Filament:

```php
abstract class XotBaseTable extends Table
{
    use TransTrait;

    protected static ?string $model = null;
    protected static ?string $recordTitleAttribute = null;

    // Metodi utili
    public static function getModuleName(): string
    public static function trans(string $key): string
    public static function getModel(): string
    public static function getRecordTitleAttribute(): string
}
```

## Implementazione

### 1. Creazione Table
```php
class ArticleTable extends XotBaseTable
{
    public static function getTableColumns(): array
    {
        return [
            // Colonne della tabella
        ];
    }
}
```

### 2. Struttura Directory
```
Module/
└── app/
    └── Filament/
        └── Tables/
            ├── ArticleTable.php
            └── CommentTable.php
```

### 3. Funzionalità Base
- Traduzioni integrate
- Model binding
- Ordinamento automatico
- Filtri automatici
- Azioni automatiche

### 4. Best Practices
- Naming: `ModelNameTable`
- Namespace: `Modules\ModuleName\Filament\Tables`
- Implementare sempre `getTableColumns()`
- Utilizzare type hints
- Documentare PHPDoc

### 5. Esempio Completo
```php
declare(strict_types=1);

namespace Modules\Blog\Filament\Tables;

use Modules\Xot\Filament\Tables\XotBaseTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\DateTimeColumn;

class ArticleTable extends XotBaseTable
{
    public static function getTableColumns(): array
    {
        return [
            TextColumn::make('title')
                ->label(static::trans('title'))
                ->searchable()
                ->sortable(),

            IconColumn::make('is_published')
                ->label(static::trans('is_published'))
                ->boolean(),

            DateTimeColumn::make('published_at')
                ->label(static::trans('published_at'))
                ->sortable(),
        ];
    }
}
```

## Colonne

### 1. Text Column
```php
TextColumn::make('title')
    ->label(static::trans('title'))
    ->searchable()
    ->sortable()
    ->limit(50)
    ->tooltip()
```

### 2. Icon Column
```php
IconColumn::make('is_published')
    ->label(static::trans('is_published'))
    ->boolean()
    ->trueIcon('heroicon-o-check-circle')
    ->falseIcon('heroicon-o-x-circle')
```

### 3. DateTime Column
```php
DateTimeColumn::make('published_at')
    ->label(static::trans('published_at'))
    ->sortable()
    ->dateTime('d/m/Y H:i')
    ->timezone('Europe/Rome')
```

### 4. Image Column
```php
ImageColumn::make('image')
    ->label(static::trans('image'))
    ->circular()
    ->disk('public')
    ->width(40)
    ->height(40)
```

### 5. Badge Column
```php
BadgeColumn::make('status')
    ->label(static::trans('status'))
    ->colors([
        'danger' => 'draft',
        'warning' => 'review',
        'success' => 'published',
    ])
```

## Filtri

### 1. Filter Base
```php
public static function getTableFilters(): array
{
    return [
        SelectFilter::make('status')
            ->label(static::trans('status'))
            ->options([
                'draft' => static::trans('status.draft'),
                'published' => static::trans('status.published'),
            ]),
    ];
}
```

### 2. Filter Personalizzato
```php
public static function getTableFilters(): array
{
    return [
        Filter::make('published_at')
            ->label(static::trans('published_at'))
            ->form([
                DatePicker::make('from')
                    ->label(static::trans('from')),
                DatePicker::make('until')
                    ->label(static::trans('until')),
            ])
            ->query(function (Builder $query, array $data): Builder {
                if (isset($data['from'])) {
                    $query->where('published_at', '>=', $data['from']);
                }
                if (isset($data['until'])) {
                    $query->where('published_at', '<=', $data['until']);
                }
                return $query;
            }),
    ];
}
```

## Azioni

### 1. Action Base
```php
public static function getTableActions(): array
{
    return [
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make(),
    ];
}
```

### 2. Action Personalizzata
```php
public static function getTableActions(): array
{
    return [
        Tables\Actions\Action::make('publish')
            ->label(static::trans('publish'))
            ->icon('heroicon-o-check-circle')
            ->action(function (Article $record): void {
                $record->update(['status' => 'published']);
            })
            ->requiresConfirmation()
            ->modalHeading(static::trans('publish.confirm'))
            ->modalDescription(static::trans('publish.description')),
    ];
}
```

## Ordinamento

### 1. Ordinamento Base
```php
public static function getDefaultTableSortColumn(): ?string
{
    return 'published_at';
}

public static function getDefaultTableSortDirection(): ?string
{
    return 'desc';
}
```

### 2. Ordinamento Personalizzato
```php
public static function getTableSortColumns(): array
{
    return [
        'title' => [
            'label' => static::trans('title'),
            'direction' => 'asc',
        ],
        'published_at' => [
            'label' => static::trans('published_at'),
            'direction' => 'desc',
        ],
    ];
}
```

## Testing

### 1. Table Test
```php
class ArticleTableTest extends TestCase
{
    public function test_can_render_table()
    {
        $table = new ArticleTable();
        $this->assertIsArray($table->getTableColumns());
    }
}
```

## Workflow di Sviluppo

1. **Setup Iniziale**
   - Creare directory Tables
   - Creare classe base
   - Configurare namespace

2. **Implementazione**
   - Definire colonne
   - Configurare filtri
   - Gestire azioni

3. **Testing**
   - Test rendering
   - Test filtri
   - Test azioni

4. **Documentazione**
   - PHPDoc
   - README
   - CHANGELOG 