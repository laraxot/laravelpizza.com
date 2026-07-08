#!/bin/bash

# Script di Refactoring SICURO Documentazione DRY + KISS
# SOLO cartelle docs/ - NON tocca docs_project o altre directory

set -e

echo "🚀 Avvio Refactoring SICURO Documentazione DRY + KISS"
echo "⚠️  SCOPE: Solo cartelle docs/ (NON docs_project)"

# Fase 1: Backup di sicurezza SOLO delle cartelle docs
echo "📦 Creazione backup documentazione docs/..."
BACKUP_DIR="/var/www/html/_bases/base_<nome progetto>/docs-backup-$(date +%Y%m%d-%H%M%S)"
mkdir -p "$BACKUP_DIR"

# Backup SOLO docs root (NON docs_project)
if [ -d "/var/www/html/_bases/base_<nome progetto>/docs" ]; then
    cp -r /var/www/html/_bases/base_<nome progetto>/docs "$BACKUP_DIR/docs-root"
fi

# Backup SOLO docs moduli
mkdir -p "$BACKUP_DIR/modules"
for module in /var/www/html/_bases/base_<nome progetto>/laravel/Modules/*/; do
    module_name=$(basename "$module")
    if [ -d "$module/docs" ]; then
        cp -r "$module/docs" "$BACKUP_DIR/modules/${module_name}-docs"
    fi
    if [ -d "$module/_docs" ]; then
        cp -r "$module/_docs" "$BACKUP_DIR/modules/${module_name}-_docs"
    fi
done

echo "✅ Backup completato in: $BACKUP_DIR"

# Fase 2: Eliminazione SOLO cartelle _docs duplicate (NON docs_project)
echo "🗑️  Eliminazione cartelle _docs duplicate..."

DOCS_DIRS=(
    "/var/www/html/_bases/base_<nome progetto>/laravel/Modules/Xot/_docs"
    "/var/www/html/_bases/base_<nome progetto>/laravel/Modules/Cms/_docs"
    "/var/www/html/_bases/base_<nome progetto>/laravel/Modules/Chart/_docs"
    "/var/www/html/_bases/base_<nome progetto>/laravel/Modules/UI/_docs"
    "/var/www/html/_bases/base_<nome progetto>/laravel/Modules/Job/_docs"
    "/var/www/html/_bases/base_<nome progetto>/laravel/Modules/Tenant/_docs"
    "/var/www/html/_bases/base_<nome progetto>/laravel/Modules/Gdpr/_docs"
    "/var/www/html/_bases/base_<nome progetto>/laravel/Modules/Notify/_docs"
    "/var/www/html/_bases/base_<nome progetto>/laravel/Modules/Lang/_docs"
    "/var/www/html/_bases/base_<nome progetto>/laravel/Modules/Geo/_docs"
    "/var/www/html/_bases/base_<nome progetto>/laravel/Modules/Media/_docs"
    "/var/www/html/_bases/base_<nome progetto>/laravel/Modules/User/_docs"
    "/var/www/html/_bases/base_<nome progetto>/laravel/Modules/Activity/_docs"
)

for dir in "${DOCS_DIRS[@]}"; do
    if [ -d "$dir" ]; then
        echo "  🗑️  Eliminando: $dir"
        rm -rf "$dir"
    fi
done

# Fase 3: Standardizzazione naming convention SOLO in docs/
echo "📝 Standardizzazione naming convention in docs/..."

# Funzione per convertire in lowercase
convert_to_lowercase() {
    local dir="$1"
    
    if [ ! -d "$dir" ]; then
        return
    fi
    
    find "$dir" -type f -name "*.md" | while read -r file; do
        dirname_path=$(dirname "$file")
        basename_file=$(basename "$file")
        
        # Skip README.md (unica eccezione)
        if [ "$basename_file" = "README.md" ]; then
            continue
        fi
        
        # Converti in lowercase
        lowercase_name=$(echo "$basename_file" | tr '[:upper:]' '[:lower:]')
        
        if [ "$basename_file" != "$lowercase_name" ]; then
            echo "  📝 Rinominando: $basename_file → $lowercase_name"
            mv "$file" "$dirname_path/$lowercase_name"
        fi
    done
}

# Applica naming convention SOLO a docs root (NON docs_project)
convert_to_lowercase "/var/www/html/_bases/base_<nome progetto>/docs"

# Applica naming convention SOLO a docs moduli
for module in /var/www/html/_bases/base_<nome progetto>/laravel/Modules/*/; do
    if [ -d "$module/docs" ]; then
        convert_to_lowercase "$module/docs"
    fi
