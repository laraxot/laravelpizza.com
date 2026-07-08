#!/bin/bash

# Script per riscrivere completamente i file di traduzione <nome progetto>
# Crea file puliti e corretti seguendo gli standard Laraxot

set -e

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

<nome progetto>_LANG_DIR="laravel/Modules/<nome progetto>/lang/it"

echo -e "${YELLOW}🔄 Riscrittura completa traduzioni <nome progetto>...${NC}"

# Funzione per creare il file patient.php
create_patient_file() {
    cat > "$<nome progetto>_LANG_DIR/patient.php" << 'EOF'
<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Pazienti',
        'group' => 'Gestione Utenti',
        'icon' => 'heroicon-o-users',
        'sort' => 20,
    ],
    'model' => [
        'label' => 'Paziente',
        'plural' => 'Pazienti',
    ],
    'pages' => [
        'index' => [
            'title' => 'Elenco Pazienti',
            'subtitle' => 'Gestisci i pazienti registrati nell\'app mobile',
        ],
        'create' => [
            'title' => 'Nuovo Paziente',
            'subtitle' => 'Registra un nuovo paziente',
        ],
        'edit' => [
            'title' => 'Modifica Paziente',
            'subtitle' => 'Modifica le informazioni del paziente',
        ],
        'view' => [
            'title' => 'Dettagli Paziente',
            'subtitle' => 'Visualizza le informazioni complete del paziente',
        ],
    ],
    'fields' => [
        'full_name' => [
            'label' => 'Nome e Cognome',
            'placeholder' => 'Inserisci nome e cognome completi',
            'helper_text' => 'Nome e cognome del paziente',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'email@esempio.com',
            'helper_text' => 'Indirizzo email per le comunicazioni',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => '+39 123 456 7890',
            'helper_text' => 'Numero di telefono principale',
        ],
        'fiscal_code' => [
            'label' => 'Codice Fiscale',
            'placeholder' => 'RSSMRA80A01H501Z',
            'helper_text' => 'Codice fiscale del paziente',
        ],
        'birth_date' => [
            'label' => 'Data di Nascita',
            'placeholder' => 'Seleziona la data',
            'helper_text' => 'Data di nascita del paziente',
        ],
        'gender' => [
            'label' => 'Sesso',
            'placeholder' => 'Seleziona il sesso',
            'helper_text' => 'Sesso del paziente',
            'options' => [
                'male' => 'Maschio',
                'female' => 'Femmina',
                'other' => 'Altro',
            ],
        ],
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Via Roma, 123',
            'helper_text' => 'Indirizzo di residenza',
        ],
        'city' => [
            'label' => 'Città',
            'placeholder' => 'Milano',
            'helper_text' => 'Città di residenza',
        ],
        'postal_code' => [
            'label' => 'CAP',
            'placeholder' => '20100',
            'helper_text' => 'Codice di avviamento postale',
        ],
        'emergency_contact_name' => [
            'label' => 'Contatto Emergenza - Nome',
            'placeholder' => 'Nome del contatto di emergenza',
            'helper_text' => 'Nome della persona da contattare in caso di emergenza',
        ],
        'emergency_contact_phone' => [
            'label' => 'Contatto Emergenza - Telefono',
            'placeholder' => '+39 123 456 7890',
            'helper_text' => 'Telefono del contatto di emergenza',
        ],
        'allergies' => [
            'label' => 'Allergie',
            'placeholder' => 'Elenco delle allergie note',
            'helper_text' => 'Allergie note del paziente',
        ],
        'medications' => [
            'label' => 'Farmaci',
            'placeholder' => 'Farmaci attualmente assunti',
            'helper_text' => 'Farmaci che il paziente sta assumendo',
        ],
        'medical_history' => [
            'label' => 'Storia Clinica',
            'placeholder' => 'Note sulla storia clinica',
            'helper_text' => 'Informazioni rilevanti sulla storia clinica',
        ],
        'is_active' => [
            'label' => 'Attivo',
            'helper_text' => 'Il paziente può prenotare visite',
        ],
        'device_token' => [
            'label' => 'Token Dispositivo',
            'helper_text' => 'Token per le notifiche push',
        ],
        'last_login' => [
            'label' => 'Ultimo Accesso',
            'helper_text' => 'Data e ora dell\'ultimo accesso all\'app',
        ],
        'reset_filters' => [
            'label' => 'Azzera Filtri',
        ],
        'apply_filters' => [
            'label' => 'Applica Filtri',
        ],
        'open_filters' => [
            'label' => 'Apri Filtri',
        ],
        'toggle_columns' => [
            'label' => 'Mostra/Nascondi Colonne',
        ],
        'reorder_records' => [
            'label' => 'Riordina Record',
        ],
    ],
    'actions' => [
        'view_medical_history' => [
            'label' => 'Storia Clinica',
            'icon' => 'heroicon-o-document-text',
            'tooltip' => 'Visualizza la storia clinica del paziente',
        ],
        'view_appointments' => [
            'label' => 'Appuntamenti',
            'icon' => 'heroicon-o-calendar-days',
            'tooltip' => 'Visualizza gli appuntamenti del paziente',
        ],
        'send_notification' => [
            'label' => 'Invia Notifica',
            'icon' => 'heroicon-o-bell',
            'tooltip' => 'Invia una notifica push al paziente',
        ],
        'deactivate' => [
            'label' => 'Disattiva',
            'icon' => 'heroicon-o-x-circle',
            'tooltip' => 'Disattiva temporaneamente il paziente',
        ],
        'add_medical_note' => [
            'label' => 'Aggiungi Nota',
            'icon' => 'heroicon-o-plus-circle',
            'tooltip' => 'Aggiungi una nota medica',
        ],
    ],
    'filters' => [
        'active' => [
            'label' => 'Solo Attivi',
        ],
        'gender' => [
            'label' => 'Per Sesso',
        ],
        'age_range' => [
            'label' => 'Fascia d\'Età',
        ],
        'city' => [
            'label' => 'Per Città',
        ],
    ],
    'bulk_actions' => [
        'send_notification_selected' => [
            'label' => 'Notifica Selezionati',
            'icon' => 'heroicon-o-bell',
        ],
        'export_selected' => [
            'label' => 'Esporta Selezionati',
            'icon' => 'heroicon-o-arrow-down-tray',
        ],
    ],
    'messages' => [
        'deactivated_successfully' => 'Paziente disattivato con successo',
        'notification_sent' => 'Notifica inviata con successo',
        'medical_note_added' => 'Nota medica aggiunta con successo',
        'export_completed' => 'Esportazione completata',
    ],
    'notifications' => [
        'created' => 'Paziente creato con successo',
        'updated' => 'Paziente aggiornato con successo',
        'deleted' => 'Paziente eliminato con successo',
        'error' => 'Si è verificato un errore durante l\'operazione',
    ],
    'validation' => [
        'required' => 'Il campo :attribute è obbligatorio',
        'email' => 'Il campo :attribute deve essere un indirizzo email valido',
        'unique' => 'Il valore del campo :attribute è già stato utilizzato',
        'min' => [
            'string' => 'Il campo :attribute deve contenere almeno :min caratteri',
        ],
        'max' => [
            'string' => 'Il campo :attribute non può superare :max caratteri',
        ],
    ],
    'search_placeholder' => 'Cerca per nome, email, telefono o codice fiscale...',
];
EOF
    echo -e "${GREEN}✅ Creato: patient.php${NC}"
}

