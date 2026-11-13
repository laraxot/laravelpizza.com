#!/bin/bash

# Script per correggere automaticamente la struttura delle directory nei moduli Laraxot PTVX

# Colori per output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Verifica se è stato fornito un modulo come argomento
if [ -z "$1" ]; then
    echo -e "${RED}Errore: È necessario specificare un modulo${NC}"
    echo -e "${YELLOW}Uso: $0 NomeModulo${NC}"
    echo -e "${YELLOW}Per correggere tutti i moduli: $0 --all${NC}"
    exit 1
fi

# Funzione per correggere la struttura di un modulo
fix_module_structure() {
    local MODULE=$1
    local MODULE_PATH="Modules/$MODULE"
    
    # Verifica se il modulo esiste
    if [ ! -d "$MODULE_PATH" ]; then
        echo -e "${RED}Errore: Il modulo $MODULE non esiste${NC}"
        return 1
    fi
    
    echo -e "${BLUE}Correzione della struttura delle directory per il modulo $MODULE...${NC}"
    
    # Trova tutti i file PHP nel modulo, escludendo le posizioni corrette
    echo -e "${YELLOW}Fase 1: Identificazione dei file PHP di applicazione che devono essere in app/...${NC}"
    
    # Cerca file che dovrebbero essere in app/, ma esclude le posizioni legittime
    # Questa lista include SOLO i modelli di percorso che devono essere spostati in app/
    local app_pattern="-path \"*/${MODULE}/Models/*\" -o -path \"*/${MODULE}/Http/*\" -o -path \"*/${MODULE}/Enums/*\" -o -path \"*/${MODULE}/Actions/*\" -o -path \"*/${MODULE}/Datas/*\" -o -path \"*/${MODULE}/Events/*\" -o -path \"*/${MODULE}/Notifications/*\" -o -path \"*/${MODULE}/Policies/*\" -o -path \"*/${MODULE}/Providers/*\" -o -path \"*/${MODULE}/Services/*\" -o -path \"*/${MODULE}/Listeners/*\" -o -path \"*/${MODULE}/Jobs/*\" -o -path \"*/${MODULE}/Exceptions/*\" -o -path \"*/${MODULE}/Filament/*\" -o -path \"*/${MODULE}/Console/*\""
    
    # Esegui la ricerca, escludendo tutto ciò che è già in app/
    local files=$(find "$MODULE_PATH" -type f -name "*.php" \( $app_pattern \) | grep -v "/app/")
    
    if [ -z "$files" ]; then
        echo -e "${GREEN}✓ Non sono stati trovati file PHP dell'applicazione da spostare in app/${NC}"
    else
        local count=0
        
        # Sposta i file nella directory app appropriata
        echo "$files" | while read file; do
            # Estrai il percorso relativo dopo Modules/NomeModulo/
            rel_path=$(echo "$file" | sed "s|$MODULE_PATH/||")
            
            # Crea il nuovo percorso
            new_path="$MODULE_PATH/app/$rel_path"
            
            # Crea la directory se non esiste
            mkdir -p "$(dirname "$new_path")"
            
            # Sposta il file
            mv "$file" "$new_path"
            echo -e "${GREEN}✓ Spostato: $file -> $new_path${NC}"
            
            # Incrementa il contatore
            ((count++))
        done
        
        echo -e "${GREEN}✓ $count file PHP spostati in app/${NC}"
    fi
    
    # Verifica se ci sono file nella cartella app/ che non dovrebbero essere lì
    echo -e "${YELLOW}Fase 2: Verifica se ci sono file di framework erroneamente in app/...${NC}"
    
    # Cerca file nella cartella app/ che dovrebbero essere nella radice
    if [ -d "$MODULE_PATH/app" ]; then
        local wrong_files=$(find "$MODULE_PATH/app" -type f -name "*.php" \( -path "*/app/config/*" -o -path "*/app/routes/*" -o -path "*/app/lang/*" -o -path "*/app/database/*" \))
        
        if [ -z "$wrong_files" ]; then
            echo -e "${GREEN}✓ Non sono stati trovati file di framework erroneamente in app/${NC}"
        else
            local count_wrong=0
            
            # Sposta i file nella posizione corretta nella radice
            echo "$wrong_files" | while read file; do
                # Estrai il percorso relativo dopo Modules/NomeModulo/app/
                rel_path=$(echo "$file" | sed "s|$MODULE_PATH/app/||")
                
                # Crea il nuovo percorso nella radice
                new_path="$MODULE_PATH/$rel_path"
                
                # Crea la directory se non esiste
                mkdir -p "$(dirname "$new_path")"
                
                # Sposta il file
                mv "$file" "$new_path"
                echo -e "${GREEN}✓ Corretto: $file -> $new_path${NC}"
                
                # Incrementa il contatore
                ((count_wrong++))
            done
            
            echo -e "${GREEN}✓ $count_wrong file di framework spostati nella posizione corretta${NC}"
        fi
    fi
    
    # Elenco dei file che sono già nel posto giusto e non devono essere toccati
    echo -e "${YELLOW}Fase 3: Verifica dei file che sono già nella posizione corretta...${NC}"
    
    local legit_files=$(find "$MODULE_PATH" -type f -name "*.php" \( -path "*/config/*" -o -path "*/database/*" -o -path "*/routes/*" -o -path "*/lang/*" -o -path "*/resources/*" -o -path "*/docs/*" -o -path "*/.vscode/*" -o -path "*/.php-cs-fixer*" -o -path "*/phpstan*" \))
    
    if [ -n "$legit_files" ]; then
        local legit_count=$(echo "$legit_files" | wc -l)
        echo -e "${GREEN}✓ $legit_count file di framework sono già nella posizione corretta (config, routes, lang, ecc.)${NC}"
    fi
    
    echo -e "${BLUE}Struttura corretta per il modulo $MODULE.${NC}"
    return 0
}

