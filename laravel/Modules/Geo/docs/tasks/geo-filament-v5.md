# Task: Geo Filament v5 Alignment (Clusters)

## 📋 Obiettivo
Organizzare le risorse geografiche in un Cluster dedicato per migliorare l'amministrazione dei dati spaziali in Filament v5.

## 🏗️ Struttura Proposta
- **GeographicCluster**: 
    - **AddressResource**: Gestione indirizzi globali.
    - **MunicipalitiesResource**: Dati ANPR (sola lettura/editing limitato).
    - **RegionsResource** / **ProvincesResource**.
- **GeoToolsCluster**:
    - **GeocodingSettings**: Configurazione API Keys.
    - **BatchGeocoding**: Action per elaborazione massiva.

## ✅ Checklist
- [ ] Creazione del Cluster `GeographicCluster`.
- [ ] Migrazione delle risorse e dei widget mappa.
- [ ] Upgrade dei componenti di geocoding alle nuove API di Filament v5.
- [ ] Ottimizzazione del caricamento dei layer GeoJSON nelle mappe widget.

## 🔗 Riferimenti
- [ROADMAP Geo](../ROADMAP.md)
