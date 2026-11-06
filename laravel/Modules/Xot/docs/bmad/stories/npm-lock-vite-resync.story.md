---
title: "Dipendenze npm: package-lock.json riallineato a package.json (vite 5 -> 6)"
type: story
module: Xot
status: done-needs-review
created: 2026-10-21
---

# Lock npm riallineato

## Causa

`package.json` dichiara `vite ^6.4.3`, ma `package-lock.json` fissava `vite 5.4.20`.
Per questo `npm ci` rifiutava l'installazione e `npm run dev` falliva con `vite: not found`.

## Correzione

`npm install` ha aggiornato il lock: `vite 6.4.5`, `esbuild 0.25.x`. Diff del lock:
271 righe aggiunte, 131 rimosse. Il build di prova `npm run build` passa.

## Da rivedere prima del commit

- Il salto da Vite 5 a 6 cambia il comportamento del dev server e del bundle. Verificare
  il frontend in browser prima di committare.
- `public_html/build` e' ignorato da git: il build non sporca il repo.

## Criteri di chiusura

- `npm ci` passa da zero.
- `npm run dev` avvia Vite senza errori nel pannello `artisan dev`.
