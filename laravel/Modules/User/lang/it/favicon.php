<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Favicon',
    'plural_label' => 'Favicon',
    'group' => 'Aspetto',
    'icon' => 'heroicon-o-photo',
    'sort' => 5,
  ),
  'label' => 'Favicon',
  'plural_label' => 'Favicon',
  'fields' => 
  array (
    'background_color' => 
    array (
      'label' => 'Colore Sfondo',
      'tooltip' => 'Colore di sfondo per l\'icona favicon',
      'placeholder' => 'Seleziona il colore di sfondo',
      'helper_text' => 'Colore di sfondo per l\'icona favicon',
      'description' => 'Seleziona il colore di sfondo per l\'icona',
    ),
    'background' => 
    array (
      'label' => 'Immagine Sfondo',
      'tooltip' => 'Immagine di sfondo per il favicon',
      'placeholder' => 'Carica un\'immagina per lo sfondo',
      'helper_text' => 'Immagine di sfondo per il favicon',
      'description' => 'Carica un\'immagina da usare come sfondo',
    ),
    'overlay_color' => 
    array (
      'label' => 'Colore Overlay',
      'tooltip' => 'Colore dell\'overlay da applicare',
      'placeholder' => 'Seleziona il colore dell\'overlay',
      'helper_text' => 'Colore dell\'overlay da applicare al favicon',
      'description' => 'Seleziona il colore dell\'overlay',
    ),
    'overlay_opacity' => 
    array (
      'label' => 'Opacità Overlay',
      'tooltip' => 'Valore di opacità (0-100)',
      'placeholder' => 'Inserisci l\'opacità (0-100)',
      'helper_text' => 'Valore di opacità per l\'overlay (0-100)',
      'description' => 'Opacità dell\'overlay tra 0 e 100',
    ),
  ),
  'actions' => 
  array (
    'save' => 
    array (
      'label' => 'Salva',
      'tooltip' => 'Salva le impostazioni del favicon',
    ),
    'reset' => 
    array (
      'label' => 'Reimposta',
      'tooltip' => 'Reimposta ai valori predefiniti',
    ),
    'upload' => 
    array (
      'label' => 'Carica',
      'tooltip' => 'Carica un\'immagina',
    ),
    'remove' => 
    array (
      'label' => 'Rimuovi',
      'tooltip' => 'Rimuovi l\'immagina caricata',
    ),
  ),
  'messages' => 
  array (
    'saved' => 'Favicon salvato con successo',
    'reset' => 'Impostazioni reimpostate',
    'uploaded' => 'Immagine caricata con successo',
    'removed' => 'Immagine rimossa con successo',
    'error' => 'Si è verificato un errore',
  ),
  'validation' => 
  array (
    'background_color_invalid' => 'Il colore di sfondo non è valido',
    'overlay_color_invalid' => 'Il colore overlay non è valido',
    'overlay_opacity_invalid' => 'L\'opacità deve essere un numero tra 0 e 100',
    'image_required' => 'L\'immagina è obbligatoria',
    'image_invalid' => 'L\'immagina non è valida',
  ),
);
