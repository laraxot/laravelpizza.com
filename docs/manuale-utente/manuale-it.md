# LaravelPizza — Manuale d'uso per ruoli (IT)

> **Stato di verifica (16 novembre 2026):** guida basata sulla lettura del codice del branch `dev`. Le schermate non sono ancora state acquisite dall'applicazione in esecuzione. **Non usare mockup come screenshot reali.** I passaggi che coinvolgono permessi o notifiche vanno verificati tramite test E2E prima della pubblicazione definitiva.

## 1. Cos'è LaravelPizza
LaravelPizza è una piattaforma community per eventi e meetup su Laravel, PHP e tecnologie collegate. Il frontoffice è sviluppato con Folio/Volt nel tema `laravel/Themes/Meetup`; la gestione eventi usa il modulo `laravel/Modules/Meetup` e risorse Filament.

## 2. Profili d'uso
| Persona | Attività | Funzioni effettivamente individuate | Verifica ancora necessaria |
|---|---|---|---|
| Visitatore | Scopre la community e gli eventi | Home, elenco/dettaglio eventi, pagine profilo | Navigazione e disponibilità di tutte le pagine |
| Utente registrato / partecipante | Crea account, accede, consulta i propri eventi | Registrazione, login, profilo, iscrizione modellata in `EventUser` | Esecuzione iscrizione/disiscrizione da UI |
| Organizzatore | Propone e gestisce eventi | `Event` contiene `organizer_id`, `status`, `max_attendees`; flusso proposta indicato da `isPending()` | Permessi e schermate specifiche |
| Gestore eventi / operatore | Compila schede eventi e gestisce iscritti | `EventResource`, `EventForm`, `RegistrationsRelationManager`, import eventi | Autorizzazioni Filament |
| Relatore | Compare in un evento | `PerformerResource`, collegamento evento-relatore | Eventuale area riservata relatore |
| Sponsor | Compare tra i partner di un evento | `SponsorResource`, collegamento evento-sponsor | Eventuale area riservata sponsor |
| Amministratore | Gestisce configurazione ed eventi | Dashboard, risorse eventi, sedi, relatori, sponsor | Pannelli e privilegi per singolo ruolo |

I ruoli *relatore* e *sponsor* sono qui considerati persone coinvolte nel workflow; il codice ispezionato **non dimostra** che ciascuna abbia un accesso dedicato.

## 3. Visitatore
1. Aprire il frontoffice e selezionare la lingua italiana o inglese.
2. Raggiungere l'elenco eventi dal menu, oppure l'URL localizzato `/it/events` in ambiente locale secondo il README.
3. Aprire un evento per vedere titolo, data, orario, luogo, modalità di partecipazione, posti disponibili e organizzatore, quando valorizzati.
4. Dal dettaglio, utilizzare il collegamento alla mappa se è presente il luogo.
5. Per creare un account, aprire la pagina di registrazione.

**Screenshot richiesti:** `screenshots/it/01-home.png`, `02-events-list.png`, `03-event-detail.png`, `04-register.png`.

## 4. Utente registrato e partecipante
1. Dalla registrazione compilare il modulo mostrato dal widget GDPR `RegisterWidget`; seguire gli eventuali passaggi di verifica account proposti dall'interfaccia.
2. Accedere dalla pagina login; aprire il proprio profilo.
3. Navigare verso un evento pubblicato e futuro.
4. Se la pagina propone un'azione d'iscrizione, verificare la disponibilità dei posti e completarla. Il modello dati usa la tabella pivot `event_user`.
5. Se l'evento è pieno o si è già iscritti, il dominio deve impedire una nuova iscrizione.
6. Verificare la sezione dei propri eventi e l'eventuale comando di annullamento, se disponibile all'account.

**Da collaudare:** collegamento di registrazione, vincoli sull'effettiva UI e visualizzazione dei messaggi. Il codice del dettaglio evento distingue anche l'eventuale URL esterno di registrazione: non presupporre che tutti gli eventi abbiano una prenotazione interna.

**Screenshot richiesti:** `05-login.png`, `06-profile.png`, `07-event-registration.png`, `08-my-events.png`, `09-full-event.png`.

## 5. Organizzatore / gestore eventi
*Accesso subordinato ai permessi effettivamente configurati nel pannello.*

