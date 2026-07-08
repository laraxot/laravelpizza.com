# PHPStan Remediation Plan – Notify (23 Dic 2025)

## Contesto

- `./vendor/bin/phpstan analyse Modules/Notify` produce 8 errori (vedi `laravel/phpstan-Modules-Notify.json`).
- Gli errori bloccano l’uso delle azioni Filament di notifica bulk e la generazione di email.

## Errori principali

1. **Classe mancante**
   - File: `app/Filament/Actions/SendNotificationBulkAction.php` linee 79-82.
   - Sintomi: `Modules\Notify\Actions\SendRecordsNotificationBulkAction` non esiste; la PHPDoc e la chiamata `execute()` puntano a una classe inesistente.
2. **Tipi canali errati**
   - File: `app/Actions/SendRecordsNotificationAction.php` linee 64, 81.
   - Sintomi: passiamo array di stringhe (es. `'mail'`) a metodi che aspettano `array<int, ChannelEnum>`; array_map riceve una closure tipizzata su `ChannelEnum` ma gli arrivano stringhe.
3. **Email layout key nullable**
   - File: `app/Emails/SpatieEmail.php` linea 150.
   - Sintomi: `XotData::getMailHtmlLayoutPath()` richiede `string $key`, ma `SpatieEmail` gli passa `string|null`.
4. **PHPDoc Enum errata**
   - File: `app/Enums/ChannelEnum.php` linea 43.
   - Sintomi: PHPDoc cita `$channelEnum` che non esiste; serve documentare i parametri reali (es. `$value`).

## Piano di intervento

1. **Ripristinare l’azione bulk mancante**
   - Creare `app/Actions/SendRecordsNotificationBulkAction.php` che riceve `Collection $records`, costruisce il DTO `SendNotificationBulkResultData` e riusa `SendRecordNotificationAction`.
   - Registrare la nuova action in `SendNotificationBulkAction` via dependency injection (niente `app()` dinamico).
2. **Uniformare i tipi dei canali**
   - In `SendRecordsNotificationAction`, convertire gli input stringa (provenienti dai form Filament) in enum con `ChannelEnum::from($value)` e validare con Webmozart Assert (`Assert::allOneOf`).
   - Aggiornare le signature: `array<int, ChannelEnum>` e documentare bene il DTO `SendNotificationBulkResultData`.
3. **Gestire layout key nullable**
   - In `SpatieEmail`, definire fallback (`$layoutKey = $this->layoutKey ?? 'default'`) prima di chiamare `getMailHtmlLayoutPath`.
4. **Correggere PHPDoc Enum**
   - Aggiornare `ChannelEnum` con PHPDoc coerenti e, se necessario, metodi helper per ottenere l’etichetta.

## Strategia QA

1. Dopo ogni fix eseguire `./vendor/bin/phpstan analyse Modules/Notify`.
2. Far seguire `./vendor/bin/phpmd Modules/Notify text cleancode,codesize,controversial,design,naming,unusedcode`.
3. Eseguire `./vendor/bin/phpinsights -n analyse Modules/Notify` (o comando equivalente definito nel progetto) per allineare i report.

## Da migliorare (DRY + KISS)

- Documentare in `docs/notification-system.md` l’unica action da usare per bulk vs single; evitare duplicati `SendRecords*`.
- Centralizzare la conversione `string → ChannelEnum` in un helper/DTO così da non ripeterla in form/action.
- Introdurre test Pest per `SendNotificationBulkAction` e `SpatieEmail` così da prevenire future regressioni di tipo.
