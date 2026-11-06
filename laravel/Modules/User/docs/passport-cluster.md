---
title: "Filosofia e Politica: Implementazione del Cluster Passport"
type: concept
tags: [passport, cluster]
created: 2026-07-14
updated: 2026-07-14
qmd: "passport-cluster filosofia e politica: implementazione del cluster passport"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

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
