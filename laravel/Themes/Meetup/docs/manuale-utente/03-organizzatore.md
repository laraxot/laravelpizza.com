# 3. Organizzatore: creare e gestire gli eventi

[← Torna all'indice](readme.md)

Sei un **organizzatore** quando un amministratore ha dato al tuo account il permesso di gestire gli eventi. Gli eventi non si creano dal sito pubblico ma dal **pannello di amministrazione**, una zona riservata con un indirizzo diverso: aggiungi `/meetup/admin` all'indirizzo del sito (per esempio `https://laravelpizza.com/meetup/admin`).

> Non vedi il pannello, o ricevi "Accesso negato"? Il tuo account non ha ancora il permesso: chiedilo all'amministratore del sito.

## 3.1 Entrare nel pannello

![Pagina di accesso al pannello](img/o01-login-admin.jpg)

1. Scrivi la tua **email** (la stessa del sito).
2. Scrivi la tua **password**.
3. Clicca **Accedi**.

## 3.2 La bacheca

Dopo l'accesso vedi la bacheca con i numeri principali: quanti eventi, quanti iscritti, i prossimi appuntamenti.

![La bacheca del pannello](img/o02-dashboard.jpg)

1. Nel menu a sinistra, **Eventi** apre l'elenco completo.

## 3.3 L'elenco degli eventi

![Elenco eventi nel pannello](img/o03-lista-eventi.jpg)

1. **Nuovo**: crea un evento.

In alto trovi i riquadri riassuntivi, sotto la tabella con tutti gli eventi (anche le bozze, che il pubblico non vede):

![La tabella degli eventi](img/o04-lista-eventi-schede.jpg)

## 3.4 Creare un evento

Clicca **Nuovo**. Si apre il modulo.

![Modulo di creazione evento](img/o05-nuovo-evento.jpg)

Compila i campi principali:

- **Titolo**: breve e chiaro, è la prima cosa che le persone leggono.
- **Descrizione**: di cosa si parla, a chi è rivolto, cosa portare.
- **Inizio** e **Fine**: data e ora. La fine deve venire dopo l'inizio.
- **Città o luogo**.
- **Posti disponibili** (riquadro 1): quante persone possono iscriversi. È **obbligatorio** e deve essere almeno 1.

Se dimentichi i posti disponibili, il sito non salva: il campo resta evidenziato e compare un avviso che chiede di compilarlo.

![Errore: posti disponibili mancanti](img/o06-errore-capienza.jpg)

## 3.5 Pubblicare

Un evento nuovo nasce come **bozza**: lo vedi solo tu. Per mostrarlo a tutti:

![Scelta della pubblicazione e pulsante Salva](img/o07-pubblica-e-salva.jpg)

1. In **Pubblicazione** scegli **Pubblicato**.
2. Clicca **Salva**.

Il sito conferma con il messaggio **Salvato** in alto a destra e ti riporta all'elenco, dove il nuovo evento è già in tabella:

![Evento salvato](img/o08-evento-salvato.jpg)

Da questo momento l'evento compare nell'elenco pubblico e le persone possono iscriversi. Il numero di iscritti si aggiorna da solo: non puoi modificarlo a mano.

## 3.6 Modificare o eliminare un evento

Dall'elenco eventi clicca sull'evento da cambiare. Modifica quello che serve e clicca **Salva**.

![Pagina di modifica evento con il pulsante Elimina](img/o09-modifica-evento.jpg)

1. **Elimina** cancella l'evento.

Prima di eliminare, il sito chiede conferma e ti avvisa se ci sono persone iscritte:

![Finestra di conferma dell'eliminazione](img/o10-conferma-eliminazione.jpg)

> Attenzione: l'eliminazione cancella anche tutte le iscrizioni a quell'evento e non si può annullare. Se l'evento è solo rinviato, è meglio cambiare la data invece di eliminarlo.

## Consigli pratici

- Prepara l'evento come **bozza**, ricontrollalo e pubblicalo solo quando è completo.
- Imposta i posti disponibili in base alla sala vera: il sito chiude da solo le iscrizioni quando sono finiti.
- Se cambi data o luogo dopo la pubblicazione, avvisa gli iscritti: il sito oggi non manda un'email automatica per le modifiche.
