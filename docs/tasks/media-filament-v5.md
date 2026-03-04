# Task: Media Filament v5 Alignment (Clusters)

## 📋 Obiettivo
Organizzare la gestione media in Clusters professionali per migliorare l'esperienza di amministrazione degli asset in Filament v5.

## 🏗️ Struttura Proposta
- **AssetLibraryCluster**: 
    - **MediaResource**: La libreria globale (Grid view).
    - **CollectionResource**: Gestione delle collezioni media.
- **MediaToolsCluster**:
    - **ConversionSettings**: Configurazione pipe di trasformazione.
    - **VideoProcessingMonitor**: Stato dei job FFmpeg.
    - **StorageAnalyzer**: Widget per lo spazio disco utilizzato.

## ✅ Checklist
- [ ] Creazione dei Cluster `AssetLibraryCluster` e `MediaToolsCluster`.
- [ ] Migrazione della libreria media alla nuova `GridView` di Filament v5.
- [ ] Implementazione del caricamento asincrono per i widget di statistica storage.
- [ ] Ottimizzazione dei RelationManager per l'associazione media fluida.

## 🔗 Riferimenti
- [Roadmap Media](../roadmap.md)
