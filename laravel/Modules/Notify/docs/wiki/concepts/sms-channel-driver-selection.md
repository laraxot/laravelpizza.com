---
issues: []
discussions: []
title: "SmsChannel: selezione driver da config"
type: concept
status: canonical
module: Notify
created: 2026-09-10
updated: 2026-09-11
tags: [sms, channel, driver, netfun, smsfactor, factory, config, gotcha, contracts, datas]
qmd: "smschannel sms driver selection factory config sms.default SMS_DRIVER netfun smsfactor SendNetfunSMSAction SmsActionFactory hardcoded regression b8321c567 SmsActionContract Models/Contracts SmsData Spatie LaravelData Data"
related:
  - ./one-migration-consolidamento-wave2.md
  - ../../../../Quaeris/docs/stories/quaeris-send-invite-migrate-to-record-notification.md
---

# `SmsChannel` sceglie il driver da `config('sms.default')`

## Come funziona ora

`RecordNotification::via()` (e `ChannelEnum::Sms`, `Contact`) indirizzano gli SMS
su `Modules\Notify\Channels\SmsChannel`. `SmsChannel`:

1. costruisce `SmsData` da `$notification->toSms(...)`;
2. sceglie il driver: se la notifica espone `getProvider(): ?string` (es.
   `SmsNotification`) usa quello, altrimenti `null`;
3. `SmsActionFactory::create($driver)`: con `$driver === null` la factory usa
   `config('sms.default')` (env `SMS_DRIVER`);
4. `->execute($smsData)` sull'action del driver.

Quindi **`SMS_DRIVER=netfun`** + `config('sms.drivers.netfun')` valorizzato
(`NETFUN_TOKEN`) fa passare gli SMS: inclusi quelli di invito survey: da
**Netfun**, senza toccare codice. Default: `smsfactor`.

## `SmsActionFactory`: mappa esplicita, non convenzione

`create()` usa una mappa `driver => Send{Provider}SMSAction::class`
(`smsfactor`/`netfun`/`twilio`/`nexmo`/`plivo`/`gammu`/`agiletelecom`). Un
driver non mappato lancia un'eccezione chiara.

**Perché non la convenzione di naming**: la versione precedente costruiva il
nome classe con `'Send'.ucfirst($driver).'SMSAction'`. Su `smsfactor` dava
`SendSmsfactorSMSAction`: classe **inesistente** (la vera è
`SendSmsFactorSMSAction`, con la F maiuscola). La factory era di fatto rotta
proprio sul driver di default.

## Storia: regressione 2026-07-02

Il commit `b8321c567` (*"Refactored SMS notification channels to utilize
SendSmsFactorSMSAction directly, removing the SmsActionFactory for
simplicity"*) aveva cablato `SmsChannel::__construct(SendSmsFactorSMSAction
$action)`: da lì gli SMS andavano **sempre** su SMSFactor, `SMS_DRIVER`
ignorato, e `SmsActionFactory` era codice morto (oltre che rotto sul default).

2026-09-10: ripristinata la selezione da config in `SmsChannel`, e sistemata
`SmsActionFactory` con la mappa esplicita.

## Nota repo: la versione corrente non è una copia del sub-repo

`module_notify_fila5` (sub-repo) e il repo root sono stati a lungo divergenti su
`SmsChannel.php`: il sub-repo conservava la versione factory-based
(config-driven), il root quella cablata su SMSFactor.

La versione corrente **non** è una copia verbatim del sub-repo: è il suo design
(config-driven) con dei miglioramenti, perché il sub-repo `SmsActionFactory` ha
lo stesso bug del casing (`smsfactor` → `SendSmsfactorSMSAction`).

| Aspetto | Sub-repo `module_notify_fila5` HEAD | Versione corrente (progetto) |
|---|---|---|
| `SmsChannel` | config-driven, `create()` senza arg | config-driven + override per-notifica `getProvider()` |
| `SmsChannel::send()` firma | `$notifiable` non tipato, no return type | `object $notifiable`, `: ?array` |
| `SmsActionFactory` | convenzione `ucfirst()` + `class_exists` + `Log::warning`: rotta su `smsfactor` | mappa esplicita `driver => Send{Provider}SMSAction::class`, funziona per tutti |
| alias | `smsfac`, `vonage`, + alcuni morti (`aws`/`amazon` senza action) | `smsfac`, `vonage` |

Va committata in **entrambi** i repo (root + `laravel/Modules/Notify` con i suoi
remote).

## Posizione contratto e forma di `SmsData` (allineamento a start.md §3)

`start.md` §3 *"Regole architetturali non negoziabili"*:

- **Contracts** → sempre in `Models/Contracts/`, mai in `app/Contracts/` né in
  sottocartelle come `app/Contracts/SMS/`. Suffisso `*Contract`.
- **Datas** → in `app/Datas/`, classe `*Data` che **estende
  `Spatie\LaravelData\Data`**.

Stato dal 2026-09-11:

| Elemento | Prima | Ora |
|---|---|---|
| `SmsActionContract` | `app/Contracts/SMS/SmsActionContract.php` (namespace `Modules\Notify\Contracts\SMS`) + un duplicato morto in `app/Contracts/SmsActionContract.php` | `app/Models/Contracts/SmsActionContract.php`: `Modules\Notify\Models\Contracts\SmsActionContract`. Duplicato eliminato. |
| `SmsData` | DTO plain (`final class SmsData`, `__construct(array $data)`, `from()` fatto a mano) | `final class SmsData extends Spatie\LaravelData\Data` con costruttore promosso `string $from/$recipient/$body = ''`; `::from([...])` è quello di Spatie. |

Le 9 `Send*SMSAction`, `SmsActionFactory` e i relativi test importano il nuovo
namespace. I chiamanti di `SmsData` usavano già tutti `SmsData::from([...])` -
nessuna modifica ai call site.

> **Nota env**: `SmsData::from()` ora passa dalla pipeline di Spatie Data (usa il
> container). Nel bootstrap Unit rotto di questo ambiente `Data::from()` fallisce
> già per `EmailData`/`WhatsAppData`/`NotificationData` (`Target class [config]
> does not exist`); dopo l'allineamento anche `SmsData` è nello stesso gruppo. In
> runtime bootstrappato correttamente funziona: verificato via tinker.

> I contract *fratelli* ancora in `app/Contracts/` (`SmsProviderContract`,
> `TelegramProviderActionContract`, `WhatsAppProviderActionContract`,
> `NotificationDispatcherContract`, …) restano non conformi: migrazione a parte,
> fuori dallo scope di questo intervento SMS.
