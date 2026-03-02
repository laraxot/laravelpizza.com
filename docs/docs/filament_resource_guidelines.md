# Cms Module Filament Resource Guidelines

## Extension Patterns

All Filament resources in the Cms module follow proper Laraxot extension patterns with multilingual support.

### ✅ Correct Patterns

#### For Multilingual Resources (extend LangBaseResource):

```php
use Modules\Cms\Models\Page;
use Modules\Lang\Filament\Resources\LangBaseResource;

class PageResource extends LangBaseResource
{
    protected static ?string $model = Page::class;

    public static function getFormSchema(): array
    {
        return [
            // Form schema components with multilingual support
        ];
    }
}
```

#### For Non-Multilingual Resources (extend XotBaseResource):

```php
use Modules\Cms\Models\Menu;
use Modules\Xot\Filament\Resources\XotBaseResource;

class MenuResource extends XotBaseResource
{
    protected static ?string $model = Menu::class;

    public static function getFormSchema(): array
    {
        return [
            // Form schema components
        ];
    }
}
```

### Current Resource Status

#### ✅ PageResource - CORRECT
- Extends LangBaseResource (for multilingual support) ✓
- Only implements getFormSchema() ✓
- No unnecessary method overrides ✓

#### ✅ PageContentResource - CORRECT  
- Extends LangBaseResource (for multilingual support) ✓
- Only implements getFormSchema() ✓
- No unnecessary method overrides ✓

#### ✅ SectionResource - CORRECT
- Extends LangBaseResource (for multilingual support) ✓
- Only implements getFormSchema() ✓
- No unnecessary method overrides ✓

#### ✅ MenuResource - CORRECT
- Extends XotBaseResource (non-multilingual) ✓
- Only implements getFormSchema() ✓
- No unnecessary method overrides ✓

### LangBaseResource Benefits

The `LangBaseResource` extends `XotBaseResource` and provides:

1. **Automatic Multilingual Support**:
   - Translatable form fields
   - Language switching UI
   - Translation management

2. **Standard Locale Configuration**:
   ```php
   public static function getTranslatableLocales(): array
   {
       return ['it', 'en'];
   }
   ```

3. **All XotBaseResource Features**:
   - Auto-generated pages
   - Relation manager discovery
   - Standard form/table handling
   - Navigation automation

### ❌ Forbidden Patterns

**DO NOT implement these methods if they return standard/default values:**

```php
// ❌ WRONG - Don't implement standard methods
public static function getPages(): array { ... }
public static function getRelations(): array { ... }
public static function form(Form $form): Form { ... }
public static function table(Table $table): Table { ... }
```

### Best Practices for Cms Resources

1. **Use LangBaseResource for translatable content**:
   - Pages, PageContent, Sections should extend LangBaseResource
   - Menus (non-translatable) can extend XotBaseResource directly

2. **Implement only getFormSchema()**:
   - The base classes handle everything else automatically
   - Keep resource classes focused and minimal

3. **Use multilingual form components**:
   ```php
   Forms\Components\TextInput::make('title')
       ->translateLabel()  // For multilingual labels
       ->required(),
   ```

4. **Leverage auto-discovery**:
   - Pages are auto-generated based on naming conventions
   - Relation managers are discovered from RelationManagers directory
   - Navigation is configured automatically

### Testing Requirements

All Cms resources must be tested to ensure:
1. Correct base class extension (LangBaseResource/XotBaseResource)
2. No unnecessary method implementations
3. Proper multilingual support where required
4. Form schema validation
5. Auto-generated functionality works correctly

### Related Documentation

- [XotBaseResource Documentation](../../Xot/docs/filament/resources/xot-base-resource.md)
- [LangBaseResource Documentation](../../Lang/docs/filament/lang-base-resource.md)
- [Multilingual Best Practices](../../Lang/docs/translation-best-practices.md)
- [Filament Resource Guidelines](../../Xot/docs/filament-resource-rules.md)