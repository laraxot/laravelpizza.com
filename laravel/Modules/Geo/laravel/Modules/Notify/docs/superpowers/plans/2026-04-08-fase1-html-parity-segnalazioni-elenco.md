# FASE 1 — HTML Parity 90% (segnalazioni-elenco) Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Raggiungere ≥ 90% di parity strutturale HTML tra il reference Design Comuni Italia e la pagina locale `segnalazioni-elenco`.

**Architecture:** Eseguire lo script agnostico `bashscripts/html/html-structure-compare.sh` con l'URL corretto, leggere il diff reale, correggere `layout.blade.php` per aggiungere gli elementi mancanti, ri-eseguire per verificare il target. Nessun testo hardcoded nelle blade, tutte le chiavi traduzione nel formato `namespace::context.collection.key.type`.

**Tech Stack:** Python 3 (compare-html-body.py), Bash, Laravel Blade, chiavi traduzione Laravel

---

## File Map

| File | Azione | Responsabilità |
|------|--------|----------------|
| `bashscripts/html/html-structure-compare.sh` | Read-only | Script wrapper agnostico |
| `bashscripts/html/compare-html-body.py` | Read-only | Engine Python confronto HTML |
| `laravel/Themes/Sixteen/resources/views/components/blocks/segnalazioni/layout.blade.php` | Modify | Block principale segnalazioni-elenco |
| `laravel/config/local/fixcity/database/content/pages/tests.segnalazioni-elenco.json` | Modify se necessario | Dati JSON pagina |
| `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazioni-elenco/report.md` | Generated | Output script (sovrascrittura auto) |
| `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazioni-elenco/summary.json` | Generated | Parity score reale |
| `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazioni-elenco/FASE1-FINAL-REPORT.md` | Update | Report finale fase |

---

## Task 1: Esegui lo script con URL corretto

**Files:**
- Read: `bashscripts/html/html-structure-compare.sh`
- Write (generated): `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazioni-elenco/report.md`
- Write (generated): `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazioni-elenco/summary.json`

- [ ] **Step 1.1: Esegui lo script di confronto**

```bash
cd /var/www/_bases/base_fixcity_fila5

bash bashscripts/html/html-structure-compare.sh \
  "https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazioni-elenco.html" \
  "http://127.0.0.1:8000/it/tests/segnalazioni-elenco" \
  "segnalazioni-elenco" \
  --output-dir "laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazioni-elenco" \
  --threshold 90
```

Output atteso: stampa a console del parity score e salva i file nella cartella output.

- [ ] **Step 1.2: Leggi il parity score reale**

```bash
cat laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazioni-elenco/summary.json
```

Guarda il campo `parity_score`. Se ≥ 0.90 → FASE 1 completata, vai a Task 4.  
Se < 0.90 → continua con Task 2.

- [ ] **Step 1.3: Leggi il report dettagliato**

```bash
cat laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazioni-elenco/report.md
```

Annota tutti gli `❌ Elementi mancanti` e `⚠️ Elementi con differenze` — servono per Task 2.

---

## Task 2: Analizza il diff e identifica le correzioni

**Files:**
- Read: `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazioni-elenco/report.md`
- Read: `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazioni-elenco/reference-body.html`
- Read: `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazioni-elenco/local-body.html`
- Read: `laravel/Themes/Sixteen/resources/views/components/blocks/segnalazioni/layout.blade.php`

- [ ] **Step 2.1: Identifica elementi mancanti dal reference**

Leggi `reference-body.html` e `local-body.html` in parallelo.  
Cerca in `report.md` le righe con `❌` (mancanti) e `⚠️` (differenti).

Categorie note dalla FASE1-PARITY-REAL.md (87.5%):
- **btn-primary mancanti**: reference ha 5, local ha 2 → delta 3 bottoni
- **cards mancanti**: reference ha 13, local ha 10 → delta 3 cards (header/footer)
- **SVG icons mancanti**: reference ha 44, local ha 39 → delta 5 icone
- **images mancanti**: reference ha 13, local ha 9 → delta 4 immagini

