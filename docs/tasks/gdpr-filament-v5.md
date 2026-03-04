# Task: Gdpr Filament v5 Alignment (Clusters)

## 📋 Obiettivo
Organizzare le risorse legate alla compliance in un Cluster dedicato per migliorare la sicurezza e l'usabilità dell'area amministrativa in Filament v5.

## 🏗️ Struttura Proposta
- **ComplianceCluster**: 
    - **TreatmentResource**: Gestione trattamenti.
    - **ConsentResource**: Log dei consensi.
    - **PrivacyEventResource**: Audit trail eventi privacy.
    - **ProfileResource**: Profili privacy.

## ✅ Checklist
- [ ] Creazione del Cluster `ComplianceCluster`.
- [ ] Migrazione delle risorse e dei widget.
- [ ] Implementazione di indicatori visuali "Compliant/Not Compliant" nelle liste.
- [ ] Aggiornamento degli export PDF per sfruttare le nuove action di Filament v5.

## 🔗 Riferimenti
- [Roadmap Gdpr](../roadmap.md)
