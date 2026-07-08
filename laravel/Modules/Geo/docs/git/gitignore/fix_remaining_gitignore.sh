#!/bin/bash

# Script per correggere i moduli .gitignore rimasti non conformi
# Data: 3 Gennaio 2025

cd /var/www/html/_bases/base_ptvx_fila5_mono/laravel/Modules

# Prototipo standardizzato completo
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

# Lista moduli non conformi identificati dalla verifica
NON_CONFORMI="CertFisc IndennitaCondizioniLavoro Mensa MobilitaVolontaria Prenotazioni PresenzeAssenze Questionari Sindacati"

echo "=== CORREZIONE FINALE MODULI NON CONFORMI ==="
echo "Data: $(date)"
echo

for module in $NON_CONFORMI; do
    if [[ -d "$module" ]]; then
        echo "Correggendo: $module"
        
        # Scrivi il nuovo contenuto completo
        echo "$GITIGNORE_CONTENT" > "$module/.gitignore"
        
        echo "✓ $module/.gitignore corretto"
    else
        echo "⚠ Saltato: $module (directory non trovata)"
    fi
    echo
done

echo "=== CORREZIONE COMPLETATA ==="
echo

# Verifica finale
echo "=== VERIFICA FINALE ==="
conformi=0
totali=0

for module in */; do
    if [[ -f "${module}.gitignore" ]]; then
        module_name="${module%/}"
        totali=$((totali + 1))
        
        zone_check=$(grep -q '\*:Zone.Identifier' "${module}.gitignore" && echo 'OK' || echo 'MANCANTE')
        dev_tools_check=$(grep -q '\.windsurf/' "${module}.gitignore" && echo 'OK' || echo 'MANCANTE')
        ide_check=$(grep -q '/\.idea' "${module}.gitignore" && echo 'OK' || echo 'MANCANTE')
        error_log_check=$(grep -q 'error_log' "${module}.gitignore" && echo 'OK' || echo 'MANCANTE')
        
        if [[ "$zone_check" == "OK" && "$dev_tools_check" == "OK" && "$ide_check" == "OK" && "$error_log_check" == "OK" ]]; then
            echo "✓ $module_name: CONFORME"
            conformi=$((conformi + 1))
        else
            echo "⚠ $module_name: Zone=$zone_check Dev=$dev_tools_check IDE=$ide_check ErrorLog=$error_log_check"
        fi
    fi
done

echo
echo "=== RISULTATO FINALE ==="
echo "Moduli totali: $totali"
echo "Moduli conformi: $conformi"
echo "Percentuale conformità: $(( (conformi * 100) / totali ))%"

if [[ $conformi -eq $totali ]]; then
    echo
    echo "🎉 TUTTI I MODULI SONO ORA CONFORMI AL PROTOTIPO STANDARDIZZATO!"
else
    echo
    echo "⚠ Alcuni moduli necessitano ancora di correzioni manuali."
fi
