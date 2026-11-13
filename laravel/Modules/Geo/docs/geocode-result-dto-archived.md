---
title: GeocodeResultDto archiviato — duplicato di AddressData/GeoData
type: decision
tags: [datas, dto, archive, duplicate]
created: 2026-07-14
---

# GeocodeResultDto archiviato

`laravel/app/DTOs/GeocodeResultDto.php` (root, zero utilizzatori) duplicava
funzionalità già coperta da `Modules\Geo\Datas\AddressData` (lat/lng, country,
`getFormattedAddress()`) e `Modules\Geo\Datas\GeoData`.

## Azione

Spostato e rinominato in
`Modules/Geo/app/Datas/GeocodeResultDto.php.old` (suffisso `.old`, non
cancellato — regola repo-wide: mai `rm` su file superati, solo rinomina).

## Perché non ricreato come Data class attivo

YAGNI/ponytail: creare `GeocodeResultData` sarebbe un doppione immediato di
`AddressData`. Se in futuro serve un value object dedicato al risultato grezzo
di un provider di geocoding (prima della normalizzazione in `AddressData`),
usare quello come base — non reintrodurre questo file.

## Nota debiti correlati (non risolti in questa sessione)

Trovati altri duplicati nello stesso modulo, da analizzare separatamente
(richiede tracciare gli usage uno per uno prima di consolidare):
- `Modules/Geo/app/Datas/LocationDTO.php`
- `Modules/Geo/app/datatransferobjects/LocationDTO.php` (cartella minuscola, altra violazione)
- `Modules/Geo/app/DataTransferObjects/LocationDTO.php`
- `Modules/Geo/app/Datas/ElevationResultDTO.php` e `Modules/Geo/app/Datas/Elevation/ElevationResultDTO.php`

Vedi `docs/chat/dtos-to-datas-cleanup-2026-07-14.md` per il tracking.
