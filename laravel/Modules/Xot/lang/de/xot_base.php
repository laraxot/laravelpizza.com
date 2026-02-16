<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'view' => 
    array (
      'label' => 'Visualizza',
      'description' => 'Visualizza dettagli elemento',
      'placeholder' => 'Clicca per visualizzare',
      'help' => 'Visualizza i dettagli completi dell\'elemento selezionato',
      'tooltip' => '',
      'helper_text' => '',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'description' => 'Elimina elemento',
      'placeholder' => 'Clicca per eliminare',
      'help' => 'Elimina definitivamente l\'elemento selezionato',
      'tooltip' => '',
      'helper_text' => '',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
      'description' => 'Modifica elemento',
      'placeholder' => 'Clicca per modificare',
      'help' => 'Modifica i dati dell\'elemento selezionato',
      'tooltip' => '',
      'helper_text' => '',
    ),
    'detach' => 
    array (
      'label' => 'Scollega',
      'description' => 'Scollega elemento',
      'placeholder' => 'Clicca per scollegare',
      'help' => 'Rimuovi la connessione con l\'elemento selezionato',
      'tooltip' => '',
      'helper_text' => '',
    ),
    'attach' => 
    array (
      'label' => 'Collega',
      'description' => 'Collega elemento',
      'placeholder' => 'Clicca per collegare',
      'help' => 'Crea una connessione con l\'elemento selezionato',
      'tooltip' => '',
      'helper_text' => '',
    ),
    'pregnancy_certificate' => 
    array (
      'label' => 'Certificato di Gravidanza',
      'description' => 'Documento attestante lo stato di gravidanza',
      'placeholder' => 'Carica certificato di gravidanza',
      'help' => 'Carica il certificato medico che attesta lo stato di gravidanza',
      'tooltip' => '',
      'helper_text' => '',
    ),
    'health_card' => 
    array (
      'label' => 'Tessera Sanitaria',
      'description' => 'Tessera sanitaria del Sistema Sanitario Nazionale',
      'placeholder' => 'Carica tessera sanitaria',
      'help' => 'Carica la foto fronte/retro della tessera sanitaria',
      'tooltip' => '',
      'helper_text' => '',
    ),
    'identity_document' => 
    array (
      'label' => 'Documento di Identità',
      'description' => 'Documento di identità valido (CI, Patente, Passaporto)',
      'placeholder' => 'Carica documento di identità',
      'help' => 'Carica un documento di identità valido e non scaduto',
      'tooltip' => '',
      'helper_text' => '',
    ),
    'isee_certificate' => 
    array (
      'label' => 'Certificazione ISEE',
      'description' => 'Indicatore della Situazione Economica Equivalente',
      'placeholder' => 'Carica certificazione ISEE',
      'help' => 'Carica la certificazione ISEE per eventuali agevolazioni economiche',
      'tooltip' => '',
      'helper_text' => '',
    ),
    'certifications' => 
    array (
      'label' => 'Certificazioni',
      'description' => 'Certificazioni e documenti aggiuntivi',
      'placeholder' => 'Carica certificazioni',
      'help' => 'Carica eventuali certificazioni mediche o documenti aggiuntivi richiesti',
      'tooltip' => '',
      'helper_text' => '',
    ),
    'certification' => 
    array (
      'label' => 'Certificato',
      'description' => 'Certificato medico o documentazione sanitaria',
      'placeholder' => 'Carica certificato',
      'help' => 'Tesserino sanitario o certificato di iscrizione all\'Ordine',
      'tooltip' => '',
      'helper_text' => '',
    ),
    'doctor_certificate' => 
    array (
      'label' => 'Certificato Medico',
      'description' => 'Certificato di abilitazione o iscrizione all\'Ordine',
      'placeholder' => 'Carica certificato medico',
      'help' => 'Tesserino sanitario o certificato di iscrizione all\'Ordine',
      'tooltip' => '',
      'helper_text' => '',
    ),
  ),
  'steps' => 
  array (
    'documents_step' => 
    array (
      'label' => 'Documenti',
      'description' => 'Caricamento documenti richiesti',
      'help' => 'Carica tutti i documenti necessari per procedere',
      'icon' => 'heroicon-o-document-arrow-up',
    ),
    'personal_data_step' => 
    array (
      'label' => 'Dati Personali',
      'description' => 'Inserimento dati anagrafici',
      'help' => 'Inserisci i tuoi dati personali e anagrafici',
      'icon' => 'heroicon-o-user',
    ),
    'privacy_step' => 
    array (
      'label' => 'Privacy e Consensi',
      'description' => 'Informativa privacy e consensi',
      'help' => 'Leggi l\'informativa sulla privacy e esprimi i tuoi consensi',
      'icon' => 'heroicon-o-shield-check',
    ),
    'previsit_step' => 
    array (
      'label' => 'Pre-Visita',
      'description' => 'Informazioni preliminari alla visita',
      'help' => 'Compila le informazioni preliminari richieste per la visita',
      'icon' => 'heroicon-o-clipboard-document-list',
    ),
    'search_step' => 
    array (
      'label' => 'Ricerca',
      'description' => 'Ricerca medico e specializzazione',
      'help' => 'Cerca il medico o la specializzazione di cui hai bisogno',
      'icon' => 'heroicon-o-magnifying-glass',
    ),
    'date_step' => 
    array (
      'label' => 'Selezione Data',
      'description' => 'Scelta della data dell\'appuntamento',
      'help' => 'Seleziona la data preferita per il tuo appuntamento',
      'icon' => 'heroicon-o-calendar-days',
    ),
    'time_step' => 
    array (
      'label' => 'Selezione Orario',
      'description' => 'Scelta dell\'orario dell\'appuntamento',
      'help' => 'Seleziona l\'orario disponibile per il tuo appuntamento',
      'icon' => 'heroicon-o-clock',
    ),
    'confirm_step' => 
    array (
      'label' => 'Conferma',
      'description' => 'Conferma finale dell\'appuntamento',
      'help' => 'Rivedi e conferma tutti i dettagli del tuo appuntamento',
      'icon' => 'heroicon-o-check-circle',
    ),
    'doctor_step' => 
    array (
      'label' => 'Selezione Medico',
      'description' => 'Scelta del medico specialista',
      'help' => 'Seleziona il medico specialista per la tua visita',
      'icon' => 'heroicon-o-user-circle',
    ),
    'studio_step' => 
    array (
      'label' => 'Studio',
      'description' => 'Scelta dello studio medico',
      'help' => 'Seleziona lo studio medico dove effettuare la visita',
      'icon' => 'heroicon-o-building-office-2',
    ),
    'test_step' => 
    array (
      'label' => 'Test e Esami',
      'description' => 'Selezione di test ed esami',
      'help' => 'Seleziona eventuali test o esami da effettuare',
      'icon' => 'heroicon-o-beaker',
    ),
    'personal_info_step' => 
    array (
      'label' => 'Informazioni Personali',
      'description' => 'Completamento informazioni personali',
      'help' => 'Completa le tue informazioni personali e di contatto',
      'icon' => 'heroicon-o-identification',
    ),
    'availability_step' => 
    array (
      'label' => 'Disponibilità',
      'description' => 'Verifica disponibilità orari',
      'help' => 'Controlla la disponibilità degli orari per il tuo appuntamento',
      'icon' => 'heroicon-o-calendar-days',
    ),
  ),
  'actions' => 
  array (
    'submit' => 
    array (
      'label' => 'Invia',
      'description' => 'Invia i dati inseriti',
      'tooltip' => 'Clicca per inviare i dati',
      'help' => 'Conferma e invia tutti i dati inseriti nel modulo',
      'success' => 'Dati inviati con successo',
      'error' => 'Errore durante l\'invio dei dati',
      'confirmation' => 'Sei sicuro di voler inviare i dati?',
    ),
    'save' => 
    array (
      'label' => 'Salva',
      'description' => 'Salva le modifiche',
      'tooltip' => 'Clicca per salvare',
      'help' => 'Salva tutte le modifiche apportate',
      'success' => 'Modifiche salvate con successo',
      'error' => 'Errore durante il salvataggio',
    ),
    'cancel' => 
    array (
      'label' => 'Annulla',
      'description' => 'Annulla l\'operazione',
      'tooltip' => 'Clicca per annullare',
      'help' => 'Annulla l\'operazione corrente senza salvare le modifiche',
    ),
    'back' => 
    array (
      'label' => 'Indietro',
      'description' => 'Torna al passaggio precedente',
      'tooltip' => 'Torna al passaggio precedente',
      'help' => 'Torna al passaggio precedente del wizard',
    ),
  ),
  'messages' => 
  array (
    'loading' => 
    array (
      'label' => 'Caricamento in corso...',
      'description' => 'Attendere il completamento dell\'operazione',
    ),
    'success' => 
    array (
      'label' => 'Operazione completata',
      'description' => 'L\'operazione è stata completata con successo',
    ),
    'error' => 
    array (
      'label' => 'Errore',
      'description' => 'Si è verificato un errore durante l\'operazione',
    ),
    'warning' => 
    array (
      'label' => 'Attenzione',
      'description' => 'Prestare attenzione alle informazioni seguenti',
    ),
    'info' => 
    array (
      'label' => 'Informazione',
      'description' => 'Informazioni aggiuntive importanti',
    ),
  ),
  'navigation' => 
  array (
    'home' => 
    array (
      'label' => 'Home',
      'description' => 'Pagina principale',
      'tooltip' => 'Torna alla pagina principale',
    ),
    'dashboard' => 
    array (
      'label' => 'Dashboard',
      'description' => 'Pannello di controllo principale',
      'tooltip' => 'Visualizza il pannello di controllo',
    ),
    'settings' => 
    array (
      'label' => 'Impostazioni',
      'description' => 'Configurazioni di sistema',
      'tooltip' => 'Accedi alle impostazioni',
    ),
    'profile' => 
    array (
      'label' => 'Profilo',
      'description' => 'Profilo utente',
      'tooltip' => 'Gestisci il tuo profilo',
    ),
    'logout' => 
    array (
      'label' => 'Esci',
      'description' => 'Disconnetti dall\'applicazione',
      'tooltip' => 'Esci dall\'applicazione',
    ),
  ),
  'validation' => 
  array (
    'required' => 
    array (
      'label' => 'Pflichtfeld',
      'description' => 'Dieses Feld ist erforderlich und muss ausgefüllt werden',
    ),
    'email' => 
    array (
      'label' => 'Ungültige E-Mail',
      'description' => 'Bitte geben Sie eine gültige E-Mail-Adresse ein',
    ),
    'numeric' => 
    array (
      'label' => 'Deve essere un numero',
      'description' => 'Questo campo deve contenere solo numeri',
    ),
    'date' => 
    array (
      'label' => 'Data non valida',
      'description' => 'Inserisci una data valida nel formato richiesto',
    ),
    'file' => 
    array (
      'label' => 'File non valido',
      'description' => 'Il file caricato non è valido o è troppo grande',
    ),
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
