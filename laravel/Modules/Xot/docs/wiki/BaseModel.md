---
module: Xot
concept: BaseModel
last_updated: 2026-04-15
---

# BaseModel Pattern

The **BaseModel** pattern is the cornerstone of Laraxot's database architecture. It ensures a consistent inheritance chain and provides shared functionality across all modules.

## The Sacred Inheritance Chain

Every model in the system MUST follow this hierarchy:

```text
Model → Module BaseModel → XotBaseModel → Laravel Model
```

### 1. XotBaseModel
Located in `Modules/Xot/app/Models/XotBaseModel.php`.
- **Foundational Traits**: `HasXotFactory`, `RelationX`, `Updater`.
- **Default Config**: Snake attributes, auto-incrementing IDs (usually string/UUID), timestamps enabled.
- **Default Connection**: Often set to `user` as a baseline.

### 2. Module BaseModel
Each module (e.g., `User`, `Incentivi`) MUST have its own `BaseModel` that extends `XotBaseModel`.
- **Responsibilities**: Add module-specific database connections, shared traits (e.g., `Cachable`, `HasMedia`), and default relationships.

### 3. Concrete Models
Actual business models extend their module's `BaseModel`.

## Sacred Rules

1. **Rule 1: Never Extend XotBaseModel Directly**: Always extend the module-specific `BaseModel`.
2. **Rule 2: Module BaseModel Must Extend XotBaseModel**: This maintains the chain of command.
3. **Rule 3: Use Schemaless Attributes**: For flexible metadata, use the `extra` field (powered by `spatie/laravel-schemaless-attributes`).

## Key Traits

- **[[HasXotTable]]**: Handles table naming conventions.
- **[[HasExtra]]**: Manages the JSON `extra` column for metadata.
- **[[Updater]]**: Automatically tracks who created/updated the record.

---
**Related Pages:**
- [[Xot Module Architecture]]
- [[Schemaless Attributes]]
- [[Database Architecture]]
