# Task: Tenant Filament v5 Alignment (Clusters)

## 📋 Obiettivo
Organizzare le risorse del modulo Tenant in Clusters per migliorare la coerenza dell'Admin Panel in Filament v5.

## 🏗️ Struttura Proposta
- **InfrastructureCluster**: Tenant, Domain, TenantUser.
- **SubscriptionsCluster**: TenantSubscription (se implementato), Pricing Plans.
- **SettingsCluster**: TenantSetting, Configuration Overrides.

## ✅ Checklist
- [ ] Definizione delle classi Cluster in `app/Filament/Clusters/`.
- [ ] Spostamento delle risorse esistenti nei Cluster corretti.
- [ ] Aggiornamento dei label e delle icone (con traduzioni automatiche).
- [ ] Verifica che l'isolamento tenant rimanga attivo anche navigando tra i Cluster.

## 🔗 Riferimenti
- [Roadmap Tenant](../roadmap.md)
- [Filament Clusters](https://filamentphp.com/docs/3.x/panels/clusters) <!-- Update to v5 -->
