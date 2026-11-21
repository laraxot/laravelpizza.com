---
title: "Xot — scopo del modulo e come raggiungerlo meglio"
type: concept
status: active
created: 2026-09-02
tags: [xot, purpose, framework, xotbase, ereditarieta, convenzioni]
qmd: "xot scopo modulo framework base xotbase ereditarieta convenzioni mai estendere filament direttamente"
updated: 2026-09-02
issues:
  # DA CREARE — `gh` non autenticato: mai numeri inventati.
  # gh issue create --repo provtv/module_xot_fila5 --title "<argomento del file>"
  - "https://github.com/provtv/module_xot_fila5/issues/"
discussions:
  # DA CREARE — vedi sopra.
  - "https://github.com/provtv/module_xot_fila5/discussions/"
---

# Xot — perche' esiste

## Lo scopo in una frase

**Xot e' il framework di questo ecosistema: non risolve un problema del dominio,
stabilisce come tutti gli altri moduli risolvono i loro.**

Nessun modulo estende Filament direttamente. Si estende `XotBaseResource`,
`XotBaseListRecords`, `XotBaseWidget`, `XotBaseServiceProvider`, `XotBaseMigration`.
Questa e' **la** regola fondamentale del progetto, e Xot e' il posto dove vive.

## L'evidenza

- **220 Action** — la piu' grande concentrazione del progetto. Non e' logica di
  dominio: sono le operazioni trasversali che tutti riusano (cast, export, file,
  moduli, traduzioni).
- 621 file PHP, 5562 documenti in `docs/`. E' il modulo piu' documentato, e deve
  esserlo: e' quello che gli altri leggono per sapere come si fa una cosa.
- Le Resource (`Cache`, `CacheLock`, `Session`, `Log`, `Module`, `Extra`) sono
  strumenti di servizio: Xot amministra il sistema, non l'ente.

## Perche' l'ereditarieta' e non la composizione

E' una scelta esplicita e vale la pena difenderla, perche' contraddice un consiglio
generico ("preferisci composizione a ereditarieta'"):

Con venti moduli scritti da mani diverse in tempi diversi, la classe base e' l'unico
meccanismo che rende una convenzione **non aggirabile**. Un trait si puo' non usare;
una classe base che devi estendere per esistere no. Il prezzo e' un accoppiamento
forte verso Xot; il beneficio e' che una correzione fatta qui arriva a tutti senza
venti pull request.

Ne discende il corollario piu' importante: **niente metodi `final` nelle classi base**.
Un `final` in Xot non e' una protezione, e' un modulo verticale che non puo' piu'
esprimere il proprio caso.

## Come raggiungerlo **meglio**

### 1. Il contratto va verificato, non raccomandato

La regola "mai estendere Filament direttamente" oggi vive nella documentazione e nella
disciplina degli agenti. La documentazione non blocca nulla.

**Azione:** un test che scandisce `Modules/*/app/Filament/**` e fallisce se una classe
estende `Filament\Resources\Resource`, `Filament\Pages\Page` o `Filament\Widgets\Widget`
invece della controparte `XotBase*`. La regola piu' importante del progetto merita la
guardia piu' semplice.

### 2. 5562 documenti sono troppi per essere una guida

`docs/` di Xot e' cresciuto fino a diventare un archivio in cui la risposta esiste ma
non si trova. Il progetto ha gia' la cura — il pattern on-demand: bridge corti,
canonico lungo, ricerca via `qmd` — ma dentro Xot non e' applicata con rigore.

**Azione:** un `docs/index.md` che sia una mappa a una schermata (dieci voci, non
cento), e per ogni argomento **un solo** documento canonico. Il resto o si collega o si
marca superseded. Un secondo brain che non risponde in tre ricerche non e' un secondo
brain.

### 3. 220 Action vanno raggruppate per intenzione

Sono troppe per un elenco piatto: chi cerca "come esporto una collezione" non sa dove
guardare, e il rischio concreto e' che ne nasca una duplicata.

**Azione:** raggruppare per area (`Actions/Cast/`, `Actions/Export/`, `Actions/File/`,
`Actions/Module/`) — in parte gia' cosi' — e mantenere in `docs/actions-catalog.md`
l'elenco con una riga di scopo per ciascuna. Prima di scrivere una Action in Xot, si
cerca li'.

### 4. Le convenzioni mute vanno rese rumorose

Il progetto ha una famiglia di errori che non producono ne' eccezioni ne' log:

| Convenzione | Cosa succede se la si sbaglia |
|---|---|
| `XotBaseMigration` deriva il modello dal **nome del file** | la migrazione non trova il modello |
| `public_path()` e' `public_html/`, non `laravel/public/` | i file si scrivono, il 404 arriva solo dal browser |
| accessor `get{X}Attribute()` senza il gemello `get{X}()` | la logica si duplica e diverge |
| visibilita' di un metodo diversa dal parent | fatal error solo quando quella pagina viene aperta |

Alcune hanno gia' una guardia (`php artisan xot:check-accessor-twins`,
`PublicPathTest`). **Azione:** completare la copertura — ogni convenzione muta o ha un
comando di verifica, o non e' una convenzione: e' una speranza.

### 5. Xot deve restare agnostico

Xot e' condiviso fra progetti diversi (`_bases/*`). Un riferimento a questa
amministrazione dentro Xot rompe tutti gli altri.

**Azione:** un test che cerchi nomi di progetto e di ente dentro `Modules/Xot`. Il
placeholder `<nome progetto>` presente in molta documentazione e' il sintomo di questa
tensione: va sostituito da `config()`, non da un altro nome fisso.

## Confini — cosa **non** appartiene a Xot

- Qualunque regola specifica di questa amministrazione.
- Qualunque modello del dominio del personale.
- Qualunque dipendenza verso un modulo verticale. Xot e' foglia: tutti dipendono da
  lui, lui da nessuno.

## Collegamenti

- `docs/wiki/rules/fundamental-xotbase-rule.md` — mai estendere Filament direttamente
- `docs/wiki/rules/final-method-override.md` — perche' niente `final`
- `docs/wiki/memories/public-path-is-public-html.md`
