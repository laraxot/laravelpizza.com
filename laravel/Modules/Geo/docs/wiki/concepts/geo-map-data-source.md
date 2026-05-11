---
name: geo-map-data-source
description: Data source configuration for Geo map components
type: concept
---

# Geo Map Data Source

## REGOLA PERMANENTE
- **Il componente `geo-map-lit` deve caricare i dati da un file GeoJSON accessibile via URL**.
- Il nome del file predefinito è **`/data/tickets.json`**, ma per test di clustering è necessario usare **`/data/tickets_big.json`**.

## PERCHÉ
- Il file `tickets_big.json` contiene un set di **70 punti densamente distribuiti** attorno al centro di Roma, progettato per verificare la corretta visualizzazione dei **cluster** e del **LOD (level‑of‑detail)**.
- Utilizzando lo stesso URL in tutti i template garantiamo **coerenza** e **riusabilità** del componente.

## COME APPLICARE
1. Generare il file di test (già fatto) con lo script `GenerateClusterTestJsonAction` o, se necessario, via script inline.
2. Copiare `cluster-test.json` in `public/data/tickets_big.json`.
3. Aggiornare il markup del componente nei template (es. `segnalazioni-elenco.blade.php`) impostando `data-url="/data/tickets_big.json"`.
4. Ricostruire gli assets con `npm run build && npm run copy`.
5. Verificare con Playwright o manualmente che i marker e i cluster siano visibili.

## LOGICHE DI VALIDAZIONE
- **PHPStan / PHPMD / PHPInsights**: il percorso dei file è relativo a `public/data/`, non vi sono path assoluti.
- **Visual parity**: confrontare lo screenshot della mappa con quello di `farmshops.eu`.

---

## RISULTATI ATTESI
- La mappa mostra **cluster** quando lo zoom è < 12.
- Il **LOD** cambia icona al superamento di `zoom ≥ 8`.
- I **popup** mostrano le proprietà `title`, `type_label`, `address`.

---

*Aggiornato il `docs/wiki/index.md` e il `docs/wiki/log.md` per riferire questa regola.*