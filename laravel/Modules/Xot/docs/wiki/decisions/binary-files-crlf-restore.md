---
title: "Immagini PNG corrotte dalla conversione CRLF→LF: ripristino dalla storia git"
type: decision
module: Xot
tags: [git, gitattributes, png, binari, manuale]
created: 2026-11-10
updated: 2026-11-10
status: accepted
---

# Immagini PNG corrotte: ripristino

## Contesto

`laravel/.gitattributes` ha `* text=auto eol=lf`. Prima che venissero aggiunte le regole
`*.png binary -eol` alcuni commit (es. 260ef0ca3, merge 333f0f8a7 del 9/11/2026) hanno
convertito i byte `\r\n` in `\n` dentro i file binari. Effetto: **410 PNG** non più leggibili
(firma `89 50 4E 47 0A 1A 0A` invece di `89 50 4E 47 0D 0A 1A 0A`), tra cui le schermate del
manuale del back office: nel PDF comparivano solo i testi alternativi.

## Decisione

- Per ogni PNG con firma errata si recupera dalla storia git l'ultima versione con firma
  corretta (`git log -- file`, `git show <commit>:file`). Ripristinati **347** file, verificati
  con Pillow (`Image.verify()`).
- **63** PNG non hanno mai avuto una versione valida nel repository (aggiunti già corrotti):
  la conversione toglie byte e non è reversibile. Vanno rigenerati o ricaricati dagli autori.
  Elenco: cartelle `Themes/Sixteen/public/design-comuni/assets/images` (24),
  `Modules/Predict/resources/img/screenshots` (6), `Modules/UI/resources/img/screenshots` (5),
  `Modules/Geo/public/assets/images` (5), altre 23 sparse.
- Altri binari (jpg, woff2, ttf, pdf, ico…): firma corretta e nessuna versione precedente uguale
  a meno della conversione CRLF: nessun intervento.

## Come evitarlo

- Le regole `binary -eol` in `laravel/.gitattributes` restano obbligatorie per ogni nuovo
  tipo binario aggiunto al progetto.
- Controllo rapido: `git ls-files '*.png' | while read f; do od -A n -t x1 -N 8 "$f"; done | sort | uniq -c`
  deve mostrare solo `89 50 4e 47 0d 0a 1a 0a`.
