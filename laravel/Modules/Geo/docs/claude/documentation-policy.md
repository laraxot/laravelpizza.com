# Documentation Policy

## 📝 Documentation Rules

### Required per Module
- `docs/README.md` - Module overview
- Code-level PHPDoc for all public methods
- API documentation for endpoints
- Translation documentation for complex keys

### Style Guidelines
- **Clear, concise, examples-focused**: Use practical examples
- **Use emoji for visual hierarchy**: Enhance readability with appropriate emojis
- **Kebab-case**: Use lowercase with hyphens for file names
- **No dates in file names**: Use CHANGELOG.md for version history
- **Relative links**: Never use absolute paths

### File Naming Convention
- Use lowercase names with hyphens (kebab-case)
- Descriptive names that clearly indicate content
- No dates in file names
- Examples: `architecture-rules.md`, `development-tasks.md`, `common-pitfalls.md`

### Link Structure
All links should be relative to maintain portability:

```markdown
[Architecture Rules](architecture-rules.md)
[Module Structure](module-structure.md)
[Development Tasks](development-tasks.md)
```

## 📚 Centralized Documentation Structure

### Core Files
1. **[overview.md](overview.md)** - Overview and quick start
2. **[architecture-rules.md](architecture-rules.md)** - Critical architecture rules
3. **[module-structure.md](module-structure.md)** - Module structure and conventions
4. **[development-tasks.md](development-tasks.md)** - Common development tasks
5. **[conventions.md](conventions.md)** - Code conventions and best practices
6. **[code-quality.md](code-quality.md)** - PHPStan, PHPMD, PHP Insights, Rector
7. **[common-pitfalls.md](common-pitfalls.md)** - Common mistakes to avoid
8. **[documentation-policy.md](documentation-policy.md)** - Documentation policies
9. **[framework-specifics.md](framework-specifics.md)** - Laravel Boost, Filament 4, etc.
10. **[laravel-boost.md](laravel-boost.md)** - Laravel Boost specific guidelines
11. **[eloquent-properties.md](eloquent-properties.md)** - Critical information about property_exists() with Eloquent models

## 🧠 DRY and KISS Principles

### DRY (Don't Repeat Yourself)
- Zero duplication between files
- Centralized rules and guidelines
- Consistent examples and patterns

### KISS (Keep It Simple, Stupid)
- Linear and intuitive structure
- Dedicated files for each domain
- Quick navigation

### Maintainability
- Centralized updates
- Simplified versioning
- Guaranteed consistency

## 📖 Content Guidelines

### Business Logic First
Document the "WHY" not just the "WHAT" - focus on explaining the reasoning behind architectural decisions and implementation choices.

### Examples-Driven
Provide practical, real-world examples that developers can directly apply to their work.

### Progressive Disclosure
Start with fundamental concepts and progressively introduce more complex topics.

### Module-Specific Documentation
Each module should maintain its own detailed documentation in its `docs/` directory, following the same principles as the main documentation.

---

**Version**: 2.0 (Refactor DRY + KISS)  
**File**: documentation-policy.md - Documentation standards and policies