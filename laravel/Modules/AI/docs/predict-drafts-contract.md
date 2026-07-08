# Contratto Draft AI Per Predict

## Scopo

Documentare il contratto reale della action `GeneratePredictionDraftsAction` usata dal modulo `Predict`.

## Stato

- aderenza al JSON strutturato: 95%
- fallback locale senza API key: 100%
- dipendenza da client ufficiale OpenAI Laravel: 100%

## Regole

- la action restituisce `array<int, array<string, mixed>>`
- il testo AI deve essere solo JSON, senza markdown
- se parsing o completezza scendono sotto il 100%, si usa fallback locale
- il fallback deve restare realistico e risolvibile

## Campi Obbligatori

- `title`
- `subtitle`
- `description`
- `category`
- `tags`
- `analysis`
- `event_end_date`
- `liquidity`

## Motivazione

Il modulo `AI` non salva nulla nel database `Predict`.

La sua responsabilita e una sola:

- generare draft editoriali e di mercato

La persistenza resta responsabilita del modulo `Predict`.

## Nota Per Altri Agenti

Se si cambia modello, temperatura o prompt, mantenere stabile il contratto dei campi oppure aggiornare contestualmente:

- questo file
- `Modules/Predict/docs/admin-ai-predict-generation.md`
