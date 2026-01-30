# Storico Appuntamenti

## Panoramica
La sezione dello storico appuntamenti consente ai pazienti di visualizzare la cronologia completa delle visite effettuate, con relativi dettagli e documenti correlati.

## Funzionalità Principali

### 1. Visualizzazione Elenco
- Lista cronologica delle visite
- Filtri per:
  - Periodo (ultimi 3/6/12 mesi, personalizzato)
  - Specialista
  - Tipologia di visita
  - Stato (completata, annullata, rinviata)
- Ordinamento per data (decrescente/crescente)
- Ricerca per parola chiave

### 2. Dettaglio Appuntamento
- Dati generali (data, ora, durata)
- Medico/specialista
- Struttura sanitaria
- Motivo della visita
- Anamnesi (se disponibile)
- Diagnosi e trattamento
- Documenti correlati
- Eventuali note

### 3. Azioni Disponibili
- Visualizza referto
- Scarica certificato
- Condividi documenti
- Richiedi copia cartacea
- Valuta la visita
- Prenota nuovo appuntamento con lo stesso specialista

## Interfaccia Utente

### Tabella Riassuntiva
| Data | Ora | Medico | Specialità | Stato | Azioni |
|------|-----|--------|------------|-------|--------|
| 15/06/2025 | 10:30 | Dr. Bianchi | Odontoiatria | Completato | [Dettagli] [Documenti] |
| 01/05/2025 | 14:15 | Dr. Verdi | Cardiologia | Completato | [Dettagli] [Documenti] |

### Filtri Avanzati
- Calendario per selezione date
- Dropdown per specialità
- Toggle per visualizzare solo gli appuntamenti con documenti
- Pulsante reset filtri

## API Endpoints

### GET /api/v1/patient/appointments
Recupera l'elenco degli appuntamenti con filtri

**Parametri:**
- `start_date`: Data inizio intervallo (YYYY-MM-DD)
- `end_date`: Data fine intervallo (YYYY-MM-DD)
- `doctor_id`: Filtro per medico
- `specialty`: Filtro per specialità
- `status`: Stato appuntamento
- `page`: Paginazione
- `per_page`: Elementi per pagina

### GET /api/v1/patient/appointments/{id}
Dettaglio singolo appuntamento

### GET /api/v1/patient/appointments/{id}/documents
Documenti correlati all'appuntamento

## Gestione Errori
- Nessun appuntamento trovato
- Errore nel caricamento dati
- Documento non disponibile
- Problemi di connessione

## Prestazioni
- Paginazione lato server (20 elementi per pagina)
- Lazy loading per documenti pesanti
- Cache dei dati per 5 minuti
- Indicatore di caricamento durante le richieste

## Sicurezza
- Verifica del proprietario dell'appuntamento
- Controllo permessi per ogni documento
- Logging degli accessi
- Protezione da enumerazione ID

## Accessibilità
- Struttura tabellare accessibile
- Testo alternativo per icone
- Tasti di scelta rapida
- Supporto per screen reader

## Documentazione Correlata
- [Panoramica Area Personale](./README.md)
- [API Documentation](../api/patient_api.md#appuntamenti)
- [Linee Guida Privacy](../privacy/privacy_policy.md#dati-sanitari)

[← Torna all'Area Personale](./README.md)
