# Dashboard Principale

## Panoramica
La dashboard principale è il punto di accesso centrale per i pazienti, fornendo una visione completa delle informazioni e delle azioni principali.

## Componenti della Dashboard

### Sezione Intestazione
- Nome e foto profilo utente
- Pulsante rapido per prenota visita
- Indicatore stato salute (se applicabile)

### Riquadri Informativi
1. **Prossimo Appuntamento**
   - Data e ora
   - Nome specialista
   - Tipo di visita
   - Pulsante "Dettagli"
   - Pulsante "Annulla Prenotazione"

2. **Notifiche Recenti**
   - Ultime 3 notifiche non lette
   - Anteprima messaggio
   - Indicatore stato lettura
   - Link a tutte le notifiche

3. **Documenti Recenti**
   - Ultimi 3 documenti caricati
   - Tipo documento
   - Data caricamento
   - Pulsante download

4. **Stato Salute** (se abilitato)
   - Grafico andamento parametri
   - Indicatori chiave
   - Link a dettagli completi

### Sezione Azioni Rapide
- Nuova prenotazione
- Richiedi referto
- Contatta l'assistenza
- Scarica certificato

## Requisiti Tecnici

### API Endpoints
```
GET /api/v1/patient/dashboard
```

### Risposta di Esempio
```json
{
  "user": {
    "name": "Mario Rossi",
    "avatar": "/storage/avatars/123.jpg"
  },
  "next_appointment": {
    "id": 456,
    "date": "2025-06-15T10:30:00+02:00",
    "doctor": "Dr. Bianchi",
    "specialty": "Odontoiatria",
    "status": "confermato"
  },
  "notifications": [
    {
      "id": 789,
      "title": "Appuntamento confermato",
      "message": "Il tuo appuntamento è stato confermato per il 15/06/2025",
      "read": false,
      "created_at": "2025-06-01T14:30:00+02:00"
    }
  ],
  "recent_documents": [
    {
      "id": 101,
      "type": "referto",
      "name": "Referto visita del 01/05/2025",
      "date": "2025-05-05",
      "url": "/documents/101/download"
    }
  ]
}
```

## Sicurezza
- Accesso consentito solo a utenti autenticati con ruolo paziente
- Verifica dei permessi per ogni richiesta
- Dati sensibili crittografati
- Logging degli accessi

## Accessibilità
- Struttura semantica HTML5
- Attributi ARIA per componenti dinamici
- Tasti di scelta rapida
- Supporto per screen reader

## Performance
- Tempo di caricamento < 2 secondi
- Lazy loading per immagini e componenti pesanti
- Cache lato client per dati non critici
- Ottimizzazione per dispositivi mobili

## Documentazione Correlata
- [Panoramica Area Personale](./README.md)
- [API Documentation](../api/patient_api.md)
- [Linee Guida UI/UX](../ui_ux/patient_dashboard_guidelines.md)

[← Torna all'Area Personale](./README.md)
