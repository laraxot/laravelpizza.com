# Filosofia e Politica: Implementazione del Cluster Passport

## Logica e Business Logic

La gestione di Laravel Passport rappresenta una funzionalità critica per l'autenticazione API. Attualmente, le risorse OAuth sono disperse in diverse posizioni, rendendo difficile la gestione centralizzata.

## Filosofia DRY + KISS

La creazione di un cluster dedicato a Passport applica il principio DRY raggruppando tutte le funzionalità correlate in un'unica posizione. Questo approccio rende più semplice (KISS) la navigazione e la gestione delle risorse OAuth.

## Religione e Zen Laraxot

- **Religione**: Estendere sempre XotBaseCluster invece di Filament\Clusters\Cluster direttamente
- **Zen**: Il vuoto che permette all'organizzazione di emergere - un cluster chiaro permette una migliore struttura mentale del sistema

## Proposta di Implementazione

### Struttura del Cluster

```
User/
├── Filament/
│   ├── Clusters/
│   │   ├── Appearance.php
│   │   └── Passport.php (NUOVO)
│   ├── Resources/
│   │   ├── OauthClientResource.php
│   │   ├── OauthAccessTokenResource.php
│   │   ├── OauthAuthCodeResource.php
│   │   ├── OauthPersonalAccessClientResource.php
│   │   ├── OauthRefreshTokenResource.php
│   │   └── ClientResource.php
```

### Configurazione

Tutte le risorse OAuth saranno configurate per utilizzare il cluster Passport tramite il parametro `$cluster`.
