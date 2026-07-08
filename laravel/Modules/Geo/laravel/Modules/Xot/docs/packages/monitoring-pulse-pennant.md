# Monitoring e Feature Management - Laravel 12

L'integrazione di Laravel Pulse e Pennant fornisce strumenti avanzati per il controllo in tempo reale e il rilascio graduale delle funzionalità.

## 1. Laravel Pulse (v1.6)
Pulse monitora la salute del server e le performance dell'applicazione.
- **Dashboard**: Disponibile all'endpoint `/pulse`.
- **Query Lente**: Pulse identifica automaticamente le query SQL che superano la soglia di performance, permettendo l'ottimizzazione mirata dei moduli.
- **Eccezioni**: Monitoraggio centralizzato degli errori che sfuggono ai log standard.

## 2. Laravel Pennant (v1.20)
Gestione delle Feature Flag per rilasci controllati.
- **Utilizzo**: Da usare per attivare nuove funzionalità (es. nuovo motore di calcolo medie Survey) solo per determinati Tenant o utenti admin.
- **Pattern**:
  ```php
  Feature::define('new-reporting', fn (User $user) => $user->isAdmin());
  
  if (Feature::active('new-reporting')) {
      // Logica avanzata
  }
  ```

## 3. Gestione Code (Queue)
Pulse monitora anche lo stato delle code gestite tramite `spatie/laravel-queueable-action`.
- **Alerting**: Verificare periodicamente il "Job throughput" in Pulse per assicurarsi che le Action asincrone non siano bloccate.
