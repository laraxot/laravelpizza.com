# Ponytail audit — Geo (over-engineering)

**Ultimo run:** 2026-06-30  
**Modulo:** geocoding, mappe, indirizzi.  
**Hub:** [../../../../docs/audit/ponytail-audit.md](../../../../docs/audit/ponytail-audit.md)  
**Remediation:** [../../../../docs/project/ponytail-audit-remediation.md](../../../../docs/project/ponytail-audit-remediation.md)  
**GitHub monorepo:** [Issue #221](https://github.com/laraxot/base_predict_fila5/issues/221) · [Discussion #222](https://github.com/laraxot/base_predict_fila5/discussions/222) · [Discussion #228](https://github.com/laraxot/base_predict_fila5/discussions/228)

## Scopo business

Un indirizzo in ingresso → coordinate e dati strutturati. In produzione serve **un** provider configurato; sette provider in cascata è fallback speculativo che moltiplica manutenzione e test.

## Findings ranked

| # | Tag | Cosa tagliare | Sostituzione | Path | Righe ~ |
|---|-----|---------------|--------------|------|---------|
| G1 | `yagni` | 7 provider in loop in `GetAddressDataFromFullAddressAction` | `config('geo.driver')` + 1 action attiva | `app/Actions/GetAddressDataFromFullAddressAction.php` | ~4.300 (Actions tot.) |
| G2 | `shrink` | doppio `GetAddressFromBingMapsAction` (`Bing/` vs `BingMaps/`) | tenere `BingMaps\` (usato dal dispatcher) | `app/Actions/Bing/` | ~130 |
| G3 | `yagni` | 12+ classi Data micro-granulari | composite Spatie Data | `app/Datas/` | ~500 |
| G4 | `yagni` | `LocationDTO` vs `LocationData` | un pattern | `app/Datas/LocationDTO.php`, `LocationData.php` | ~80 |
| G5 | `delete`→`.bak` | `GeocodingServiceInterface` (già verificata morta) | contratto attivo o niente | `app/Contracts/` | ~15 |

## Contesto runtime

`GetAddressDataFromFullAddressAction` prova in sequenza: Google, Photon, Nominatim, BingMaps, Here, Mapbox, OpenCage. Lazy: un driver + retry opzionale, non un foreach di classi hardcoded.

## Azione proposta

1. Grep uso per provider in config/env produzione.  
2. `.bak` su action provider non referenziati.  
3. Pest su geocoding con driver canonico.

## Collegamenti

- [00-INDEX.md](./00-INDEX.md)
- [module-philosophy.md](./module-philosophy.md)
- [Notify audit](../../Notify/docs/ponytail-audit-over-engineering.md) (stesso pattern multi-provider)