- [ ] **Step 2.2: Verifica classi CSS e ID mancanti**

Nel `report.md` cerca:
- ID presenti in reference ma assenti in local
- Classi CSS presenti in reference ma assenti in local

**Regola:** Il confronto considera tag + id + classi. Un elemento con stessa struttura ma classi diverse conta come `⚠️ differente`, non come identico.

- [ ] **Step 2.3: Determina quali fix sono nel layout block vs app layout**

- Elementi in `<main>` → si trovano in `layout.blade.php` → correggere qui
- Elementi in `<header>` o `<footer>` → si trovano nel layout app → NON toccare (impatto globale)

---

## Task 3: Correggi layout.blade.php

**Files:**
- Modify: `laravel/Themes/Sixteen/resources/views/components/blocks/segnalazioni/layout.blade.php`
- Read: `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazioni-elenco/reference-body.html`

**Regole critiche:**
- ❌ Nessun testo hardcoded in italiano o inglese
- ✅ Tutte le stringhe via `__('fixcity::segnalazione.x.y.z.type')`
- ✅ Formato chiave: `namespace::context.collection.key.type` (es. `fixcity::segnalazione.card.expand.button.label`)
- ❌ Non usare formato `_label`, `_text` (underscore) → usare `.label`, `.text` (punto)

- [ ] **Step 3.1: Aggiungi elementi `❌ mancanti` identificati in Task 2**

Per ogni elemento mancante nel `<main>` (scope `layout.blade.php`):

Esempio per un bottone primary mancante:
```blade
{{-- Se nel reference c'è un btn-primary extra nel CTA map --}}
<a href="{{ $cta['url'] ?? '#' }}" class="btn btn-primary mobile-full py-3 mt-2 mb-4 mb-lg-0">
    <span>{{ __('fixcity::segnalazione.map.cta.link.label') }}</span>
</a>
```

Esempio per una card mancante:
```blade
{{-- card-header presente in reference ma assente in local --}}
<div class="card-header border-bottom border-light p-0 mb-0 d-flex justify-content-between">
    <span class="data-text">{{ $item['status'] ?? '' }}</span>
    <span class="data-text">{{ $item['date'] ?? '' }}</span>
</div>
```

- [ ] **Step 3.2: Correggi elementi `⚠️ con differenze` di classi CSS o ID**

Per ogni elemento con differenze strutturali, allinea le classi al reference.

Esempio correzione classe:
```blade
{{-- PRIMA --}}
<div class="col-lg-8 offset-lg-1">

{{-- DOPO (se reference usa offset diverso) --}}
<div class="col-lg-9">
```

- [ ] **Step 3.3: Verifica che il modal `#modal-disservizio` sia completo**

Il file `layout.blade.php` attuale finisce con il modal categories (riga 447). Verifica che il modal `#modal-disservizio` esista nel file. Se mancante, aggiungi (cerca struttura nel reference-body.html):

```blade
{{-- Modal segnalazione disservizio --}}
<div class="modal fade" id="modal-disservizio" tabindex="-1" role="dialog"
    aria-labelledby="modal2Title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title h4" id="modal2Title">
                    {{ __('fixcity::segnalazione.modal.disservizio.title.label') }}
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="{{ __('fixcity::segnalazione.modal.close.label') }}"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('fixcity::segnalazione.modal.disservizio.body.text') }}</p>
            </div>
            <div class="modal-footer justify-content-start">
                <button type="button" class="btn btn-primary"
                    data-bs-dismiss="modal">
                    {{ __('fixcity::segnalazione.modal.disservizio.confirm.button.label') }}
                </button>
                <button type="button" class="btn btn-link"
                    data-bs-dismiss="modal">
                    {{ __('fixcity::segnalazione.modal.close.label') }}
                </button>
            </div>
        </div>
    </div>
</div>
```

