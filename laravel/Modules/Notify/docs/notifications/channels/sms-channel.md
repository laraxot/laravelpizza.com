---
title: "sms channel"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "sms channel"
issues: []
discussions: []
---

# `SmsChannel`

Canale di notifica Laravel per l'invio di SMS. Non contiene la logica di
trasporto: sceglie il **driver** e delega alla sua `Send{Provider}SMSAction`.

> SSoT sul funzionamento e sulla storia (regressione + fix): il concept
> [../../wiki/concepts/sms-channel-driver-selection.md](../../wiki/concepts/sms-channel-driver-selection.md).
> Questo file è solo un riferimento rapido.

## Percorso

`laravel/Modules/Notify/app/Channels/SmsChannel.php`

(non `app/Notifications/Channels/` — lì c'è solo il legacy `NetfunChannel`
accoppiato a `ThemeNotification`.)

## Come arriva qui una notifica

`RecordNotification::via()` (e `ChannelEnum::Sms`, `Contact`) restituiscono
`SmsChannel::class`. Laravel risolve `app(SmsChannel::class)` → autowire di
`SmsActionFactory`.

## `send(object $notifiable, Notification $notification): ?array`

1. `$notification->toSms($notifiable)` → deve restituire uno `SmsData` (altrimenti
   `Exception`). `SmsData` porta `from` / `recipient` / `body` già pronti (il
   corpo lo compone chi implementa `toSms()`, es. `SpatieEmail::buildSms()` per
   `RecordNotification`).
2. Driver: se la notifica espone `getProvider(): ?string` (es. `SmsNotification`)
   usa quello; altrimenti `null`.
3. `SmsActionFactory::create($driver)` — con `$driver === null` la factory usa
   `config('sms.default')` (env `SMS_DRIVER`).
4. `->execute($smsData)` sull'azione del driver risolto.

Ritorna quello che ritorna `SmsActionContract::execute()` — di norma
`array{status_code: int, status_txt: string}`.

## `SmsActionFactory`

Mappa esplicita `driver => Send{Provider}SMSAction::class`:
`smsfactor`, `netfun`, `twilio`, `nexmo`, `plivo`, `gammu`, `agiletelecom`.
Alias: `smsfac → smsfactor`, `vonage → nexmo`. Un driver non mappato lancia
`Exception` chiara. Ogni `Send*SMSAction` legge la propria
`config('sms.drivers.<driver>')` e lancia se non configurata.

## Usare Netfun

`.env`: `SMS_DRIVER=netfun` + `NETFUN_TOKEN=...` (`config('sms.drivers.netfun')`).
Nessuna modifica al codice — vale anche per gli SMS di invito survey
(`SendInviteAction` → `RecordNotification` → `SmsChannel`).

## Correlati

- [`ChannelEnum`](../../enums/channel-enum.md)
- [`RecordNotification`](../record-notification.md)
- `NormalizePhoneNumberAction` — la normalizzazione E.164 vive dentro le
  `Send*SMSAction`, non in `SmsChannel`.
