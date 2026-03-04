# Page Translation Strategy

## Overview

The Cms module uses a JSON-based translation system to manage multi-language content for pages and their associated blocks.

## Translation Architecture

### Database Structure
```php
// Page model fields
$title               // JSON: {"it": "Titolo", "en": "Title"}
$content_blocks      // JSON: {"it": [...], "en": [...]}
$sidebar_blocks      // JSON: {"it": [...], "en": [...]}
$footer_blocks       // JSON: {"it": [...], "en": [...]}
```

### Language Resolution Logic
```php
public function __construct(string $side, string $slug, ?string $type = null, array $ = [])
{
    // ... setup code ...
    
    $blocks = $page->$field; // e.g., content_blocks
    
    if (is_array($blocks) && ! empty($blocks)) {
        $locales = array_keys($blocks);
        $current_lang = app()->getLocale();
        
        // Priority 1: Current language
        if (in_array($current_lang, $locales)) {
            $blocks = $blocks[$current_lang];
        }
        // Priority 2: Italian fallback
        elseif (in_array('it', $locales)) {
            $blocks = $blocks['it'];
        }
    }
    
    // Final fallback to primary language from XotData
    if (! is_array($blocks)) {
        $primary_lang = XotData::make()->primary_lang;
        $blocks = $page->getTranslation($field, $primary_lang);
    }
}
```

## Translation Best Practices

### 1. Consistent Language Keys
Always use the same language keys across all translation fields:
- `it` - Italian (primary fallback)
- `en` - English
- `de` - German (if supported)
- `fr` - French (if supported)

### 2. Content Parity Guidelines
Maintain structural parity between language versions:
- Same block types
- Similar content depth
- Consistent data structures
- Equivalent component usage

### 3. Component Reference Validation
Ensure all referenced components exist for all languages:
```php
// Example validation script
$required_components = [
    'it' => ['hero.simple', 'services.grid', 'testimonials.grid'],
    'en' => ['hero.fullscreen', 'services.grid', 'newsletter.simple']
];

foreach ($required_components[$lang] as $component) {
    if (!view()->exists($component)) {
        throw new \Exception("Missing component: $component");
    }
}
```

## Common Issues and Solutions

### Issue 1: Missing Components
**Problem**: Component referenced but not found
```json
{
  "type": "hero",
  "data": {
    "view": "pub_theme::components.blocks.hero.fullscreen" // ❌ Missing
  }
}
```

**Solution**: Create missing component or update reference
```json
{
  "type": "hero", 
  "data": {
    "view": "pub_theme::components.blocks.hero.simple" // ✅ Exists
  }
}
```

### Issue 2: Content Disparity
**Problem**: Different number of blocks per language
- Italian: 9 comprehensive sections
- English: 3 basic sections

**Solution**: Standardize content structure
- Align block types between languages
- Maintain similar content depth
- Use translation-specific adaptations where necessary

### Issue 3: Data Structure Inconsistency
**Problem**: Same block type with different data structure
```php
// Italian services grid
"services" => [
    ["title" => "Service 1", "description" => "...", "icon" => "..."]
]

// English services grid  
"services" => [
    ["title" => "Service 1", "description" => "...", "icon" => "...", "url" => "..."]
]
```

**Solution**: Define standard data structure per block type

## Translation Workflow

### 1. Adding New Language
```php
// 1. Add content blocks to page
$page->content_blocks = [
    'it' => $existing_italian_blocks,
    'en' => $new_english_blocks,
    'de' => $new_german_blocks
];
```

### 2. Updating Existing Content
```php
// 2. Modify specific language content
$content = $page->content_blocks;
$content['en'][0]['data']['title'] = 'Updated English Title';
$page->content_blocks = $content;
```

### 3. Validation
```php
// 3. Validate component references
foreach ($page->content_blocks as $lang => $blocks) {
    foreach ($blocks as $block) {
        $view = $block['data']['view'] ?? null;
        if ($view && !view()->exists($view)) {
            Log::warning("Missing view: $view for language: $lang");
        }
    }
}
```

## Monitoring and Maintenance

### Automated Checks
1. **Component existence validation**
2. **Content parity monitoring**
3. **Translation completeness checks**
4. **Data structure consistency validation**

### Manual Reviews
1. **Content quality assessment**
2. **User experience consistency**
3. **SEO optimization per language**
4. **Cultural appropriateness verification**

## Tools and Utilities

### Translation Helper Commands
```bash
# Check for missing components
php artisan cms:check-components

# Validate content parity
php artisan cms:validate-parity

# Export translation data
php artisan cms:export-translations

# Import translation data
php artisan cms:import-translations
```

### Debug Information
```php
// Get current page structure
$page = Page::where('slug', 'home')->first();
dd($page->content_blocks);

// Check component existence
$view = 'pub_theme::components.blocks.hero.fullscreen';
echo "View exists: " . (view()->exists($view) ? 'Yes' : 'No');
```

## Future Improvements

### Planned Enhancements
1. **Translation Management Interface**: Filament panel for managing translations
2. **Automated Component Validation**: Runtime checks for missing components
3. **Content Parity Monitoring**: Automated reports on language consistency
4. **Translation Workflow**: Git-based translation workflow with review process

### Architecture Considerations
1. **Component Versioning**: Support for component version compatibility
2. **Conditional Rendering**: Language-specific component variants
3. **Translation Caching**: Optimized translation loading and caching
4. **Fallback Strategies**: Advanced fallback mechanisms for missing translations

---


**Status**: Active - Critical issues identified requiring immediate attention
