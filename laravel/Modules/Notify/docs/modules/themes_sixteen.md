---
title: "themes sixteen"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "themes sixteen"
issues: []
discussions: []
status: draft
---

# Gestione asset Vite per il tema Sixteen

> **Obsoleto: `npm run copy` non esiste piu' (2026-11-11).** Gli asset dei temi
> arrivano nella document root con un symlink, non con una copia. Per il
> procedimento valido vedi
> [Xot/docs/theme-assets-workflow.md](/laravel/Modules/Xot/docs/theme-assets-workflow.md).
> Le istruzioni di copia qui sotto sono lasciate come documentazione storica.

Se riscontri l'errore:

```
Unable to locate file in Vite manifest: Resources/css/app.css
```

Segui questi passaggi per risolvere:

1. Vai nella cartella del tema:
   ```bash
   cd /var/www/html/_bases/base_fixcity_fila5_mono/laravel/Themes/Sixteen
   ```
2. Esegui il comando:
   ```bash
<<<<<<< .merge_file_jhyFIG
   # niente npm run copy: public_html/themes/<Tema> è un symlink a ../../laravel/Themes/<Tema>/public
=======
>>>>>>> .merge_file_ymDu11
   ```

Questo comando pubblica gli asset necessari e risolve l'errore.

---
## Collegamenti
- [Documentazione asset Vite nel tema](../../Themes/Sixteen/docs/assets.md)
- [Documentazione asset Vite nel tema](../../../../Themes/Sixteen/docs/assets.md)
- [Indice gestione temi e asset](../temi_asset.md) *(creare se non esiste)*

---

> Aggiornato automaticamente da Windsurf AI il 17/04/2025
