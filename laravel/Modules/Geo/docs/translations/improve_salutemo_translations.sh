#!/bin/bash

# Script per migliorare le traduzioni del modulo <nome progetto>
# Segue gli standard di Laraxot per le traduzioni

set -e

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

<nome progetto>_LANG_DIR="laravel/Modules/<nome progetto>/lang/it"

echo -e "${YELLOW}🔧 Miglioramento traduzioni modulo <nome progetto>...${NC}"

# Funzione per creare backup
create_backup() {
    local file="$1"
    local backup_file="${file}.backup.$(date +%Y%m%d_%H%M%S)"
    cp "$file" "$backup_file"
    echo -e "${BLUE}📦 Backup creato: $backup_file${NC}"
}

# Funzione per migliorare un file di traduzione
improve_translation_file() {
    local file="$1"
    local filename=$(basename "$file")
    
    echo -e "${YELLOW}📝 Migliorando: $filename${NC}"
    
    # Crea backup
    create_backup "$file"
    
    # Leggi il contenuto attuale
    local content=$(cat "$file")
    
    # Sostituisci array() con []
    content=$(echo "$content" | sed 's/array (/[/g' | sed 's/)/]/g')
    
    # Aggiungi declare(strict_types=1) se non presente
    if ! echo "$content" | grep -q "declare(strict_types=1)"; then
        content="<?php

declare(strict_types=1);

return $content"
    fi
    
    # Rimuovi <?php se già presente e aggiungi di nuovo
    content=$(echo "$content" | sed 's/^<?php$//g' | sed 's/^<?php//g')
    content="<?php

declare(strict_types=1);

return $content"
    
    # Scrivi il file migliorato
    echo "$content" > "$file"
    
    echo -e "${GREEN}✅ Migliorato: $filename${NC}"
}

# Funzione per aggiungere traduzioni mancanti
add_missing_translations() {
    local file="$1"
    local filename=$(basename "$file" .php)
    
    echo -e "${YELLOW}🔍 Verificando traduzioni mancanti per: $filename${NC}"
    
    # Aggiungi traduzioni comuni mancanti
    case $filename in
        "patient"|"doctor")
            # Aggiungi traduzioni per enum se mancanti
            if ! grep -q "'enum'" "$file"; then
                echo -e "${BLUE}➕ Aggiungendo traduzioni enum per $filename${NC}"
                # Aggiungi dopo la sezione fields
                sed -i "/'fields' => \[/a\\
  'enum' => \[\\
    'gender' => \[\\
      'male' => 'Maschio',\\
      'female' => 'Femmina',\\
      'other' => 'Altro',\\
    \],\\
  \]," "$file"
            fi
            
            # Aggiungi traduzioni per validazione se mancanti
            if ! grep -q "'validation'" "$file"; then
                echo -e "${BLUE}➕ Aggiungendo traduzioni validazione per $filename${NC}"
                # Aggiungi alla fine prima della chiusura
                sed -i "/^);$/i\\
  'validation' => \[\\
    'required' => 'Il campo :attribute è obbligatorio',\\
    'email' => 'Il campo :attribute deve essere un indirizzo email valido',\\
    'unique' => 'Il valore del campo :attribute è già stato utilizzato',\\
    'min' => \[\\
      'string' => 'Il campo :attribute deve contenere almeno :min caratteri',\\
    \],\\
    'max' => \[\\
      'string' => 'Il campo :attribute non può superare :max caratteri',\\
    \],\\
  \]," "$file"
            fi
            ;;
    esac
}

