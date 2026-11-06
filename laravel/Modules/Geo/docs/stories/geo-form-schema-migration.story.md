---
title: "Migrazione schema Address/Location in Form class (Geo)"
type: story
status: completed
created: 2026-10-15
updated: 2026-10-15
module: Geo
tags: [phpstan, filament, refactor, final, migration]
---

# Migrazione schema Address/Location in Form class (Geo)

## Richiesta
Dopo la rimozione dell'override `getFormSchemaOld()` in `XotBaseResource`, i due Resource Geo (`AddressResource`,
`LocationResource`) non potevano più compilare: il loro unico schema era in quel metodo `final`.

## Analisi
- `AddressForm` e `LocationForm` esistevano già come classi, ma erano **stubs** (schema vuoto). Il form reale era solo in `getFormSchemaOld()`.
- `AddressResource::getSearchStep()` usava `Select`/`Get`/`Set`/`Region`/`Province`/`Locality` — logica di ricerca geografica a cascata
  (regione → provincia → località → CAP) che non era ancora nel Form.
- `LocationResource` usava `Section` + `TextInput` per name/lat/lon/street/city/state/zip/formatted_address.

## Modifiche
- `AddressResource/Schemas/AddressForm.php`: scritto lo schema completo (name, country nascosto, administrative_area_level_1/2
  con `live()` + `afterStateUpdated` per azzerare i figli, locality con `disabled` condizionale, postal_code, route,
  street_number, is_primary Toggle).
- `AddressResource.php`: rimosso l'override `getFormSchemaOld()` e gli import `TextInput`/`Toggle` non più usati; mantenuto
  `getSearchStep()` (era già una funzionalità reale, non duplicata).
- `LocationResource/Schemas/LocationForm.php`: scritto lo schema con `Section::make()` e i 7 campi.
- `LocationResource.php`: rimosso l'override e gli import inutili; mantenuto `getRelations()` e `getPages()`.

## Verifica
```bash
php -l <file>          # tutti OK
phpstan analyse Modules # 0 errors
```

## Decisioni
- **D-1**: i campi del form vivono solo nei `*Form` (stessa regola di DCP-184).
- **D-2**: `getSearchStep()` rimane in `AddressResource` perché è una funzionalità distinta (ricerca geografica a cascata),
  non un duplicato del form.
- **D-3**: la logica `live()`/`afterStateUpdated()`/`disabled()` è stata copiata fedelmente dal vecchio override.

## Aperto
- Nessuno. I due Form sono adesso la sorgente di verità.