done

# Fase 4: Miglioramento struttura docs/ root
echo "📁 Miglioramento struttura docs/ root..."

cd /var/www/html/_bases/base_<nome progetto>

# Crea struttura DRY standardizzata SOLO in docs/
mkdir -p docs/{architecture,standards,guides,templates}

# Fase 5: Creazione template standardizzati SOLO in docs/
echo "📋 Creazione template standardizzati..."

# Template README.md per moduli
cat > "docs/templates/module-readme-template.md" << 'EOF'
# {ModuleName} Module

## Overview
Brief description of the module's purpose and functionality.

## Features
- Feature 1
- Feature 2
- Feature 3

## Installation
```bash
# Installation commands
```

## Configuration
```php
// Configuration examples
```

## Usage
```php
// Usage examples
```

## API Reference
Link to detailed API documentation.

## Testing
```bash
# Testing commands
```

## Contributing
Guidelines for contributing to this module.

## Links
- [Root Documentation](../../../docs/README.md)
- [Architecture Guide](../../../docs/architecture/)
- [Standards](../../../docs/standards/)
EOF

# Template per documentazione API
cat > "docs/templates/api-documentation-template.md" << 'EOF'
# {ModuleName} API Documentation

## Endpoints

### GET /api/{module}/{resource}
Description of the endpoint.

**Parameters:**
- `param1` (string, required): Description
- `param2` (integer, optional): Description

**Response:**
```json
{
    "data": [],
    "meta": {}
}
```

## Authentication
Authentication requirements and methods.

## Rate Limiting
Rate limiting information.

## Error Handling
Common error responses and codes.
EOF

# Fase 6: Aggiornamento README.md principale
echo "📚 Aggiornamento README.md principale..."

cat > "docs/README.md" << 'EOF'
# <nome progetto> - Documentazione Progetto

## Overview
Sistema di gestione sanitaria per la <slogan> con architettura modulare Laravel.

## Architettura
- [Architettura Generale](architecture/)
- [Standard e Convenzioni](standards/)
- [Guide Implementazione](guides/)

## Moduli Principali
- [<nome progetto>](../laravel/Modules/<nome progetto>/docs/) - Modulo principale
- [User](../laravel/Modules/User/docs/) - Gestione utenti
- [UI](../laravel/Modules/UI/docs/) - Componenti interfaccia
- [Xot](../laravel/Modules/Xot/docs/) - Framework base

## Guide Rapide
- [Quick Reference](guides/quick_reference.md)
- [Development Guidelines](guides/development-guidelines.md)
- [Testing Strategy](guides/testing-strategy.md)

## Template
- [Module README Template](templates/module-readme-template.md)
- [API Documentation Template](templates/api-documentation-template.md)

## Principi DRY + KISS
Questa documentazione segue rigorosamente i principi:
- **DRY**: Un solo punto di verità per ogni argomento
- **KISS**: Struttura semplice e navigabile
- **Naming Convention**: Tutto lowercase (tranne README.md)
- **Collegamenti Bidirezionali**: Navigazione coerente

## Documentazione Progetto
Per la documentazione dettagliata del progetto, vedere [docs_project/](../docs_project/).

## Manutenzione
- Backup automatico prima di modifiche
- Validazione naming convention
- Controllo collegamenti bidirezionali
EOF

echo "✅ Refactoring SICURO DRY + KISS Completato!"
echo "📊 Statistiche:"
echo "   - Eliminate 13 cartelle _docs duplicate"
echo "   - Standardizzato naming convention SOLO in docs/"
echo "   - Creati template standardizzati"
echo "   - docs_project PRESERVATO e non toccato"
echo "   - Backup salvato in: $BACKUP_DIR"
echo ""
echo "🎯 Benefici ottenuti:"
echo "   - Eliminazione duplicazioni _docs"
echo "   - Struttura DRY + KISS in docs/"
echo "   - Naming convention uniforme"
echo "   - docs_project intatto e sicuro"
