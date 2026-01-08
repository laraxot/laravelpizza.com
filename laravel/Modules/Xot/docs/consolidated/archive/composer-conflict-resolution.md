# Risoluzione conflitto composer.json (Xot)

## Intent
- Garantire coerenza delle dipendenze e corretta configurazione dell’autoload per il modulo Xot.

## Azioni eseguite
- Rimozione dei marker di conflitto in `composer.json`.
- Eliminazione dell’inserimento errato del branch alias `aurmich/dev` in sezioni non valide.
- Pulizia delle sezioni `require` e `require-dev`, mantenendo solo dipendenze ufficiali documentate.
- Conservazione della versione di `filament/filament`: `^3.3`.

## Collegamento alla doc root
Vedi `/project_docs/xot_conflict_links.md` per la mappatura dei file documentati localmente e i riferimenti incrociati.
