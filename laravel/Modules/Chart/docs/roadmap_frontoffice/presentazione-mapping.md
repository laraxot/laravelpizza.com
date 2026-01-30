# Mappatura tra Presentazione del Portale e File di Implementazione

Questo documento fornisce una mappatura completa tra le sezioni della [Presentazione del Portale <nome progetto>](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md) e i relativi file di implementazione nella directory `roadmap_frontoffice`.

## Homepage e Landing Page

| Sezione Presentazione | File Implementazione | Percentuale | Elementi Chiave |
|------------------------|----------------------|-------------|----------------|
| [Homepage](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#homepage) | [./05-homepage-landing.md](./05-homepage-landing.md) | 90% | Titolo, logo, info progetto |
| [Homepage - Call to Action](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#homepage---call-to-action) | [./05-homepage-landing.md](./05-homepage-landing.md#call-to-action) | 85% | Pulsante principale per iniziare registrazione |

## Flusso Paziente

| Sezione Presentazione | File Implementazione | Percentuale | Elementi Chiave |
|------------------------|----------------------|-------------|----------------|
| [Iscrizione paziente](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#iscrizione-paziente) | [./06-iscrizione-paziente.md](./06-iscrizione-paziente.md#form-dati-anagrafici) | 90% | Form anagrafica completo |
| [Iscrizione paziente - Documentazione](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#iscrizione-paziente---documentazione) | [./06-iscrizione-paziente.md](./06-iscrizione-paziente.md#upload-documentazione) | 80% | Upload documenti sanitari e ISEE |
| [Iscrizione paziente - Questionario](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#iscrizione-paziente---questionario) | [./06-iscrizione-paziente.md](./06-iscrizione-paziente.md#questionario-anamnestico) | 85% | Questionario sanitario |
| [Iscrizione paziente - Privacy](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#iscrizione-paziente---privacy) | [./06-iscrizione-paziente.md](./06-iscrizione-paziente.md#gestione-privacy) | 100% | Consenso privacy |
| [Iscrizione paziente - Completamento](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#iscrizione-paziente---completamento) | [./06-iscrizione-paziente.md](./06-iscrizione-paziente.md#schermata-completamento) | 75% | Conferma e attesa approvazione |
| [Trova Dentista](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#trova-dentista) | [./07-prenotazione-visite.md](./07-prenotazione-visite.md#ricerca-dentisti) | 85% | Ricerca per area geografica |
| [Trova Dentista - Risultati](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#trova-dentista---risultati) | [./07-prenotazione-visite.md](./07-prenotazione-visite.md#risultati-ricerca) | 80% | Lista studi disponibili |
| [Prenota visita](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#prenota-visita) | [./07-prenotazione-visite.md](./07-prenotazione-visite.md#processo-prenotazione) | 75% | Selezione slot disponibili |
| [Prenota visita - Conferma](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#prenota-visita---conferma) | [./07-prenotazione-visite.md](./07-prenotazione-visite.md#conferma-prenotazione) | 80% | Conferma e notifica |

## Flusso Odontoiatra

| Sezione Presentazione | File Implementazione | Percentuale | Elementi Chiave |
|------------------------|----------------------|-------------|----------------|
| [Iscrizione odontoiatra](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#iscrizione-odontoiatra) | [./09-iscrizione-odontoiatra.md](./09-iscrizione-odontoiatra.md#registrazione-iniziale-e-verifica-identità) | 85% | Form iniziale e verifica identità |
| [Iscrizione odontoiatra - Verifica](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#iscrizione-odontoiatra---verifica) | [./09-iscrizione-odontoiatra.md](./09-iscrizione-odontoiatra.md#fase-di-verifica-e-approvazione) | 100% | Attesa verifica backoffice |
| [Iscrizione odontoiatra - Dati](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#iscrizione-odontoiatra---dati) | [./09-iscrizione-odontoiatra.md](./09-iscrizione-odontoiatra.md#completamento-dati-professionali) | 80% | Inserimento dati studio e bancari |
| [Iscrizione odontoiatra - Disponibilità](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#iscrizione-odontoiatra---disponibilità) | [./09-iscrizione-odontoiatra.md](./09-iscrizione-odontoiatra.md#impostazione-disponibilità) | 85% | Calendario disponibilità |
| [Richieste di prenotazione](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#richieste-di-prenotazione) | [./08-dashboard-odontoiatra.md](./08-dashboard-odontoiatra.md#dashboard-richieste) | 85% | Lista richieste appuntamenti |
| [Appuntamenti accettati](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#appuntamenti-accettati) | [./08-dashboard-odontoiatra.md](./08-dashboard-odontoiatra.md#gestione-richieste) | 80% | Visualizzazione appuntamenti confermati |
| [Appuntamenti accettati - Azioni](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#appuntamenti-accettati---azioni) | [./08-dashboard-odontoiatra.md](./08-dashboard-odontoiatra.md#note-appuntamento) | 65% | Note, referto, annullamento |
| [Rifiuto di un appuntamento](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#rifiuto-di-un-appuntamento) | [./08-dashboard-odontoiatra.md](./08-dashboard-odontoiatra.md#gestione-rifiuti) | 65% | Motivazione rifiuto |
| [Appuntamenti rifiutati](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#appuntamenti-rifiutati) | [./08-dashboard-odontoiatra.md](./08-dashboard-odontoiatra.md#storico-appuntamenti) | 60% | Storico appuntamenti rifiutati |
| [Richieste rimborso](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#richieste-rimborso) | [./10-gestione-rimborsi.md](./10-gestione-rimborsi.md) | 80% | Sistema rimborsi e fatturazione |

## Flusso Back Office

| Sezione Presentazione | File Implementazione | Percentuale | Elementi Chiave |
|------------------------|----------------------|-------------|----------------|
| [Schermata di accesso](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#schermata-di-accesso) | [./backoffice-verifica.md](./backoffice-verifica.md) | 75% | Accesso e dashboard amministratore |
| [Avvisi di sistema](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#avvisi-di-sistema) | [./backoffice-avvisi.md](./backoffice-avvisi.md) | 70% | Notifiche e alert automatici |
| [Richiesta di iscrizione](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#richiesta-di-iscrizione) | [./backoffice-verifica.md](./backoffice-verifica.md) | 85% | Gestione richieste pazienti |
| [Richiesta di iscrizione - Documentazione](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#richiesta-di-iscrizione---documentazione) | [./backoffice-gestione.md](./backoffice-gestione.md) | 80% | Visualizzazione e verifica documenti |
| [Conferma di iscrizione](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#conferma-di-iscrizione) | [./backoffice-verifica.md](./backoffice-verifica.md) | 80% | Approvazione richieste |
| [Iscrizione non accettata](../12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md#iscrizione-non-accettata) | [./backoffice-rifiuti.md](./backoffice-rifiuti.md) | 80% | Rifiuto con motivazione |

## Componenti Tecnici Trasversali

| Componente | File Implementazione | Percentuale | Elementi Chiave |
|------------|----------------------|-------------|----------------|
| Architettura Base | [./02-architettura-base.md](./02-architettura-base.md) | 95% | Laravel Folio, Volt, Livewire |
| UI/UX Base | [./03-ui-ux-base.md](./03-ui-ux-base.md) | 80% | Componenti UI, layout responsive |
| Sistema Notifiche | [./09-sistema-notifiche.md](./09-sistema-notifiche.md) | 70% | Email, SMS, in-app |
| Localizzazione | [./04-registrazione-autenticazione.md](./04-registrazione-autenticazione.md) | 75% | Multi-lingua, contenuti localizzati |

## File di Implementazione con Collegamenti al Codice

Ogni file di implementazione contiene dettagli tecnici che includono:

1. Descrizione funzionale basata sulla presentazione
2. Percentuale di completamento
3. Dettagli di implementazione con riferimenti ai file sorgente
4. Componenti UI e loro utilizzo
5. Flussi di dati e interazioni
6. Esempi di codice Blade, PHP, JavaScript

### Esempi di Collegamenti al Codice nei File di Implementazione

#### Iscrizione Odontoiatra
```php
// File: /var/www/html/<nome progetto>/laravel/Modules/Dental/app/Http/Livewire/DentistRegistration.php

namespace Modules\Dental\Http\Livewire;

class DentistRegistration extends Component
{
    // Implementazione del form di registrazione odontoiatra
}
```

#### Dashboard Odontoiatra
```php
// File: /var/www/html/<nome progetto>/laravel/Modules/Dental/app/Http/Livewire/DentistDashboard.php

namespace Modules\Dental\Http\Livewire;

class DentistDashboard extends Component
{
    // Implementazione della dashboard odontoiatra
}
```

## Rilevamento Anomalie e Suggerimenti

- Assicurarsi che tutti i file di implementazione esistano fisicamente
- Verificare che i riferimenti al codice puntino a file effettivamente esistenti
- Mantenere sincronizzati i file di implementazione con il codice man mano che progredisce lo sviluppo
- Aggiornare regolarmente le percentuali di completamento

## Prossimi Passi

1. Completare la documentazione tecnica per ciascun file di implementazione
2. Aggiungere diagrammi di flusso per i processi principali
3. Creare video tutorial per i flussi utente principali
4. Sviluppare test end-to-end per ciascun flusso descritto

# Mapping Presentazione ⇄ Roadmap ⇄ Dettaglio

Questa tabella mette in relazione ogni punto della presentazione del portale con la roadmap frontoffice e i file di dettaglio, includendo:
- Backlink relativi
- Percentuale di completamento
- File PHP coinvolti
- Filosofia, consigli, note

| # | Punto Presentazione | Roadmap | File Dettaglio | Percentuale | File PHP | Filosofia/Note |
|---|---------------------|---------|---------------|-------------|----------|----------------|
| 1 | Homepage, CTA | [05-homepage-landing.md](./05-homepage-landing.md) | [01-homepage-layout.md](./01-homepage-layout.md) | 100% | Blade, JSON | Semplicità, chiarezza |
| 2 | Iscrizione paziente (dati, documenti, privacy, questionario) | [04-registrazione-autenticazione.md](./04-registrazione-autenticazione.md) | [06-iscrizione-paziente.md](./06-iscrizione-paziente.md) | 90% | UserResource, Form, Upload | Accoglienza, trasparenza |
| 3 | Ricerca dentista | [07-prenotazione-visite.md](./07-prenotazione-visite.md) | [16-sistema-prenotazioni.md](./16-sistema-prenotazioni.md) | 80% | DentistSearch, BookingCalendar | Accessibilità, scelta |
| 4 | Prenotazione visita | [07-prenotazione-visite.md](./07-prenotazione-visite.md) | [16-sistema-prenotazioni.md](./16-sistema-prenotazioni.md) | 80% | BookingResource, BookingCalendar | Fluidità, feedback |
| 5 | Iscrizione odontoiatra (doctor) | [08-registrazione-odontoiatra.md](./08-registrazione-odontoiatra.md) | [13-registrazione-odontoiatra.md](./13-registrazione-odontoiatra.md) | 85% | RegistrationWidget.php, DoctorResource.php, ProcessDoctorModerationAction.php | Qualità, fiducia, zen |
| 6 | Gestione richieste, appuntamenti, referti | [08-registrazione-odontoiatra.md](./08-registrazione-odontoiatra.md) | [dentista-appuntamenti.md](./dentista-appuntamenti.md), [dentista-referti.md](./dentista-referti.md) | 75% | AppointmentResource, RefertoResource | Responsabilità, memoria |
| 7 | Sistema rimborsi, fatturazione | [26-sistema-rimborsi.md](./26-sistema-rimborsi.md), [27-sistema-fatturazione.md](./27-sistema-fatturazione.md) | [dentista-rimborsi.md](./dentista-rimborsi.md) | 70% | ReimbursementResource, InvoiceResource | Trasparenza, equità |
| 8 | Backoffice: verifica, rimborsi, report | [09-backoffice.md](./09-backoffice.md) | [backoffice-verifica.md](./backoffice-verifica.md), [backoffice-rifiuti.md](./backoffice-rifiuti.md) | 85% | BackofficeDashboard, PazienteResource | Controllo, servizio |
| 9 | Notifiche | [28-sistema-notifiche.md](./28-sistema-notifiche.md) | [28-sistema-notifiche.md](./28-sistema-notifiche.md) | 75% | NotificationService, NotificationResource | Comunicazione, attenzione |
| 10 | Analytics, reportistica | [24-analytics.md](./24-analytics.md) | [24-analytics.md](./24-analytics.md) | 70% | AnalyticsResource | Miglioramento continuo |

---

**Nota:**
- Ogni file di dettaglio contiene spiegazione, percentuale, file PHP, filosofia, consigli e best practice.
- Tutti i collegamenti sono relativi e ogni punto della presentazione è tracciato.
- Per la registrazione odontoiatra, sono citati tighten/parental, widget Filament, e tutti i file PHP coinvolti.
- La filosofia zen e i principi di trasparenza, semplicità, responsabilità sono esplicitati nei file di dettaglio.

Se vuoi approfondire un punto specifico, segnalalo qui sotto!