# Funzione per creare il file doctor.php
create_doctor_file() {
    cat > "$<nome progetto>_LANG_DIR/doctor.php" << 'EOF'
<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Medici',
        'group' => 'Gestione Utenti',
        'icon' => 'heroicon-o-user-plus',
        'sort' => 10,
    ],
    'model' => [
        'label' => 'Medico',
        'plural' => 'Medici',
    ],
    'pages' => [
        'index' => [
            'title' => 'Elenco Medici',
            'subtitle' => 'Gestisci i medici registrati nell\'app mobile',
        ],
        'create' => [
            'title' => 'Nuovo Medico',
            'subtitle' => 'Registra un nuovo medico',
        ],
        'edit' => [
            'title' => 'Modifica Medico',
            'subtitle' => 'Modifica le informazioni del medico',
        ],
        'view' => [
            'title' => 'Dettagli Medico',
            'subtitle' => 'Visualizza le informazioni complete del medico',
        ],
    ],
    'fields' => [
        'full_name' => [
            'label' => 'Nome e Cognome',
            'placeholder' => 'Inserisci nome e cognome completi',
            'helper_text' => 'Nome e cognome come registrati nell\'Ordine dei Medici',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'email@esempio.com',
            'helper_text' => 'Indirizzo email per le comunicazioni',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => '+39 123 456 7890',
            'helper_text' => 'Numero di telefono principale',
        ],
        'mobile_phone' => [
            'label' => 'Cellulare',
            'placeholder' => '+39 123 456 7890',
            'helper_text' => 'Numero di cellulare per le notifiche push',
        ],
        'license_number' => [
            'label' => 'Numero Iscrizione Ordine',
            'placeholder' => 'Inserisci il numero di iscrizione',
            'helper_text' => 'Numero di iscrizione all\'Ordine dei Medici',
        ],
        'specialization' => [
            'label' => 'Specializzazione',
            'placeholder' => 'Seleziona la specializzazione',
            'helper_text' => 'Specializzazione medica principale',
        ],
        'clinic_address' => [
            'label' => 'Indirizzo Studio',
            'placeholder' => 'Via Roma, 123',
            'helper_text' => 'Indirizzo dello studio medico',
        ],
        'is_active' => [
            'label' => 'Attivo',
            'helper_text' => 'Il medico può ricevere prenotazioni',
        ],
        'verified_at' => [
            'label' => 'Data Verifica',
            'helper_text' => 'Data di verifica della documentazione',
        ],
        'device_token' => [
            'label' => 'Token Dispositivo',
            'helper_text' => 'Token per le notifiche push',
        ],
        'last_login' => [
            'label' => 'Ultimo Accesso',
            'helper_text' => 'Data e ora dell\'ultimo accesso all\'app',
        ],
        'reset_filters' => [
            'label' => 'Azzera Filtri',
        ],
        'apply_filters' => [
            'label' => 'Applica Filtri',
        ],
        'open_filters' => [
            'label' => 'Apri Filtri',
        ],
        'toggle_columns' => [
            'label' => 'Mostra/Nascondi Colonne',
        ],
        'reorder_records' => [
            'label' => 'Riordina Record',
        ],
    ],
    'actions' => [
        'verify' => [
            'label' => 'Verifica',
            'icon' => 'heroicon-o-check-circle',
            'tooltip' => 'Verifica la documentazione del medico',
        ],
        'deactivate' => [
            'label' => 'Disattiva',
            'icon' => 'heroicon-o-x-circle',
            'tooltip' => 'Disattiva temporaneamente il medico',
        ],
        'send_notification' => [
            'label' => 'Invia Notifica',
            'icon' => 'heroicon-o-bell',
            'tooltip' => 'Invia una notifica push al medico',
        ],
        'view_appointments' => [
            'label' => 'Vedi Appuntamenti',
            'icon' => 'heroicon-o-calendar-days',
            'tooltip' => 'Visualizza gli appuntamenti del medico',
        ],
    ],
    'filters' => [
        'active' => [
            'label' => 'Solo Attivi',
        ],
        'verified' => [
            'label' => 'Solo Verificati',
        ],
        'specialization' => [
            'label' => 'Per Specializzazione',
        ],
    ],
    'bulk_actions' => [
        'verify_selected' => [
            'label' => 'Verifica Selezionati',
            'icon' => 'heroicon-o-check-circle',
        ],
        'send_notification_selected' => [
            'label' => 'Notifica Selezionati',
            'icon' => 'heroicon-o-bell',
        ],
    ],
    'messages' => [
        'verified_successfully' => 'Medico verificato con successo',
        'deactivated_successfully' => 'Medico disattivato con successo',
        'notification_sent' => 'Notifica inviata con successo',
    ],
    'notifications' => [
        'created' => 'Medico creato con successo',
        'updated' => 'Medico aggiornato con successo',
        'deleted' => 'Medico eliminato con successo',
        'error' => 'Si è verificato un errore durante l\'operazione',
    ],
    'validation' => [
        'required' => 'Il campo :attribute è obbligatorio',
        'email' => 'Il campo :attribute deve essere un indirizzo email valido',
        'unique' => 'Il valore del campo :attribute è già stato utilizzato',
        'min' => [
            'string' => 'Il campo :attribute deve contenere almeno :min caratteri',
        ],
        'max' => [
            'string' => 'Il campo :attribute non può superare :max caratteri',
        ],
    ],
    'search_placeholder' => 'Cerca per nome, email, telefono o numero di iscrizione...',
];
EOF
    echo -e "${GREEN}✅ Creato: doctor.php${NC}"
}

