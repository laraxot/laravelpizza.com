#!/bin/bash

# Script per ottimizzare l'uso della memoria nei pannelli Filament
# SuperMucca Memory Optimizer 🐄

set -e

echo "🐄 SuperMucca Filament Memory Optimizer 🐄"
echo "==========================================="
echo "Ottimizzazione memory usage per pannelli admin Filament"
echo ""

# Colori
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
PURPLE='\033[0;35m'
NC='\033[0m'

WORK_DIR="/var/www/_bases/base_<nome progetto>_fila5_mono/laravel"
cd "$WORK_DIR"

echo -e "${BLUE}Directory di lavoro: ${WORK_DIR}${NC}"
echo ""

# Funzione per ottimizzare i modelli
optimize_models() {
    echo -e "${BLUE}Ottimizzazione modelli Eloquent...${NC}"
    
    # Trova modelli con eager loading eccessivo
    echo -e "${YELLOW}Ricerca modelli con eager loading eccessivo...${NC}"
    
    local models_with_with
    mapfile -t models_with_with < <(find Modules -name "*.php" -type f -exec grep -l "protected \$with = \[" {} \; 2>/dev/null || true)
    
    if [ ${#models_with_with[@]} -eq 0 ]; then
        echo -e "${GREEN}✓ Nessun modello con eager loading trovato${NC}"
    else
        echo -e "${YELLOW}Trovati ${#models_with_with[@]} modelli con eager loading:${NC}"
        for model in "${models_with_with[@]}"; do
            echo -e "${YELLOW}  - ${model}${NC}"
            
            # Mostra il contenuto del $with
            echo -e "${BLUE}    Contenuto \$with:${NC}"
            grep -A 5 "protected \$with = \[" "$model" | head -10
            echo ""
        done
    fi
}

# Funzione per ottimizzare i widget
optimize_widgets() {
    echo -e "${BLUE}Ottimizzazione widget Filament...${NC}"
    
    # Trova widget che potrebbero caricare troppi dati
    echo -e "${YELLOW}Ricerca widget con query pesanti...${NC}"
    
    local heavy_widgets
    mapfile -t heavy_widgets < <(find Modules -path "*/Filament/Widgets/*.php" -type f -exec grep -l "->get()" {} \; 2>/dev/null || true)
    
    if [ ${#heavy_widgets[@]} -eq 0 ]; then
        echo -e "${GREEN}✓ Nessun widget con query pesanti trovato${NC}"
    else
        echo -e "${YELLOW}Trovati ${#heavy_widgets[@]} widget con potenziali query pesanti:${NC}"
        for widget in "${heavy_widgets[@]}"; do
            echo -e "${YELLOW}  - ${widget}${NC}"
            
            # Controlla se ha limitazioni
            if grep -q "->limit(" "$widget"; then
                echo -e "${GREEN}    ✓ Ha limitazioni${NC}"
            else
                echo -e "${RED}    ⚠ Nessuna limitazione trovata${NC}"
            fi
            
            # Controlla se ha whereNotNull per coordinate
            if grep -q "whereNotNull.*latitude\|whereNotNull.*longitude" "$widget"; then
                echo -e "${GREEN}    ✓ Ha filtri per coordinate${NC}"
            else
                echo -e "${YELLOW}    ? Potrebbe beneficiare di filtri coordinate${NC}"
            fi
            echo ""
        done
    fi
}

# Funzione per controllare le configurazioni dei pannelli
check_panel_configs() {
    echo -e "${BLUE}Controllo configurazioni pannelli...${NC}"
    
    local panel_providers
    mapfile -t panel_providers < <(find Modules -name "*PanelProvider.php" -type f 2>/dev/null || true)
    
    if [ ${#panel_providers[@]} -eq 0 ]; then
        echo -e "${YELLOW}Nessun PanelProvider trovato${NC}"
    else
        echo -e "${YELLOW}Trovati ${#panel_providers[@]} PanelProvider:${NC}"
        for provider in "${panel_providers[@]}"; do
            echo -e "${YELLOW}  - ${provider}${NC}"
            
            # Controlla se ha widget registrati
            if grep -q "->widgets(" "$provider"; then
                echo -e "${BLUE}    Ha widget registrati${NC}"
                grep -A 5 "->widgets(" "$provider" | head -10
            fi
            
            # Controlla middleware
            if grep -q "middleware(" "$provider"; then
                echo -e "${BLUE}    Ha middleware personalizzati${NC}"
            fi
            echo ""
        done
    fi
}

# Funzione per controllare le risorse Filament
check_filament_resources() {
    echo -e "${BLUE}Controllo risorse Filament...${NC}"
    
    local resources
    mapfile -t resources < <(find Modules -path "*/Filament/Resources/*Resource.php" -type f 2>/dev/null || true)
    
    if [ ${#resources[@]} -eq 0 ]; then
        echo -e "${YELLOW}Nessuna risorsa Filament trovata${NC}"
    else
        echo -e "${YELLOW}Trovate ${#resources[@]} risorse Filament${NC}"
        
        local heavy_resources=0
        for resource in "${resources[@]}"; do
            # Controlla se ha query complesse
            if grep -q "->with(" "$resource" || grep -q "->load(" "$resource"; then
                echo -e "${RED}  ⚠ ${resource} - Ha eager loading${NC}"
                ((heavy_resources++))
            fi
            
            # Controlla se ha paginazione
            if grep -q "->paginate(" "$resource" || grep -q "paginateTableQuery" "$resource"; then
                echo -e "${GREEN}  ✓ ${resource} - Ha paginazione${NC}"
            fi
        done
        
        if [ $heavy_resources -gt 0 ]; then
            echo -e "${YELLOW}${heavy_resources} risorse potrebbero beneficiare di ottimizzazioni${NC}"
        else
            echo -e "${GREEN}✓ Tutte le risorse sembrano ottimizzate${NC}"
        fi
    fi
}

# Funzione per suggerimenti di ottimizzazione
suggest_optimizations() {
    echo -e "${PURPLE}Suggerimenti di ottimizzazione:${NC}"
    echo ""
    
    echo -e "${BLUE}1. Modelli Eloquent:${NC}"
    echo "   - Rimuovi eager loading non necessario (\$with)"
    echo "   - Usa ->select() per limitare le colonne"
    echo "   - Implementa scope per query comuni"
    echo ""
    
    echo -e "${BLUE}2. Widget Filament:${NC}"
    echo "   - Aggiungi ->limit() alle query"
    echo "   - Usa whereNotNull per campi obbligatori"
    echo "   - Implementa caching per dati statici"
    echo ""
    
    echo -e "${BLUE}3. Risorse Filament:${NC}"
    echo "   - Usa paginazione invece di ->get()"
    echo "   - Limita le relazioni caricate"
    echo "   - Implementa filtri di default"
    echo ""
    
    echo -e "${BLUE}4. Configurazioni PHP:${NC}"
    echo "   - Aumenta memory_limit se necessario"
    echo "   - Ottimizza opcache settings"
    echo "   - Usa Redis per sessioni e cache"
    echo ""
}

# Funzione per applicare ottimizzazioni automatiche
apply_optimizations() {
    echo -e "${BLUE}Applicazione ottimizzazioni automatiche...${NC}"
    
    read -p "Vuoi applicare le ottimizzazioni automatiche? (y/N): " -n 1 -r
    echo ""
    
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        echo -e "${YELLOW}Ottimizzazioni automatiche saltate${NC}"
        return 0
    fi
    
    # Backup dei file prima delle modifiche
    echo -e "${YELLOW}Creazione backup...${NC}"
    mkdir -p storage/backups/memory_optimization_$(date +%Y%m%d_%H%M%S)
    
    # Ottimizzazione 1: Cache delle configurazioni
    echo -e "${BLUE}Ottimizzazione cache configurazioni...${NC}"
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    
    # Ottimizzazione 2: Pulizia cache
    echo -e "${BLUE}Pulizia cache obsoleta...${NC}"
    php artisan cache:clear
    
    # Ottimizzazione 3: Ottimizzazione autoloader
    echo -e "${BLUE}Ottimizzazione autoloader...${NC}"
    composer dump-autoload --optimize
    
    echo -e "${GREEN}✓ Ottimizzazioni automatiche applicate${NC}"
}

# Funzione per monitoraggio memory usage
monitor_memory() {
    echo -e "${BLUE}Monitoraggio memory usage...${NC}"
    
    if command -v php >/dev/null 2>&1; then
        echo -e "${YELLOW}Configurazione PHP corrente:${NC}"
        echo "  Memory limit: $(php -r "echo ini_get('memory_limit');")"
        echo "  Max execution time: $(php -r "echo ini_get('max_execution_time');")"
        echo "  Opcache enabled: $(php -r "echo ini_get('opcache.enable') ? 'Yes' : 'No';")"
        echo ""
    fi
    
    echo -e "${YELLOW}Per monitorare in tempo reale:${NC}"
    echo "  # Memory usage durante le richieste"
    echo "  tail -f storage/logs/laravel.log | grep -i memory"
    echo ""
    echo "  # Profiling con Xdebug (se installato)"
    echo "  php -d xdebug.profiler_enable=1 artisan serve"
    echo ""
}

# Menu principale
show_menu() {
    echo ""
    echo -e "${BLUE}Opzioni disponibili:${NC}"
    echo "1. Analizza modelli Eloquent"
    echo "2. Analizza widget Filament"
    echo "3. Controlla configurazioni pannelli"
    echo "4. Controlla risorse Filament"
    echo "5. Mostra suggerimenti ottimizzazione"
    echo "6. Applica ottimizzazioni automatiche"
    echo "7. Monitoraggio memory usage"
    echo "8. Esegui analisi completa"
    echo "9. Esci"
    echo ""
}

# Analisi completa
run_full_analysis() {
    echo -e "${PURPLE}Esecuzione analisi completa...${NC}"
    echo ""
    
    optimize_models
    echo ""
    optimize_widgets
    echo ""
    check_panel_configs
    echo ""
    check_filament_resources
    echo ""
    suggest_optimizations
    echo ""
    monitor_memory
    
    echo -e "${GREEN}🎉 Analisi completa terminata!${NC}"
}

# Main loop
while true; do
    show_menu
    read -p "Scegli un'opzione (1-9): " -n 1 -r
    echo ""
    echo ""
    
    case $REPLY in
        1)
            optimize_models
            ;;
        2)
            optimize_widgets
            ;;
        3)
            check_panel_configs
            ;;
        4)
            check_filament_resources
            ;;
        5)
            suggest_optimizations
            ;;
        6)
            apply_optimizations
            ;;
        7)
            monitor_memory
            ;;
        8)
            run_full_analysis
            ;;
        9)
            echo -e "${GREEN}Arrivederci! 🐄${NC}"
            exit 0
            ;;
        *)
            echo -e "${RED}Opzione non valida${NC}"
            ;;
    esac
    
    echo ""
    read -p "Premi ENTER per continuare..."
done
