---
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "notify mail layout shared with theme.story"
issues: []
discussions: []
title: Layout HTML mail "puliti" (senza header/footer) di Notify invisibili nel tab Inviti
epic: null
story: null
status: done
module: Notify
date: 2026-09-22
---

# Story: Layout mail condivisi tra modulo Notify e tema attivo

## Fase BMAD
Plan (proposta di design, non ancora implementata: nessun file `.php` toccato).

## Contesto

Il campo `html_layout_path` sul tab "Inviti" (`ManageMailTemplates`, es.
`quaeris/admin/ats/survey-pdfs/48/mail-templates`) è una select
(`HtmlLayoutPathSelect`) che elenca i file `.html` trovati in una sola cartella:

```
Themes/<tema attivo>/resources/mail-layouts/
```

risolta da `XotData::getMailHtmlLayoutPath()`
(`laravel/Modules/Xot/app/Datas/XotData.php`). Oggi, per il tema `Zero`, contiene
solo due layout **con header e footer** (`base.html`,
`christmas-professional.html`).

Esiste già un layout "pulito" (nessun header/footer, solo un contenitore
centrato attorno al placeholder `{{{ body }}}`, con dark-mode e responsive
inclusi):

```
Modules/Notify/resources/mail-layouts/base/default.html
```

Non compare nella select per due motivi cumulativi:

1. **Cartella sbagliata**: `getMailHtmlLayoutPath()` guarda solo la cartella del
   tema attivo, mai `Modules/Notify/resources/mail-layouts/`.
2. **Non ricorsiva**: `HtmlLayoutPathSelect::setUp()` usa `File::files()` (non
   `File::allFiles()`), quindi anche spostando il file dentro il tema, se
   restasse in una sottocartella (`base/`) non verrebbe comunque visto.

La stessa funzione (`getMailHtmlLayoutPath()`) è usata anche da
`SpatieEmail::getHtmlLayout()` al momento dell'invio reale: qualunque fix deve
tenere allineati **select** (cosa si può scegliere) e **lettura** (cosa viene
davvero incluso nella mail), altrimenti si sceglie un layout che poi non si
legge.

## Opzioni valutate

1. **Duplicare il file** dentro il tema (`Themes/Zero/resources/mail-layouts/`).
   Scartata: due copie dello stesso layout da tenere manualmente allineate,
   nessuna garanzia che restino identiche nel tempo.
2. **Comando "publish"** (pattern `vendor:publish` di Laravel): copia i layout
   di Notify nel tema on-demand. Valida, ma introduce un passo manuale da
   ricordare a ogni deploy/nuovo tema.
3. **Ricerca su più cartelle** (raccomandata): `XotData` espone una lista di
   cartelle (tema attivo + `Modules/Notify/resources/mail-layouts/`);
   `HtmlLayoutPathSelect` le scansiona entrambe con `File::allFiles()`
   (ricorsivo, path relativo come valore/etichetta per evitare collisioni tipo
   `base.html` vs `base/default.html`); `SpatieEmail::getHtmlLayout()` prova le
   stesse cartelle in ordine finché trova il file. Nessuna duplicazione,
   retrocompatibile con i valori già salvati (`base.html` continua a risolversi
   nel tema, che resta il primo in lista).

## Impatto se non risolto

Il layout "pulito" resta inutilizzabile da admin, nonostante esista e sia
pronto: per ottenerlo oggi l'unica via visibile è copiare il file dentro il
tema, cosa che il richiedente ha esplicitamente rifiutato di fare per non
duplicare contenuto.

## Workaround temporaneo applicato (2026-09-22)

In attesa della risposta del team (discussion collegata), si è scelto di
**duplicare** il file invece di aspettare l'implementazione dell'opzione 3:

```
Themes/Zero/resources/mail-layouts/clean.html
```

è una copia letterale di `Modules/Notify/resources/mail-layouts/base/default.html`,
con un commento HTML in testa che rimanda a questa story/issue/discussion e
avverte che va rimosso quando l'opzione 3 sarà implementata. **Fino ad
allora, ogni modifica al layout "pulito" va fatta in entrambi i file.**

Verificato (2026-09-22) che `clean.html` compare correttamente tra le opzioni
scansionate da `HtmlLayoutPathSelect` (simulazione diretta della sua logica via
tinker: `base.html`, `christmas-professional.html`, `clean.html`).

Da provare dal vivo: `notify/admin/test/send-spatie-email-page` (pagina Test
del modulo Notify): permette di scegliere/creare un `MailTemplate` con
`html_layout_path = clean.html` e inviare una mail di prova per vedere
l'invio reale senza header/footer.

## Decisione del team (2026-09-22)

Il team ha risposto sulla discussion: **duplicazione consentita** in questo
caso specifico, perché si tratta di un file HTML statico (nessuna logica,
nessun comportamento programmato): non ricade nel principio DRY nello stesso
modo di codice duplicato. `clean.html` resta quindi definitivo, non un
workaround temporaneo: **non va rimosso**, e l'opzione 3 (ricerca su più
cartelle) non verrà implementata per questo caso.

Story chiusa. Issue e discussion collegate chiuse di conseguenza.

## Prossimi passi (storico, non più attivi)

- [x] Decidere l'opzione: deciso: duplicazione, vedi sopra
- [ ] ~~Se opzione 3: modificare 3 file...~~: non applicabile, opzione 3 scartata
- [ ] Verifica manuale via `notify/admin/test/send-spatie-email-page` con
      `html_layout_path = clean.html`: resta valida come verifica funzionale,
      indipendente dalla decisione
- [ ] ~~Aggiungere test: select mostra `default.html`...~~: non applicabile,
      `default.html` resta solo il sorgente di riferimento in Notify, non
      un'opzione da esporre in select

## Riferimenti
- [HtmlLayoutPathSelect.php](../../app/Filament/Forms/Components/HtmlLayoutPathSelect.php)
- [SpatieEmail.php](../../app/Emails/SpatieEmail.php)
- [XotData.php](../../../Xot/app/Datas/XotData.php)
- [default.html (layout pulito gia' esistente)](../../resources/mail-layouts/base/default.html)
