# PHPStan Notification Action Contract

## Problem

Il cluster PHPStan di `Notify` nasce quando action, job e service non condividono lo stesso contratto applicativo e puntano a model o payload troppo generici.

## Active Rule

- usare il model reale del modulo: `Modules\Notify\Models\Notification`
- esporre un entrypoint coerente `execute()` per le actions invocate da job/service
- tipizzare canali come `array<int, string>`
- tipizzare payload come `array<string, mixed>`
- portare `MobilePushNotification::toCloudMessage()` al tipo Kreait realmente accettato dal channel

## Result

Questo evita errori `class.notFound`, `method.notFound`, `argument.type` e riduce il rumore nel cluster Notify senza toccare la configurazione di PHPStan.
