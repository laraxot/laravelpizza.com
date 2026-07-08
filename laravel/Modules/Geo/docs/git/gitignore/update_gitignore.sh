#!/bin/bash

# Script per aggiornare tutti i .gitignore dei moduli al prototipo standardizzato
# Data: 3 Gennaio 2025

cd /var/www/html/_bases/base_ptvx_fila5_mono/laravel/Modules

# Prototipo standardizzato
GITIGNORE_CONTENT='# Dependencies and packages
/vendor/
/node_modules/
/docs/vendor/

# Lock files and cache
*.lock
*.cache
*.phar
*.jar
package-lock.json
yarn-error.log
npm-debug.log
composer.lock
.phpunit.result.cache
.php-cs-fixer.cache

# Log files
*.log
error_log

# Build directories
/build/
/build
build/

# Laravel specific
bootstrap/compiled.php
app/storage/
public/storage
public/hot
public_html/storage
public_html/hot
storage/*.key
.env

# Local configurations
Homestead.yaml
Homestead.json
/.vagrant

# IDE specific
/.idea
.phpintel

# Git specific
.git-blame-ignore-revs
.git-rewrite/
.git-rewrite

# Temporary and system files
*.tmp
*.swp
*.swo
*.stackdump
*.exe
*:Zone.Identifier
.DS_Store
*.old
*.old1
*.backup
*.backup.*
*.bak
*.new

# Documentation and cache
docs/phpstan/
docs/cache/
cache/

# Development tools
.windsurf/
.cursor/'

# Lista moduli da aggiornare (quelli con .gitignore incompleti)
MODULES_TO_UPDATE="ContoAnnuale Europa Inail Incentivi IndennitaCondizioniLavoro IndennitaResponsabilita Legge104 Legge109 Media Mensa MobilitaVolontaria Notify Prenotazioni PresenzeAssenze Progressioni Questionari Sindacati"

echo "=== AGGIORNAMENTO GITIGNORE MODULI LARAXOT ==="
echo "Data: $(date)"
echo

for module in $MODULES_TO_UPDATE; do
    if [[ -d "$module" && -f "$module/.gitignore" ]]; then
        echo "Aggiornando: $module"
        
        # Scrivi il nuovo contenuto
        echo "$GITIGNORE_CONTENT" > "$module/.gitignore"
        
        echo "✓ $module/.gitignore aggiornato"
    else
        echo "⚠ Saltato: $module (directory o .gitignore non trovato)"
    fi
    echo
done

echo "=== AGGIORNAMENTO COMPLETATO ==="
echo

# Verifica finale
echo "=== VERIFICA CONFORMITA' ==="
for module in */; do
    if [[ -f "${module}.gitignore" ]]; then
        module_name="${module%/}"
        zone_check=$(grep -q '\*:Zone.Identifier' "${module}.gitignore" && echo 'OK' || echo 'MANCANTE')
        dev_tools_check=$(grep -q '\.windsurf/' "${module}.gitignore" && echo 'OK' || echo 'MANCANTE')
        
        if [[ "$zone_check" == "OK" && "$dev_tools_check" == "OK" ]]; then
            echo "✓ $module_name: CONFORME"
        else
            echo "⚠ $module_name: Zone.Identifier=$zone_check, Dev.Tools=$dev_tools_check"
        fi
    fi
done

echo
echo "Aggiornamento completato!"
