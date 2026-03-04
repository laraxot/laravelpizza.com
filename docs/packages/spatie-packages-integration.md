# Integrazione Pacchetti Spatie - Laraxot PTVX

L'architettura Laraxot si basa pesantemente sull'ecosistema Spatie. Di seguito le linee guida per l'uso dei pacchetti installati.

## 1. Spatie Laravel Data (v4.19)
Utilizzato come spina dorsale per lo scambio di dati tipizzati.
- **Regola**: Ogni Action deve ricevere un oggetto `Data`.
- **Regola**: Le risorse Filament che non usano Eloquent direttamente devono mappare i dati tramite DTO.

## 2. Spatie MediaLibrary (v11.21)
Gestione unificata degli allegati.
- **Integrazione Filament**: Usare il plugin `filament/spatie-laravel-media-library-plugin` per i campi di upload.
- **Regola**: Definire sempre le `mediaCollections` nel metodo `registerMediaCollections` del modello.

## 3. Spatie Laravel Permission (v7.2)
Gestione RBAC.
- **Integrazione**: Centralizzata nel modulo `User`.
- **Regola**: Non usare `can()` con stringhe hardcoded, usare i nomi dei permessi definiti nelle costanti dei modelli o classi dedicate.

## 4. Spatie Queueable Action (v2.17)
Logica di business asincrona.
- **Regola**: Tutte le operazioni che superano i 200ms (es. invio mail, elaborazione immagini, export pesanti) DEVONO estendere `QueueableAction` ed essere eseguite in coda.

## 5. Altri Pacchetti Critici
- **Schemaless Attributes**: Usato per i campi extra JSON (`extra_attributes`).
- **Laravel Model States**: Usato per workflow complessi (es. stati di una pratica, approvazioni).
- **Activity Log**: Logger automatico per le modifiche ai modelli (Audit Trail).
