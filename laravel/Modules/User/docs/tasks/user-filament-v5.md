# Task: User Filament v5 Alignment (Clusters)

## 📋 Obiettivo
Organizzare la gestione degli utenti e della sicurezza in Cluster dedicati per una navigazione più pulita.

## 🏗️ Struttura Proposta
- **IdentityCluster**:
    - **UserResource**: Gestione anagrafica utenti.
    - **RoleResource**: Gestione ruoli (Spatie).
    - **PermissionResource**: Gestione permessi granulari.
- **SecurityCluster**:
    - **OauthClientResource**: Gestione client Passport.
    - **AuditLogResource**: Storico accessi e modifiche.
    - **SessionResource**: Gestione sessioni attive.

## ✅ Checklist
- [ ] Registrazione dei due nuovi Cluster.
- [ ] Migrazione delle risorse esistenti.
- [ ] Aggiornamento dei link nelle dashboard.

## 🔗 Riferimenti
- [Roadmap User](../roadmap.md)
