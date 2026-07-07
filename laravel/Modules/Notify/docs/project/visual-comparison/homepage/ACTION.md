# Homepage Visual Parity - Action Items

## Current Status

### Reference: https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html
- Uses Bootstrap Italia CSS directly
- Proper header structure with slim + center + nav sections
- Full hero section with "Benvenuti" title
- Services cards with specific styling

### Local: http://127.0.0.1:8000/it/tests/homepage
- Same HTML structure (verified via diff)
- CSS styling differs significantly
- Missing visual elements

## Key Differences Found

### 1. Header
| Element | Reference | Local Status |
|---------|-----------|---------------|
| Header Slim | ✅ Has region name | ❌ Missing |
| Language selector | ✅ Shows ITA/ENG | ❌ Different |
| Accedi button | ✅ Blue, full width | ❌ Different |
| Logo | ✅ Left aligned | ✅ OK |
| Nav links | ✅ Amministrazione/Servizi/Novità/Documenti | ❌ Different |

### 2. Hero Section
| Element | Reference | Local Status |
|---------|-----------|---------------|
| Background | Dark blue (#003366) with pattern | ❌ Different |
| Title | "Benvenuti" big text | ❌ Not visible |
| Card | "Vivi il Comune" with image | ❌ Not matching |

### 3. Cards/Sections
| Element | Reference | Local Status |
|---------|-----------|---------------|
| Services grid | 3 columns | ❌ Different |
| Categories | "Governo", "Territorio", "Cultura" | ❌ Not matching |
| Argomenti | Cards with images | ❌ Not matching |

## Next Steps

1. **Fix Header CSS** - Ensure it-header-slim-wrapper displays correctly
2. **Fix Hero Section** - Add proper background and title styling
3. **Fix Cards Grid** - Ensure 3-column layout with proper cards

## Files to Modify

- `/laravel/Themes/Sixteen/resources/css/homepage-visual-fix.css`
- Run `npm run build` after changes
- Run `npm run copy` after build

## Last Screenshots

- `before/` - Screenshots before any fixes
- `after-build-desktop.png` - Current local desktop
- `after-build-mobile.png` - Current local mobile