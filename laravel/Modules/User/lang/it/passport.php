<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Passport',
    'group' => 'Sicurezza',
    'icon' => 'heroicon-o-shield-check',
    'sort' => 35,
  ),
  'label' => 'Passport',
  'plural_label' => 'Passport',
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Nome',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'client_id' => 
    array (
      'label' => 'Client ID',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'client_secret' => 
    array (
      'label' => 'Client Secret',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'redirect' => 
    array (
      'label' => 'Reindirizza',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'personal_access_client' => 
    array (
      'label' => 'Client per accesso personale',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_client' => 
    array (
      'label' => 'Client per accesso con password',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'revoked' => 
    array (
      'label' => 'Revocato',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create_client' => 
    array (
      'label' => 'Crea client',
    ),
    'revoke' => 
    array (
      'label' => 'Revoca',
    ),
    'install' => 
    array (
      'label' => 'Installa Passport',
      'modal_description' => 'Verrà eseguito passport:install --uuids. Verranno generate le chiavi e creati i client predefiniti.',
    ),
    'generate_keys' => 
    array (
      'label' => 'Genera Chiavi',
    ),
    'purge_tokens' => 
    array (
      'label' => 'Pulisci Token',
      'modal_description' => 'Verranno rimossi tutti i token scaduti e revocati dal database.',
    ),
    'hash_secrets' => 
    array (
      'label' => 'Hash Secret',
      'modal_description' => 'Verrà eseguito l\'hashing di tutti i secret dei client esistenti. Questa è un\'operazione a senso unico.',
    ),
    'create_personal' => 
    array (
      'label' => 'Crea Client Personale',
      'success' => 'Client di accesso personale creato.',
    ),
    'create_password' => 
    array (
      'label' => 'Crea Client Password',
      'success' => 'Client con grant password creato.',
    ),
    'create_client_credentials' => 
    array (
      'label' => 'Crea Client Credentials',
      'success' => 'Client con grant client credentials creato.',
    ),
  ),
  'status' => 
  array (
    'public_key' => 'Chiave Pubblica',
    'private_key' => 'Chiave Privata',
    'present' => 'Presente',
    'missing' => 'Mancante',
  ),
);
