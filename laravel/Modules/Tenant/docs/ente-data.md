---
title: "Dati dell'ente (EnteData e GetEnteDataAction)"
type: reference
module: Tenant
tags: [ente, dcp-289, sync, regressioni]
---

# Dati dell'ente

- `Modules\Tenant\Actions\Ente\GetEnteDataAction` legge `config('ente')` (file `config/<tenant>/ente.php`) e restituisce un
  `Modules\Tenant\Datas\EnteData` normalizzato: valore mancante o non valido = stringa vuota, mai un segnaposto.
- Telefono: solo cifre con `+` iniziale, 3-15 cifre, dopo aver tolto spazi, punti, trattini, parentesi e barre.
- `EnteData::link()` costruisce `tel:` tenendo solo cifre e `+`.

## Pulizia con `Str::of()->replaceMatches()`

Le pulizie con regex (`GetEnteDataAction::text()`, `::phone()`, `EnteData::link()`) usano
`Str::of($value)->replaceMatches($pattern, '')`, non `Safe\preg_replace`: il risultato resta sempre una stringa
(niente `string|array`) e non serve l'import di `Safe`.

## Regressione del sync del 21/11 (24/11/2026)

Il sync dei moduli (nessun marcatore) aveva riportato la versione con `Safe\preg_replace` nei due file, piu' vecchia di
quella scelta dal progetto (root `96f13e652`). Ripristinata la versione con `Str`; comportamento identico, test
`tests/Unit/Actions/Ente/GetEnteDataActionTest.php`.
