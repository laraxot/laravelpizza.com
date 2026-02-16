<?php

declare(strict_types=1);

return array (
  'register' => 
  array (
    'title' => 'Create your account',
    'subtitle' => 'Join the most delicious Laravel developer community!',
    'submit' => 'Create my free account',
    'submitting' => 'Creating account...',
    'already_have_account' => 'Already have an account?',
    'already_registered' => 'Already have an account?',
    'login' => 'Login now',
    'sections' => 
    array (
      'user_info' => 'Personal Information',
      'user_info_description' => 'Enter your details to create your account',
      'required_consents' => 'Required Consents',
      'required_consents_description' => 'To proceed with registration, you must accept the following conditions for processing your personal data',
      'optional_consents' => 'Optional Consents',
      'optional_consents_description' => 'These consents are optional and do not affect your registration. You can modify them at any time from your profile.',
    ),
    'fields' => 
    array (
      'first_name' => 
      array (
        'label' => 'First Name',
        'placeholder' => 'Enter your first name',
      ),
      'last_name' => 
      array (
        'label' => 'Last Name',
        'placeholder' => 'Enter your last name',
      ),
      'email' => 
      array (
        'label' => 'Email',
        'placeholder' => 'Enter your email',
      ),
      'password' => 
      array (
        'label' => 'Password',
        'placeholder' => 'Create a secure password',
      ),
      'password_confirmation' => 
      array (
        'label' => 'Confirm Password',
        'placeholder' => 'Repeat your password',
      ),
    ),
    'consents' => 
    array (
      'title' => 'Consents',
      'privacy_policy_label' => 'Privacy Policy',
      'privacy_policy_hint' => 'I have read and understood the Privacy Policy and accept the processing of my personal data as described',
      'terms_label' => 'Terms and Conditions',
      'terms_hint' => 'I have read and accept the Terms and Conditions',
      'marketing_label' => 'Marketing Consent',
      'marketing_hint' => 'I want to receive pizza tips and meetup invitations',
      'privacy_complete' => 'Full information pursuant to Articles 13 and 14 of Regulation (EU) 2016/679 (GDPR)',
      'terms_complete' => 'Service contract pursuant to Article 6(1)(b) of Regulation (EU) 2016/679 (GDPR)',
    ),
    'actions' => 
    array (
      'read_privacy_policy' => 'Read privacy policy',
      'read_terms' => 'Read terms and conditions',
    ),
    'links' => 
    array (
      'and' => 'and',
    ),
  ),
  'navigation' => 
  array (
    'name' => 'GDPR',
    'plural' => 'GDPR',
    'group' => 
    array (
      'name' => 'Privacy',
      'description' => 'Gestione della privacy e protezione dei dati',
    ),
    'label' => 'Dashboard GDPR',
    'sort' => '79',
    'icon' => 'gdpr-dashboard-animated',
  ),
  'sections' => 
  array (
    'dashboard' => 
    array (
      'title' => 'Dashboard GDPR',
      'description' => 'Panoramica della conformità GDPR',
      'sort' => '80',
      'icon' => 'gdpr-dashboard-animated',
    ),
    'consent' => 
    array (
      'title' => 'Consensi',
      'description' => 'Gestione dei consensi degli utenti',
      'sort' => '81',
      'icon' => 'gdpr-consent-animated',
    ),
    'treatment' => 
    array (
      'title' => 'Trattamenti',
      'description' => 'Registro dei trattamenti dati',
      'sort' => '82',
      'icon' => 'gdpr-treatment-animated',
    ),
    'profile' => 
    array (
      'title' => 'Profili',
      'description' => 'Gestione dei profili di privacy',
      'sort' => '83',
      'icon' => 'gdpr-profile-animated',
    ),
    'event' => 
    array (
      'title' => 'Eventi',
      'description' => 'Registro degli eventi privacy',
      'sort' => '84',
      'icon' => 'gdpr-event-animated',
    ),
  ),
  'widgets' => 
  array (
    'consent_summary' => 'Riepilogo Consensi',
    'treatment_status' => 'Stato Trattamenti',
    'recent_events' => 'Eventi Recenti',
    'compliance_score' => 'Indice di Conformità',
  ),
  'metrics' => 
  array (
    'active_consents' => 'Consensi Attivi',
    'pending_requests' => 'Richieste in Sospeso',
    'data_breaches' => 'Violazioni Dati',
    'compliance_level' => 'Livello Conformità',
  ),
  'status' => 
  array (
    'compliant' => 'Conforme',
    'partially_compliant' => 'Parzialmente Conforme',
    'non_compliant' => 'Non Conforme',
    'needs_review' => 'Necessita Revisione',
  ),
  'actions' => 
  array (
    'export_data' => 'Esporta Dati',
    'generate_report' => 'Genera Report',
    'review_compliance' => 'Verifica Conformità',
    'update_policies' => 'Aggiorna Policies',
  ),
  'reports' => 
  array (
    'compliance' => 'Report Conformità',
    'consent' => 'Report Consensi',
    'treatment' => 'Report Trattamenti',
    'event' => 'Report Eventi',
  ),
  'notifications' => 
  array (
    'consent_expired' => 'Consenso Scaduto',
    'review_needed' => 'Revisione Necessaria',
    'breach_detected' => 'Violazione Rilevata',
    'policy_updated' => 'Policy Aggiornata',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
  'fields' => 
  array (
  ),
);
