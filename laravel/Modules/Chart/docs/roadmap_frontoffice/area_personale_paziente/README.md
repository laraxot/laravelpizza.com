# Area Personale Paziente

## Stato Attuale
- **Completamento**: 70%
- **Ultimo Aggiornamento**: 05 Giugno 2025

## Componenti

### Completati ✅
- [x] Dashboard principale
  - [Documentazione](./dashboard_principale.md)
- [x] Gestione profilo
  - [Documentazione](./gestione_profilo.md)
- [x] Storico appuntamenti
  - [Documentazione](./storico_appuntamenti.md)

### In Corso 🚧
- [ ] Documenti clinici
  - [Specifiche tecniche](./documenti_clinici/specifiche.md)
  - [Architettura](./documenti_clinici/architettura.md)
  - [Piano di implementazione](./documenti_clinici/piano_implementazione.md)

### Pianificati 📅
- [ ] Impostazioni notifiche
  - [Requisiti](./impostazioni_notifiche/requisiti.md)
  - [Design](./impostazioni_notifiche/design.md)
  - [Piano di sviluppo](./impostazioni_notifiche/piano_sviluppo.md)

## Flussi Principali
1. **Accesso all'Area Personale**
   - Login con credenziali o SPID/CIE
   - Verifica 2FA se abilitata
   - Reindirizzamento alla dashboard

2. **Navigazione**
   - Menu laterale per accesso rapido
   - Breadcrumb per orientamento
   - Ricerca globale

## Requisiti di Sistema
- Browser aggiornati (Chrome, Firefox, Safari, Edge)
- JavaScript abilitato
- Connessione Internet stabile
- Risoluzione minima 320x568px (iPhone SE/5s)

## Documentazione Correlata
- [Panoramica Generale](../stato_avanzamento_lavori_2025_06_05.md#panoramica-generale)
- [Registrazione e Autenticazione](../registrazione_autenticazione/README.md)
- [Prenotazione Visite](../prenotazione_visite/README.md)

## Note di Sviluppo
- Tutte le pagine devono essere responsive
- Supporto per screen reader obbligatorio
- Logging di tutte le azioni sensibili
- Backup automatico dei dati

---
[← Torna alla Panoramica](../stato_avanzamento_lavori_2025_06_05.md)