- [ ] **Step 3.4: Verifica rating section ha id corretto**

```blade
{{-- Deve avere id="rating" --}}
<div class="cmp-rating pt-lg-80 pb-lg-80" id="rating">
```

- [ ] **Step 3.5: Verifica rating-feedback section**

Dal reference, dopo il rating c'è spesso una sezione `id="rating-feedback"`. Controlla se presente in reference-body.html e aggiungi se mancante:

```blade
{{-- Rating feedback (visibile dopo voto) --}}
<div class="cmp-rating__answer d-none" id="rating-feedback" aria-live="polite">
    <p class="title-medium-2-semi-bold mb-0">{{ __('fixcity::segnalazione.rating.feedback.text') }}</p>
</div>
```

---

## Task 4: Re-run script e verifica ≥ 90%

**Files:**
- Read (generated): `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazioni-elenco/summary.json`

- [ ] **Step 4.1: Ri-esegui lo script**

```bash
cd /var/www/_bases/base_fixcity_fila5

bash bashscripts/html/html-structure-compare.sh \
  "https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazioni-elenco.html" \
  "http://127.0.0.1:8000/it/tests/segnalazioni-elenco" \
  "segnalazioni-elenco" \
  --output-dir "laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazioni-elenco" \
  --threshold 90
```

- [ ] **Step 4.2: Controlla parity_score**

```bash
python3 -c "import json; d=json.load(open('laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazioni-elenco/summary.json')); print(f'Parity: {d[\"parity_score\"]*100:.1f}%'); print('✅ TARGET RAGGIUNTO' if d['parity_score'] >= 0.90 else '❌ Ancora sotto 90%, continua fix')"
```

- [ ] **Step 4.3: Se ancora < 90%, torna a Task 2**

Rileggi il nuovo `report.md`, identifica ulteriori diff, correggi, ri-esegui.

---

## Task 5: Aggiorna documentazione FASE 1

**Files:**
- Modify: `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazioni-elenco/FASE1-FINAL-REPORT.md`
- Modify: `laravel/Themes/Sixteen/docs/body-structure-comparison/INDEX.md`
- Read: `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazioni-elenco/summary.json`

- [ ] **Step 5.1: Aggiorna FASE1-FINAL-REPORT.md con dati reali**

Apri `FASE1-FINAL-REPORT.md` e aggiorna:
- Il parity score (da stima a valore reale da `summary.json`)
- La data
- Le correzioni applicate in questa sessione
- Checklist completamento

- [ ] **Step 5.2: Aggiorna INDEX.md**

In `laravel/Themes/Sixteen/docs/body-structure-comparison/INDEX.md`, aggiorna la riga di `segnalazioni-elenco` con il parity score reale e la data odierna.

---

## Note Importanti

### Regola agnosticità bashscripts
`bashscripts/` non contiene mai riferimenti al progetto. Il collegamento avviene tramite:
- `docs/html-structure-comparison.md` (project bridge)
- Il parametro `--output-dir` passato a runtime

### Regola traduzioni
Formato UNICO accettato: `'namespace::context.collection.key.type'`

```
✅ fixcity::segnalazione.heading.title.label
✅ fixcity::segnalazione.rating.feedback.text
✅ fixcity::segnalazione.modal.close.label

❌ SEGNALAZIONE::SEGNALAZIONE.ELENCO.TITLE   (namespace maiuscolo, manca tipo)
❌ fixcity::segnalazione.heading.title_label  (underscore invece di punto)
❌ fixcity::segnalazione.fields.label         (manca chiave specifica)
```

### Regola multilingua
Nessuna stringa letterale in blade. Ogni testo visibile passa da `__()` o `$t()`.

### Regola git
Nessun commit finché FASE 1 non è completata al 100% (parity ≥ 90% + docs aggiornate).
