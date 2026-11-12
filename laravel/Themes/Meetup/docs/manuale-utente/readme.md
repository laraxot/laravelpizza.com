# Manuale d'uso di Laravel Pizza Meetups

Benvenuto! Questo manuale spiega, passo per passo e senza dare nulla per scontato, come usare il sito **Laravel Pizza Meetups**: il posto dove gli sviluppatori Laravel trovano i meetup, si iscrivono e si incontrano davanti a una pizza.

Non serve essere esperti di computer. Ogni capitolo ha delle **immagini prese dal sito vero**: i riquadri gialli con il numero indicano esattamente dove cliccare, e i passi del testo usano gli stessi numeri.

## Versione PDF da stampare o inviare

- [Manuale completo (PDF)](pdf/manuale-completo.pdf)
- Solo il capitolo che ti serve: [Visitatore](pdf/01-visitatore.pdf) · [Partecipante](pdf/02-partecipante.pdf) · [Organizzatore](pdf/03-organizzatore.pdf)

## Chi sei? Scegli il tuo capitolo

Il sito ha tre tipi di utente. Ognuno vede cose diverse e può fare cose diverse.

| Tipo di utente | Chi è | Cosa può fare | Capitolo |
|---|---|---|---|
| **Visitatore** | Chiunque apra il sito, senza account | Guardare e cercare gli eventi, vedere quelli passati, aggiungerli al calendario, cambiare lingua, scrivere agli organizzatori | [1. Visitatore](01-visitatore.md) |
| **Partecipante** | Chi si è registrato con email e password | Tutto quello del visitatore, più: iscriversi agli eventi (con email di conferma e promemoria), annullare l'iscrizione, vedere "I miei eventi", gestire il profilo | [2. Partecipante](02-partecipante.md) |
| **Organizzatore** | Chi ha ricevuto dall'amministratore il permesso di gestire gli eventi | Entrare nel pannello di amministrazione, creare, pubblicare, modificare ed eliminare eventi; gestire sedi, relatori e sponsor; vedere e scaricare gli iscritti | [3. Organizzatore](03-organizzatore.md) |

Se non sai quale sei: se non hai mai creato un account sei un **Visitatore**. Se hai un account sei un **Partecipante**. Diventi **Organizzatore** solo se un amministratore te lo ha detto.

## Parole che incontrerai

- **Evento** (o *meetup*): un incontro con data, ora, luogo e un numero massimo di posti.
- **Iscriversi**: prenotare il proprio posto a un evento. È gratis.
- **Posti disponibili** (o *capienza*): quante persone possono partecipare. Quando sono finiti, l'evento mostra "Posti esauriti".
- **Account**: il tuo profilo sul sito, protetto da email e password.
- **Pannello di amministrazione**: la parte riservata agli organizzatori, a un indirizzo diverso dal sito pubblico.

## Domande frequenti

**Quanto costa?** Niente. Iscriversi al sito e agli eventi è gratuito.

**Ho dimenticato la password.** Nella pagina "Accedi" clicca su "Password dimenticata?" e segui le istruzioni che ricevi per email (vedi il [capitolo 2](02-partecipante.md#hai-dimenticato-la-password)).

**Ho aperto un link e vedo "Pagina non trovata".** L'indirizzo è sbagliato o la pagina non esiste più (per esempio un evento cancellato). Usa i pulsanti della pagina per tornare agli eventi o alla home.

**Non vedo il pulsante "Iscriviti".** Hai fatto l'accesso? Se no, il pulsante si chiama "Accedi per iscriverti". Se l'evento è pieno o già iniziato, l'iscrizione è chiusa.

**Posso cercare gli eventi vicino a me?** Sì: nella pagina Eventi scegli la tua città nella ricerca (vedi il [capitolo 1](01-visitatore.md#13-cercare-per-città-o-per-data)).

**Come metto l'evento nel calendario?** Nella pagina dell'evento clicca "Aggiungi al calendario", oppure apri l'allegato dell'email di conferma.

**Ho cliccato "Iscriviti" ma non è arrivata l'email.** Controlla la cartella spam. La tua iscrizione vale comunque: la trovi in "I miei eventi".

## Note per chi mantiene il manuale

- Le immagini sono in [`img/`](img/) e vanno rifatte quando l'interfaccia cambia. Sono state catturate su un'installazione locale con dati dimostrativi (persone ed eventi inventati), non dal sito in produzione.
- I PDF in [`pdf/`](pdf/) si generano dai `.md` con `node build-pdf.mjs` (richiede pandoc e Playwright). Dopo ogni modifica al testo o agli screenshot rigenera i PDF e committa `.md` e `.pdf` insieme.
- Nomi file: `v` = visitatore, `p` = partecipante, `o` = organizzatore, seguiti dal numero d'ordine.
