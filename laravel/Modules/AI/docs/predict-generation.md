# Predict Generation

## Scopo

Definire come il modulo `AI` deve generare predizioni realistiche per il modulo `Predict`.

## Output richiesto

L'action AI non deve restituire prose libera. Deve restituire una struttura JSON validabile.

## Schema logico

```json
[
  {
    "title": "string",
    "subtitle": "string",
    "description": "string",
    "category": "string",
    "tags": ["string"],
    "analysis": "string",
    "event_end_date": "YYYY-MM-DD",
    "liquidity": 1000
  }
]
```

## Prompt strategy

- Rispondere in italiano.
- Generare predizioni credibili, specifiche e verificabili.
- Evitare titoli vaghi o non risolvibili.
- Distribuire le predizioni su categorie ragionevoli.
- Restituire solo JSON.

## Vincoli

- Quantita' richiesta dall'admin: 1-100
- Massima lunghezza raccomandata del titolo: 140 caratteri
- Minimo 3 tag per predizione quando possibile
- Approfondimento con valore editoriale, non riempitivo

## Ruoli

- `AI`: genera struttura e copy
- `Predict`: valida, normalizza e persiste

## Nota

Se in futuro il backend AI cambia da provider remoto a modello locale, il contratto di output deve restare stabile per non rompere il pannello admin.
