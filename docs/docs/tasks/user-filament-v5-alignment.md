# Task: User Filament v5 Alignment (Clusters)

## 📋 Obiettivo
Utilizzare la nuova funzionalità "Clusters" di Filament v5 per organizzare le numerose risorse del modulo User in gruppi logici, migliorando la navigazione e l'esperienza utente nell'Admin Panel.

## 🏗️ Struttura Proposta
- **IdentityCluster**: User, Profile, AuthenticationLog.
- **AccessControlCluster**: Role, Permission.
- **ApiCluster**: Passport Clients, Tokens, OAuth resources.
- **OrganizationCluster**: Team, Tenant.

## ✅ Checklist
- [ ] Creazione delle classi Cluster in `app/Filament/Clusters/`.
- [ ] Assegnazione di ogni risorsa al rispettivo Cluster.
- [ ] Aggiornamento delle icone e dei label dei Cluster (utilizzando traduzioni automatiche).
- [ ] Verifica che i permessi (Spatie) funzionino correttamente con la nuova struttura a Cluster.
- [ ] Test di navigazione.

## 🔗 Riferimenti
- [Roadmap User](../roadmap.md)
- [Filament Clusters Documentation](https://filamentphp.com/docs/3.x/panels/clusters) <!-- Sostituire con v5 -->
