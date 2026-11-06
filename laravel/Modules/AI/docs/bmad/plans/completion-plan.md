# Piano di completamento — AI

## Scopo
Fornire assistenza AI controllabile per operatori e flussi applicativi, con prompt, provider, classificazione, sentiment e proposte verificabili.

## Piano BMAD

1. Mappare Actions, contratti, Data, provider e integrazioni dal punto di ingresso ai test.
2. Rendere espliciti confini, fallback, gestione errori, costi e dati sensibili; mantenere la logica nelle Actions.
3. Completare `SettingPage` e `AIConfigData` senza esporre segreti o chiavi tecniche.
4. Portare PHPStan max, Pint, PHPMD, PHP Insights e Pest a verde sul modulo.
5. Aggiornare wiki, story e indice QMD solo con fatti verificati.

## Criteri di accettazione
Provider sostituibili, output tipizzati, fallback testati, nessun segreto nei form, gate ripetibili e documentazione orientata allo scopo.