# Funzione per rimuovere traduzioni duplicate
remove_duplicates() {
    local file="$1"
    local filename=$(basename "$file")
    
    echo -e "${YELLOW}🧹 Rimuovendo duplicati da: $filename${NC}"
    
    # Rimuovi campi duplicati (es. applyFilters vs apply_filters)
    if grep -q "'applyFilters'" "$file" && grep -q "'apply_filters'" "$file"; then
        echo -e "${BLUE}🗑️ Rimuovendo campo duplicato applyFilters${NC}"
        # Rimuovi la sezione applyFilters
        sed -i "/'applyFilters' => \[/,/^\s*\],$/d" "$file"
    fi
    
    if grep -q "'toggleColumns'" "$file" && grep -q "'toggle_columns'" "$file"; then
        echo -e "${BLUE}🗑️ Rimuovendo campo duplicato toggleColumns${NC}"
        sed -i "/'toggleColumns' => \[/,/^\s*\],$/d" "$file"
    fi
    
    if grep -q "'reorderRecords'" "$file" && grep -q "'reorder_records'" "$file"; then
        echo -e "${BLUE}🗑️ Rimuovendo campo duplicato reorderRecords${NC}"
        sed -i "/'reorderRecords' => \[/,/^\s*\],$/d" "$file"
    fi
    
    if grep -q "'resetFilters'" "$file" && grep -q "'reset_filters'" "$file"; then
        echo -e "${BLUE}🗑️ Rimuovendo campo duplicato resetFilters${NC}"
        sed -i "/'resetFilters' => \[/,/^\s*\],$/d" "$file"
    fi
    
    if grep -q "'openFilters'" "$file" && grep -q "'open_filters'" "$file"; then
        echo -e "${BLUE}🗑️ Rimuovendo campo duplicato openFilters${NC}"
        sed -i "/'openFilters' => \[/,/^\s*\],$/d" "$file"
    fi
}

# Funzione per migliorare helper_text
improve_helper_text() {
    local file="$1"
    local filename=$(basename "$file")
    
    echo -e "${YELLOW}📝 Migliorando helper_text per: $filename${NC}"
    
    # Sostituisci helper_text identici a placeholder con stringhe vuote
    sed -i "s/'helper_text' => 'Inserisci nome e cognome completi'/'helper_text' => ''/g" "$file"
    sed -i "s/'helper_text' => 'email@esempio.com'/'helper_text' => ''/g" "$file"
    sed -i "s/'helper_text' => '+39 123 456 7890'/'helper_text' => ''/g" "$file"
    sed -i "s/'helper_text' => 'RSSMRA80A01H501Z'/'helper_text' => ''/g" "$file"
    sed -i "s/'helper_text' => 'Seleziona la data'/'helper_text' => ''/g" "$file"
    sed -i "s/'helper_text' => 'Seleziona il sesso'/'helper_text' => ''/g" "$file"
    sed -i "s/'helper_text' => 'Via Roma, 123'/'helper_text' => ''/g" "$file"
    sed -i "s/'helper_text' => 'Milano'/'helper_text' => ''/g" "$file"
    sed -i "s/'helper_text' => '20100'/'helper_text' => ''/g" "$file"
    sed -i "s/'helper_text' => 'Nome del contatto di emergenza'/'helper_text' => ''/g" "$file"
    sed -i "s/'helper_text' => 'Elenco delle allergie note'/'helper_text' => ''/g" "$file"
    sed -i "s/'helper_text' => 'Farmaci attualmente assunti'/'helper_text' => ''/g" "$file"
    sed -i "s/'helper_text' => 'Note sulla storia clinica'/'helper_text' => ''/g" "$file"
    sed -i "s/'helper_text' => 'Inserisci il numero di iscrizione'/'helper_text' => ''/g" "$file"
    sed -i "s/'helper_text' => 'Seleziona la specializzazione'/'helper_text' => ''/g" "$file"
}

# Funzione per aggiungere traduzioni per notifiche
add_notification_translations() {
    local file="$1"
    local filename=$(basename "$file" .php)
    
    echo -e "${YELLOW}🔔 Aggiungendo traduzioni notifiche per: $filename${NC}"
    
    # Aggiungi sezione notifiche se mancante
    if ! grep -q "'notifications'" "$file"; then
        echo -e "${BLUE}➕ Aggiungendo sezione notifiche per $filename${NC}"
        # Aggiungi prima della chiusura
        sed -i "/^);$/i\\
  'notifications' => \[\\
    'created' => '$filename creato con successo',\\
    'updated' => '$filename aggiornato con successo',\\
    'deleted' => '$filename eliminato con successo',\\
    'error' => 'Si è verificato un errore durante l\'operazione',\\
  \]," "$file"
    fi
}

