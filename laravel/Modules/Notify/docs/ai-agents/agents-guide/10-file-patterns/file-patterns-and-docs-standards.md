# 10. File Patterns

### Include
- `**/*.php`
- `**/*.blade.php`
- `**/*.css`
- `**/*.js`
- `**/*.json`
- `**/*.md`

### Exclude
- `**/vendor/**`
- `**/node_modules/**`
- `**/storage/**`
- `**/bootstrap/cache/**`
- `**/.git/**`

### Documentation Standards (CRITICAL)
**All .md files MUST be inside existing docs/ folders only - NEVER create new docs directories!**

**File Naming Conventions:**
- **ALL filenames**: lowercase with kebab-case (dashes)
- **Exceptions**: Only `README.md` and `CHANGELOG.md` can have uppercase letters
- **Pattern**: `filename-with-kebab-case.md` ✅
- **Pattern**: `README.md` ✅ (exception)
- **Pattern**: `CHANGELOG.md` ✅ (exception)

**Module Documentation Structure:**
```
Modules/{ModuleName}/docs/
├── 00-index.md              # Main documentation index (CRITICAL)
├── README.md               # Module overview and main documentation
├── 01-getting-started/     # Quick start guides
├── 02-architecture/        # Architecture documentation
├── 03-development/         # Development guides
├── 04-features/           # Feature documentation
├── 05-api/                # API documentation
├── 06-integration/        # Integration guides
├── 07-troubleshooting/    # Troubleshooting
├── actions/               # Action-specific docs
├── charts/                # Chart-related docs
├── database/              # Database documentation
├── development/           # Development guides
├── filament/              # Filament-specific docs
├── quality/               # Quality assurance docs
├── testing/               # Testing documentation
└── ...                     # Feature-specific subdirectories
```

**Theme Documentation Structure:**
```
Themes/Meetup/docs/
├── 00-index.md              # Main documentation index
├── README.md               # Theme overview
└── ...                      # Same subfolders as modules
```

**Roadmap Structure (obbligatoria per moduli e temi):**
```
docs/
├── roadmap.md               # Redirect: "Vedi [roadmap/00-index](roadmap/00-index.md)"
└── roadmap/
    ├── 00-index.md         # Overview, indice, metriche
    ├── vision.md           # Visione e obiettivi
    ├── phases.md           # Fasi di sviluppo
    └── quality.md          # Checklist qualità
```
Indice centralizzato: `laravel/docs/roadmap/00-index.md`

**Key Principles:**
- **DRY + KISS + SOLID** - No duplication, keep it simple, follow SOLID principles
- **Cross-referencing** - Use relative paths for internal links
- **Git integration** - All documentation changes tracked via Git
- **PHPStan Level 10** - Compliance status documented
- **Update workflow** - PRIMA del codice: aggiornare docs, DOPO il codice: verificare docs

**Documentation Workflow:**
1. **Before coding**: Update/verify docs in existing docs/ folders
2. **After coding**: Verify and improve docs
3. **No new docs directories** - always use existing ones
4. **Consistent structure** - follow the same patterns across all modules

---

