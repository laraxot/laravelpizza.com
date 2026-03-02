# Build & Copy Workflow - Reminder Critico

## Data
[DATE]

## Correzione Importante dall'Utente

> "e ti ricordo che per vedere le modifiche in http://127.0.0.1:8000/it devi fare npm run build && npm run copy .. aggiorna le tue rules e le tue memories"

## La Regola

**Per vedere qualsiasi modifica in http://127.0.0.1:8000/it è OBBLIGATORIO eseguire ENTRAMBI i comandi:**

```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm run build && npm run copy
```

## Perché Entrambi i Comandi

### 1. `npm run build`
- Compila `resources/css/app.css` e `resources/js/app.js`
- Output: `./public/assets/` con file hashati
- Genera: `./public/manifest.json`

### 2. `npm run copy`
- Copia da: `./public/*`
- Copia a: `../../../public_html/themes/Meetup`
- Include tutti gli asset compilati

## Workflow Completo

```bash
# 1. Modifica i file sorgente
vim resources/css/app.css
vim resources/js/app.js

# 2. Compila E copia (SEMPRE entrambi!)
npm run build && npm run copy

# 3. Verifica nel browser
# Apri: http://127.0.0.1:8000/it
# Hard refresh: Ctrl+Shift+R
```

## Verifica Post-Build

### Check Build Output
```bash
ls -la /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup/public/
# Deve contenere:
# - assets/ (con file CSS e JS hashati)
# - manifest.json
```

### Check Deployed Assets
```bash
ls -la /var/www/_bases/base_laravelpizza/public_html/themes/Meetup/
# Deve contenere gli stessi file del build output
```

## Errori Comuni

### ❌ Errore: Solo `npm run build`
```bash
npm run build  # Build fatto ma NON copiato!
```
**Problema**: Le modifiche sono compilate ma non deployate
**Risultato**: http://127.0.0.1:8000/it mostra ancora la vecchia versione

### ❌ Errore: Solo `npm run copy`
```bash
npm run copy  # Copia fatta ma con vecchi file!
```
**Problema**: Copia i vecchi file compilati
**Risultato**: http://127.0.0.1:8000/it mostra la versione non aggiornata

### ✅ Corretto: Entrambi i comandi
```bash
npm run build && npm run copy
```
**Risultato**: http://127.0.0.1:8000/it mostra le nuove modifiche

## Perché Questo Workflow?

### Architettura del Sistema

L'applicazione Laravel serve gli asset del tema da:
```
/var/www/_bases/base_laravelpizza/public_html/themes/Meetup/
```

NOT da:
```
/var/www/_bases/base_laravelpizza/laravel/public/
```

Quindi il workflow è:
1. **Build** → compila in `Themes/Meetup/public/`
2. **Copy** → deploya da `public/` a `public_html/themes/Meetup/`
3. **Laravel** → serve da `public_html/themes/Meetup/`

## Aggiornamento Documentazione

Questa regola è stata aggiunta a:

1. **critical-rules-and-patterns.md**
   - Sezione "Build Commands"
   - Key Takeaway #2

2. **static-html-deployment-workflow.md**
   - Sezione "Commands"

3. **Questo file**
   - Reminder specifico per il workflow

## Regola Memorizzata

**SEMPRE ricordare**:

```
Modifiche a CSS/JS del tema
    ↓
cd Themes/Meetup
    ↓
npm run build && npm run copy
    ↓
Refresh http://127.0.0.1:8000/it
```

**NON è sufficiente solo `npm run build`!**
**NON è sufficiente solo `npm run copy`!**

**ENTRAMBI sono necessari per vedere le modifiche!**

## Checklist Pre-Test

Dopo ogni modifica a `resources/css/app.css` o `resources/js/app.js`:

- [ ] Eseguito `cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup`
- [ ] Eseguito `npm run build`
- [ ] Verificato output in `./public/assets/`
- [ ] Eseguito `npm run copy`
- [ ] Verificato copia in `../../../public_html/themes/Meetup/`
- [ ] Refresh browser su http://127.0.0.1:8000/it
- [ ] Hard refresh (Ctrl+Shift+R) se necessario

---

**Importanza**: Critica
**Frequenza**: Ogni modifica agli asset del tema
**Comando**: `npm run build && npm run copy`
**Location**: `/var/www/_bases/base_laravelpizza/laravel/Themes/Meetup`
