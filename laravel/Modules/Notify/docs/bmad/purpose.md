---
title: "Notify: scopo del modulo e come raggiungerlo meglio"
type: concept
created: 2026-09-02
tags: [notify, purpose, notifiche, template, canali, comunicazione]
qmd: "notify scopo modulo notifiche template canali email sms comunicazione tracciabilita"
updated: 2026-09-02
issues:
  # DA CREARE: `gh` non autenticato: mai numeri inventati.
  # gh issue create --repo provtv/module_notify_fila5 --title "<argomento del file>"
  - "https://github.com/provtv/module_notify_fila5/issues/"
discussions:
  # DA CREARE: vedi sopra.
  - "https://github.com/provtv/module_notify_fila5/discussions/"
status: superseded
superseded_by: ../purpose.md
---

# Notify: perche' esiste

## Lo scopo in una frase

**Notify e' il solo punto da cui la piattaforma parla con una persona: separa il
*fatto* che qualcosa e' accaduto dal *come* glielo si dice.**

## L'evidenza

- 232 file PHP, **46 Action**, zero Widget: e' un modulo di servizio, non una
  schermata.
- `NotificationTemplate`, `MailTemplate`, `NotifyTheme`: il testo e l'aspetto sono
  **dati**, non codice. Cambiare una comunicazione non deve richiedere un deploy.
- `Contact`: a chi si scrive e' un'entita', non una stringa dentro un modello.

## Perche' e' piu' importante di quanto sembri

In una pubblica amministrazione la comunicazione **e' parte del provvedimento**. Una
valutazione non comunicata non produce effetti; un termine decorre dalla
comunicazione, non dalla decisione. Il modulo che spedisce non e' accessorio: e'
l'ultimo anello di una catena giuridica.

Ne discende il requisito centrale: **tracciabilita'**. Non "abbiamo provato a
inviare", ma cosa e' partito, a chi, quando, con quale testo.

## Come raggiungerlo **meglio**

### 1. Il testo inviato va congelato al momento dell'invio

Se una comunicazione rimanda al template e il template poi cambia, rileggendo la
comunicazione di sei mesi fa si legge il testo di oggi. Il passato viene riscritto in
silenzio.

**Azione:** salvare il **corpo renderizzato** insieme all'invio, non solo il
riferimento al template. Lo spazio costa poco; la ricostruibilita' vale un
contenzioso.

### 2. Un invio fallito deve essere visibile a chi ha deciso

Le code assorbono i fallimenti: il messaggio va in `failed_jobs` e la persona che ha
firmato non lo sa. Il caso peggiore e' silenzioso: nessuno si accorge che la
comunicazione non e' partita.

**Azione:** stato dell'invio (in coda / inviato / fallito / rimbalzato) leggibile
accanto al provvedimento, non solo nella dashboard delle code. Integrazione con il
modulo Job, che gia' possiede `FailedJob` e `FailedImportRow`.

### 3. 3073 documenti in `docs/` sono un archivio, non una guida

E' il secondo modulo per volume documentale del progetto, dietro Xot. La stessa cura
vale qui: un `index.md` a una schermata, un solo canonico per argomento, il resto
collegato o marcato superseded.

Questo modulo ospitava anche coppie di file che differivano **solo per maiuscole**
(`AGENTS.md`/`agents.md`, `QUICK-REFERENCE.md`/`quick-reference.md`,
`SESSION-SUMMARY.md`/`session-summary.md`), risolte il 2026-09-02: rompevano il
checkout su macOS e Windows.

### 4. I template vanno versionati e validati

Un template con un segnaposto scritto male non fallisce: **spedisce il segnaposto**.
`{{ nome }}` diventa testo visibile nella lettera a un cittadino.

**Azione:** validazione dei segnaposto contro i dati disponibili prima del salvataggio,
e un'anteprima con dati di esempio. Il controllo va fatto quando si scrive il template,
non quando si invia.

### 5. Il canale non deve essere una scelta del chiamante

Se ogni modulo decide "mando una mail", il giorno in cui serve anche una PEC o un SMS
si cambiano venti punti.

**Azione:** il dominio dichiara l'**evento** ("scheda approvata"), Notify decide i
canali in base alla configurazione e alle preferenze del destinatario.

## Confini: cosa **non** appartiene a Notify

- La **decisione** che genera la comunicazione: modulo di dominio.
- **Chi** e' il destinatario come identita': User.
- L'**esecuzione asincrona**: Job.

## Collegamenti

- `laravel/Modules/Job/docs/purpose.md`: code e fallimenti
- `laravel/Modules/User/docs/purpose.md`: destinatari e preferenze
