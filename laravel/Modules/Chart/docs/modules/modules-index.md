# Indice dei Moduli Base

## Moduli Core

### Xot
- **Scopo**: Modulo base del framework
- **Dipendenze**: Laravel
- **Documentazione**: [Xot/docs/README.md](../laravel/Modules/Xot/docs/README.md)
- **Funzionalità Principali**:
  - Classi base per estensione
  - Gestione configurazioni
  - Utility comuni
  - Service Provider base

### UI
- **Scopo**: Componenti di interfaccia utente
- **Dipendenze**: Xot
- **Documentazione**: [UI/docs/README.md](../laravel/Modules/UI/docs/README.md)
- **Funzionalità Principali**:
  - Componenti Blade
  - Temi e layout
  - Form components
  - Widget riutilizzabili

### User
- **Scopo**: Gestione utenti e autorizzazioni
- **Dipendenze**: Xot, Spatie/Laravel-permission
- **Documentazione**: [User/docs/README.md](../laravel/Modules/User/docs/README.md)
- **Funzionalità Principali**:
  - Autenticazione
  - Ruoli e permessi
  - Profili utente
  - Social login

### Patient
Il modulo Patient è responsabile della gestione completa dei pazienti e dei loro dati.

#### Responsabilità Principali
- Gestione anagrafica completa
- Gestione ISEE e documenti
- Storia medica del paziente
- Consensi e privacy GDPR
- Gestione appuntamenti e follow-up

#### Interazioni
- **→ Dental**: Fornisce dati paziente per visite
- **→ Reporting**: Invia dati per statistiche
- **← Dental**: Riceve aggiornamenti stato clinico

#### Componenti Chiave
- Wizard di registrazione
- Gestione documenti
- Sistema di consensi
- Gestione appuntamenti

### Dental
Il modulo Dental gestisce tutti gli aspetti clinici e odontoiatrici.

#### Responsabilità Principali
- Cartella clinica odontoiatrica
- Piano di trattamento
- Gestione appuntamenti
- Documentazione clinica
- Immagini e radiografie

#### Interazioni
- **← Patient**: Riceve dati paziente
- **→ Reporting**: Invia dati per analisi
- **→ Patient**: Aggiorna stato clinico

#### Componenti Chiave
- Cartella clinica digitale
- Sistema di imaging
- Pianificazione trattamenti
- Gestione appuntamenti

## Moduli Business

### Dental
- **Scopo**: Funzionalità specifiche odontoiatriche
- **Dipendenze**: Patient, Chart
- **Documentazione**: [Dental/docs/README.md](../laravel/Modules/Dental/docs/README.md)
- **Funzionalità Principali**:
  - Odontogramma
  - Piani di cura
  - Preventivi
  - Trattamenti

## Moduli di Supporto

### Activity
- **Scopo**: Logging e tracciamento attività
- **Dipendenze**: Xot
- **Documentazione**: [Activity/docs/README.md](../laravel/Modules/Activity/docs/README.md)
- **Funzionalità Principali**:
  - Audit trail
  - Log attività
  - Monitoraggio
  - Report

### Chart
- **Scopo**: Visualizzazione dati e grafici
- **Dipendenze**: Xot
- **Documentazione**: [Chart/docs/README.md](../laravel/Modules/Chart/docs/README.md)
- **Funzionalità Principali**:
  - Grafici statistici
  - Dashboard
  - Report visivi
  - KPI

### Gdpr
- **Scopo**: Conformità GDPR
- **Dipendenze**: User
- **Documentazione**: [Gdpr/docs/README.md](../laravel/Modules/Gdpr/docs/README.md)
- **Funzionalità Principali**:
  - Consensi
  - Privacy policy
  - Export dati
  - Cancellazione dati

### Lang
- **Scopo**: Gestione traduzioni
- **Dipendenze**: Xot
- **Documentazione**: [Lang/docs/README.md](../laravel/Modules/Lang/docs/README.md)
- **Funzionalità Principali**:
  - Traduzioni UI
  - Gestione lingue
  - Import/export
  - Fallback

### Media
- **Scopo**: Gestione file e media
- **Dipendenze**: Xot
- **Documentazione**: [Media/docs/README.md](../laravel/Modules/Media/docs/README.md)
- **Funzionalità Principali**:
  - Upload file
  - Conversioni
  - Ottimizzazione
  - Storage

### Notify
- **Scopo**: Sistema di notifiche
- **Dipendenze**: User
- **Documentazione**: [Notify/docs/README.md](../laravel/Modules/Notify/docs/README.md)
- **Funzionalità Principali**:
  - Email
  - SMS
  - Push notifications
  - Templates

### Reporting
Il modulo Reporting si occupa dell'analisi dati e della generazione di report.

#### Responsabilità Principali
- Statistiche cliniche
- Report finanziari
- Analisi performance
- KPI e metriche
- Dashboard interattive

#### Interazioni
- **← Patient**: Riceve dati demografici
- **← Dental**: Riceve dati clinici
- **→ Patient/Dental**: Fornisce insights

#### Componenti Chiave
- Dashboard analytics
- Sistema di reporting
- Generazione PDF
- Visualizzazione dati

### Tenant
- **Scopo**: Supporto multi-tenant
- **Dipendenze**: Xot
- **Documentazione**: [Tenant/docs/README.md](../laravel/Modules/Tenant/docs/README.md)
- **Funzionalità Principali**:
  - Isolamento dati
  - Domini personalizzati
  - Configurazioni
  - Temi

## Note sulle Dipendenze

1. Tutti i moduli dipendono implicitamente da `Xot`
2. I moduli business (`Patient`, `Dental`) dipendono dai moduli core
3. I moduli di supporto sono generalmente indipendenti tra loro
4. Le dipendenze circolari sono evitate per design

## Standard di Sviluppo

Ogni modulo deve:
1. Avere una cartella `docs/` con documentazione completa
2. Seguire le convenzioni di naming stabilite
3. Implementare test unitari e funzionali
4. Mantenere un CHANGELOG aggiornato

## Collegamenti Utili

- [Architettura Moduli](../architecture/modules-structure.md)
- [Convenzioni di Codice](../standards/coding-standards.md)
- [Documentazione Filament](../filament/componenti-blade.md)
- [Guida Frontend](../frontend/README.md) 
