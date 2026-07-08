# Regole di Naming per File

## 🎯 Regola Fondamentale: NO Duplicati Case-Insensitive

### Problema

Su filesystem case-insensitive (Windows, macOS default), file con nomi che differiscono solo per maiuscole/minuscole causano conflitti:

```
❌ ERRATO - Duplicati case-insensitive:
- readme.md e README.md
- Activity.php e activity.php
- ListRecords.md e listrecords.md
```

### Soluzione

**Mantenere SOLO la versione con naming corretto secondo le convenzioni:**

## 📋 Convenzioni di Naming

### File PHP

```
✅ CORRETTO:
- Models: PascalCase → Activity.php, User.php
- Controllers: PascalCase → ActivityController.php
- Tests: PascalCase → ActivityTest.php, ActivityTest.pest.php
- Factories: PascalCase → ActivityFactory.php
- Migrations: snake_case → 2024_01_01_000000_create_activities_table.php
```

### File Markdown

```
✅ CORRETTO:
- README.md (maiuscolo - convenzione universale)
- ROADMAP.md (maiuscolo - convenzione universale)
- CHANGELOG.md (maiuscolo - convenzione universale)
- LICENSE.md (maiuscolo - convenzione universale)
- CONTRIBUTING.md (maiuscolo - convenzione universale)
- SECURITY.md (maiuscolo - convenzione universale)

- Tutti gli altri: kebab-case minuscolo
  → file-naming-rules.md
  → phpstan-fixes.md
  → api-integration.md
```

### File Blade

```
✅ CORRETTO:
- Views: kebab-case minuscolo
  → content-start.blade.php
  → wide-image.blade.php
  → footer.blade.php
```

### File Config

```
✅ CORRETTO:
- Config: kebab-case minuscolo
  → database.php
  → filesystems.php
  → app-config.php
```

## 🔧 Come Identificare Duplicati

```bash
# Script per trovare duplicati case-insensitive
find Modules -type f \( -name "*.php" -o -name "*.md" \) -exec bash -c '
    dir=$(dirname "{}")
    base=$(basename "{}")
    find "$dir" -maxdepth 1 -iname "$base" ! -name "$base" 2>/dev/null
' \; | grep -v "^$"
```

## 🗑️ Quale File Eliminare

### Regola Generale

**Elimina il file che NON rispetta le convenzioni:**

1. **README.md vs readme.md** → Elimina `readme.md`
2. **Activity.php vs activity.php** → Elimina `activity.php`
3. **ListRecords.md vs listrecords.md** → Elimina `listrecords.md`
4. **ROADMAP.md vs roadmap.md** → Elimina `roadmap.md` (tranne se contiene info diverse)

### Eccezioni

Se entrambi i file contengono contenuto diverso:
1. Unisci il contenuto nel file con naming corretto
2. Elimina il duplicato
3. Committa con messaggio chiaro

## ✅ Checklist Pre-Commit

- [ ] Nessun file con nome duplicato case-insensitive
- [ ] File PHP in PascalCase (tranne migrations)
- [ ] File .md documentazione in kebab-case minuscolo
- [ ] File .md standard (README, LICENSE, etc.) in MAIUSCOLO
- [ ] File blade in kebab-case minuscolo
- [ ] Nessun carattere speciale nei nomi file (solo a-z, 0-9, -, _)

## 🚀 Script di Pulizia

```bash
# Rimuovi duplicati automaticamente (ATTENZIONE: verifica prima!)
./bashscripts/cleanup-duplicate-files.sh --dry-run
```

## 📚 Riferimenti

- PSR-4: Autoloading Standard
- Laravel Naming Conventions
- Filament Best Practices
- Git Case Sensitivity Issues
