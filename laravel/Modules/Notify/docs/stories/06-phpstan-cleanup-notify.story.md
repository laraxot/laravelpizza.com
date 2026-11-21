---
title: "[STORY] PHPStan cleanup Notify: scopo del codice, non solo l'errore"
type: story
status: done
priority: medium
module: Notify
created: 2026-10-06
updated: 2026-10-06
tags: [notify, phpstan, enum, push, notification-log]
---

# [STORY] PHPStan cleanup Notify

## User Request

> «sistema tutte le segnalazioni di phpstan [...] concentrati sullo scopo/funzionalita', non sull'errore;
> aumenta la qualita' del codice; usa enum al posto delle costanti».

Gruppo Notify: 69 errori in 26 file (`phpstan analyse Modules/Notify`, config `phpstan.neon` invariata).

## Analysis

Gli errori non erano 69 problemi indipendenti: tre cause radice.

1. **`NotificationLog` svuotato.** Il modello nel working tree aveva perso docblock `@property`/`@method`
   e generics (`MorphTo<Model, $this>`, `Builder<static>`) rispetto a HEAD, e le costanti `STATUS_*`
   erano state tolte senza cast verso l'enum. Da qui `property.notFound` (`$status`, `$data`) in
   `NotificationTrackingController` e `NotifyModelsTest`, piu' 8 `missingType.generics`.
   Scopo del modello: log di consegna per notifica/canale con stato ciclo-di-vita, tracking apertura/click.
2. **Stub push (APNs / Web Push / targeting) che ignoravano i parametri.** Le consegne APNs e Web Push
   sono "simulate" (decision-log 2026-09: ritornano `success: true`) e `getTokensByCriteria()` ritorna `[]`
   perche' non esiste uno store dei device token. Nel caso Web Push il payload veniva calcolato e buttato
   (`json_encode(...)` senza uso): logica mancante, non codice morto.
3. **Pagine di test Filament e test con intento perso.** `$notificationData` (Firebase) costruito e mai
   inviato; `$smtpConfig`/`$defaultEmail` (SMTP) calcolati per precompilare il form ma i `->default()`
   erano commentati; `$user`/`$attachments` residui di copia-incolla; test "has required imports" che
   calcolavano `$filename` ma asserivano solo `strict_types`.

## Acceptance Criteria

- [x] `phpstan analyse Modules/Notify --memory-limit=-1 --no-progress` = 0 errori (69 -> 0), senza toccare `*.neon`/baseline e senza `@phpstan-ignore`.
- [x] Stato log notifica = backed enum `NotificationLogStatusEnum` (riuso, nessun enum nuovo), con cast nel modello e `PROCESSING` presente (label/colore/icona in `lang/it`).
- [x] Nessun consumatore fuori da Notify delle vecchie `NotificationLog::STATUS_*` (grep su `Modules/` e `Themes/`).
- [x] Stub push: i parametri sono usati davvero (log del "simulato", topic nel risultato) senza cambiare firme ne' esiti.
- [x] Pagina Firebase invia davvero (`Messaging`), pagina SMTP precompila da config (senza segreti), residui morti rimossi.
- [x] Test: asserzioni reali al posto di variabili inutilizzate; test enum/modello allineati.
- [x] `php -l` su tutti i file toccati.
- [ ] Pest non eseguito (vedi dev-story, Testing): da lanciare in ambiente con DB di test isolato.

## GitHub (tracciamento)

- Issue: TODO (gh non installato su questa macchina)
- Discussion: TODO
