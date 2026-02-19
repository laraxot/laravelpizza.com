# Screenshot Documentation

**Scopo**: Cartella per screenshot di riferimento durante lo sviluppo e l'allineamento del tema

---

## 📸 Screenshot Disponibili

### Event Detail Alignment

- **`laravelpizza-events-1-prod`** - Event detail produzione https://laravelpizza.com/events/1
- **`laravelpizza-events-local`** - Event detail locale http://127.0.0.1:8000/it/events/laravel-11-release-pizza-party-1

### Homepage Alignment

- **`homepage-locale-after-fixes.png`** - Homepage locale dopo le correzioni di allineamento
- **`homepage-produzione-reference.png`** - Homepage di produzione come riferimento

---

## 📋 Convenzioni Naming

### Formato Nome File

```
{sezione}-{stato}-{descrizione}.png
```

**Esempi**:
- `homepage-locale-after-fixes.png` - Homepage locale dopo correzioni
- `homepage-produzione-reference.png` - Homepage produzione come riferimento
- `hero-section-before.png` - Hero section prima delle modifiche
- `hero-section-after.png` - Hero section dopo le modifiche

### Stati Comuni

- `before` - Prima delle modifiche
- `after` - Dopo le modifiche
- `reference` - Screenshot di riferimento (es. produzione)
- `local` - Versione locale
- `production` - Versione produzione

---

## 🔧 Come Prendere Screenshot

### Usando MCP Browser Extension

```javascript
// Naviga alla pagina
browser_navigate({ url: "http://127.0.0.1:8002/it" })

// Prendi screenshot full page
browser_take_screenshot({
    filename: "homepage-locale.png",
    fullPage: true
})
```

### Usando Browser DevTools

1. Apri DevTools (F12)
2. Vai su "Console"
3. Esegui: `document.documentElement.scrollHeight` per altezza totale
4. Usa estensione screenshot (es. "Full Page Screen Capture")

---

## Sottocartelle screenshot

### grafica-confronto

Confronto con laravelpizza.com: [grafica-confronto](grafica-confronto/README.md). Contiene screenshot produzione (`laravelpizza-com-home.png`) e, quando generati, locale (`nostra-home.png`). Screenshot “nostra” home (light/dark, 1440px) sono anche in [2026-02-02](2026-02-02/): `local-home-light-1440.png`, `local-home-dark-1440.png`. Generazione: `npm run screenshots` dalla cartella del tema, o MCP cursor-browser-extension. Doc differenze: [differenze-grafica-e-miglioramenti](../differenze-grafica-e-miglioramenti.md).

### 2026-02-02

Screenshot datati (es. produzione Hostinger, locale light/dark) per confronto e regressioni.

## 📚 Documentazione Correlata

- [Differenze grafica e miglioramenti](../differenze-grafica-e-miglioramenti.md)
- [Processo Allineamento Homepage](../homepage-alignment-process.md)
- [Analisi Differenze Visive](../homepage-visual-alignment-analysis.md)
- [Correzioni Completate](../homepage-alignment-completed.md)

---

**Nota**: Gli screenshot vengono presi automaticamente durante il processo di sviluppo per documentare visivamente le modifiche e i confronti.
