---
title: "status"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< HEAD
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
qmd: "status"
issues: []
discussions: []
---

# Homepage CSS/JS Fix - Status

> **Obsoleto: `npm run copy` non esiste piu' (2026-11-11).** Gli asset dei temi
> arrivano nella document root con un symlink, non con una copia. Per il
> procedimento valido vedi
> [Xot/docs/theme-assets-workflow.md](/laravel/Modules/Xot/docs/theme-assets-workflow.md).
> Le istruzioni di copia qui sotto sono lasciate come documentazione storica.

## Build Completo

**Data**: 2026-04-07

### Comandi Eseguiti

```bash
cd laravel/Themes/Sixteen
npm run build    # ✓ Completato
# niente npm run copy: public_html/themes/<Tema> è un symlink a ../../laravel/Themes/<Tema>/public
```

### Output Build

```
✓ 10 modules transformed
✓ built in 5.57s
```

### File Modificati

- `tailwind.config.js` - Già configurato con colori AGID
- `comune-custom.css` - Stili custom esistenti
- `comune-functions.js` - JS con dipendenza da Bootstrap

### Documentazione Creata

- `/docs/theme/sixteen/analysis/homepage-comparison.md`
- `/docs/theme/sixteen/analysis/index.md`

### Prossimi Passi

1. Verificare visualmente la homepage su http://127.0.0.1:8000/it/tests/homepage
2. Confrontare visivamente con reference
3. Applicare ulteriori correzioni CSS se necessario

---

title: "status"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "status"
issues: []
discussions: []
*Last Updated: 2026-04-07*
<<<<<<< HEAD
*Status: in_progress*
=======
*Status: in_progress*
>>>>>>> laraxot/dev
