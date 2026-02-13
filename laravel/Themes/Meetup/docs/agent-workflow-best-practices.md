# Best Practices Workflow Agenti AI - Consolidamento

**Status**: ✅ Documentazione Completa
**Scopo**: Consolidare le best practices identificate dagli altri agenti AI per workflow ottimale

---

## 🎯 Processo Obbligatorio (Da `error-analysis-and-solution.md`)

### 1. Study Phase (SEMPRE PRIMA)

**Cosa fare**:
- ✅ Leggere **TUTTI** i file in `/Modules/*/docs/`
- ✅ Leggere **TUTTI** i file in `/Themes/*/docs/`
- ✅ Cercare README, INDEX, ARCHITECTURE files
- ✅ Verificare screenshot o riferimenti a siti reali
- ✅ Cercare raccomandazioni di altri agenti AI

**Perché**: Evita assunzioni errate e duplicazione di lavoro

**Output**: Comprensione completa del contesto

---

### 2. Clarify Phase (Se Necessario)

**Cosa fare**:
- Se ancora non chiaro, **chiedere all'utente**
- Riferire documenti specifici che sembrano contraddittori
- Proporre comprensione per conferma utente

**Perché**: Meglio chiedere che assumere

**Output**: Comprensione confermata

---

### 3. Document Phase (PRIMA di Implementare)

**Cosa fare**:
- Documentare cosa si è imparato
- Documentare interpretazione
- Documentare assunzioni fatte
- Aggiungere a docs/ folders

**Perché**: Altri agenti AI possono beneficiare

**Output**: Documentazione aggiornata

---

### 4. Implement Phase

**Cosa fare**:
- Codice basato su comprensione documentata
- Test contro sito reale se disponibile
- Aggiornare docs con nuove scoperte

**Perché**: Implementazione corretta e documentata

**Output**: Codice implementato

---

### 5. Verify Phase

**Cosa fare**:
- Confrontare con sito reale
- Verificare tutti i link funzionano
- Verificare design matcha
- Aggiornare docs con risultati

**Perché**: Garantisce qualità

**Output**: Verifica completata

---

## 📸 Workflow Screenshot (Da `pixel-parity-home.md`)

### Quando Prendere Screenshot

1. **Prima di modifiche significative**: Screenshot stato attuale
2. **Dopo modifiche**: Screenshot stato finale
3. **Durante confronti**: Screenshot riferimento (es. produzione)
4. **Per documentazione**: Screenshot per spiegare problemi/soluzioni

### Dove Salvare

- `Themes/Meetup/docs/screenshots/` - Screenshot generali
- `Themes/Meetup/docs/assets/pixel-parity/` - Screenshot pixel parity specifici

### Convenzioni Naming

```
{sezione}-{stato}-{descrizione}.png
```

**Esempi**:
- `homepage-locale-after-fixes.png`
- `homepage-produzione-reference.png`
- `hero-section-before.png`

---

## 🔄 Cache Clear Workflow (Da `pixel-parity-home.md`)

### Regola Operativa

Dopo **qualsiasi** modifica a Blade/Views del tema:

```bash
php artisan view:clear
php artisan optimize:clear
```

Poi **hard refresh browser** (Ctrl+Shift+R).

**Perché**: Laravel cache le viste compilate, quindi modifiche non sono visibili senza clear cache.

---

## 🎨 Verifica Accenti Colori (Da `visual-parity-progress.md`)

### Checklist

- [ ] Tutti gli accenti rossi usano `#dc2626` (Tailwind `red-600`)
- [ ] Nessun uso di `blue`, `primary-`, `bg-blue`, `text-blue` nei componenti blocks
- [ ] Palette colori coerente con design produzione

### Comando Verifica

```bash
grep -r "blue\|primary-" Themes/Meetup/resources/views/components/blocks
```

---

## 📋 Content Alignment (Da `visual-parity-progress.md`)

### Checklist JSON

- [ ] `home.json` si concentra su "Meetups", "Pizza", "Community"
- [ ] `header.json` ha link corretti (Events, Community Chat)
- [ ] `footer.json` ha link corretti
- [ ] Contenuti matchano produzione

---

## 🏗️ Architettura Pattern (Da `completion-plan-corrections.md`)

### Frontoffice Pattern OBBLIGATORIO

**✅ CORRETTO**:
- Folio per routing (`resources/views/pages/*.blade.php`)
- Volt per interattività (`@volt('component-name')`)
- JSON per contenuti (`config/local/laravelpizza/database/content/pages/*.json`)
- Actions per business logic (NO Services)

**❌ VIETATO**:
- Controller per pagine pubbliche
- Routes in `web.php` per frontend
- API calls JavaScript per dati frontend
- Services invece di Actions

---

## 📚 Documentazione da Aggiornare

### Dopo Ogni Modifica Significativa

1. **Aggiornare documenti rilevanti**:
   - `homepage-alignment-process.md` (se homepage)
   - `visual-parity-progress.md` (se allineamento)
   - `implementation-status.md` (se nuove features)

2. **Creare nuovi documenti se necessario**:
   - Processo nuovo → nuovo documento MD
   - Screenshot → salvare in `docs/screenshots/`
   - Raccomandazioni → aggiungere a `agent-recommendations-consolidated.md`

3. **Aggiornare indici**:
   - `00-index.md` se nuovo documento importante
   - README se necessario

---

## ✅ Checklist Pre-Implementazione

Prima di iniziare qualsiasi implementazione:

- [ ] Letto tutti i file in `docs/` del tema/modulo
- [ ] Compreso architettura e pattern
- [ ] Verificato raccomandazioni altri agenti AI
- [ ] Documentato comprensione
- [ ] Chiarito dubbi con utente (se necessario)
- [ ] Scelto soluzione più intelligente
- [ ] Creato piano implementazione

---

## ✅ Checklist Post-Implementazione

Dopo implementazione:

- [ ] Codice implementato e testato
- [ ] Cache clear eseguito (`view:clear`, `optimize:clear`)
- [ ] Screenshot presi (prima/dopo se necessario)
- [ ] Documentazione aggiornata
- [ ] Verifica visiva completata
- [ ] Build asset eseguito (`npm run build && npm run copy`)

---

## 🔗 Riferimenti

- [Error Analysis and Solution](./error-analysis-and-solution.md) - Processo 5 fasi
- [Pixel Parity Homepage](./pixel-parity-home.md) - Cache clear workflow
- [Visual Parity Progress](./visual-parity-progress.md) - Checklist allineamento
- [Completion Plan Corrections](./completion-plan-corrections.md) - Pattern architetturali
- [Agent Recommendations Consolidated](./agent-recommendations-consolidated.md) - Raccomandazioni
- [Screenshots Workflow](./screenshots-workflow.md) - Workflow screenshot

---

**Ultimo aggiornamento**: 2025-01-22
**Versione**: 1.0.0
**Status**: ✅ Best Practices Consolidate
