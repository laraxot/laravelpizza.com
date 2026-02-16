#!/bin/bash

# Configurazione
MODULE_ROOT="/var/www/html/_bases/base_predict_fila3_mono/laravel/Modules"
LOG_FILE="./module_structure_fix.log"

# Funzioni di utilità
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" | tee -a "$LOG_FILE"
}

fix_directory_case() {
    local module_path="$1"
    
    # Lista di cartelle da controllare
    declare -A dir_mapping=(
        ["Resources"]="resources"
        ["Lang"]="lang"
        ["Views"]="views"
        ["Http"]="app/Http"
        ["Actions"]="app/Actions"
        ["Models"]="app/Models"
        ["Providers"]="app/Providers"
        ["Services"]="app/Services"
    )
    
    for wrong_name in "${!dir_mapping[@]}"; do
        correct_name="${dir_mapping[$wrong_name]}"
        
        # Cerca cartelle con nomi errati
        find "$module_path" -type d -name "$wrong_name" | while read -r dir; do
            parent_dir=$(dirname "$dir")
            
            # Se la cartella corretta esiste già
            if [[ -d "${parent_dir}/${correct_name}" ]]; then
                log "ATTENZIONE: ${parent_dir}/${correct_name} esiste già"
                log "Unisco i contenuti di $dir in ${parent_dir}/${correct_name}"
                
                # Sposta i contenuti
                cp -r "$dir"/* "${parent_dir}/${correct_name}/"
                rm -rf "$dir"
            else
                # Se la cartella corretta non esiste, rinomina
                if [[ "$correct_name" == app/* ]]; then
                    mkdir -p "${parent_dir}/app"
                    mv "$dir" "${parent_dir}/${correct_name}"
                else
                    mv "$dir" "${parent_dir}/${correct_name}"
                fi
                log "Rinominato: $dir -> ${parent_dir}/${correct_name}"
            fi
        done
    done
}

fix_namespace() {
    local module_path="$1"
    local module_name=$(basename "$module_path")
    
    # Cerca file PHP
    find "$module_path" -type f -name "*.php" | while read -r file; do
        # Correggi namespace
        if grep -q "namespace Modules\\\\${module_name}\\\\Http" "$file"; then
            sed -i "s/namespace Modules\\\\${module_name}\\\\Http/namespace Modules\\\\${module_name}\\\\App\\\\Http/g" "$file"
            log "Corretto namespace in: $file"
        fi
        
        if grep -q "namespace Modules\\\\${module_name}\\\\Actions" "$file"; then
            sed -i "s/namespace Modules\\\\${module_name}\\\\Actions/namespace Modules\\\\${module_name}\\\\App\\\\Actions/g" "$file"
            log "Corretto namespace in: $file"
        fi
    done
}

create_missing_directories() {
    local module_path="$1"
    
    # Lista delle cartelle standard
    directories=(
        "app/Actions"
        "app/Http"
        "app/Models"
        "app/Providers"
        "app/Services"
        "config"
        "database"
        "docs"
        "lang"
        "resources/views"
        "routes"
        "tests"
    )
    
    for dir in "${directories[@]}"; do
        if [[ ! -d "${module_path}/${dir}" ]]; then
            mkdir -p "${module_path}/${dir}"
            log "Creata cartella mancante: ${module_path}/${dir}"
        fi
    done
}

fix_permissions() {
    local module_path="$1"
    
    # Imposta permessi corretti
    find "$module_path/app" -type d -exec chmod 755 {} \;
    find "$module_path/app" -type f -exec chmod 644 {} \;
    find "$module_path/resources" -type d -exec chmod 755 {} \;
    find "$module_path/resources" -type f -exec chmod 644 {} \;
    
    log "Permessi corretti impostati per: $module_path"
}

main() {
    log "Inizio correzione struttura moduli"
    
    # Per ogni modulo
    for module_path in "$MODULE_ROOT"/*; do
        if [[ -d "$module_path" ]]; then
            log "Processando modulo: $module_path"
            
            # Crea backup
            backup_dir="./module_backups/$(basename "$module_path")_$(date +%Y%m%d_%H%M%S)"
            mkdir -p "$backup_dir"
            cp -r "$module_path" "$backup_dir"
            
            # Applica correzioni
            fix_directory_case "$module_path"
            fix_namespace "$module_path"
            create_missing_directories "$module_path"
            fix_permissions "$module_path"
            
            log "Modulo processato: $module_path"
        fi
    done
    
    log "Correzione struttura moduli completata"
}

# Esegui lo script
main 