# Correggi tutti i moduli o solo quello specificato
if [ "$1" == "--all" ]; then
    echo -e "${BLUE}Correzione della struttura delle directory per tutti i moduli...${NC}"
    
    # Trova tutti i moduli
    for module_path in Modules/*; do
        if [ -d "$module_path" ]; then
            module_name=$(basename "$module_path")
            fix_module_structure "$module_name"
        fi
    done
    
    echo -e "${BLUE}Correzione della struttura delle directory completata per tutti i moduli${NC}"
else
    # Correggi solo il modulo specificato
    fix_module_structure "$1"
fi

# Correzione specifica per Rating/Enums/SupportedLocale.php
if [ -f "Modules/Rating/Enums/SupportedLocale.php" ]; then
    echo -e "${YELLOW}Correzione specifica per Rating/Enums/SupportedLocale.php...${NC}"
    
    # Crea la directory se non esiste
    mkdir -p "Modules/Rating/app/Enums"
    
    # Sposta il file
    mv "Modules/Rating/Enums/SupportedLocale.php" "Modules/Rating/app/Enums/SupportedLocale.php"
    echo -e "${GREEN}✓ Spostato: Modules/Rating/Enums/SupportedLocale.php -> Modules/Rating/app/Enums/SupportedLocale.php${NC}"
    
    # Rimuovi la directory vuota
    rmdir "Modules/Rating/Enums" 2>/dev/null
fi

echo -e "${BLUE}Verifica finale...${NC}"

# Conta i file dell'applicazione che dovrebbero essere in app/
echo -e "${YELLOW}Verifica finale dei file dell'applicazione ancora non in app/...${NC}"

# Genera un pattern combinato per tutti i moduli
app_pattern=""
for module_path in Modules/*; do
    if [ -d "$module_path" ]; then
        module_name=$(basename "$module_path")
        if [ -n "$app_pattern" ]; then
            app_pattern="$app_pattern -o "
        fi
        app_pattern="$app_pattern(-path \"*/Modules/${module_name}/Models/*\" -o -path \"*/Modules/${module_name}/Http/*\" -o -path \"*/Modules/${module_name}/Enums/*\" -o -path \"*/Modules/${module_name}/Actions/*\" -o -path \"*/Modules/${module_name}/Datas/*\" -o -path \"*/Modules/${module_name}/Events/*\" -o -path \"*/Modules/${module_name}/Notifications/*\" -o -path \"*/Modules/${module_name}/Policies/*\" -o -path \"*/Modules/${module_name}/Providers/*\" -o -path \"*/Modules/${module_name}/Services/*\" -o -path \"*/Modules/${module_name}/Listeners/*\" -o -path \"*/Modules/${module_name}/Jobs/*\" -o -path \"*/Modules/${module_name}/Exceptions/*\" -o -path \"*/Modules/${module_name}/Filament/*\" -o -path \"*/Modules/${module_name}/Console/*\")"
    fi
done

# Controlla che non ci siano ancora file dell'applicazione fuori dalla cartella app/
remaining_app_files=$(find Modules -type f -name "*.php" \( $app_pattern \) | grep -v "/app/" | grep -v "/vendor/")

if [ -n "$remaining_app_files" ]; then
    remaining_count=$(echo "$remaining_app_files" | wc -l)
    echo -e "${YELLOW}Attenzione: Ci sono ancora $remaining_count file dell'applicazione che dovrebbero essere in app/:${NC}"
    echo "$remaining_app_files" | head -n 10 | while read file; do
        echo -e "${RED}✗ $file${NC}"
    done
    
    if [ $(echo "$remaining_app_files" | wc -l) -gt 10 ]; then
        echo -e "${YELLOW}... e altri file (mostrati solo i primi 10)${NC}"
    fi
    
    echo -e "${YELLOW}Esegui nuovamente lo script per correggere questi file.${NC}"
else
    echo -e "${GREEN}✓ Tutti i file dell'applicazione sono correttamente posizionati in app/!${NC}"
fi

# Verifica se ci sono file nella cartella app/ che non dovrebbero essere lì
echo -e "${YELLOW}Verifica finale dei file di framework erroneamente in app/...${NC}"

wrong_framework_files=$(find Modules/*/app -type f -name "*.php" \( -path "*/app/config/*" -o -path "*/app/routes/*" -o -path "*/app/lang/*" -o -path "*/app/database/*" \))

if [ -n "$wrong_framework_files" ]; then
    wrong_count=$(echo "$wrong_framework_files" | wc -l)
    echo -e "${YELLOW}Attenzione: Ci sono $wrong_count file di framework erroneamente posizionati in app/:${NC}"
    echo "$wrong_framework_files" | while read file; do
        echo -e "${RED}✗ $file${NC}"
    done
    echo -e "${YELLOW}Questi file dovrebbero essere spostati nella radice del modulo.${NC}"
else
    echo -e "${GREEN}✓ Non ci sono file di framework erroneamente posizionati in app/!${NC}"
fi

echo -e "${GREEN}Script completato.${NC}" 