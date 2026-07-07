---
title: "Consolidamento Actions/SMS e Contracts (ponytail audit)"
type: decision
tags: [notify, sms, ponytail, contracts, factory, actions]
created: 2026-06-30
updated: 2026-07-01
qmd: "Notify SMS Actions consolidation SmsActionFactory SmsActionContract ponytail audit smsfactor"
issues:
  - "https://github.com/laraxot/base_predict_fila5/issues/221"
discussions:
  - "https://github.com/laraxot/base_predict_fila5/discussions/222"
  - "https://github.com/laraxot/base_predict_fila5/discussions/228"
related:
  - ../../ponytail-audit-over-engineering.md
  - ../../sms-provider-architecture.md
---

# Consolidamento Actions/SMS e Contracts (ponytail audit)

## Stato 2026-07-01 (run #4)

Driver canonico: **`smsfactor`** (`config/sms.php` default).

- 8 action SMS inattive + `NetfunSendAction` → `.php.bak`
- 5 Data class driver inattivi → `.php.bak`
- Contratti root duplicati eliminati (N3/N4)
- `SmsDriverEnum` → solo `SMSFACTOR`
- `SmsActionFactory` → solo `smsfactor`
- Canali `NetfunChannel` (entrambi) → `SmsActionFactory`

Dettaglio file: [ponytail-audit-over-engineering.md](../../ponytail-audit-over-engineering.md).

## Contesto (run #1–#3)

L'audit ponytail (`docs/ponytail-audit-over-engineering.md`, finding N1/N2/N3/N4) segnalava
`app/Actions/SMS/` con 9 classi `Send*SMSAction` per 7 provider quando `config/sms.php`
ha come default solo `smsfactor`, più contratti SMS duplicati in `app/Contracts/` (root)
invece che in `app/Contracts/SMS/`.

## Cosa è stato verificato (regola d'oro: tracciare tutti i chiamanti)

1. **Contratti SMS**: i duplicati root (`app/Contracts/SmsActionContract.php`,
   `app/Contracts/SmsProviderContract.php`, finding N3/N4) **risultano già rimossi**
   da un commit precedente (`35d858b57`). Resta solo `app/Contracts/SMS/SmsActionContract.php`,
   namespace corretto, implementato da tutte le 9 azioni. Nessuna azione necessaria.

2. **Driver SMS realmente raggiungibili in produzione**: a differenza di quanto
   ipotizzato nell'audit, `smsfactor` non è l'unico driver raggiungibile:
   - `Modules\Notify\Enums\SmsDriverEnum` espone 7 case (smsfactor, twilio, nexmo,
     plivo, gammu, netfun, agiletelecom), usati da una `Select` nella pagina Filament
     `app/Filament/Clusters/Test/Pages/SendSmsPage.php` (cluster "Test", ma codice
     live e raggiungibile da qualunque admin con permesso sul pannello).
   - `netfun` ha inoltre wiring dedicato: `app/Channels/NetfunChannel.php`,
     `app/Notifications/Channels/NetfunChannel.php` (duplicato, fuori scope di
     questo intervento), `app/Filament/Clusters/Test/Pages/SendNetfunSmsPage.php`,
     e `services.netfun.token` presente in tutti i config per-tenant
     (`config/*/services.php`).
   - Due suite di test (`SmsDriverEnumTest.php`, `NotifyEnumsCoverageTest.php`)
     asseriscono esplicitamente `SmsDriverEnum::cases()` count = 7: l'architettura
     multi-provider è quindi un comportamento testato/intenzionale, non solo bloat.

   Conclusione: rinominare in `.bak` le azioni Twilio/Nexmo/Plivo/Gammu/Agiletelecom
   (wrapper+v2)/Netfun avrebbe rotto la dropdown della pagina Filament di test e
   2 suite di test esistenti, violando sia "Regola d'oro" sia "consolida senza
   rompere nulla". Non sono state toccate: richiede una decisione esplicita
   separata (rimuovere i case enum + pagina di test + lang file, oppure confermare
   che il multi-provider è voluto) prima di poter rimuovere altro codice.

3. **Codice realmente orfano confermato e consolidato** (zero chiamanti, anche
   dinamici, fuori dal proprio test):
   - `app/Actions/SMS/SendAgiletelecomSMSv1Action.php` — la factory/enum risolvono
     sempre e solo `SendAgiletelecomSMSAction` (wrapper che delega a `...v2Action`);
     la v1 non è mai istanziata da nessun punto del codice. Rinominata `.bak`.
   - `app/Actions/NormalizePhoneNumberAction.php` (namespace root, diverso da
     `app/Actions/SMS/NormalizePhoneNumberAction.php` che resta attivo e usato
     da `ChannelEnum`, `RecordNotificationData`, `SendNetfunSMSAction`) — duplicato
     orfano, usato solo dal proprio test. Rinominata `.bak`.

## File modificati

| File | Esito |
|---|---|
| `app/Actions/SMS/SendAgiletelecomSMSv1Action.php` | rinominato `.php.bak` |
| `tests/Unit/Actions/SMS/SendAgiletelecomSMSv1ActionTest.php` | rinominato `.php.bak` |
| `app/Actions/NormalizePhoneNumberAction.php` | rinominato `.php.bak` |
| `tests/Unit/Actions/NormalizePhoneNumberActionTest.php` | rinominato `.php.bak` |

## Pattern driver+factory (già presente, non duplicato)

`app/Factories/SmsActionFactory.php` + `app/Contracts/SMS/SmsActionContract.php` sono
già il pattern minimale richiesto (1 contratto + 1 factory con risoluzione dinamica
per convenzione di naming `Send{Driver}SMSAction`). Non è stata creata nessuna nuova
astrazione.

## Follow-up consigliato (fuori scope di questo intervento)

Per ridurre realmente il numero di provider SMS occorre, in un intervento dedicato:
1. Decidere quali driver restano supportati in produzione (oggi: smsfactor configurato,
   netfun con wiring dedicato ma senza credenziali in `.env`/`.env.example`).
2. Aggiornare `SmsDriverEnum` (rimuovere i case non supportati).
3. Aggiornare `SmsActionFactory::$supportedDrivers`.
4. Aggiornare/rimuovere `SmsDriverEnumTest.php` e `NotifyEnumsCoverageTest.php`.
5. Aggiornare `config/sms.php` (sezione `drivers`) e i lang file `sms*.php` (it/en/de).
6. Solo a quel punto rinominare in `.bak` le azioni Twilio/Nexmo/Plivo/Gammu/Agiletelecom.

## Nota disco

Durante questo intervento il filesystem host era pieno (260MB liberi su 460GB).
Eventuali ulteriori controlli (PHPStan/PHPMD/PHPInsights/Pest) potrebbero essere
stati eseguiti in condizioni di spazio disco limitato: vedi report finale dell'agente
per l'esito effettivo di ciascun tool.
