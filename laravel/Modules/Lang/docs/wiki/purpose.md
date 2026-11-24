---
title: "Lang — scopo del modulo e come raggiungerlo meglio"
type: concept
status: active
created: 2026-09-02
tags: [lang, purpose, traduzioni, label, filament, chiavi]
qmd: "lang scopo modulo traduzioni label placeholder helper text filament chiavi mancanti fallback"
updated: 2026-09-02
issues:
  # DA CREARE — `gh` non autenticato: mai numeri inventati.
  # gh issue create --repo provtv/module_lang_fila5 --title "<argomento del file>"
  - "https://github.com/provtv/module_lang_fila5/issues/"
discussions:
  # DA CREARE — vedi sopra.
  - "https://github.com/provtv/module_lang_fila5/discussions/"
---

# Lang — perche' esiste

## Lo scopo in una frase

**Lang tiene fuori dal codice ogni parola che un utente legge: nessuna etichetta si
scrive dentro una classe, si dichiara in un file di lingua.**

## L'evidenza

- `LangBase`, `TranslationFile`: i file di traduzione sono **gestibili**, non solo
  presenti su disco.
- 14 Action, 1 Widget, 62 file PHP — e **704 documenti** in `docs/`.

Quel rapporto (62 file di codice, 704 di documentazione) e' il segnale piu' onesto del
modulo: il problema che risolve e' fatto di regole e convenzioni molto piu' che di
codice.

## La regola che genera tutto il resto

In questo progetto e' **vietato** usare `->label()`, `->placeholder()` e
`->helperText()` nelle classi Filament. Il testo si risolve per convenzione dalla
chiave del campo nel file di lingua del modulo.

Non e' pedanteria. Tre conseguenze concrete:

1. Un'etichetta scritta inline e' invisibile a chi cura le traduzioni.
2. La stessa cosa finisce chiamata in due modi in due schermate.
3. Nessuno puo' rivedere i testi senza toccare il codice — e in una PA i testi li
   rivede chi non programma.

E' anche il motivo per cui gli array di `getFormSchema()` sono **associativi**: la
chiave e' il ponte verso la traduzione. Rinominarla o passare a `array_values()` rompe
l'etichetta senza rompere il codice.

## Come raggiungerlo **meglio**

### 1. Una chiave mancante deve fallire in sviluppo e ripiegare in produzione

Oggi una chiave assente si manifesta come la chiave stessa stampata a video
(`ptv.scheda.fields.dal`). E' brutto ma non blocca: quindi arriva in produzione.

**Azione:** in ambiente di sviluppo e nei test, chiave mancante = eccezione. In
produzione, fallback leggibile. Il momento giusto per accorgersene e' quando si scrive
il campo.

### 2. Serve un comando che elenchi le chiavi mancanti e quelle orfane

**Azione:** `php artisan lang:audit {modulo}` che confronti le chiavi usate nel codice
con quelle definite, in entrambe le direzioni. Le orfane sono debito; le mancanti sono
bug visibili all'utente.

### 3. La struttura dei file di lingua e' una convenzione: va verificata

Il progetto ha una struttura attesa (per modulo, per risorsa, con `fields`, `actions`,
`navigation`). Se un modulo devia, le etichette non si risolvono e nessuno capisce
perche'.

**Azione:** un test che validi la forma dei file `lang/` di ogni modulo. E' la stessa
famiglia di guardie di `xot:check-accessor-twins`.

### 4. Italiano prima di tutto, ma le chiavi in inglese

Le chiavi e i nomi di file restano in inglese — e' la regola di naming del progetto —
mentre i valori sono in italiano, che e' la lingua dell'amministrazione. Confondere i
due piani produce chiavi come `scheda.campi.data_inizio`, che nessun modulo condiviso
puo' riusare.

### 5. 704 documenti per 62 file di codice

Come Xot, Notify, Activity e UI: `index.md` a una schermata, un canonico per argomento.
Questo modulo, che esiste per rendere le parole gestibili, e' quello che ne ha di piu'
fuori controllo.

## Confini — cosa **non** appartiene a Lang

- I **testi delle comunicazioni** verso i cittadini: Notify (sono template con dati,
  non etichette di interfaccia).
- La **localizzazione di numeri e date** nella logica: dominio.
- Le **classi base Filament**: Xot.

## Collegamenti

- `docs/wiki/rules/no-filament-labels.md` — il divieto e il perche'
- `docs/wiki/rules/filament-table-columns-array-keys.md` — chiavi associative
