# Aggiornamento Documentazione - Problema con ai_init.sh

## Problema Identificato

Lo script `/var/www/_bases/base_quaeris_fila4_mono/bashscripts/ai/ai_init.sh` non crea la junction richiesta per la cartella `/var/www/_bases/base_quaeris_fila4_mono/bashscripts/ai/.gemini` da vedere dentro `/var/www/_bases/base_quaeris_fila4_mono/`.

## Analisi

Dopo l'analisi dello script, è stato identificato un problema logico nell'implementazione:

- Lo script cerca cartelle nella root del progetto (come `.gemini`)
- Poi crea symlink da `bashscripts/ai/.$nome` a quelle cartelle
- Ma invece dovrebbe cercare cartelle specifiche in `bashscripts/ai/` (come `.gemini`) e creare symlink nella root del progetto che puntano a quelle cartelle

## Comportamento Atteso

Dovrebbe creare un symlink nella root del progetto:
```
/var/www/_bases/base_quaeris_fila4_mono/.gemini -> /var/www/_bases/base_quaeris_fila4_mono/bashscripts/ai/.gemini
```

## Comportamento Attuale

Lo script cerca una cartella `.gemini` nella root del progetto e crea un symlink in `bashscripts/ai/` che punta a quella cartella (se esistesse).

## Soluzione

Lo script deve essere corretto per invertire la logica:
- Cercare le cartelle specifiche in `bashscripts/ai/` 
- Creare symlink nella root del progetto che puntano a quelle cartelle

## Cartelle Coinvolte

- Source: `/var/www/_bases/base_quaeris_fila4_mono/bashscripts/ai/.gemini`
- Target symlink: `/var/www/_bases/base_quaeris_fila4_mono/.gemini`