1. Aprire **Eventi** nel pannello Filament.
2. Usare **Crea** per aprire il form evento. La lista contiene anche un'azione di importazione eventi.
3. Compilare titolo, descrizione, data/ora di inizio e fine (la fine deve essere successiva all'inizio), luogo e, se disponibile, sede strutturata.
4. Impostare stato: bozza, pubblicato o annullato. Iniziare in bozza finché i dettagli non sono definitivi.
5. Impostare una capienza massima almeno pari a 1. Il conteggio iscritti è di sola lettura e non deve essere modificato manualmente.
6. Caricare la copertina e collegare relatori e sponsor. Il form permette di creare nuove sedi, relatori e sponsor durante l'inserimento.
7. Salvare e controllare la resa della scheda pubblica.
8. In **Iscrizioni**, visualizzare nome, email, stato e data dell'iscrizione; scaricare il CSV tramite l'azione export. L'annullamento dell'iscrizione richiede conferma.
9. Per eliminare un evento, leggere la finestra di conferma: il sistema avverte quando sono presenti iscritti; la cancellazione passa da `DeleteEventAction`.

**Screenshot richiesti:** `10-admin-events.png`, `11-create-event.png`, `12-event-people.png`, `13-event-registrations.png`, `14-export-csv.png`, `15-delete-confirmation.png`.

## 6. Sedi, relatori e sponsor
Nel pannello Filament sono presenti `VenueResource`, `PerformerResource` e `SponsorResource`, ognuna con liste e pagine di creazione/modifica. Aggiungere le schede prima di associarle agli eventi, oppure crearle dal form evento. **Non sono state verificate aree personali dedicate** ai singoli relatori o sponsor.

**Screenshot richiesti:** `16-venues.png`, `17-performers.png`, `18-sponsors.png`.

## 7. Amministrazione e supervisione
Le risorse esaminate includono dashboard, riepilogo statistiche eventi, vista calendario, gestione eventi/sedi/relatori/sponsor e importazione. Verificare i permessi per l'utente di prova prima di descrivere controlli riservati. Non documentare opzioni che non compaiono effettivamente nella UI del ruolo.

**Screenshot richiesti:** `19-dashboard.png`, `20-calendar.png`, `21-import-events.png`.

## 8. Regole applicative da provare
- Evento pieno: iscrizione rifiutata.
- Iscrizione duplicata: rifiutata.
- Iscrizione confermata: una riga nella pivot e contatore incrementato una volta, in un'unica transazione.
- Una bozza dell'organizzatore è distinta da una proposta `pending`.
- Evento pubblicato visibile ai visitatori; bozze/proposte visibili al proprietario secondo `scopeVisibleTo`; il ruolo `super-admin` può vedere tutti gli eventi nello scope.
- Eliminazioni e annullamenti devono mantenere allineati iscrizioni e contatori.

## 9. Dati dimostrativi e screenshot REALI
Esistono già factories per `Event`, `EventUser`, `Performer`, `Sponsor`, `Venue`, `Profile`, `Feedback` e relativi pivot; esiste `MeetupDatabaseSeeder`, che crea sedi, relatori, sponsor ed eventi futuri/passati collegati. Il seeder corrente genera eventi «quasi pieni» e «esauriti» tramite contatori, **non risulta dal codice ispezionato che crei anche gli iscritti reali corrispondenti**: non usarli per screenshot di una lista iscritti verosimile finché la coerenza non è verificata.

Procedura obbligatoria per la documentazione definitiva:
1. Avviare una **copia isolata** dell'app, con database demo e account fittizi; non eseguire `migrate:fresh` su dati reali.
2. Verificare lo stato delle migrazioni e delle dipendenze prima di eseguire i seeder.
3. Creare account di prova per ciascun ruolo **effettivamente autorizzato**. Verificare policy, tenant e collegamenti.
4. Generare iscrizioni coerenti con capienza e contatori, eventi futuri/passati, una bozza, una proposta, un evento pieno e un evento annullato.
5. Visitare ogni pagina nel browser con sessioni distinte; catturare PNG originali della pagina renderizzata, desktop e mobile.
6. Oscurare informazioni personali, token, credenziali e dati sensibili, senza alterare il significato dei controlli.
7. Registrare per ogni immagine: URL relativo, lingua, ruolo, stato dei dati, data acquisizione e commit SHA.
8. Aggiungere solo screenshot autentici in `docs/manuale-utente/screenshots/{it,en}/`. **Non sono ancora inclusi** in questa versione.

## 10. Criteri di completamento
Il manuale è finale soltanto quando tutti i flussi sono riprodotti su build funzionante, gli screenshot autentici sono presenti, gli account demo e le factories/seeder sono verificati, i test passano e la versione PDF è generata dagli stessi contenuti Markdown.

## 11. Riferimenti di codice (branch dev)
- `laravel/Modules/Meetup/database/seeders/MeetupDatabaseSeeder.php`
- `laravel/Modules/Meetup/database/factories/`
- `laravel/Modules/Meetup/app/Filament/Resources/`
- `laravel/Modules/Meetup/app/Models/Event.php`
- `laravel/Modules/Meetup/docs/attendee-registration-domain-rules.md`
- `laravel/Themes/Meetup/resources/views/pages/`
- `laravel/Themes/Meetup/resources/views/components/blocks/events/detail.blade.php`
