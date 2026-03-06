# UI Module Icon System

## How It Works

`XotBaseServiceProvider::registerBladeIcons()` automatically registers each module's SVG directory with BladeUI/Icons using the module's lowercase alias as prefix.

```php
// XotBaseServiceProvider.php (line 65-76)
public function registerBladeIcons(): void
{
    $this->callAfterResolving(BladeIconsFactory::class, function (BladeIconsFactory $factory): void {
        $assetsPath = app(GetModulePathByGeneratorAction::class)->execute($this->name, 'assets');
        $svgPath = $assetsPath.'/../svg';
        if (File::exists($svgPath)) {
            $factory->add($this->nameLower, ['path' => $svgPath, 'prefix' => $this->nameLower]);
        }
    });
}
```

**Result for UI module** (`nameLower = 'ui'`):
- All SVGs in `Modules/UI/resources/svg/` → prefix `ui-`
- `google.svg` → `icon="ui-google"`
- `brands/google.svg` → `icon="ui-brands-google"` (subdirs use dash separator)

## The Rule (MANDATORY)

### NEVER use raw inline SVG in Blade templates
```blade
{{-- ❌ WRONG - raw SVG, maintenance nightmare, no theming --}}
<svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
    <path d="M22.56 12.25c0-.78..." fill="#4285F4"/>
    ...
</svg>

{{-- ✅ CORRECT - uses icon system, reusable, maintainable --}}
<x-filament::icon icon="ui-google" class="w-5 h-5 flex-shrink-0" />
```

### Why?
1. **DRY**: Define once in SVG file, use everywhere
2. **Maintainable**: Update SVG in one place
3. **Consistent**: Same component everywhere
4. **Accessible**: BladeUI/Icons handles aria attributes
5. **Theming**: Can be styled via CSS classes

## Available UI Icons (89 total)

### Root icons (prefix: `ui-`)
Common icons: `ui-ai`, `ui-alert`, `ui-archive-box`, `ui-article`, `ui-authenticate`,
`ui-bathroom`, `ui-brain`, `ui-cancel`, `ui-categories`, `ui-chatgpt`, `ui-clean`,
`ui-create`, `ui-dashboard`, `ui-delete`, `ui-document-report`, `ui-google`, ...

### Brands (prefix: `ui-brands-`)
`ui-brands-apple`, `ui-brands-discord`, `ui-brands-dribbble`, `ui-brands-fb`,
`ui-brands-github`, `ui-brands-google`, `ui-brands-google-play`, `ui-brands-ig`,
`ui-brands-linkedin`, `ui-brands-microsoft`, `ui-brands-twitter`, `ui-brands-youtube`, ...

## Usage in Filament
```php
// In PHP (Filament resource/widget)
use Filament\Support\Icons\Icon;

Tables\Columns\IconColumn::make('status')
    ->icon('ui-google')

// In Blade
<x-filament::icon icon="ui-google" class="w-5 h-5" />

// Social login buttons
<x-filament::icon icon="ui-brands-google" class="w-5 h-5 flex-shrink-0" />
<x-filament::icon icon="ui-brands-microsoft" class="w-5 h-5 flex-shrink-0" />
<x-filament::icon icon="ui-brands-github" class="w-5 h-5 flex-shrink-0" />
```

## Adding New Icons
1. Save SVG file to `Modules/UI/resources/svg/{name}.svg`
2. For brand icons: `Modules/UI/resources/svg/brands/{name}.svg`
3. Use as `ui-{name}` or `ui-brands-{name}` immediately (auto-registered)
4. Clear view cache if not appearing: `php artisan view:clear`

## Cross-Module Icons
Each module registers its own SVG icons:
- `Modules/User/resources/svg/` → `user-{name}`
- `Modules/<nome progetto>/resources/svg/` → `<nome progetto>-{name}`
- etc.

The `ui-` prefix is special: contains the global design system icons shared across all modules.
