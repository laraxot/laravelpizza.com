# Risks & Dependencies (CMS)

## Dependencies
- **Modules\Xot**: Required for base classes.
- **Modules\UI**: Core for block components.
- **Modules\Media**: For image and file management.

## Risks
- **Rendering Performance**: Large page structures with many blocks could lead to overhead.
- **Complexity**: The flexibility of JSON-driven pages can lead to "Configuration Hell" without clear standards.
- **Breaking Changes**: Refactoring block interfaces could affect multiple themes.
