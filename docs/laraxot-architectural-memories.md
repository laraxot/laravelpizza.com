# Laraxot Architectural Memories - February 2026

Critical architectural discoveries and best practices compiled during the Footer Refinement and Theme Integration phase.

## 1. Component Resolution Strategy
### The Correct Pattern
Always use the CMS module's Generic Section component for rendering theme-specific segments:
```blade
<x-section slug="footer" />
```
### Why?
- **Data Flow**: `Section.php` handles fetching `BlockData` from the persistent storage (JSON/DB).
- **Namespacing**: It automatically maps the slug to `pub_theme::components.sections.{slug}.v1`.
- **Decoupling**: Prevents "Unable to locate a class or view" errors caused by hardcoding theme namespaces like `two::`.

## 2. UI/UX & Accessibility (WCAG 2.1 AA)
### Background & Contrast
- **Primary Footer Color**: `#0F3460` (Deep Navy Blue).
- **Text Contrast**: Use `text-blue-100/90` or `text-white`. Avoid `text-gray-400` or `text-slate-400` on dark backgrounds.
- **Visual Clarity**: Solid backgrounds are preferred over complex gradients to guarantee consistent contrast ratios across different screen types.

## 3. Data Integrity & Mapping
### BlockData Standardization
Always structure block data using an `items` array with explicit types:
```json
{
    "type": "footer",
    "slug": "main-footer",
    "data": {
        "contact": {
            "items": [
                { "type": "address", "value": "..." },
                { "type": "email", "value": "..." }
            ]
        }
    }
}
```
Use `Spatie\LaravelData\DataCollection` for type-safe processing in Blade.

## 4. Development Workflow
### Asset Compilation
When modifying theme components (`laravel/Themes/*`):
1. Execute `npm run build` in the theme root.
2. Execute `npm run copy` to sync assets to `public_html/themes/{ThemeName}/dist`.
3. Perform a Hard Refresh (Ctrl+Shift+R) in the browser.

### Verification without Browser Tools
If CDP connection fails, use `curl -s http://127.0.0.1:8000/{path} | grep -A 100 "<footer"` to verify HTML structure and class application.

## 5. Documentation Standards
- **Naming**: All `.md` files must be lowercase, no dates in filenames (except `CHANGELOG.md`/`README.md`).
- **Organization**: No `_docs` folders allowed. All sub-documentation must reside directly in the `docs/` folder of the respective module/theme.
