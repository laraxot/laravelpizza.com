# Task: Notify Filament v5 Alignment (Clusters)

## 📋 Obiettivo
Riorganizzare le risorse del modulo Notify in Clusters per migliorare la navigazione e la gestione nel nuovo Admin Panel di Filament v5.

## 🏗️ Struttura Cluster Proposta
- **CommunicationsCluster**: Dashboard, Logs, Active Notifications.
- **TemplatesCluster**: Email Templates, SMS Templates, Seasonal Templates.
- **SettingsCluster**: Provider Configurations (SMTP, Twilio/Netfun, Firebase).

## ✅ Checklist
- [ ] Definizione delle classi Cluster in `app/Filament/Clusters/`.
- [ ] Spostamento delle risorse esistenti nei rispettivi Cluster.
- [ ] Aggiornamento dei link nel `00-index.md` per riflettere la nuova organizzazione UI.
- [ ] Verifica che le azioni bulk continuino a funzionare nella nuova struttura.

## 🔗 Riferimenti
- [Roadmap Notify](../roadmap.md)
