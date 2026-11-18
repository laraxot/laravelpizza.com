# Manuale d'uso di Laravel Pizza Meetups

Benvenuto! Questo manuale spiega, passo per passo e senza dare nulla per scontato, come usare il sito **Laravel Pizza Meetups**: il posto dove gli sviluppatori Laravel trovano i meetup, si iscrivono e si incontrano davanti a una pizza.

Non serve essere esperti di computer. Ogni capitolo ha delle **immagini prese dal sito vero**: i riquadri gialli con il numero indicano esattamente dove cliccare, e i passi del testo usano gli stessi numeri.

## Versione PDF da stampare o inviare

- [Manuale completo (PDF)](pdf/manuale-completo.pdf)
- Solo il capitolo che ti serve: [Visitatore](pdf/01-visitatore.pdf) · [Partecipante](pdf/02-partecipante.pdf) · [Organizzatore](pdf/03-organizzatore.pdf) · [Amministratore](pdf/04-amministratore.pdf)

## Chi sei? Scegli il tuo capitolo

Il sito ha quattro tipi di utente. Ognuno vede cose diverse e può fare cose diverse.

| Tipo di utente | Chi è | Cosa può fare | Capitolo |
|---|---|---|---|
| **Visitatore** | Chiunque apra il sito, senza account | Guardare e cercare gli eventi, vedere quelli passati, aggiungerli al calendario, cambiare lingua, scrivere agli organizzatori | [1. Visitatore](01-visitatore.md) |
| **Partecipante** | Chi ha un account (anche creato iscrivendosi a un evento, con sola email e password) | Tutto quello del visitatore, più: iscriversi agli eventi (con email di conferma e promemoria), annullare l'iscrizione, vedere "I miei eventi", gestire il profilo | [2. Partecipante](02-partecipante.md) |
| **Organizzatore** | Chi ha ricevuto dall'amministratore il permesso di gestire gli eventi | Entrare nel pannello di amministrazione, creare, pubblicare, modificare ed eliminare eventi; gestire sedi, relatori e sponsor; vedere e scaricare gli iscritti | [3. Organizzatore](03-organizzatore.md) |
| **Amministratore** | Chi gestisce il sito (ruolo super-admin) | Tutto quello dell'organizzatore, più: dare e togliere il ruolo di organizzatore, controllare gli account, le impostazioni e i pannelli tecnici | [4. Amministratore](04-amministratore.md) |

Se non sai quale sei: se non hai mai creato un account sei un **Visitatore**. Se hai un account sei un **Partecipante**. Diventi **Organizzatore** solo se un amministratore ti ha dato il permesso; gli **Amministratori** sono una o due persone, che lo sanno già.

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

**Come mi iscrivo a un evento se non ho un account?** Apri l'evento: nel riquadro **Partecipa ora** scrivi email e password, spunta la privacy e clicca **Iscriviti all'evento**. L'account si crea in quel momento (vedi il [capitolo 2](02-partecipante.md#21-iscriversi-a-un-evento-in-un-solo-passo)).

**Non vedo il pulsante "Iscriviti".** Se l'evento è pieno, già iniziato o concluso, l'iscrizione è chiusa; se sei già iscritto vedi "Annulla iscrizione" (vedi il [capitolo 2](02-partecipante.md#28-quando-non-puoi-iscriverti)).

**La mia password viene rifiutata.** Deve avere almeno 12 caratteri, con lettere maiuscole e minuscole, un numero e un simbolo, e non deve essere tra quelle finite in furti di dati noti.

**Posso cercare gli eventi vicino a me?** Sì: nella pagina Eventi scegli la tua città nella ricerca (vedi il [capitolo 1](01-visitatore.md#13-cercare-per-città-o-per-data)).

**Come metto l'evento nel calendario?** Nella pagina dell'evento clicca "Aggiungi al calendario", oppure apri l'allegato dell'email di conferma.

**Ho cliccato "Iscriviti" ma non è arrivata l'email.** Controlla la cartella spam. La tua iscrizione vale comunque: la trovi in "I miei eventi".

## Note per chi mantiene il manuale

- Le immagini sono in [`img/`](img/) e vanno rifatte quando l'interfaccia cambia. Sono state catturate su un'installazione locale con dati dimostrativi (persone ed eventi inventati), non dal sito in produzione.
- Gli screenshot si rifanno con gli script in [`tools/`](tools/), su un database demo con dati inventati:
  1. da `laravel/`: `sh Themes/Meetup/docs/manuale-utente/tools/reset-demo.sh` (si rifiuta di girare se il database non ha "demo" nel nome);
  2. da `laravel/`: `php Themes/Meetup/docs/manuale-utente/tools/render-mail.php $PWD /tmp/mail.html` (l'email di conferma, p08);
  3. da `laravel/Themes/Meetup`: `node docs/manuale-utente/tools/capture.cjs docs/manuale-utente/img /tmp/mail.html`. Alla fine stampa "Tutti i riquadri trovati"; altrimenti l'interfaccia è cambiata e il riquadro va corretto nello script.
- I PDF in [`pdf/`](pdf/) si generano dai `.md` con `node build-pdf.mjs` (richiede pandoc e Playwright). Dopo ogni modifica al testo o agli screenshot rigenera i PDF e committa `.md` e `.pdf` insieme.
- Nomi file: `v` = visitatore, `p` = partecipante, `o` = organizzatore, `a` = amministratore, seguiti dal numero d'ordine.
