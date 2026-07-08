# Product Requirements Document (PRD)

## Metadata

| Campo | Valore |
|-------|--------|
| **Version** | 1.0.0 |
| **Status** | Approved |
| **Last Updated** | 2026-03-03 |
| **Owner** | IT Team |
| **Module** | Pdnd |
| **Repository** | laraxot/module_pdnd_fila5 |

---

## 1. Panoramica del Prodotto

### Descrizione Breve
Il modulo Pdnd gestisce l'**interoperabilità con la Piattaforma Digitale Nazionale Dati (PDND)**: servizi CIE, SPID, Fascicolo Sanitario, servizi pubblici.

### Visione
Abilitare l'interoperabilità PA con:
- Integrazione PDND
- Gestione client OAuth2
- Catalogazione API
- Audit trail

### Target Users
- **IT**: Configurazione
- **PA**: Servizi
- **Cittadino**: Accesso

---

## 2. Problema

### Problema Risolto
- Integrazioni manuali
- No standard interoperabilità
- Difficoltà adeguamento
- Audit assente

---

## 3. Soluzione Proposta

### Funzionalità

#### 3.1 PDND Integration
- [x] Client OAuth2 registration
- [x] Interop metadata
- [x] Token management
- [x] Purpose limitation

#### 3.2 Servizi CIE
- [x] Autenticazione CIE
- [x] Lettura dati anagrafici
- [x] Firma con CIE

#### 3.3 Servizi SPID
- [x] Autenticazione SPID
- [x] Livelli assurance
- [x] Attribute aggregator

#### 3.4 Catalog
- [x] API catalog
- [x] Usage statistics
- [x] Versioning

---

## 4. Scope

### In Scope
- [x] PDND client
- [x] CIE/SPID
- [x] API catalog

### Out of Scope
- [ ] Servizi specifici PA

---

## 5. Standard

### Riferimenti
- D.Lgs. 82/2005 (CAD)
- DPCM PdND
- Linee guida AgID
- Regolamento eIDAS
