<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Meta Tag',
    'plural' => 'Meta Tags',
    'group' => 
    array (
      'name' => 'Sistema',
      'description' => 'Gestione dei meta tag e SEO del sito',
    ),
    'label' => 'metatag',
    'sort' => '16',
    'icon' => 'xot-metatag',
  ),
  'fields' => 
  array (
    'basic' => 
    array (
      'title' => 
      array (
        'label' => 'Titolo',
        'placeholder' => 'Inserisci il titolo della pagina',
        'help' => 'Meta title - massimo 60 caratteri',
      ),
      'description' => 
      array (
        'label' => 'Descrizione',
        'placeholder' => 'Inserisci la descrizione della pagina',
        'help' => 'Meta description - massimo 160 caratteri',
      ),
      'keywords' => 
      array (
        'label' => 'Parole chiave',
        'placeholder' => 'Inserisci le parole chiave separate da virgola',
        'help' => 'Meta keywords - massimo 10 parole chiave',
      ),
      'robots' => 
      array (
        'label' => 'Robots',
        'help' => 'Istruzioni per i motori di ricerca',
        'options' => 
        array (
          'index,follow' => 'Indicizza e segui i link',
          'noindex,follow' => 'Non indicizzare ma segui i link',
          'index,nofollow' => 'Indicizza ma non seguire i link',
          'noindex,nofollow' => 'Non indicizzare e non seguire i link',
        ),
      ),
      'canonical' => 
      array (
        'label' => 'URL Canonico',
        'placeholder' => 'Inserisci l\'URL canonico',
        'help' => 'URL canonico per evitare contenuti duplicati',
      ),
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
    ),
    'social' => 
    array (
      'og_title' => 
      array (
        'label' => 'Titolo Open Graph',
        'placeholder' => 'Inserisci il titolo per social',
        'help' => 'Titolo ottimizzato per la condivisione sui social',
      ),
      'og_description' => 
      array (
        'label' => 'Descrizione Open Graph',
        'placeholder' => 'Inserisci la descrizione per social',
        'help' => 'Descrizione ottimizzata per la condivisione sui social',
      ),
      'og_image' => 
      array (
        'label' => 'Immagine Open Graph',
        'placeholder' => 'Seleziona l\'immagine per social',
        'help' => 'Immagine ottimizzata per la condivisione (1200x630px)',
      ),
      'twitter_card' => 
      array (
        'label' => 'Twitter Card',
        'help' => 'Tipo di card per la condivisione su Twitter',
        'options' => 
        array (
          'summary' => 'Card riassuntiva',
          'summary_large_image' => 'Card con immagine grande',
          'app' => 'Card per applicazione',
          'player' => 'Card per contenuti multimediali',
        ),
      ),
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'site' => 
    array (
      'sitename' => 
      array (
        'label' => 'Nome Sito',
        'placeholder' => 'Inserisci il nome del sito',
        'help' => 'Nome principale del sito web',
      ),
      'subtitle' => 
      array (
        'label' => 'Sottotitolo',
        'placeholder' => 'Inserisci il sottotitolo del sito',
        'help' => 'Breve descrizione del sito',
      ),
      'author' => 
      array (
        'label' => 'Autore',
        'placeholder' => 'Inserisci l\'autore del sito',
        'help' => 'Nome dell\'autore o organizzazione',
      ),
      'copyright' => 
      array (
        'label' => 'Copyright',
        'placeholder' => 'Inserisci il copyright',
        'help' => 'Informazioni sul copyright del sito',
      ),
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'appearance' => 
    array (
      'logo_header' => 
      array (
        'label' => 'Logo Header',
        'help' => 'Logo principale del sito (SVG o PNG)',
      ),
      'logo_header_dark' => 
      array (
        'label' => 'Logo Header Scuro',
        'help' => 'Versione scura del logo per tema dark',
      ),
      'logo_footer' => 
      array (
        'label' => 'Logo Footer',
        'help' => 'Logo per il footer del sito',
      ),
      'favicon' => 
      array (
        'label' => 'Favicon',
        'help' => 'Icona del sito (32x32px)',
      ),
      'colors' => 
      array (
        'label' => 'Colori',
        'help' => 'Schema colori del sito',
        'key' => 
        array (
          'label' => 'Chiave',
          'help' => 'Identificativo del colore',
        ),
        'hex' => 
        array (
          'label' => 'Codice HEX',
          'help' => 'Codice colore esadecimale',
        ),
      ),
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'contact' => 
    array (
      'email' => 
      array (
        'label' => 'Email',
        'placeholder' => 'Inserisci l\'email di contatto',
        'help' => 'Email principale per i contatti',
      ),
      'phone' => 
      array (
        'label' => 'Telefono',
        'placeholder' => 'Inserisci il telefono di contatto',
        'help' => 'Numero di telefono principale',
      ),
      'address' => 
      array (
        'label' => 'Indirizzo',
        'placeholder' => 'Inserisci l\'indirizzo',
        'help' => 'Indirizzo fisico dell\'attività',
      ),
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Nuovo Meta Tag',
      'success' => 'Meta tag creato con successo',
      'error' => 'Errore durante la creazione del meta tag',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
      'success' => 'Meta tag aggiornato con successo',
      'error' => 'Errore durante l\'aggiornamento del meta tag',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'success' => 'Meta tag eliminato con successo',
      'error' => 'Errore durante l\'eliminazione del meta tag',
    ),
    'preview' => 
    array (
      'label' => 'Anteprima',
      'success' => 'Anteprima generata con successo',
      'error' => 'Errore durante la generazione dell\'anteprima',
    ),
    'validate' => 
    array (
      'label' => 'Valida',
      'success' => 'Meta tag validati con successo',
      'error' => 'Errore durante la validazione dei meta tag',
    ),
  ),
  'messages' => 
  array (
    'validation' => 
    array (
      'title' => 
      array (
        'required' => 'The title is required',
        'max' => 'Il titolo non può superare i :max caratteri',
        'unique' => 'Questo titolo è già in uso',
      ),
      'description' => 
      array (
        'required' => 'La descrizione è obbligatoria',
        'max' => 'La descrizione non può superare i :max caratteri',
        'min' => 'La descrizione deve essere di almeno :min caratteri',
      ),
      'keywords' => 
      array (
        'max' => 'Le parole chiave non possono superare i :max caratteri',
        'regex' => 'Le parole chiave devono essere separate da virgola',
      ),
      'canonical' => 
      array (
        'url' => 'L\'URL canonico deve essere un URL valido',
        'unique' => 'Questo URL canonico è già in uso',
      ),
      'og_image' => 
      array (
        'image' => 'Il file deve essere un\'immagine',
        'dimensions' => 'L\'immagine deve essere :width x :height pixel',
        'max' => 'L\'immagine non può superare :max KB',
      ),
    ),
    'warnings' => 
    array (
      'missing_description' => 'Meta description mancante',
      'duplicate_title' => 'Meta title duplicato',
      'invalid_canonical' => 'URL canonico non valido',
      'oversized_image' => 'Immagine social troppo grande',
    ),
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
