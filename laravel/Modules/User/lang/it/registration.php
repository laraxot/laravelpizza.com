<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Registrazione',
    'group' => 'Gestione Utenti',
    'icon' => 'heroicon-o-user-plus',
    'sort' => 50,
  ),
  'pages' => 
  array (
    'registration' => 
    array (
      'title' => 'Registrazione Utente',
      'subtitle' => 'Completa la registrazione seguendo tutti i passaggi',
      'description' => 'Inserisci tutte le informazioni richieste per completare la tua registrazione',
    ),
    'wizard' => 
    array (
      'title' => 'Wizard di Registrazione',
      'subtitle' => 'Procedura guidata per la registrazione',
      'description' => 'Segui la procedura guidata per completare la registrazione',
    ),
  ),
  'steps' => 
  array (
    'personal_info' => 
    array (
      'label' => 'Dati Personali',
      'description' => 'Inserisci i tuoi dati anagrafici personali',
      'icon' => 'heroicon-o-user',
      'help' => 'Compila tutti i campi obbligatori con i tuoi dati personali',
    ),
    'contacts' => 
    array (
      'label' => 'Contatti',
      'description' => 'Inserisci i tuoi dati di contatto',
      'icon' => 'heroicon-o-phone',
      'help' => 'Fornisci i tuoi recapiti per essere contattato',
    ),
    'credentials' => 
    array (
      'label' => 'Credenziali',
      'description' => 'Imposta email e password per l\'accesso',
      'icon' => 'heroicon-o-key',
      'help' => 'Scegli una password sicura per proteggere il tuo account',
    ),
    'privacy_step' => 
    array (
      'label' => 'Privacy e Consensi',
      'description' => 'Accetta i termini e le condizioni',
      'icon' => 'heroicon-o-shield-check',
      'help' => 'Leggi attentamente e accetta i consensi richiesti',
    ),
    'documents_step' => 
    array (
      'label' => 'Documenti',
      'description' => 'Carica i documenti richiesti',
      'icon' => 'heroicon-o-document',
      'help' => 'Carica i documenti necessari per la verifica dell\'identità',
    ),
    'professional' => 
    array (
      'label' => 'Informazioni Professionali',
      'description' => 'Inserisci le tue informazioni professionali',
      'icon' => 'heroicon-o-briefcase',
      'help' => 'Completa il tuo profilo professionale con esperienze e competenze',
    ),
    'availability' => 
    array (
      'label' => 'Disponibilità',
      'description' => 'Definisci i tuoi orari di disponibilità',
      'icon' => 'heroicon-o-calendar',
      'help' => 'Imposta quando sei disponibile per appuntamenti o contatti',
    ),
    'moderation' => 
    array (
      'label' => 'Moderazione',
      'description' => 'Stato di moderazione del profilo',
      'icon' => 'heroicon-o-check-badge',
      'help' => 'Il tuo profilo sarà verificato dal nostro team',
    ),
    'personal_data_step' => 
    array (
      'label' => 'Informazioni Aggiuntive',
      'description' => 'Completa con altre informazioni personali',
      'icon' => 'heroicon-o-identification',
      'help' => 'Fornisci informazioni aggiuntive per completare il profilo',
    ),
    'pre_visit_step' => 
    array (
      'label' => 'Pre-Visita',
      'description' => 'Informazioni preliminari per la visita',
      'icon' => 'heroicon-o-clipboard-document-list',
      'help' => 'Compila le informazioni necessarie per la pre-visita',
    ),
  ),
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il tuo nome',
      'help' => 'Il tuo nome di battesimo',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'placeholder' => 'Inserisci il tuo cognome',
      'help' => 'Il tuo cognome di famiglia',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'Inserisci il tuo indirizzo email',
      'help' => 'Indirizzo email valido che utilizzerai per accedere',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password' => 
    array (
      'label' => 'Password',
      'placeholder' => 'Inserisci una password sicura',
      'help' => 'Minimo 8 caratteri con lettere, numeri e simboli',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_confirmation' => 
    array (
      'label' => 'Conferma Password',
      'placeholder' => 'Ripeti la password',
      'help' => 'Inserisci nuovamente la password per confermarla',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'phone' => 
    array (
      'label' => 'Telefono',
      'placeholder' => 'Inserisci il numero di telefono',
      'help' => 'Numero di telefono per essere contattato',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'address' => 
    array (
      'label' => 'Indirizzo',
      'placeholder' => 'Inserisci il tuo indirizzo completo',
      'help' => 'Via/Piazza e numero civico di residenza',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'city' => 
    array (
      'label' => 'Città',
      'placeholder' => 'Inserisci la città',
      'help' => 'Città di residenza o domicilio',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'state' => 
    array (
      'label' => 'Provincia/Stato',
      'placeholder' => 'Inserisci la provincia o stato',
      'help' => 'Provincia italiana o stato se estero',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'zip' => 
    array (
      'label' => 'CAP',
      'placeholder' => 'Inserisci il CAP',
      'help' => 'Codice di avviamento postale',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'country' => 
    array (
      'label' => 'Paese',
      'placeholder' => 'Seleziona il paese',
      'help' => 'Paese di residenza',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'fiscal_code' => 
    array (
      'label' => 'Codice Fiscale',
      'placeholder' => 'Inserisci il codice fiscale',
      'help' => 'Codice fiscale italiano (16 caratteri]',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'birth_date' => 
    array (
      'label' => 'Data di Nascita',
      'placeholder' => 'Seleziona la data di nascita',
      'help' => 'La tua data di nascita nel formato gg/mm/aaaa',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'birth_place' => 
    array (
      'label' => 'Luogo di Nascita',
      'placeholder' => 'Inserisci il luogo di nascita',
      'help' => 'Città e provincia di nascita',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'gender' => 
    array (
      'label' => 'Genere',
      'placeholder' => 'Seleziona il genere',
      'help' => 'Genere anagrafico',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'nationality' => 
    array (
      'label' => 'Nazionalità',
      'placeholder' => 'Inserisci la nazionalità',
      'help' => 'Nazionalità secondo il documento d\'identità',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'document_type' => 
    array (
      'label' => 'Tipo Documento',
      'placeholder' => 'Seleziona il tipo di documento',
      'help' => 'Carta d\'identità, patente, passaporto',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'document_number' => 
    array (
      'label' => 'Numero Documento',
      'placeholder' => 'Inserisci il numero del documento',
      'help' => 'Numero identificativo del documento',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'document_issue_date' => 
    array (
      'label' => 'Data Rilascio',
      'placeholder' => 'Seleziona la data di rilascio',
      'help' => 'Data in cui il documento è stato rilasciato',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'document_expiry_date' => 
    array (
      'label' => 'Data Scadenza',
      'placeholder' => 'Seleziona la data di scadenza',
      'help' => 'Data di scadenza del documento',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'document_issuing_authority' => 
    array (
      'label' => 'Autorità Rilascio',
      'placeholder' => 'Inserisci l\'autorità che ha rilasciato il documento',
      'help' => 'Comune, questura o altro ente che ha rilasciato il documento',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'document_file' => 
    array (
      'label' => 'File Documento',
      'placeholder' => 'Carica una scansione del documento',
      'help' => 'Scansione fronte/retro del documento in formato PDF o JPG',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'photo' => 
    array (
      'label' => 'Foto Profilo',
      'placeholder' => 'Carica una foto profilo',
      'help' => 'Foto recente per il profilo, formato quadrato consigliato',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'cv' => 
    array (
      'label' => 'Curriculum Vitae',
      'placeholder' => 'Carica il tuo CV',
      'help' => 'Curriculum vitae aggiornato in formato PDF',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'bio' => 
    array (
      'label' => 'Biografia',
      'placeholder' => 'Scrivi una breve biografia',
      'help' => 'Descrizione di te stesso e delle tue competenze',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'professional_title' => 
    array (
      'label' => 'Titolo Professionale',
      'placeholder' => 'Inserisci il tuo titolo professionale',
      'help' => 'La tua qualifica o posizione professionale principale',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'terms' => 
    array (
      'label' => 'Termini e Condizioni',
      'placeholder' => 'Accetta i termini e condizioni',
      'help' => 'Devi accettare i termini e condizioni per procedere',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'privacy' => 
    array (
      'label' => 'Informativa Privacy',
      'placeholder' => 'Accetta l\'informativa sulla privacy',
      'help' => 'Consenso obbligatorio al trattamento dei dati personali',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'marketing' => 
    array (
      'label' => 'Comunicazioni Marketing',
      'placeholder' => 'Accetta di ricevere comunicazioni promozionali',
      'help' => 'Consenso facoltativo per ricevere newsletter e promozioni',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'moderation_status' => 
    array (
      'label' => 'Stato Moderazione',
      'placeholder' => 'Stato attuale della moderazione',
      'help' => 'Lo stato di verifica del profilo da parte degli amministratori',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'moderation_notes' => 
    array (
      'label' => 'Note Moderazione',
      'placeholder' => 'Note del moderatore',
      'help' => 'Eventuali annotazioni del team di moderazione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'register' => 
    array (
      'label' => 'Registrati',
      'tooltip' => 'Completa la registrazione',
      'modal_heading' => 'Conferma Registrazione',
      'modal_description' => 'Confermi di voler completare la registrazione con i dati inseriti?',
      'success' => 'Registrazione completata con successo',
      'error' => 'Si è verificato un errore durante la registrazione',
    ),
    'previous' => 
    array (
      'label' => 'Precedente',
      'tooltip' => 'Torna al passaggio precedente',
    ),
    'next' => 
    array (
      'label' => 'Successivo',
      'tooltip' => 'Procedi al passaggio successivo',
    ),
    'save_draft' => 
    array (
      'label' => 'Salva Bozza',
      'tooltip' => 'Salva i dati inseriti come bozza',
      'success' => 'Bozza salvata con successo',
      'error' => 'Errore durante il salvataggio della bozza',
    ),
  ),
  'messages' => 
  array (
    'welcome' => 'Benvenuto nella procedura di registrazione',
    'step_completed' => 'Passaggio completato con successo',
    'all_steps_completed' => 'Tutti i passaggi sono stati completati',
    'validation_errors' => 'Controlla i campi evidenziati e correggi gli errori',
    'required_fields' => 'I campi contrassegnati con * sono obbligatori',
    'save_progress' => 'I tuoi progressi sono stati salvati automaticamente',
    'errors' => 
    array (
      'general' => 'Si è verificato un errore durante la registrazione',
      'email_exists' => 'Questo indirizzo email è già registrato',
      'validation' => 'Alcuni campi contengono errori, controllali e riprova',
    ),
    'success' => 
    array (
      'registration' => 'Registrazione completata con successo! Riceverai una email di conferma',
      'step' => 'Passaggio completato correttamente',
    ),
  ),
  'label' => 'Registration',
  'plural_label' => 'Registration (Plurale)',
);
