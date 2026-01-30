# Pages Filament

## XotBasePage

La classe base per tutte le pagine Filament:

```php
abstract class XotBasePage extends Page
{
    use TransTrait;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';
    protected static string $view = 'job::filament.pages.job-monitor';
    protected static ?string $model = null;

    // Metodi utili
    public static function getModuleName(): string
    public static function trans(string $key): string
    public static function getPluralModelLabel(): string
    public static function getNavigationLabel(): string
    public static function getNavigationGroup(): string
    public function getModel(): string
}
```

## Implementazione

### 1. Creazione Page
```php
class ListArticles extends XotBasePage
{
    protected static string $view = 'blog::filament.pages.list-articles';
}
```

### 2. Struttura Directory
```
Module/
└── app/
    └── Filament/
        └── Pages/
            ├── ListArticles.php
            ├── CreateArticle.php
            ├── EditArticle.php
            └── ViewArticle.php
```

### 3. Views
```
Module/
└── resources/
    └── views/
        └── filament/
            └── pages/
                ├── list-articles.blade.php
                ├── create-article.blade.php
                ├── edit-article.blade.php
                └── view-article.blade.php
```

### 4. Funzionalità Base
- Traduzioni integrate
- Navigazione automatica
- Model binding
- Layout standard
- Form handling

### 5. Best Practices
- Naming: `ActionModelName`
- Namespace: `Modules\ModuleName\Filament\Pages`
- Definire sempre `$view`
- Utilizzare type hints
- Documentare PHPDoc

### 6. Esempio Completo
```php
declare(strict_types=1);

namespace Modules\Blog\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;

class ListArticles extends XotBasePage
{
    protected static string $view = 'blog::filament.pages.list-articles';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Blog';
    protected static ?string $navigationLabel = 'Articoli';

    public function getTitle(): string
    {
        return $this->trans('Lista Articoli');
    }
}
```

## Tipi di Pagine

### 1. List Page
```php
class ListArticles extends XotBasePage
{
    protected static string $view = 'blog::filament.pages.list-articles';
    
    public function getArticles()
    {
        return Article::paginate();
    }
}
```

### 2. Create Page
```php
class CreateArticle extends XotBasePage
{
    protected static string $view = 'blog::filament.pages.create-article';
    
    public function save()
    {
        // Logica di salvataggio
    }
}
```

### 3. Edit Page
```php
class EditArticle extends XotBasePage
{
    protected static string $view = 'blog::filament.pages.edit-article';
    
    public function mount($record)
    {
        $this->record = $record;
    }
}
```

### 4. View Page
```php
class ViewArticle extends XotBasePage
{
    protected static string $view = 'blog::filament.pages.view-article';
    
    public function mount($record)
    {
        $this->record = $record;
    }
}
```

## Views Blade

### 1. List View
```blade
<x-filament-panels::page>
    <x-filament::table>
        <x-slot name="header">
            <x-filament::table.header-cell>
                {{ trans('blog::article.title') }}
            </x-filament::table.header-cell>
        </x-slot>

        @foreach($articles as $article)
            <x-filament::table.row>
                <x-filament::table.cell>
                    {{ $article->title }}
                </x-filament::table.cell>
            </x-filament::table.row>
        @endforeach
    </x-filament::table>
</x-filament-panels::page>
```

### 2. Form View
```blade
<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}
        
        <x-filament::button type="submit">
            {{ trans('blog::article.save') }}
        </x-filament::button>
    </form>
</x-filament-panels::page>
```

## Testing

### 1. Page Test
```php
class ListArticlesTest extends TestCase
{
    public function test_can_render_page()
    {
        $this->get(route('filament.pages.list-articles'))
            ->assertSuccessful();
    }
}
```

## Workflow di Sviluppo

1. **Setup Iniziale**
   - Creare directory Pages
   - Creare views
   - Configurare namespace

2. **Implementazione**
   - Definire logica
   - Creare views
   - Configurare navigazione

3. **Testing**
   - Test rendering
   - Test funzionalità
   - Test navigazione

4. **Documentazione**
   - PHPDoc
   - README
   - CHANGELOG 
## Collegamenti tra versioni di pages.md
* [pages.md](docs/tecnico/filament/pages.md)
* [pages.md](laravel/Themes/One/docs/pages.md)

