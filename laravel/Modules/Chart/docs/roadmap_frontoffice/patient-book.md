# Prenotazione Paziente (/it/patient/book)

## Descrizione Funzionalità
Implementazione del flusso di prenotazione diretta tramite URL `/it/patient/book`, progettato per semplificare il processo di prenotazione su dispositivi mobili e desktop.

## Stato Attuale
- **Completamento**: 25%
- **Responsabile**: Team Frontend
- **Deadline**: Luglio 2025
- **Priorità**: Alta
- **Dipendenze**: Sistema di disponibilità odontoiatri, Validazione documenti

## Mockup e Wireframe
I mockup dettagliati sono disponibili nella cartella `/docs/images/`:
- Schermata principale: [Wireframe prenotazione](/docs/images/20.png)
- Flusso mobile: [Sequenza mobile](/docs/images/21.png)

## Requisiti Tecnici

### Frontend
- Form multi-step con React Hook Form e Filament
- Geolocalizzazione per suggerimento studio più vicino
- Caricamento asincrono slot disponibilità
- Visualizzazione calendario interattivo
- Upload documenti con validazione client-side

### Backend
- API endpoint ottimizzato `/api/v1/appointments/book`
- Verifica in tempo reale disponibilità slot
- Validazione documenti (ISEE, gravidanza, tessera sanitaria)
- Sistema di notifiche multi-canale (email, SMS, push)

## Struttura Codice

```php
namespace Modules\<nome progetto>\Http\Controllers;

class PatientBookController extends Controller
{
    public function showBookingForm()
    {
        // Logica visualizzazione form
    }
    
    public function getAvailableSlots(Request $request)
    {
        // API per slot disponibili
    }
    
    public function bookAppointment(BookAppointmentRequest $request)
    {
        // Logica salvataggio prenotazione
    }
}
```

## Widget Frontend

```php
namespace Modules\<nome progetto>\Filament\Widgets;

class PatientBookWidget extends XotBaseWidget
{
    // Implementazione widget prenotazione
    // Integrazione con mappa e calendario
}
```

## Timeline di Sviluppo

| Fase | Descrizione | Data Inizio | Data Fine | Stato |
|------|------------|-------------|-----------|-------|
| 1 | Progettazione UX/UI | 01-05-2025 | 15-05-2025 | Completato |
| 2 | Sviluppo API backend | 15-05-2025 | 15-06-2025 | In corso |
| 3 | Implementazione widget | 01-06-2025 | 30-06-2025 | In corso |
| 4 | Integrazione mappa | 15-06-2025 | 30-06-2025 | Pianificato |
| 5 | Testing e ottimizzazione | 01-07-2025 | 15-07-2025 | Pianificato |

## Rischi e Mitigazioni

| Rischio | Impatto | Probabilità | Mitigazione |
|---------|---------|------------|-------------|
| Problemi integrazione calendario | Alto | Media | Testare intensivamente i casi limite |
| Performance mobile | Alto | Bassa | Ottimizzare rendering e lazy loading |
| Validazione documenti lenta | Medio | Alta | Implementare job queue per elaborazione |

## Metriche di Successo
- Tempo medio di completamento prenotazione < 2 minuti
- Tasso di abbandono < 20%
- Soddisfazione utente > 4/5 (da survey post-prenotazione)

## Testing Richiesto
- Test automatici API (PHPUnit)
- E2E testing del flusso (Cypress)
- Test prestazionali mobile (Lighthouse)
- Test di usabilità con utenti reali

## Collegamenti
- [Mappa dentisti](mappa-dentisti.md)
- [Sistema notifiche](sistema-notifiche.md)
- [Documentazione API](../standards/api-documentation.md)

## Note Aggiuntive
La funzionalità rappresenta un punto critico per l'esperienza utente dell'intero portale. È fondamentale mantenere un equilibrio tra semplicità d'uso e completezza delle informazioni richieste.
