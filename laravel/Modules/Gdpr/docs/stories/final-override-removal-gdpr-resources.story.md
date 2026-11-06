---
title: "Rimozione override getFormSchemaOld() final in 5 Filament Resources Gdpr"
type: story
status: completed
created: 2026-10-15
updated: 2026-10-15
module: Gdpr
tags: [phpstan, filament, refactor, final, dead-code]
---

# Rimozione override getFormSchemaOld() final in 5 Filament Resources Gdpr

## Richiesta
`phpstan analyse Modules` non partiva: PHP Fatal error `Cannot override final method XotBaseResource::getFormSchemaOld()`.
La radice era in `Modules/Gdpr/app/Filament/Resources/ConsentResource.php:33` e si estendeva a tutti i Resource Gdpr.

## Analisi
- `XotBaseResource::getFormSchemaOld()` è `final` (ponte di dismissione DCP-184): l'override era mortale al runtime.
- La sorgente di verità del form è già la classe `*Form` (`ConsentForm`, `EventForm`, `TreatmentForm`, `ProfileForm`) —
  il Resource la richiama tramite `form()`. L'override duplicava i campi e non era mai chiamato da nessun consumer.
- Gli import inutili (`Select`, `TextInput`, `Toggle`, `Textarea`, `Component`) erano l'unica ragione d'uso di quelle classi.

## Modifiche
- `ConsentResource.php`, `EventResource.php`, `TreatmentResource.php`, `ProfileResource.php`,
  `Clusters/Profile/Resources/ConsentResource.php`, `Clusters/Profile/Resources/ProfileResource.php`:
  rimozione del metodo `getFormSchemaOld()` e degli import non più usati.

## Verifica
```bash
php -l <file>          # tutti OK
phpstan analyse Modules # 0 errors
```

## Decisioni
- **D-1**: il ponte `getFormSchemaOld()` rimane `final` in `XotBaseResource`; nessun Resource lo override più.
- **D-2**: i campi del form vivono solo nei `*Form` (single source of truth).

## Aperto
- Nessuno. I `*Form` sono già completi e testati dai test del modulo.