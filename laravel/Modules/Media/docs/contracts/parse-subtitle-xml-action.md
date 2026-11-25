---
title: "ParseSubtitleXmlAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Subtitle\\ParseSubtitleXmlAction"
qmd: "ParseSubtitleXmlAction parsing sottotitoli XML timing start end millisecondi righe sentence item"
---

# ParseSubtitleXmlAction

Legge un file di sottotitoli XML e produce una riga per ogni `item`, con inizio, fine, intervallo `HH:MM:SS,mmm` e testo. Codice: `app/Actions/Subtitle/ParseSubtitleXmlAction.php:22-98`.

## Input

- `string $filePath`: percorso del file. Solo l'estensione `xml` (minuscola o no) viene elaborata.

## Output

- `list<SubtitleRow>`: `sentence_i`, `item_i`, `start` e `end` in secondi (`ms / 1000`), `time`, `text`.

## Invarianti

- **PARSE-SUBTITLE-XML-INV-1** — Un file senza estensione o con estensione diversa da `xml` produce `[]` senza errore.
  Test: `tests/Unit/Actions/Subtitle/ParseSubtitleXmlActionTest.php:19` (estensione non xml) e `:25` (percorso senza estensione).
- **PARSE-SUBTITLE-XML-INV-2** — Gli indici `sentence_i` e `item_i` partono da 0 e si resettano per ogni sentence.
  Test: nessuno (la fixture `tests/Fixtures/subtitle.xml` esiste ma non è verificata nei valori).

## Effetti collaterali

- Lettura del file. Nessuna scrittura.

## Errori

- Un `item` senza attributi lancia `Exception` con un messaggio che contiene riga e classe.
- `Safe` lancia se il file non esiste o l'XML non è valido.

## Non fa

- Non legge SRT né altri formati: restituisce `[]`.
- Il `time` è calcolato dai secondi arrotondati al millisecondo.
