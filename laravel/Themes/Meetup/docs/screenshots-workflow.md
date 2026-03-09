# Workflow Screenshot per Sviluppo e Documentazione

**Scopo**: Documentare il processo di cattura e gestione screenshot durante lo sviluppo

---

## 📸 Quando Prendere Screenshot

### Durante Sviluppo

1. **Prima di modifiche significative**: Screenshot dello stato attuale
2. **Dopo modifiche**: Screenshot dello stato finale
3. **Durante confronti**: Screenshot di riferimento (es. produzione)
4. **Per documentazione**: Screenshot per spiegare problemi o soluzioni

### Casi d'Uso Specifici

- ✅ Allineamento homepage locale vs produzione
- ✅ Verifica correzioni CSS/JS
- ✅ Documentazione bug visivi
- ✅ Confronto design prima/dopo
- ✅ Test responsive design
- ✅ Verifica accessibilità

---

## 🎯 Come Prendere Screenshot

### Metodo 1: MCP Browser Extension (Raccomandato)

```javascript
// Naviga alla pagina
browser_navigate({ url: "http://127.0.0.1:8002/it" })

// Screenshot full page
browser_take_screenshot({
    filename: "homepage-locale-after-fixes.png",
    fullPage: true
})

// Screenshot elemento specifico
browser_take_screenshot({
    filename: "hero-section.png",
    selector: "section.hero",
    fullPage: false
})
```

**Vantaggi**:
- ✅ Automatico e programmabile
- ✅ Full page support
- ✅ Integrato nel workflow AI
- ✅ Screenshot consistenti

### Metodo 2: Browser DevTools

1. Apri DevTools (F12)
2. Vai su "Console"
3. Esegui comando screenshot (dipende dal browser)
4. Salva manualmente in `docs/screenshots/`

**Vantaggi**:
- ✅ Controllo manuale
- ✅ Possibilità di selezionare area specifica

### Metodo 3: Estensioni Browser

- **Chrome**: "Full Page Screen Capture"
- **Firefox**: "FireShot"
- **Edge**: "Webpage Screenshot"

---

## 📁 Organizzazione File

### Struttura Directory

```
Themes/Meetup/docs/screenshots/
├── README.md                          # Questo file
├── homepage-locale-after-fixes.png    # Homepage locale dopo correzioni
├── ...
└── visual-analysis/                   # Analisi comparative strutturate
    └── footer/                        # Confronto logo e layout footer
        ├── README.md
        ├── footer-laravelpizza-com.png
        └── footer-locale-it.png
```

### Convenzioni Naming

**Formato**: `{sezione}-{stato}-{descrizione}.png`

**Esempi**:
- `homepage-locale-after-fixes.png`
- `homepage-produzione-reference.png`
- `hero-section-before.png`
- `hero-section-after.png`
- `features-grid-comparison.png`

**Stati Comuni**:
- `before` - Prima delle modifiche
- `after` - Dopo le modifiche
- `reference` - Screenshot di riferimento
- `local` - Versione locale
- `production` - Versione produzione
- `comparison` - Screenshot di confronto

---

## 📝 Documentazione Correlata

### Creare Documento MD per Ogni Processo

Quando prendi screenshot per un processo specifico, crea anche un documento MD che spiega:

1. **Cosa stai facendo**: Obiettivo del processo
2. **Perché**: Motivazione delle modifiche
3. **Come**: Passi seguiti
4. **Risultati**: Screenshot prima/dopo
5. **Riferimenti**: Link a documentazione correlata

**Esempio**: `homepage-alignment-process.md`

---

## 🔄 Workflow Completo

### 1. Prima di Iniziare

```bash
# Naviga alla pagina
browser_navigate({ url: "http://127.0.0.1:8002/it" })

# Screenshot stato iniziale
browser_take_screenshot({
    filename: "homepage-locale-before.png",
    fullPage: true
})
```

### 2. Durante Sviluppo

- Prendi screenshot intermedi se necessario
- Documenta ogni modifica significativa

### 3. Dopo Modifiche

```bash
# Screenshot stato finale
browser_take_screenshot({
    filename: "homepage-locale-after-fixes.png",
    fullPage: true
})

# Screenshot riferimento produzione
browser_navigate({ url: "https://laravelpizza.com/" })
browser_take_screenshot({
    filename: "homepage-produzione-reference.png",
    fullPage: true
})
```

### 4. Documentazione

- Crea documento MD che spiega il processo
- Includi riferimenti agli screenshot
- Aggiorna README.md nella cartella screenshots

---

## 📚 Esempi Pratici

### Esempio 1: Allineamento Homepage

**Screenshot Presi**:
- `homepage-locale-before.png` (stato iniziale)
- `homepage-locale-after-fixes.png` (stato finale)
- `homepage-produzione-reference.png` (riferimento)

**Documento Creato**: `homepage-alignment-process.md`

### Esempio 2: Correzione Hero Section

**Screenshot Presi**:
- `hero-section-before.png` (prima correzioni)
- `hero-section-after.png` (dopo correzioni)

**Documento Creato**: `hero-section-display-issue-analysis.md`

---

## ✅ Checklist

Prima di completare un task con screenshot:

- [ ] Screenshot presi (prima/dopo se necessario)
- [ ] Screenshot salvati in `docs/screenshots/`
- [ ] Nomi file seguono convenzioni
- [ ] Documento MD creato che spiega il processo
- [ ] README.md aggiornato (se necessario)
- [ ] Riferimenti agli screenshot nel documento MD

---

## 🔗 Riferimenti

- [Processo Allineamento Homepage](../homepage-alignment-process.md)
- [Analisi Differenze Visive](../homepage-visual-alignment-analysis.md)
- [Correzioni Completate](../homepage-alignment-completed.md)
- [README Screenshots](./readme.md)

---

**Ultimo aggiornamento**: [DATE]
**Versione**: 1.0.0
**Status**: ✅ Documentazione Completa