# Processa tutti i file di traduzione
for file in "$<nome progetto>_LANG_DIR"/*.php; do
    if [ -f "$file" ]; then
        echo -e "${BLUE}📁 Processando: $(basename "$file")${NC}"
        
        # Migliora la sintassi
        improve_translation_file "$file"
        
        # Rimuovi duplicati
        remove_duplicates "$file"
        
        # Migliora helper_text
        improve_helper_text "$file"
        
        # Aggiungi traduzioni mancanti
        add_missing_translations "$file"
        
        # Aggiungi traduzioni notifiche
        add_notification_translations "$file"
        
        echo -e "${GREEN}✅ Completato: $(basename "$file")${NC}"
        echo "---"
    fi
done

# Crea file di traduzioni comuni se non esistono
create_common_translations() {
    echo -e "${YELLOW}📝 Creando traduzioni comuni...${NC}"
    
    # File per traduzioni comuni
    local common_file="$<nome progetto>_LANG_DIR/common.php"
    
    if [ ! -f "$common_file" ]; then
        cat > "$common_file" << 'EOF'
<?php

declare(strict_types=1);

return [
    'actions' => [
        'create' => 'Crea',
        'edit' => 'Modifica',
        'delete' => 'Elimina',
        'save' => 'Salva',
        'cancel' => 'Annulla',
        'back' => 'Indietro',
        'close' => 'Chiudi',
        'confirm' => 'Conferma',
        'yes' => 'Sì',
        'no' => 'No',
        'search' => 'Cerca',
        'filter' => 'Filtra',
        'export' => 'Esporta',
        'import' => 'Importa',
        'refresh' => 'Aggiorna',
        'download' => 'Scarica',
        'upload' => 'Carica',
    ],
    'messages' => [
        'success' => 'Operazione completata con successo',
        'error' => 'Si è verificato un errore',
        'warning' => 'Attenzione',
        'info' => 'Informazione',
        'confirm_delete' => 'Sei sicuro di voler eliminare questo elemento?',
        'no_records' => 'Nessun record trovato',
        'loading' => 'Caricamento...',
        'saving' => 'Salvataggio...',
        'deleting' => 'Eliminazione...',
    ],
    'validation' => [
        'required' => 'Il campo :attribute è obbligatorio',
        'email' => 'Il campo :attribute deve essere un indirizzo email valido',
        'unique' => 'Il valore del campo :attribute è già stato utilizzato',
        'min' => [
            'string' => 'Il campo :attribute deve contenere almeno :min caratteri',
            'numeric' => 'Il campo :attribute deve essere almeno :min',
        ],
        'max' => [
            'string' => 'Il campo :attribute non può superare :max caratteri',
            'numeric' => 'Il campo :attribute non può superare :max',
        ],
        'date' => 'Il campo :attribute non è una data valida',
        'date_format' => 'Il campo :attribute non corrisponde al formato :format',
        'numeric' => 'Il campo :attribute deve essere un numero',
        'string' => 'Il campo :attribute deve essere una stringa',
    ],
    'filters' => [
        'all' => 'Tutti',
        'active' => 'Attivi',
        'inactive' => 'Inattivi',
        'today' => 'Oggi',
        'yesterday' => 'Ieri',
        'this_week' => 'Questa settimana',
        'this_month' => 'Questo mese',
        'this_year' => 'Questo anno',
    ],
    'pagination' => [
        'previous' => 'Precedente',
        'next' => 'Successivo',
        'showing' => 'Mostrando',
        'to' => 'a',
        'of' => 'di',
        'results' => 'risultati',
        'per_page' => 'per pagina',
    ],
];
EOF
        echo -e "${GREEN}✅ Creato: common.php${NC}"
    fi
}

create_common_translations

echo -e "${GREEN}🎉 Miglioramento traduzioni <nome progetto> completato!${NC}"
echo -e "${YELLOW}📋 Prossimi passi:${NC}"
echo -e "  1. Verifica che tutti i file siano stati migliorati correttamente"
echo -e "  2. Controlla che non ci siano errori di sintassi"
echo -e "  3. Testa l'applicazione per verificare che le traduzioni funzionino"
echo -e "  4. Aggiorna la documentazione se necessario" 