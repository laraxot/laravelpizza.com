---
title: "Job — scopo del modulo e come raggiungerlo meglio"
type: concept
status: active
created: 2026-09-02
tags: [job, purpose, code, import, export, fallimenti, schedule]
qmd: "job scopo modulo code queue import export failed jobs batch schedule fallimenti visibili"
updated: 2026-09-02
issues:
  # DA CREARE — `gh` non autenticato: mai numeri inventati.
  # gh issue create --repo provtv/module_job_fila5 --title "<argomento del file>"
  - "https://github.com/provtv/module_job_fila5/issues/"
discussions:
  # DA CREARE — vedi sopra.
  - "https://github.com/provtv/module_job_fila5/discussions/"
---

# Job — perche' esiste

## Lo scopo in una frase

**Job rende visibile e governabile tutto cio' che accade fuori dalla richiesta HTTP:
code, importazioni, esportazioni, lavori pianificati — e soprattutto i loro
fallimenti.**

## L'evidenza

Le Resource dicono esattamente qual e' la priorita' del modulo:

`Job`, `JobsWaiting`, `JobBatch`, `JobManager`, `Schedule`, `Import`, `Export`,
**`FailedJob`**, **`FailedImportRow`**.

Due delle nove riguardano il fallimento. Non e' un caso: **un lavoro asincrono che
fallisce in silenzio e' peggio di un lavoro che non e' mai partito**, perche' chi lo ha
richiesto crede che sia andato a buon fine.

15 Action e 2 Widget: il modulo amministra, e mostra lo stato.

## Il valore che aggiunge rispetto a Laravel nudo

Laravel ha code, batch e `failed_jobs`. Quello che non ha e' una **superficie** in cui
un funzionario — non un sistemista — possa vedere che l'importazione di ieri sera si e'
fermata alla riga 4.312 e perche'. `FailedImportRow` esiste per questo: non "l'import e'
fallito", ma **quale riga** e **quale errore**.

## Come raggiungerlo **meglio**

### 1. Il fallimento deve raggiungere chi ha chiesto il lavoro

Oggi il fallimento e' visibile a chi apre la schermata dei job. Chi ha lanciato
l'importazione non lo sa.

**Azione:** ogni lavoro porta con se' il richiedente; al fallimento definitivo parte una
notifica (via Notify). La dashboard resta per chi amministra, la notifica e' per chi
aspetta.

### 2. Un import va ripreso, non rifatto

Se un'importazione di 50.000 righe fallisce a 40.000, ripartire da zero e' costoso e
rischioso (doppie scritture).

**Azione:** con `FailedImportRow` popolata, offrire "ritenta solo le righe fallite".
Il dato per farlo c'e' gia'.

### 3. Distinguere l'errore di dato dall'errore di sistema

Una riga scartata perche' il codice fiscale e' malformato e un job fallito perche' il
database non rispondeva richiedono azioni opposte: la prima si corregge nel file, la
seconda si ritenta identica.

**Azione:** classificare il fallimento (dato / sistema / configurazione) e mostrare la
classe accanto all'errore. Senza, ogni fallimento va istruito a mano.

### 4. Un lavoro pianificato che non parte piu' deve farsi notare

`Schedule` dice cosa **dovrebbe** girare. Il caso pericoloso non e' il job che fallisce:
e' il job che smette di partire. Nessun errore, nessuna riga in `failed_jobs`, nessun
sintomo — finche' qualcuno non nota che un dato e' fermo da settimane.

**Azione:** registrare l'ultima esecuzione riuscita di ogni voce pianificata e segnalare
quando supera l'intervallo atteso. E' il controllo che nessuno scrive e che tutti
vorrebbero avere avuto.

### 5. La ritentabilita' e' una proprieta' del lavoro, non una speranza

Ritentare un'operazione non idempotente raddoppia gli effetti.

**Azione:** dichiarare per ogni lavoro se e' idempotente; per quelli che non lo sono,
una chiave di idempotenza. Prima di aggiungere `$tries`, chiedersi cosa succede se
questo lavoro gira due volte.

## Confini — cosa **non** appartiene a Job

- Il **contenuto** del lavoro: dominio. Job esegue e osserva, non sa cosa sta importando.
- L'**invio** delle notifiche: Notify.
- Le **regole di validazione** delle righe importate: modulo che possiede il dato.

## Collegamenti

- `laravel/Modules/Notify/docs/purpose.md` — per notificare i fallimenti
- `docs/wiki/rules/queueable-actions.md` — Action accodabili
