---
title: "theme"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "theme"
issues: []
discussions: []
status: draft
---

# Theme

> **Obsoleto: `npm run copy` non esiste piu' (2026-11-11).** Gli asset dei temi
> arrivano nella document root con un symlink, non con una copia. Per il
> procedimento valido vedi
> [Xot/docs/theme-assets-workflow.md](/laravel/Modules/Xot/docs/theme-assets-workflow.md).
> Le istruzioni di copia qui sotto sono lasciate come documentazione storica.

per sapere quale tema utilizza questo progetto devi leggere laravel/.env  la variabile APP_URL  vedi un dominio , devi togliere http:// o https:// , togliere anche wwww. e lasciare solo il dominio, poi explodere la stringa da "."  poi invertire l'array e poi unire con "/"  questo e' il nome della configurazione percio' devi andare a leggere base_path('config/<nome>/xra.php');
e qui trovi la variabile pub_theme  e qui c'e' scritto il nome del tema, che corrisponde al nome della cartella del tema in laravel/Themes/
aggiorna le cartelle docs dentro i moduli e dentro i temi, le tue rules, le tue memories, le tue skills, utilizzando gli indici in ottica dry + kiss, utilizza openviking installato globalmente, bmad, gsd , ralph loop e notebooklm


questo errore Vite manifest not found at: /var/www/_bases/base_fixcity_fila5/public_html/themes/<nome tema>/manifest.json 
si risolve andando in 
cd laravel/Themes/<nome tem>
composer update -W 
npm install
npm run build
<<<<<<< .merge_file_aqWyml
# niente npm run copy: public_html/themes/<Tema> è un symlink a ../../laravel/Themes/<Tema>/public
=======
>>>>>>> .merge_file_5IOrxT
capisci te i perche' 
utilizza openviking installato globalmente, bmad, gsd , ralph loop e notebooklm
