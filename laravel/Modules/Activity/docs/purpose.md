---
title: "Activity — scopo del modulo e come raggiungerlo meglio"
type: concept
status: active
created: 2026-09-02
tags: [activity, purpose, audit, event-sourcing, snapshot, tracciabilita]
qmd: "activity scopo modulo audit log event sourcing snapshot stored event tracciabilita chi ha cambiato"
updated: 2026-09-02
issues:
  # DA CREARE — `gh` non autenticato: mai numeri inventati.
  # gh issue create --repo provtv/module_activity_fila5 --title "<argomento del file>"
  - "https://github.com/provtv/module_activity_fila5/issues/"
discussions:
  # DA CREARE — vedi sopra.
  - "https://github.com/provtv/module_activity_fila5/discussions/"
---

# Activity — perche' esiste

## Lo scopo in una frase

**Activity risponde alla domanda "chi ha cambiato cosa, quando e com'era prima" — che
in una pubblica amministrazione non e' curiosita', e' un obbligo.**

## L'evidenza

Il modulo tiene insieme **due meccanismi diversi**, ed e' importante non confonderli:

| Modello | Meccanismo | Domanda a cui risponde |
|---|---|---|
| `Activity` | activity log (Spatie) | "chi ha toccato questo record" |
| `StoredEvent`, `Snapshot` | event sourcing (Spatie) | "come si e' arrivati a questo stato" |

Solo 66 file PHP ma **694 documenti** in `docs/`: e' un modulo piccolo di codice e
grande di conseguenze.

## Perche' i due meccanismi non vanno fusi

- L'**activity log** e' una traccia *accanto* al dato: il dato vive per conto suo, il
  log lo osserva. Perderlo e' grave ma non distrugge lo stato.
- L'**event sourcing** e' il dato: lo stato *e'* la somma degli eventi, e lo snapshot e'
  solo un'ottimizzazione. Perdere gli eventi significa perdere tutto.

Trattarli allo stesso modo — per esempio applicando una politica di cancellazione
uniforme — e' l'errore da evitare. **Uno si puo' potare, l'altro no.**

## Come raggiungerlo **meglio**

### 1. Dichiarare quale entita' usa quale meccanismo

Oggi la scelta e' implicita nel codice. Chi entra non sa se una scheda e' event-sourced
o solo loggata, e la risposta cambia cosa e' lecito fare.

**Azione:** una tabella in `docs/` — entita' → meccanismo → motivo. Una pagina, ma
decide se un `delete` e' recuperabile.

### 2. Il log va potato con una regola dichiarata; gli eventi mai

Un activity log che cresce senza limite degrada le query e conserva dati personali
oltre il necessario. Ma **la potatura non deve poter toccare `StoredEvent`**.

**Azione:** politica di conservazione esplicita per `Activity` (quanto, e con quale
base giuridica), e un vincolo che renda impossibile applicarla agli eventi. Vale la
regola dei dati sacri: nessun comando distruttivo deciso dall'agente.

### 3. Il log deve essere leggibile da chi non legge codice

`properties` con il diff grezzo risponde a "cosa e' cambiato" solo a chi conosce lo
schema. Un responsabile deve poter leggere "il valutatore e' passato da Rossi a
Bianchi".

**Azione:** una resa leggibile per le entita' che contano davvero — schede,
valutazioni, importi. Non per tutte: per quelle che finiscono in un contraddittorio.

### 4. Il nome `Activity` collide con `Activity` di Incentivi

`Modules\Activity\Models\Activity` (traccia di sistema) e
`Modules\Incentivi\Models\Activity` (attivita' di progetto) condividono il nome e
nient'altro. In un `use` distratto la collisione e' silenziosa.

**Azione:** dichiarare la distinzione qui e nel README di entrambi i moduli; valutare
`ProjectActivity` sul lato Incentivi.

### 5. 694 documenti per 66 file di codice

Come Xot e Notify: serve un `index.md` a una schermata e un solo canonico per
argomento.

## Confini — cosa **non** appartiene ad Activity

- Il **significato** di cio' che e' cambiato: modulo di dominio.
- **Chi** e' l'autore come identita': User. Qui si registra il riferimento.
- Le **notifiche** su un cambiamento: Notify.

## Collegamenti

- `laravel/Modules/Incentivi/docs/purpose.md` — la collisione di nome
- `docs/wiki/memories/data-sacred-no-destructive-db.md`
