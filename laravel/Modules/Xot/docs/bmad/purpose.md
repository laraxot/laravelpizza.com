---
title: "Xot — scopo del modulo e come raggiungerlo meglio"
type: concept
status: active
created: 2026-10-06
tags: [xot, purpose, framework, base classes, contracts, filament, foundation, ereditarieta, convenzioni]
qmd: "xot scopo modulo foundation base classes traits contracts filament xotbase patterns architecture mai estendere filament direttamente"
updated: 2026-10-06
issues:
  - "https://github.com/laraxot/module_xot_fila5/issues/"
discussions:
  - "https://github.com/laraxot/module_xot_fila5/discussions/"
---

# Xot — perche' esiste

## Lo scopo in una frase

**Xot è il fondamento architetturale dell'intera piattaforma: fornisce classi base (`XotBaseModel`, `XotBaseResource`, `XotBasePage`), contract per la type-safety, e pattern riutilizzabili che tutti gli altri 17 moduli estendono.**

Nessun modulo estende Filament direttamente. Si estende `XotBaseResource`, `XotBaseListRecords`, `XotBaseWidget`, `XotBaseServiceProvider`, `XotBaseMigration`. Questa è **la** regola fondamentale del progetto, e Xot è il posto dove vive.

## L'evidenza

- `XotBaseModel`, `XotBaseResource`, `XotBasePage`, `XotBaseTable`: classi base per estensione
- `Contracts`: interfacce per type-safety obbligatoria
- **220 Action** — la più grande concentrazione del progetto. Non è logica di dominio: sono operazioni trasversali che tutti riusano (cast, export, file, moduli, traduzioni)
- 621 file PHP, 5562 documenti in `docs/` — il modulo più documentato
- **Nessun modulo deve estendere Filament/Laravel direttamente**: passa sempre da Xot

## Perche' l'ereditarieta' e non la composizione

Con venti moduli scritti da mani diverse in tempi diversi, la classe base è l'unico meccanismo che rende una convenzione **non aggirabile**. Un trait si può non usare; una classe base che devi estendere per esistere no. Il prezzo è un accoppiamento forte verso Xot; il beneficio è che una correzione fatta qui arriva a tutti senza venti pull request.

Ne discende il corollario più importante: **niente metodi `final` nelle classi base**. Un `final` in Xot non è una protezione, è un modulo verticale che non può più esprimere il proprio caso.

## Come raggiungerlo **meglio**

### 1. Il contratto va verificato, non raccomandato

La regola "mai estendere Filament direttamente" oggi vive nella documentazione e nella disciplina degli agenti. La documentazione non blocca nulla.

**Azione:** un test che scandisce `Modules/*/app/Filament/**` e fallisce se una classe estende `Filament\Resources\Resource`, `Filament\Pages\Page` o `Filament\Widgets\Widget` invece della controparte `XotBase*`.

### 2. 5562 documenti sono troppi per essere una guida

`docs/` di Xot è cresciuto fino a diventare un archivio in cui la risposta esiste ma non si trova. Il progetto ha già la cura — il pattern on-demand: bridge corti, canonico lungo, ricerca via `qmd` — ma dentro Xot non è applicata con rigore.

**Azione:** un `docs/index.md` che sia una mappa a una schermata (dieci voci, non cento), e per ogni argomento **un solo** documento canonico.

### 3. 220 Action vanno raggruppate per intenzione

Sono troppe per un elenco piatto. **Azione:** raggruppare per area (`Actions/Cast/`, `Actions/Export/`, `Actions/File/`, `Actions/Module/`) e mantenere un catalogo centralizzato.

### 4. Le convenzioni mute vanno rese rumorose

| Convenzione | Cosa succede se la si sbaglia |
|---|---|
| `XotBaseMigration` deriva il modello dal **nome del file** | la migrazione non trova il modello |
| `public_path()` è `public_html/`, non `laravel/public/` | i file si scrivono, il 404 arriva solo dal browser |
| accessor `get{X}Attribute()` senza il gemello `get{X}()` | la logica si duplica e diverge |
| visibilità di un metodo diversa dal parent | fatal error solo quando quella pagina viene aperta |

### 5. Xot deve restare agnostico

Xot è condiviso fra progetti diversi (`_bases/*`). Un riferimento a questa amministrazione dentro Xot rompe tutti gli altri.

**Azione:** un test che cerchi nomi di progetto e di ente dentro `Modules/Xot`.

## Confini — cosa **non** appartiene a Xot

- La **logica di business** di alcun dominio: ogni modulo implementa il suo
- L'**estensione di laraxot/framework**: rimane nel repository laraxot/module_xot_fila5
- Qualunque regola specifica di questa amministrazione
- Qualunque dipendenza verso un modulo verticale (Xot è foglia)

## Collegamenti

- `docs/wiki/patterns/` — pattern architetturali
- `docs/bmad/` — decisioni di design framework
- `docs/wiki/rules/fundamental-xotbase-rule.md` — mai estendere Filament direttamente
- `docs/wiki/rules/final-method-override.md` — perche' niente `final`
- `docs/wiki/memories/public-path-is-public-html.md`
