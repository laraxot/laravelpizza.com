#!/bin/bash

# Configurazione
MODULE_ROOT="/var/www/html/_bases/base_predict_fila3_mono/laravel/Modules"
LOG_FILE="./path_fix.log"

# Logging
log() {
    local level=$1
    local message=$2
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] [$level] $message" | tee -a "$LOG_FILE"
}

# Funzione per correggere i path di un modulo
fix_module_paths() {
    local module_path="$1"
    local module_name=$(basename "$module_path")
    
    log "INFO" "Processando modulo: $module_name"
    
    # Backup
    local backup_dir="./module_backups/${module_name}_$(date +%Y%m%d_%H%M%S)"
    mkdir -p "$backup_dir"
    cp -r "$module_path" "$backup_dir"
    
    # Correggi cartelle maiuscole in minuscole
    if [ -d "$module_path/Resources" ]; then
        if [ -d "$module_path/resources" ]; then
            log "WARNING" "Unisco Resources in resources"
            cp -r "$module_path/Resources/"* "$module_path/resources/"
            rm -rf "$module_path/Resources"
        else
            log "INFO" "Rinomino Resources in resources"
            mv "$module_path/Resources" "$module_path/resources"
        fi
    fi
    
    if [ -d "$module_path/Lang" ]; then
        if [ -d "$module_path/lang" ]; then
            log "WARNING" "Unisco Lang in lang"
            cp -r "$module_path/Lang/"* "$module_path/lang/"
            rm -rf "$module_path/Lang"
        else
            log "INFO" "Rinomino Lang in lang"
            mv "$module_path/Lang" "$module_path/lang"
        fi
    fi
    
    # Crea struttura app/ se non esiste
    mkdir -p "$module_path/app"
    
    # Sposta Actions sotto app/
    if [ -d "$module_path/Actions" ]; then
        mkdir -p "$module_path/app/Actions"
        log "INFO" "Sposto Actions sotto app/"
        cp -r "$module_path/Actions/"* "$module_path/app/Actions/"
        rm -rf "$module_path/Actions"
    fi
    
    # Sposta Http sotto app/
    if [ -d "$module_path/Http" ]; then
        mkdir -p "$module_path/app/Http"
        log "INFO" "Sposto Http sotto app/"
        cp -r "$module_path/Http/"* "$module_path/app/Http/"
        rm -rf "$module_path/Http"
    fi
    
    # Correggi namespace nei file PHP
    log "INFO" "Correzione namespace..."
    find "$module_path" -type f -name "*.php" | while read -r file; do
        # Correggi namespace Actions
        sed -i "s/namespace Modules\\\\${module_name}\\\\Actions/namespace Modules\\\\${module_name}\\\\App\\\\Actions/g" "$file"
        
        # Correggi namespace Http
        sed -i "s/namespace Modules\\\\${module_name}\\\\Http/namespace Modules\\\\${module_name}\\\\App\\\\Http/g" "$file"
        
        # Correggi use statements
        sed -i "s/use Modules\\\\${module_name}\\\\Actions/use Modules\\\\${module_name}\\\\App\\\\Actions/g" "$file"
        sed -i "s/use Modules\\\\${module_name}\\\\Http/use Modules\\\\${module_name}\\\\App\\\\Http/g" "$file"
    done
    
    # Correggi permessi
    log "INFO" "Correzione permessi..."
    find "$module_path/app" -type d -exec chmod 755 {} \;
    find "$module_path/app" -type f -exec chmod 644 {} \;
    find "$module_path/resources" -type d -exec chmod 755 {} \;
    find "$module_path/resources" -type f -exec chmod 644 {} \;
    
    log "SUCCESS" "Modulo $module_name processato"
}

# Funzione per verificare la struttura
verify_structure() {
    local module_path="$1"
    local errors=0
    
    # Verifica cartelle errate
    if find "$module_path" -type d \( -name "Resources" -o -name "Lang" -o -name "Actions" -o -name "Http" \) | grep -q .; then
        log "ERROR" "Trovate cartelle con nomi errati in $module_path"
        ((errors++))
    fi
    
    # Verifica namespace errati
    if grep -r "namespace Modules.*\\\\\(Actions\|Http\);" "$module_path" | grep -v "App\\\\" | grep -q .; then
        log "ERROR" "Trovati namespace errati in $module_path"
        ((errors++))
    fi
    
    return $errors
}

# Main
main() {
    log "INFO" "Inizio correzione path"
    
    # Per ogni modulo
    for module_path in "$MODULE_ROOT"/*; do
        if [ -d "$module_path" ]; then
            # Verifica struttura attuale
            if ! verify_structure "$module_path"; then
                # Correggi path
                fix_module_paths "$module_path"
                
                # Verifica dopo la correzione
                if ! verify_structure "$module_path"; then
                    log "ERROR" "Persistono errori in $module_path dopo la correzione"
                fi
            else
                log "INFO" "Nessuna correzione necessaria per $(basename "$module_path")"
            fi
        fi
    done
    
    log "INFO" "Correzione path completata"
    
    # Suggerimenti finali
    echo ""
    echo "Operazioni post-correzione consigliate:"
    echo "1. Esegui 'composer dump-autoload'"
    echo "2. Esegui 'php artisan cache:clear'"
    echo "3. Verifica i test"
    echo "4. Controlla il log in $LOG_FILE"
}

# Esegui main
main "$@" 