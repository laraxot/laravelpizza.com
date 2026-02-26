# Cms Module Documentation

## Overview

The Cms module handles content management, page rendering, and multi-language support through a flexible block-based system.

## Key Components

### Page Model
- **Location**: `app/Models/Page.php`
- **Purpose**: Manages page content with multi-language JSON fields
- **Fields**: `title`, `content_blocks`, `sidebar_blocks`, `footer_blocks`

### Page Component
- **Location**: `app/View/Components/Page.php`
- **Purpose**: Renders pages using block-based architecture
- **Features**: Multi-language support, block processing, component resolution

### BlockData System
- **Location**: `app/Datas/BlockData.php`
- **Purpose**: Manages individual block data and view resolution
- **Features**: Type safety, view existence validation, data merging

## Multi-Language Support

### Language Detection Logic
```php
// In Page component
$current_lang = app()->getLocale();
if (in_array($current_lang, $locales)) {
    $blocks = $blocks[$current_lang];
} elseif (in_array('it', $locales)) {
    $blocks = $blocks['it']; // Fallback to Italian
}
```

### Content Structure
```json
{
  "title": {
    "it": "Titolo Italiano",
    "en": "English Title"
  },
  "content_blocks": {
    "it": [...],
    "en": [...]
  }
}
```

## Block System Architecture

### Block Types
- **Hero**: Page header sections
- **Services**: Service listings and grids
- **Content**: General content sections
- **Forms**: Contact and interaction forms
- **Testimonials**: Customer reviews
- **Resources**: Downloads and guides

### Component Resolution
Blocks use view paths like:
- `pub_theme::components.blocks.hero.simple`
- `pub_theme::components.blocks.services.grid`
- `pub_theme::components.blocks.newsletter.simple`

## Important Notes

### Critical Issues Identified ([DATE])
1. **Missing Component**: `hero.fullscreen.blade.php` referenced but non-existent
2. **Content Disparity**: Italian version has 9 blocks vs English 3 blocks
3. **Component Duplication**: 32+ hero variants across themes

### Recommendations
1. **Audit Component References**: Ensure all referenced views exist
2. **Standardize Content**: Maintain parity between language versions
3. **Consolidate Components**: Reduce redundant hero component variants

## File Structure

```
Modules/Cms/
├── app/
│   ├── Models/Page.php
│   ├── View/Components/
│   │   ├── Page.php
│   │   └── PageContent.php
│   └── Datas/BlockData.php
├── resources/views/
│   └── components/
│       ├── page.blade.php
│       └── page-content.blade.php
└── docs/
    ├── 00-index.md (this file)
    ├── page-translation-strategy.md
    ├── block-component-guidelines.md
    └── multi-language-content-management.md
```

## Filament

- **Compatibilità 5.x**: [filament-5x-compatibility.md](filament-5x-compatibility.md) — progetto su Filament 5.x; pattern e riferimenti per il modulo Cms.

## Dependencies

- **Xot Module**: Base functionality and data structures
- **Lang Module**: Multi-language support (if available)
- **Themes**: Component rendering (active: "Two")

## Best Practices

1. **Always verify component existence** before referencing in page data
2. **Maintain content parity** across all supported languages
3. **Use consistent data structures** for similar block types
4. **Test multi-language functionality** thoroughly
5. **Document custom block types** and their required data structure

## Testing

- Use Pest testing framework
- Test multi-language scenarios
- Verify component rendering
- Test data validation and fallbacks

## Recent Changes

### [DATE]
- Identified critical missing component issue
- Documented content disparity between languages
- Created comprehensive duplicate content analysis
