<?php

declare(strict_types=1);

return [
  'fields' => [
    'name' => 'Nome',
    'name.placeholder' => 'Inserisci il nome del provider',
    'name.helper_text' => 'Il nome del provider social (es. Facebook, Google]',
    'scopes' => 'Ambiti',
    'scopes.placeholder' => 'Inserisci gli ambiti di accesso',
    'scopes.helper_text' => 'Gli ambiti di accesso richiesti dal provider',
    'parameters' => 'Parametri',
    'parameters.placeholder' => 'Inserisci i parametri aggiuntivi',
    'parameters.helper_text' => 'Parametri aggiuntivi per la configurazione',
    'stateless' => 'Senza stato',
    'stateless.helper_text' => 'Se il provider non mantiene lo stato della sessione',
    'active' => 'Attivo',
    'active.helper_text' => 'Se il provider è attualmente attivo',
    'socialite' => 'Socialite',
    'socialite.helper_text' => 'Se il provider usa Laravel Socialite',
    'svg' => 'SVG',
    'svg.placeholder' => 'Inserisci il codice SVG dell\'icona',
    'svg.helper_text' => 'L\'icona SVG del provider social',
  ],
  'navigation' => [
    'name' => 'Social Providers',
    'plural' => 'Social Providers',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Social Providers',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ],
  'label' => 'Social Providers',
  'plural_label' => 'Social Providers (Plurale)',
  'actions' => [
    'create' => [
      'label' => 'Crea Social Providers',
    ],
    'edit' => [
      'label' => 'Modifica Social Providers',
    ],
    'delete' => [
      'label' => 'Elimina Social Providers',
    ],
  ],
];
