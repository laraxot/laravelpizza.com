<?php

declare(strict_types=1);

return array (
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
