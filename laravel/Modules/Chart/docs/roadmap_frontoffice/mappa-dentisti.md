# Mappa Interattiva Dentisti

## Descrizione Funzionalità
Implementazione di una mappa interattiva per la ricerca e visualizzazione degli odontoiatri disponibili, con filtri avanzati e integrazione geolocalizzazione.

## Stato Attuale
- **Completamento**: 40%
- **Responsabile**: Team Frontend
- **Deadline**: Luglio 2025
- **Priorità**: Alta
- **Dipendenze**: API geolocalizzazione, Profili dentisti completi

## Mockup e Wireframe
I mockup dettagliati sono disponibili nella cartella `/docs/images/`:
- Vista mappa: [Wireframe mappa](/docs/images/22.png)
- Dettaglio dentista: [Scheda dettaglio](/docs/images/23.png)

## Requisiti Tecnici

### Frontend
- Integrazione Google Maps API con clustering
- Filtri dinamici (distanza, specializzazione, disponibilità)
- Visualizzazione responsive per mobile e desktop
- Caricamento progressivo risultati (pagination, lazy loading)
- Scheda dettaglio dentista con foto, recensioni, disponibilità

### Backend
- API ottimizzata per ricerca geolocalizzata
- Caching dei risultati per migliorare performance
- Calcolo disponibilità in tempo reale
- Sicurezza dati personali dentisti

## Struttura Codice

```php
namespace Modules\<nome progetto>\app\Http\Controllers;

class DentistMapController extends Controller
{
    public function mapData(MapSearchRequest $request)
    {
        // Logica ricerca geolocalizzata
        // Restituisce JSON per Google Maps
    }
    
    public function dentistDetails($id)
    {
        // Dettagli completi dentista
    }
}
```

## Componente React/Alpine.js

```javascript
// Componente mappa interattiva
const DentistMap = {
    init() {
        // Inizializzazione mappa e marker
    },
    loadDentists(bounds, filters) {
        // Caricamento dentisti nell'area visibile
    },
    showDetails(id) {
        // Visualizzazione dettaglio al click
    }
};
```

## Timeline di Sviluppo

| Fase | Descrizione | Data Inizio | Data Fine | Stato |
|------|------------|-------------|-----------|-------|
| 1 | Setup Google Maps API | 15-05-2025 | 30-05-2025 | Completato |
| 2 | API backend geolocalizzata | 01-06-2025 | 15-06-2025 | In corso |
| 3 | Implementazione filtri | 15-06-2025 | 30-06-2025 | In corso |
| 4 | Schede dettaglio | 01-07-2025 | 15-07-2025 | Pianificato |
| 5 | Ottimizzazione mobile | 15-07-2025 | 31-07-2025 | Pianificato |

## Ottimizzazioni Performance
- Clustering marker per elevate densità di risultati
- Lazy loading delle informazioni dettagliate
- Precaricamento dati per aree geografiche adiacenti
- Compressione dati GeoJSON

## Test e Validazione
- Usability testing su dispositivi diversi
- Test di performance con densità diverse di risultati
- Verifica accessibilità (WCAG AA)
- A/B testing di diverse visualizzazioni mappa

## Integrazione con Altri Moduli
- Sistema prenotazione: [patient-book.md](patient-book.md)
- Profili dentisti: [profili-dentisti.md](profili-dentisti.md)
- Sistema notifiche: [sistema-notifiche.md](sistema-notifiche.md)

## KPI e Metriche
- Tempo medio per trovare un dentista adeguato < 30 secondi
- Tasso di conversione ricerca → prenotazione > 40%
- Soddisfazione utente per accuratezza risultati > 4.2/5

## Note Tecniche Aggiuntive
La componente mappa richiede particolare attenzione all'ottimizzazione mobile, considerando la necessità di mantenere interattività e velocità di caricamento anche su connessioni lente.
