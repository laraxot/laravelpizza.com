---
title: "UI — scopo del modulo e come raggiungerlo meglio"
type: concept
status: active
created: 2026-09-02
tags: [ui, purpose, design-system, componenti, accessibilita, blade]
qmd: "ui scopo modulo design system componenti blade widget accessibilita agid coerenza visiva"
updated: 2026-09-02
issues:
  # DA CREARE — `gh` non autenticato: mai numeri inventati.
  # gh issue create --repo provtv/module_ui_fila5 --title "<argomento del file>"
  - "https://github.com/provtv/module_ui_fila5/issues/"
discussions:
  # DA CREARE — vedi sopra.
  - "https://github.com/provtv/module_ui_fila5/discussions/"
---

# UI — perche' esiste

## Lo scopo in una frase

**UI e' il vocabolario visivo condiviso: fa si' che la stessa cosa abbia lo stesso
aspetto e lo stesso comportamento in tutti i moduli, senza che nessuno debba
ricordarselo.**

## L'evidenza

- **Zero Resource, 11 Widget, 107 file PHP.** Non ha dominio: e' composto di pezzi che
  altri usano.
- 779 documenti in `docs/`: e' il quarto modulo per volume documentale. Sproporzionato
  rispetto al codice, e il segnale che qui si e' discusso molto.

## Perche' un modulo separato, e non "componenti nel tema"

Il tema decide **come appare** questo progetto. UI decide **cosa esiste** come mattone.
La distinzione conta:

- Un componente in UI e' riusabile in un altro progetto dell'ecosistema.
- Un componente nel tema e' legato a questo progetto.

Se un pezzo generico finisce nel tema, il progetto successivo lo riscrive. Se un pezzo
specifico finisce in UI, lo importa chi non lo vuole. **Il confine e' la riusabilita',
non la comodita' del momento.**

## Il criterio per estrarre un componente

Regola gia' fissata nel progetto e da tenere ferma: **si estrae solo dopo aver misurato
la duplicazione** (`grep -rl`), mai in previsione. Un componente creato per un solo
consumatore e' un'astrazione senza evidenza, e va mantenuta comunque.

Corollario verificato: una `Section` estratta senza heading di default **perde il
titolo** rispetto all'inline — regressione muta, nessun errore.

## Come raggiungerlo **meglio**

### 1. L'accessibilita' e' un requisito di legge, non una rifinitura

Un portale di pubblica amministrazione italiana e' soggetto agli obblighi di
accessibilita'. Se l'accessibilita' non e' nei componenti, va rifatta in ogni pagina —
cioe' non si fa.

**Azione:** ogni componente dichiara nel proprio doc il comportamento con tastiera, i
ruoli ARIA e il contrasto. E un test automatico di contrasto sui token di colore. E'
il contributo piu' alto che questo modulo puo' dare al progetto.

### 2. Serve una vetrina, non solo la documentazione

779 documenti e nessun posto dove **vedere** i componenti. Chi deve scegliere apre il
codice, non trova, e ne scrive uno nuovo: e' cosi' che nasce la duplicazione che il
modulo dovrebbe evitare.

**Azione:** una pagina catalogo (anche una Folio protetta) che renda ogni componente
nei suoi stati: normale, con errore, disabilitato, vuoto, in caricamento.

### 3. Gli stati "brutti" vanno progettati una volta per tutte

Vuoto, errore, caricamento, permesso negato: sono gli stati che ogni modulo reinventa
peggio.

**Azione:** un componente per ciascuno, e la regola che nessuna schermata li scriva a
mano. La qualita' percepita di un gestionale si misura li', non sul caso felice.

### 4. La parita' Forms ↔ Tables vale anche qui

La regola nata in Ptv — a ogni componente di form corrisponde una colonna che mostra lo
stesso concetto — e' una regola di **vocabolario**, e il vocabolario e' questo modulo.

**Azione:** dove UI offre un componente di input per un concetto ricorrente, offrire
anche la colonna corrispondente.

### 5. La documentazione va ridotta per essere usata

Come Xot, Notify e Activity: un `index.md` a una schermata, un canonico per argomento.

## Confini — cosa **non** appartiene a UI

- Il **tema** e le scelte cromatiche di questo progetto: `Themes/`.
- Qualunque **regola di dominio**. Un componente che sa cos'e' una scheda non e' un
  componente di UI: e' un componente di Ptv.
- Le **classi base Filament**: Xot.

## Collegamenti

- `laravel/Modules/Ptv/docs/form-column-parity.md` — la parita' come regola
- `docs/wiki/rules/filament-form-components-vocabulary.md` — quando estrarre
- `./architecture.md` — architettura tecnica del modulo (componenti, Filament, Blocks)
