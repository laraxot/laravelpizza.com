# Task: Notify Filament v5 Alignment (Clusters)

## 📋 Obiettivo
Centralizzare la gestione delle comunicazioni in un Cluster dedicato per migliorare l'organizzazione in Filament v5.

## 🏗️ Struttura Proposta
- **CommunicationCluster**:
    - **MailTemplateResource**: Layout e contenuti email.
    - **NotificationLogResource**: Storico degli invii multi-canale.
    - **ChannelConfigResource**: Configurazione driver (NetFun, etc.).
    - **SeasonalAction**: Tool per l'invio di messaggi periodici.

## ✅ Checklist
- [ ] Registrazione del `CommunicationCluster`.
- [ ] Migrazione delle risorse esistenti nel nuovo raggruppamento.
- [ ] Testing dei permessi di accesso granulari per il cluster.

## 🔗 Riferimenti
- [Roadmap Notify](../roadmap.md)
