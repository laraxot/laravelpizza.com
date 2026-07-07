# Aggiornamento Documentazione - Problema con ai_init.sh

## Problema Identificato

<<<<<<< HEAD
Lo script `./bashscripts/ai/ai_init.sh` non crea la junction richiesta per la cartella `./bashscripts/ai/.gemini` da vedere dentro `./`.
=======
Lo script `/var/www/_bases/base_quaeris_fila4_mono/bashscripts/ai/ai_init.sh` non crea la junction richiesta per la cartella `/var/www/_bases/base_quaeris_fila4_mono/bashscripts/ai/.gemini` da vedere dentro `/var/www/_bases/base_quaeris_fila4_mono/`.
>>>>>>> origin/dev

## Analisi

Dopo l'analisi dello script, è stato identificato un problema logico nell'implementazione:

- Lo script cerca cartelle nella root del progetto (come `.gemini`)
- Poi crea symlink da `bashscripts/ai/.$nome` a quelle cartelle
- Ma invece dovrebbe cercare cartelle specifiche in `bashscripts/ai/` (come `.gemini`) e creare symlink nella root del progetto che puntano a quelle cartelle

## Comportamento Atteso

Dovrebbe creare un symlink nella root del progetto:
```
<<<<<<< HEAD
./.gemini -> ./bashscripts/ai/.gemini
=======
/var/www/_bases/base_quaeris_fila4_mono/.gemini -> /var/www/_bases/base_quaeris_fila4_mono/bashscripts/ai/.gemini
>>>>>>> origin/dev
```

## Comportamento Attuale

Lo script cerca una cartella `.gemini` nella root del progetto e crea un symlink in `bashscripts/ai/` che punta a quella cartella (se esistesse).

## Soluzione

Lo script deve essere corretto per invertire la logica:
- Cercare le cartelle specifiche in `bashscripts/ai/` 
- Creare symlink nella root del progetto che puntano a quelle cartelle

## Cartelle Coinvolte

<<<<<<< HEAD
- Source: `./bashscripts/ai/.gemini`
- Target symlink: `./.gemini`
=======
- Source: `/var/www/_bases/base_quaeris_fila4_mono/bashscripts/ai/.gemini`
- Target symlink: `/var/www/_bases/base_quaeris_fila4_mono/.gemini`
>>>>>>> origin/dev
