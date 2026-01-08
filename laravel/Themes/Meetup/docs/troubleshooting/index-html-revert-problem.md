# Problema: index.html Continua a Essere Ripristinato

**Data**: 28 Novembre 2024
**Problema**: Le modifiche a `index.html` vengono perse/ripristinate
**Status**: RISOLTO

---

## Descrizione del Problema

### Sintomi
1. Modifico `resources/html/index.html` da tema "delivery" a tema "meetup"
2. Salvo il file
3. Vite rileva il cambiamento e ricarica
4. **Il file torna allo stato originale** (tema meetup invece di delivery)

### File Interessato
```
/var/www/_bases/base_laravelpizza/laravel/Themes/Meetup/resources/html/index.html
```

### Stato Desiderato vs Attuale

| Elemento | Desiderato (Delivery) | Attuale (Meetup) |
|----------|----------------------|------------------|
| Titolo | "Laravel Pizza" | "Laravel Pizza Meetups" |
| Background | `bg-white` | `bg-slate-900 text-white` |
| Navigation | Home, Menu, Chi Siamo, Contatti, Cart (badge 2) | Home, Events, Community Chat, Login/Sign Up |
| Hero | "La Pizza Artigianale che ami, a casa tua" | "Laravel Developers. Pizza. Community." |
| Features | Consegna Veloce, Ingredienti Freschi, Ricette Tradizionali | Regular Meetups, Growing Community, etc. |

---

## Causa del Problema

### 1. Git Subtree / Submodule

Il tema Meetup è stato aggiunto come **git subtree**:

```bash
git log --oneline | head -5
# 1d412ff86 Merge commit '7d3df31228c9667d18243bb6a9c92eb1d767da2c' as 'laravel/Themes/Meetup'
```

Questo significa che:
- Il tema ha un **proprio repository Git separato**
- Modifiche locali possono essere sovrascritte da pull/merge dal subtree
- Git può ripristinare automaticamente i file

### 2. Vite HMR (Hot Module Replacement)

Vite potrebbe:
- Avere una cache dei file originali
- Ripristinare file da `node_modules/.vite`
- Avere conflitti con watchers multipli

### 3. Editor/IDE Cache

Editor come VSCode potrebbero:
- Avere file bufferizzati in memoria
- Auto-revert da file watcher
- Conflitti con git hooks

---

## Soluzione

### Approccio 1: Commit le Modifiche (CONSIGLIATO)

```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup/resources/html

# 1. Verifica lo stato
git status

# 2. Aggiungi le modifiche
git add index.html

# 3. Commit con messaggio chiaro
git commit -m "feat: Convert index.html from meetup theme to delivery theme

- Change title from 'Laravel Pizza Meetups' to 'Laravel Pizza'
- Update navigation: Home, Menu, Chi Siamo, Contatti with cart badge
- Change hero section to delivery-focused Italian content
- Replace community features with delivery features
- Update footer for delivery business

🤖 Generated with Claude Code"

# 4. Verifica che il commit sia stato creato
git log -1
```

### Approccio 2: Ferma Vite Durante le Modifiche

```bash
# 1. Ferma il server Vite
Ctrl+C

# 2. Pulisci la cache
rm -rf node_modules/.vite

# 3. Modifica i file

# 4. Commit le modifiche (vedi Approccio 1)

# 5. Riavvia Vite
npm run dev
```

### Approccio 3: Ignora File Specifici in Git

Se vuoi mantenere modifiche locali senza commit:

```bash
# Aggiungi a .git/info/exclude (locale, non commitato)
echo "resources/html/index.html" >> .git/info/exclude

# Oppure usa assume-unchanged (sconsigliato)
git update-index --assume-unchanged resources/html/index.html
```

**NOTA**: Questo approccio è **sconsigliato** perché rende difficile tracciare le modifiche.

---

## Workflow Corretto

### Per Modifiche al Tema

1. **SEMPRE fare commit** delle modifiche significative
2. Usare branch separati per sperimentazioni
3. Documentare le modifiche in `docs/IMPLEMENTATION-LOG.md`
4. Testare con Vite DOPO il commit

### Esempio: Convertire da Meetup a Delivery

```bash
# 1. Crea branch per la conversione
git checkout -b feature/delivery-theme

# 2. Modifica i file
# - resources/html/index.html
# - resources/html/css/app.css (colori, tema)
# - altre pagine...

# 3. Commit incrementali
git add resources/html/index.html
git commit -m "feat: Convert index.html header to delivery theme"

git add resources/html/css/app.css
git commit -m "feat: Update CSS theme for delivery site"

# 4. Testa
npm run dev

# 5. Merge nel branch principale
git checkout develop
git merge feature/delivery-theme
```

---

## Modifiche Necessarie per Tema Delivery

### File da Modificare

1. **index.html**
   - Cambiare da dark theme (`bg-slate-900`) a light theme (`bg-white`)
   - Logo: "Laravel Pizza" invece di "Laravel Pizza Meetups"
   - Navigation: Home, Menu, Chi Siamo, Contatti
   - Aggiungere cart icon con badge "2"
   - Hero: "La Pizza Artigianale che ami, a casa tua"
   - Features: Consegna Veloce, Ingredienti Freschi, Ricette Tradizionali
   - Sostituire "Upcoming Events" con "Le Nostre Pizze" (Margherita, Diavola, Quattro Formaggi)

2. **css/app.css**
   - Definire `@theme` con colori primary (rosso pizza)
   - Rimuovere colori dark theme

3. **Logo**
   - Scaricare logo "spicchio di pizza" da laravelpizza.com
   - Sostituire SVG placeholder con logo reale

4. **Nuove Pagine**
   - `menu.html` - Menu pizze
   - `about.html` - Chi Siamo
   - `contact.html` - Contatti
   - `cart.html` - Carrello
   - `events.html` - Eventi (meetup community)
   - `login.html` - Login
   - `register.html` - Registrazione
   - `dashboard.html` - Dashboard utente
   - `profile.html` - Profilo utente

---

## Prevenzione Futura

### Git Hooks

Crea un hook per avvisare prima di sovrascrivere file:

```bash
# .git/hooks/pre-commit
#!/bin/bash

# Controlla se index.html è stato modificato
if git diff --cached --name-only | grep -q "resources/html/index.html"; then
    echo "⚠️  WARNING: You are committing changes to index.html"
    echo "📝  Make sure this is intentional"
fi
```

### Documentazione

Aggiorna `docs/IMPLEMENTATION-LOG.md` OGNI volta che modifichi file importanti:

```markdown
## 2024-11-28 - Converted index.html to Delivery Theme

**Files Changed**: resources/html/index.html

**Changes**:
- Changed from dark meetup theme to light delivery theme
- Updated navigation, hero, features sections

**Reason**: Site should focus on pizza delivery, not developer meetups
```

---

## Checklist Post-Modifica

- [ ] File modificato e salvato
- [ ] Commit creato con messaggio descrittivo
- [ ] Cache Vite pulita (`rm -rf node_modules/.vite`)
- [ ] Server Vite riavviato
- [ ] Pagina verificata su http://localhost:5175/
- [ ] Modifiche documentate in `docs/IMPLEMENTATION-LOG.md`
- [ ] Git status pulito (no unstaged changes)

---

## Riferimenti

- [Git Subtree Documentation](https://www.atlassian.com/git/tutorials/git-subtree)
- [Vite HMR API](https://vitejs.dev/guide/api-hmr.html)
- Tema originale: `Themes/Meetup` (subtree da repository esterno)

