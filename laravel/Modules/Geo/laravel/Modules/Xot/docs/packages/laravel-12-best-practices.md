# Laravel 12 Best Practices - Laraxot PTVX

Aggiornamento delle pratiche consigliate basate sulle nuove funzionalità di Laravel 12.

## 1. Routing & Folio
- **Laravel Folio**: Usare Folio per rotte basate su file per pagine statiche o dashboard semplici, riducendo la complessità dei controller.
- **Folio & Volt**: L'accoppiata Folio + Volt è ideale per il frontend del tema Zero.

## 2. Feature Flags (laravel/pennant)
- **Utilizzo**: Implementare nuove funzionalità sotto feature flag durante lo sviluppo.
- **Pattern**:
  ```php
  if (Feature::active('new-survey-engine')) {
      // Logica nuova
  }
  ```

## 3. Monitoring (laravel/pulse)
- **Dashboard**: Accessibile in `/pulse`.
- **Custom Cards**: Creare card Pulse specifiche per i moduli (es. numero survey inviate oggi) per il monitoraggio business.

## 4. Database & Performance
- **Database Transactions**: Usare sempre `DatabaseTransactions` nei test Pest per velocità e isolamento.
- **Batching**: Sfruttare le nuove ottimizzazioni di Laravel 12 per il DB batching nelle operazioni di importazione dati Limesurvey.
