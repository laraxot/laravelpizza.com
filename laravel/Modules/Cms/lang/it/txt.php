<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'title' => 
    array (
      'label' => 'Titolo',
      'placeholder' => 'Inserisci il titolo principale',
      'help' => 'Titolo principale',
      'helper_text' => 'Titolo che apparirà come intestazione principale',
      'tooltip' => '',
      'description' => '',
    ),
    'slug' => 
    array (
      'label' => 'Slug',
      'placeholder' => 'testo-per-url',
      'help' => 'Versione dell\'URL del titolo (solo lettere minuscole, trattini e numeri]',
      'helper_text' => 'URL SEO-friendly generato automaticamente dal titolo',
      'tooltip' => '',
      'description' => '',
    ),
    'subtitle' => 
    array (
      'label' => 'Sottotitolo',
      'placeholder' => 'Inserisci un sottotitolo',
      'help' => 'Sottotitolo opzionale',
      'helper_text' => 'Testo secondario che accompagna il titolo principale',
      'tooltip' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Descrizione',
      'placeholder' => 'Inserisci una descrizione',
      'help' => 'Testo descrittivo',
      'helper_text' => 'Descrizione utilizzata per SEO e preview social',
      'tooltip' => '',
      'description' => '',
    ),
    'content' => 
    array (
      'label' => 'Contenuto',
      'placeholder' => 'Scrivi il contenuto principale qui...',
      'helper_text' => 'Contenuto principale dell\'articolo o pagina',
      'tooltip' => '',
      'description' => '',
    ),
    'text' => 
    array (
      'label' => 'Testo',
      'placeholder' => 'Inserisci il testo',
      'helper_text' => 'Contenuto testuale semplice senza formattazione',
      'tooltip' => '',
      'description' => '',
    ),
    'image' => 
    array (
      'label' => 'Immagine',
      'help' => 'Carica un\'immagine',
      'placeholder' => 'Seleziona o carica immagine',
      'helper_text' => 'Immagine principale associata al contenuto',
      'tooltip' => '',
      'description' => '',
    ),
    'alt' => 
    array (
      'label' => 'Testo Alternativo',
      'placeholder' => 'Descrizione immagine per accessibilità',
      'helper_text' => 'Testo letto dagli screen reader per utenti non vedenti',
      'tooltip' => '',
      'description' => '',
    ),
    'width' => 
    array (
      'label' => 'Larghezza',
      'placeholder' => '100%, 500px, auto',
      'helper_text' => 'Larghezza dell\'elemento in pixel, percentuale o auto',
      'tooltip' => '',
      'description' => '',
    ),
    'height' => 
    array (
      'label' => 'Altezza',
      'placeholder' => '300px, auto, 50vh',
      'helper_text' => 'Altezza dell\'elemento in pixel, percentuale o viewport',
      'tooltip' => '',
      'description' => '',
    ),
    'style' => 
    array (
      'label' => 'Stile',
      'help' => 'Stile di visualizzazione',
      'placeholder' => 'Seleziona stile di visualizzazione',
      'helper_text' => 'Stile predefinito per la visualizzazione dell\'elemento',
      'tooltip' => '',
      'description' => '',
    ),
    'size' => 
    array (
      'label' => 'Dimensione',
      'placeholder' => 'Piccolo, Medio, Grande',
      'helper_text' => 'Dimensione relativa dell\'elemento',
      'tooltip' => '',
      'description' => '',
    ),
    'alignment' => 
    array (
      'label' => 'Allineamento',
      'help' => 'Allineamento del testo',
      'options' => 
      array (
        'left' => 'Sinistra',
        'center' => 'Centro',
        'right' => 'Destra',
        'justify' => 'Giustificato',
      ),
      'placeholder' => 'Sinistra, Centro, Destra',
      'helper_text' => 'Allineamento del contenuto all\'interno dell\'elemento',
      'tooltip' => '',
      'description' => '',
    ),
    'gap' => 
    array (
      'label' => 'Spaziatura',
      'placeholder' => '10px, 1rem, small',
      'helper_text' => 'Spazio tra gli elementi',
      'tooltip' => '',
      'description' => '',
    ),
    'orientation' => 
    array (
      'label' => 'Orientamento',
      'placeholder' => 'Orizzontale, Verticale',
      'helper_text' => 'Orientamento del layout o degli elementi',
      'tooltip' => '',
      'description' => '',
    ),
    'background_color' => 
    array (
      'label' => 'Colore di sfondo',
      'help' => 'Seleziona un colore di sfondo',
      'placeholder' => '#FFFFFF, bianco, transparent',
      'helper_text' => 'Colore di sfondo dell\'elemento',
      'tooltip' => '',
      'description' => '',
    ),
    'text_color' => 
    array (
      'label' => 'Colore Testo',
      'placeholder' => '#000000, nero, inherit',
      'helper_text' => 'Colore del testo dell\'elemento',
      'tooltip' => '',
      'description' => '',
    ),
    'cta_color' => 
    array (
      'label' => 'Colore CTA',
      'placeholder' => '#007BFF, blu, primary',
      'helper_text' => 'Colore dei pulsanti call-to-action',
      'tooltip' => '',
      'description' => '',
    ),
    'items' => 
    array (
      'label' => 'Elementi',
      'help' => 'Elenco di elementi',
      'placeholder' => 'Aggiungi elementi alla lista',
      'helper_text' => 'Lista di elementi che compongono menu o collezioni',
      'tooltip' => '',
      'description' => '',
    ),
    'label' => 
    array (
      'label' => 'Etichetta',
      'placeholder' => 'Testo dell\'etichetta',
      'helper_text' => 'Testo visibile per link, pulsanti o elementi interattivi',
      'tooltip' => '',
      'description' => '',
    ),
    'url' => 
    array (
      'label' => 'URL',
      'placeholder' => 'https://esempio.com',
      'help' => 'Inserisci un URL valido (inizia con http:// o https://]',
      'helper_text' => 'Indirizzo web completo di destinazione',
      'tooltip' => '',
      'description' => '',
    ),
    'target' => 
    array (
      'label' => 'Destinazione',
      'placeholder' => '_blank, _self, _parent, _top',
      'helper_text' => 'Come aprire il collegamento (stessa finestra o nuova]',
      'tooltip' => '',
      'description' => '',
    ),
    'icon' => 
    array (
      'label' => 'Icona',
      'help' => 'Seleziona un\'icona da visualizzare',
      'placeholder' => 'Seleziona icona rappresentativa',
      'helper_text' => 'Icona da mostrare accanto al testo o come elemento standalone',
      'tooltip' => '',
      'description' => '',
    ),
    'view' => 
    array (
      'label' => 'Template',
      'placeholder' => 'Seleziona template di visualizzazione',
      'helper_text' => 'Template Blade utilizzato per renderizzare questo elemento',
      'tooltip' => '',
      'description' => '',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
      'placeholder' => 'Categoria o tipologia',
      'helper_text' => 'Tipo di contenuto o categoria dell\'elemento',
      'tooltip' => '',
      'description' => '',
    ),
    'level' => 
    array (
      'label' => 'Livello',
      'placeholder' => 'Livello gerarchico (1-6]',
      'helper_text' => 'Livello di importanza nella gerarchia del contenuto',
      'tooltip' => '',
      'description' => '',
    ),
    'children' => 
    array (
      'label' => 'Elementi Figli',
      'placeholder' => 'Elementi nested o subordinati',
      'helper_text' => 'Elementi contenuti o dipendenti da questo elemento',
      'tooltip' => '',
      'description' => '',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'esempio@dominio.com',
      'help' => 'Indirizzo email valido',
      'helper_text' => 'Indirizzo email principale per contatti',
      'tooltip' => '',
      'description' => '',
    ),
    'phone' => 
    array (
      'label' => 'Telefono',
      'placeholder' => '+39 000 000 0000',
      'helper_text' => 'Numero di telefono principale',
      'tooltip' => '',
      'description' => '',
    ),
    'address' => 
    array (
      'label' => 'Indirizzo',
      'placeholder' => 'Via Roma 1, 00100 Roma RM',
      'help' => 'Indirizzo completo',
      'helper_text' => 'Indirizzo fisico completo dell\'azienda',
      'tooltip' => '',
      'description' => '',
    ),
    'map_url' => 
    array (
      'label' => 'Link Mappa',
      'placeholder' => 'https://maps.google.com/...',
      'helper_text' => 'Link a Google Maps o altro servizio di mappe',
      'tooltip' => '',
      'description' => '',
    ),
    'logo' => 
    array (
      'label' => 'Logo',
      'placeholder' => 'Carica logo aziendale',
      'helper_text' => 'Logo rappresentativo dell\'azienda o brand',
      'tooltip' => '',
      'description' => '',
    ),
    'copyright' => 
    array (
      'label' => 'Copyright',
      'placeholder' => '2024 Nome Azienda. Tutti i diritti riservati.',
      'helper_text' => 'Testo di copyright da visualizzare nel footer',
      'tooltip' => '',
      'description' => '',
    ),
    'button_text' => 
    array (
      'label' => 'Testo del pulsante',
      'placeholder' => 'Scopri di più',
      'help' => 'Testo visualizzato sul pulsante',
      'helper_text' => 'Testo che apparirà sul pulsante',
      'tooltip' => '',
      'description' => '',
    ),
    'button_link' => 
    array (
      'label' => 'Collegamento del pulsante',
      'placeholder' => 'https://esempio.com',
      'help' => 'URL di destinazione del pulsante',
      'helper_text' => 'URL di destinazione quando si clicca il pulsante',
      'tooltip' => '',
      'description' => '',
    ),
    'cta_text' => 
    array (
      'label' => 'Testo Call-to-Action',
      'placeholder' => 'Inizia ora, Contattaci oggi',
      'helper_text' => 'Testo persuasivo per invitare all\'azione',
      'tooltip' => '',
      'description' => '',
    ),
    'cta_link' => 
    array (
      'label' => 'Collegamento CTA',
      'placeholder' => 'https://esempio.com',
      'help' => 'URL di destinazione per la call-to-action',
      'helper_text' => 'URL della pagina di destinazione per la CTA',
      'tooltip' => '',
      'description' => '',
    ),
    'social_links' => 
    array (
      'label' => 'Link Social',
      'placeholder' => 'Aggiungi profili social media',
      'helper_text' => 'Collegamenti ai profili social dell\'azienda',
      'tooltip' => '',
      'description' => '',
    ),
    'platform' => 
    array (
      'label' => 'Piattaforma',
      'placeholder' => 'Facebook, Instagram, LinkedIn, Twitter',
      'helper_text' => 'Nome della piattaforma social media',
      'tooltip' => '',
      'description' => '',
    ),
    'links' => 
    array (
      'label' => 'Collegamenti',
      'placeholder' => 'Lista di link di navigazione',
      'helper_text' => 'Collezione di collegamenti per menu o footer',
      'tooltip' => '',
      'description' => '',
    ),
    'stats' => 
    array (
      'label' => 'Statistiche',
      'placeholder' => 'Dati numerici da evidenziare',
      'helper_text' => 'Statistiche o metriche da mostrare',
      'tooltip' => '',
      'description' => '',
    ),
    'number' => 
    array (
      'label' => 'Numero',
      'placeholder' => 'Valore numerico',
      'helper_text' => 'Valore numerico per contatori o statistiche',
      'tooltip' => '',
      'description' => '',
    ),
    'sections' => 
    array (
      'label' => 'Sezioni',
      'help' => 'Elenco delle sezioni',
      'placeholder' => 'Sezioni che compongono la pagina',
      'helper_text' => 'Sezioni principali che strutturano il contenuto',
      'tooltip' => '',
      'description' => '',
    ),
    'content_blocks' => 
    array (
      'label' => 'Blocchi Contenuto',
      'placeholder' => 'Blocchi di contenuto principale',
      'helper_text' => 'Blocchi che compongono il corpo principale della pagina',
      'tooltip' => '',
      'description' => '',
    ),
    'sidebar_blocks' => 
    array (
      'label' => 'Blocchi Sidebar',
      'placeholder' => 'Contenuti della barra laterale',
      'helper_text' => 'Elementi da visualizzare nella barra laterale',
      'tooltip' => '',
      'description' => '',
    ),
    'footer_blocks' => 
    array (
      'label' => 'Blocchi Footer',
      'placeholder' => 'Contenuti del piè di pagina',
      'helper_text' => 'Elementi da includere nel footer del sito',
      'tooltip' => '',
      'description' => '',
    ),
    'placeholder' => 
    array (
      'label' => 'Placeholder',
      'placeholder' => 'Testo segnaposto per campi input',
      'helper_text' => 'Testo mostrato nei campi vuoti come suggerimento',
      'tooltip' => '',
      'description' => '',
    ),
    'success_message' => 
    array (
      'label' => 'Messaggio Successo',
      'placeholder' => 'Operazione completata con successo',
      'helper_text' => 'Messaggio mostrato quando un\'operazione ha successo',
      'tooltip' => '',
      'description' => '',
    ),
    'error_message' => 
    array (
      'label' => 'Messaggio Errore',
      'placeholder' => 'Si è verificato un errore',
      'helper_text' => 'Messaggio mostrato in caso di errore',
      'tooltip' => '',
      'description' => '',
    ),
    'background' => 
    array (
      'label' => 'Sfondo',
      'placeholder' => 'Immagine o colore di sfondo',
      'helper_text' => 'Sfondo della sezione (immagine, colore o gradiente]',
      'tooltip' => '',
      'description' => '',
    ),
    'buttons' => 
    array (
      'label' => 'Pulsanti',
      'placeholder' => 'Pulsanti di azione per l\'utente',
      'helper_text' => 'Collezione di pulsanti per interazioni utente',
      'tooltip' => '',
      'description' => '',
    ),
    'class' => 
    array (
      'label' => 'Classe CSS',
      'placeholder' => 'custom-class another-class',
      'helper_text' => 'Classi CSS personalizzate per styling avanzato',
      'tooltip' => '',
      'description' => '',
    ),
    'link' => 
    array (
      'label' => 'Collegamento',
      'placeholder' => 'https://link-destinazione.it',
      'helper_text' => 'URL generico di collegamento',
      'tooltip' => '',
      'description' => '',
    ),
    'ratio' => 
    array (
      'label' => 'Proporzioni',
      'placeholder' => '16:9, 4:3, 1:1, 21:9',
      'helper_text' => 'Rapporto di proporzione per immagini e video',
      'tooltip' => '',
      'description' => '',
    ),
    'caption' => 
    array (
      'label' => 'Didascalia',
      'placeholder' => 'Didascalia per immagine o video',
      'helper_text' => 'Testo descrittivo mostrato sotto contenuti multimediali',
      'tooltip' => '',
      'description' => '',
    ),
    'img_uuid' => 
    array (
      'label' => 'ID Immagine',
      'placeholder' => 'UUID dell\'immagine',
      'helper_text' => 'Identificatore univoco dell\'immagine nel sistema',
      'tooltip' => '',
      'description' => '',
    ),
    'gallery' => 
    array (
      'label' => 'Galleria',
      'placeholder' => 'Collezione di immagini',
      'helper_text' => 'Galleria di immagini correlate',
      'tooltip' => '',
      'description' => '',
    ),
    'version' => 
    array (
      'label' => 'Versione',
      'placeholder' => '1.0.0, v2.1, beta',
      'helper_text' => 'Versione del contenuto o componente',
      'tooltip' => '',
      'description' => '',
    ),
    'method' => 
    array (
      'label' => 'Metodo',
      'placeholder' => 'GET, POST, PUT, DELETE',
      'helper_text' => 'Metodo HTTP per form o richieste API',
      'tooltip' => '',
      'description' => '',
    ),
    'video' => 
    array (
      'label' => 'Video',
      'placeholder' => 'URL video YouTube/Vimeo o carica file',
      'helper_text' => 'Video da incorporare o collegare',
      'tooltip' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'save' => 
    array (
      'label' => 'Salva',
      'success' => 'Contenuto salvato con successo',
      'error' => 'Errore durante il salvataggio del contenuto',
      'confirmation' => 'Vuoi salvare le modifiche apportate?',
    ),
    'cancel' => 
    array (
      'label' => 'Annulla',
      'confirmation' => 'Sei sicuro di voler annullare? Tutte le modifiche non salvate andranno perse.',
    ),
    'activeLocale' => 
    array (
      'label' => 'Lingua Attiva',
      'description' => 'Seleziona la lingua per la traduzione del contenuto',
      'help' => 'Modifica la lingua di editing per contenuti multilingua',
    ),
  ),
  'sections' => 
  array (
    'content' => 
    array (
      'label' => 'Contenuto',
      'description' => 'Gestione del contenuto principale',
    ),
    'media' => 
    array (
      'label' => 'Media',
      'description' => 'Immagini, video e contenuti multimediali',
    ),
    'design' => 
    array (
      'label' => 'Design',
      'description' => 'Aspetto visivo e layout',
    ),
    'navigation' => 
    array (
      'label' => 'Navigazione',
      'description' => 'Menu, link e struttura di navigazione',
    ),
    'company' => 
    array (
      'label' => 'Azienda',
      'description' => 'Informazioni aziendali e contatti',
    ),
    'social' => 
    array (
      'label' => 'Social Media',
      'description' => 'Profili e collegamenti social',
    ),
    'cta' => 
    array (
      'label' => 'Call-to-Action',
      'description' => 'Pulsanti e inviti all\'azione',
    ),
    'structure' => 
    array (
      'label' => 'Struttura',
      'description' => 'Layout e organizzazione della pagina',
    ),
    'advanced' => 
    array (
      'label' => 'Avanzato',
      'description' => 'Impostazioni tecniche e personalizzazioni',
    ),
  ),
  'messages' => 
  array (
    'content_saved' => 'Contenuto salvato con successo',
    'save_error' => 'Si è verificato un errore durante il salvataggio',
    'validation_failed' => 'Alcuni campi contengono errori. Controlla e riprova.',
    'unsaved_changes' => 'Hai modifiche non salvate',
    'confirm_navigation' => 'Vuoi davvero lasciare questa pagina? Le modifiche non salvate andranno perse.',
    'loading_content' => 'Caricamento contenuto in corso...',
    'processing_save' => 'Salvataggio in corso...',
    'image_upload_success' => 'Immagine caricata con successo',
    'image_upload_error' => 'Errore durante il caricamento dell\'immagine',
    'video_upload_success' => 'Video caricato con successo',
    'video_upload_error' => 'Errore durante il caricamento del video',
  ),
  'validation' => 
  array (
    'title_required' => 'Il titolo è obbligatorio',
    'slug_unique' => 'Questo slug è già in uso',
    'email_format' => 'Inserisci un indirizzo email valido',
    'url_format' => 'Inserisci un URL valido',
    'phone_format' => 'Inserisci un numero di telefono valido',
    'image_size' => 'L\'immagine deve essere inferiore a 5MB',
    'video_format' => 'Formato video non supportato',
    'required_field' => 'Questo campo è obbligatorio',
    'max_length' => 'Il testo è troppo lungo (massimo :max caratteri]',
    'min_length' => 'Il testo è troppo corto (minimo :min caratteri]',
  ),
  'label' => 'Txt',
  'plural_label' => 'Txt (Plurale)',
  'navigation' => 
  array (
    'name' => 'Txt',
    'plural' => 'Txt',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Txt',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
);
