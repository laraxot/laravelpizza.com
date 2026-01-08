# Pulizia File Duplicati Case-Insensitive

## 📋 File Duplicati Identificati

### Regola di Rimozione

**Mantieni sempre la versione con naming corretto secondo le convenzioni.**

## 🗑️ File da Eliminare

### Moduli - docs/

```bash
# README.md (MAIUSCOLO) è corretto, elimina minuscolo
rm Modules/Activity/docs/readme.md
rm Modules/UI/docs/readme.md

# ROADMAP.md (MAIUSCOLO) è corretto, elimina minuscolo  
rm Modules/Fixcity/docs/roadmap.md

# ListRecords.md (PascalCase) è corretto, elimina minuscolo
rm Modules/UI/docs/filament/listrecords.md
```

### Moduli - .github/

```bash
# File standard .github in MAIUSCOLO
rm Modules/Activity/.github/contributing.md
rm Modules/Activity/.github/security.md
rm Modules/UI/.github/contributing.md
rm Modules/UI/.github/security.md
```

### Moduli - Views

```bash
# Blade views in kebab-case minuscolo
rm Modules/Notify/resources/views/emails/templates/ark/contentEnd.blade.php
rm Modules/Notify/resources/views/emails/templates/ark/wideImage.blade.php
rm Modules/Notify/resources/views/emails/templates/ark/contentStart.blade.php

# Mantieni versioni minuscole:
# - content-end.blade.php
# - wide-image.blade.php  
# - content-start.blade.php
```

### Moduli - Config

```bash
# .php-cs-fixer in minuscolo
rm "Modules/Notify/.php-cs-fixer.dist - Copia.php"
```

## ✅ Comando di Pulizia Manuale

```bash
# Esegui dalla directory laravel/

# 1. Verifica file da eliminare
find Modules -type f \( -name "readme.md" -o -name "roadmap.md" \) ! -path "*/vendor/*"

# 2. Elimina readme.md minuscoli (mantieni README.md)
find Modules -type f -name "readme.md" ! -path "*/vendor/*" -delete

# 3. Elimina file .github minuscoli
find Modules -path "*/.github/contributing.md" -delete
find Modules -path "*/.github/security.md" -delete

# 4. Verifica blade duplicati
find Modules -type f -name "*.blade.php" -exec bash -c '
    dir=$(dirname "{}")
    base=$(basename "{}")
    lower=$(echo "$base" | tr "[:upper:]" "[:lower:]")
    if [[ "$base" != "$lower" ]]; then
        other="$dir/$lower"
        if [[ -f "$other" ]]; then
            echo "Duplicato: {} <-> $other"
        fi
    fi
' \;
```

## 🔍 Verifica Post-Pulizia

```bash
# Verifica nessun duplicato rimasto
find Modules -type f \( -name "*.php" -o -name "*.md" \) -exec bash -c '
    dir=$(dirname "{}")
    base=$(basename "{}")
    count=$(find "$dir" -maxdepth 1 -iname "$base" | wc -l)
    if [[ $count -gt 1 ]]; then
        echo "⚠️  Duplicato: $dir/$base"
    fi
' \;
```

## 📊 Statistiche

- **readme.md**: 2 file da eliminare
- **roadmap.md**: 1 file da eliminare
- **.github/**: 4 file da eliminare
- **blade views**: 3 file da eliminare
- **config**: 1 file da eliminare

**Totale**: ~11 file da eliminare

## ⚠️ Attenzione

Prima di eliminare, verifica che i file duplicati abbiano lo stesso contenuto:

```bash
# Confronta contenuto
diff Modules/Activity/docs/README.md Modules/Activity/docs/readme.md
```

Se il contenuto è diverso:
1. Unisci il contenuto nel file corretto
2. Poi elimina il duplicato
