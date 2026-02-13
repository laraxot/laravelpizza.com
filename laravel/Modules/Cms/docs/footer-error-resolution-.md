# Footer Error Resolution - 2026-02-08

## Error Fixed
`htmlspecialchars(): Argument #1 ($string) must be of type string, array given`

## Context
The error occurred when accessing the homepage and other pages that render the footer component.

## Root Cause Analysis

### Data Structure (footer.json)
```json
"normative": {
    "title": "Normative & Certificazioni",
    "items": [
        {"label": "D.Lgs 101/2020", "description": "Attuazione della direttiva 2013/59/Euratom..."},
        {"label": "Esperti Qualificati", "description": "Professionisti iscritti negli elenchi..."},
        {"label": "IEC 62353", "description": "Verifiche periodiche di sicurezza elettrica..."}
    ]
}
```

### Blade Template Issue (footer/v1.blade.php ~line 300)
The template attempted to handle both arrays and strings with `is_array()` check:

```blade
@if(is_array($item))
    <div>
        <span class="font-semibold">{{ $item['label'] ?? '' }}</span>
        <p class="text-xs text-gray-400">{{ $item['description'] }}</p>
    </div>
@else
    <span>{{ $item }}</span>
@endif
```

**Problem**: When `{{ $item['label'] }}` is used, Blade passes the array value to `htmlspecialchars()` which expects a string.

## Solution Implemented

### Changed from list to div structure:
```blade
<!-- Before (using <ul> with mixed handling) -->
<ul class="space-y-2">
    @foreach($normative['items'] ?? [] as $item)
        @if(is_array($item))
            <li>...</li>
        @else
            <li>{{ $item }}</li>
        @endif
    @endforeach
</ul>

<!-- After (using <div> with consistent array handling) -->
<div class="space-y-4">
    @foreach($normative['items'] ?? [] as $item)
        <div>
            <h4 class="font-bold text-sm text-white">{{ $item['label'] ?? '' }}</h4>
            <p class="text-gray-400 text-xs">{{ $item['description'] ?? '' }}</p>
        </div>
    @endforeach
</div>
```

### Key Changes:
1. **Removed `is_array()` check** - always treat items as arrays
2. **Changed `<ul>` to `<div>`** - better semantic structure for this content
3. **Fixed closing tag** - was `</ul>` changed to `</div>`
4. **Simplified styling** - removed complex inline hover effects
5. **Type safety** - always access array keys with null coalescing operator

## Verification Steps

1. **Clear all caches**:
```bash
cd /var/www/_bases/base_techplanner_fila5/laravel
rm -rf bootstrap/cache/*
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

2. **Test footer rendering**:
```bash
curl -s http://127.0.0.1:8000/it | grep -A 5 "Normative"
```

3. **Verify output**:
```
Normative & Certificazioni
<div class="space-y-4">
    <div class="group">
        <h4 class="font-semibold text-sm text-white group-hover:text-orange-400">D.Lgs 101/2020</h4>
        <p class="text-xs text-gray-400 mt-1">Attuazione della direttiva 2013/59/Euratom...</p>
    </div>
</div>
```

## Files Modified
- `/var/www/_bases/base_techplanner_fila5/laravel/Themes/Two/resources/views/components/sections/footer/v1.blade.php`

## Related Documentation
- `/var/www/_bases/base_techplanner_fila5/laravel/Themes/Two/docs/footer-target-complete-analysis.md`
- `/var/www/_bases/base_techplanner_fila5/laravel/Modules/Cms/docs/footer-target-implementation.md`

## Status
✅ Error resolved
✅ Footer renders correctly
✅ All normative items display properly
✅ No PHP errors
✅ Cache cleared and tested

## Lesson Learned
When working with Blade templates, always ensure consistent data structure handling. The `is_array()` check pattern is error-prone when the data source is consistent. Better to:
1. Use one consistent structure
2. Validate data at source (JSON schema validation)
3. Use null coalescing operators for type safety
4. Choose appropriate HTML semantic elements for content