# Funzione per creare il file common.php
create_common_file() {
    cat > "$<nome progetto>_LANG_DIR/common.php" << 'EOF'
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
}

# Crea backup della directory
echo -e "${YELLOW}📦 Creando backup della directory traduzioni...${NC}"
backup_dir="laravel/Modules/<nome progetto>/lang/it.backup.$(date +%Y%m%d_%H%M%S)"
cp -r "$<nome progetto>_LANG_DIR" "$backup_dir"
echo -e "${BLUE}📦 Backup creato: $backup_dir${NC}"

# Rimuovi tutti i file esistenti
echo -e "${YELLOW}🗑️ Rimuovendo file esistenti...${NC}"
rm -f "$<nome progetto>_LANG_DIR"/*.php

# Ricrea i file principali
create_patient_file
create_doctor_file
create_common_file

echo -e "${GREEN}🎉 Riscrittura traduzioni <nome progetto> completata!${NC}"
echo -e "${YELLOW}📋 File creati:${NC}"
echo -e "  ✅ patient.php - Traduzioni per i pazienti"
echo -e "  ✅ doctor.php - Traduzioni per i medici"
echo -e "  ✅ common.php - Traduzioni comuni"
echo -e "${YELLOW}📋 Prossimi passi:${NC}"
echo -e "  1. Verifica che i file siano sintatticamente corretti"
echo -e "  2. Aggiungi altri file di traduzione se necessario"
echo -e "  3. Testa le traduzioni nell'applicazione"
echo -e "  4. Aggiorna la documentazione" 