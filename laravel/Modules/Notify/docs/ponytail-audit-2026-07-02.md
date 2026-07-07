# Ponytail-audit 2026-07-02: Notify module findings

Source: repo-wide ponytail-audit, published as GitHub issues [#103](https://github.com/laraxot/base_quaeris_fila5/issues/103) and [#112](https://github.com/laraxot/base_quaeris_fila5/issues/112), summarized in discussion [#114](https://github.com/laraxot/base_quaeris_fila5/discussions/114).

## Finding

`Modules/Notify/app/Services/NotificationManager.php` is a thin wrapper that delegates almost every call to `SendNotificationAction`, and its `send()` method throws a generic `Exception` with a string message instead of using Laravel conventions (`firstOrFail`) or a typed domain exception.

## Why this is not just a style nit

Discussion [#82](https://github.com/laraxot/base_quaeris_fila5/discussions/82) / [#83](https://github.com/laraxot/base_quaeris_fila5/discussions/83) established a repository-wide architecture rule: **business logic must live in `QueueableAction` classes (`spatie/laravel-queueable-action`), never in Service classes.** `Modules/Xot/app/Services/` and `Modules/Job/app/Services/` are the only allowed exception (framework wrappers, not business logic).

`NotificationManager` is exactly the forbidden pattern this rule targets: a Service class sitting in front of an Action. Removing it is not just a YAGNI cleanup, it is compliance with an already-ratified architecture decision.

## Fix direction

1. Delete `NotificationManager`; call `app(SendNotificationAction::class)->execute(...)` directly at call sites (or `->onQueue()->execute(...)` for async).
2. Inside `SendNotificationAction`, replace the manual template lookup + generic `Exception` with `NotificationTemplate::where('code', $templateCode)->firstOrFail()` and a typed domain exception (e.g. `NotificationTemplateNotFoundException`).
3. Follow the pattern documented in `.claude/skills/create-action/SKILL.md` and `.claude/docs/spatie-queueable-action.md`.

## Related

- Discussion #82/#83: Actions over Services architecture decision (canonical rule).
- Issue #103: NotificationManager wrapper removal (yagni).
- Issue #112: firstOrFail + domain exception (stdlib).
- Known doc-sprawl debt in this module (discussion #22) is out of scope here; `Modules/Notify/docs/` still has duplicate `README.md`/`index.md`/`INDEX.md`/`00-index.md` entrypoints pending consolidation.

## 2026-07-02 (second pass): collapsed single-driver Sms/Telegram/WhatsApp factories

### Finding

`app/Factories/SmsActionFactory.php`, `TelegramActionFactory.php`, `WhatsAppActionFactory.php` each do class-name-convention dynamic resolution (a `supportedDrivers` list + `Send{Driver}{Channel}Action` string-built class name) to select the concrete Action at runtime. This pattern is only justified when there are multiple interchangeable implementations selected at runtime.

### What was actually true per factory

Checked `app/Actions/{SMS,Telegram,WhatsApp}/` directly rather than trusting the summary:

- **SMS**: exactly one implementation, `SendSmsFactorSMSAction`. Matches the pattern — collapsed.
- **Telegram**: three implementations, `SendBotmanTelegramAction`, `SendNutgramTelegramAction`, `SendOfficialTelegramAction`, genuinely selected by `telegram.default` config at runtime. Does **not** match the pattern — left in place.
- **WhatsApp**: four implementations, `Send360dialogWhatsAppAction`, `SendFacebookWhatsAppAction`, `SendTwilioWhatsAppAction`, `SendVonageWhatsAppAction`, genuinely selected by `whatsapp.default` config at runtime. Does **not** match the pattern — left in place.

### Fix applied (SMS only)

1. Deleted `app/Factories/SmsActionFactory.php`.
2. Replaced `app(SmsActionFactory::class)->create()` / constructor-injected `SmsActionFactory` with direct container resolution of the concrete `Modules\Notify\Actions\SMS\SendSmsFactorSMSAction` at all three call sites:
   - `app/Notifications/Channels/NetfunChannel.php` — `app(SendSmsFactorSMSAction::class)` inline (no constructor).
   - `app/Channels/NetfunChannel.php` — constructor now type-hints `SendSmsFactorSMSAction $action` directly, calls `$this->action->execute($smsData)`.
   - `app/Channels/SmsChannel.php` — same pattern, `SendSmsFactorSMSAction $action` constructor property.
3. Kept `app/Contracts/SMS/SmsActionContract.php` — it is the Action's own interface (return type for `execute()`), not a `*FactoryContract` wrapper, and remains used for type-hinting in tests and at call sites. Not a target for this cleanup.
4. Updated tests to resolve/bind the concrete action instead of the factory:
   - `tests/Unit/Factories/ActionFactoriesTest.php` — SMS factory test replaced with a direct `app(SendSmsFactorSMSAction::class)` resolution test; Telegram/WhatsApp factory tests untouched.
   - `tests/Unit/Notifications/Channels/NotificationsChannelsTest.php` — mock now bound via `app()->instance(SendSmsFactorSMSAction::class, ...)` instead of subclassing `SmsActionFactory`.
   - `tests/Unit/Channels/SmsChannelTest.php` — reflection test updated from `factory` property to `action` property.

### Verification

- `phpstan analyse Modules/Notify`: blocked repo-wide by a pre-existing, unrelated Laravel bootstrap failure (`Modules/Xot/app/Contracts/ModelContract.php` missing on disk — confirmed via `git status` as already-deleted working-tree state before this task started). Not caused by this change.
- `phpmd.phar Modules/Notify ... cleancode,codesize,controversial,design,naming,unusedcode`: crashes module-wide on an unrelated file (pre-existing phpmd/parser bug). Re-ran scoped to only the three edited production files — clean except one pre-existing `StaticAccess` notice in `app/Channels/NetfunChannel.php` unrelated to the factory removal.
- `phpinsights analyse Modules/Notify --no-interaction`: ran clean; grepped output for all touched files (`SmsChannel.php`, both `NetfunChannel.php`, `SendSmsFactorSMSAction.php`, and the three edited test files) — zero hits, no new issues introduced.
- Pest: skipped, test DB unreachable in this environment (`Access denied for user`), per task instructions.
- Puppeteer/playwright-mcp: skipped — this is backend messaging-dispatch code with no renderable UI.

### Not collapsed (report only)

Telegram and WhatsApp factories were left untouched because both genuinely have 2+ swappable runtime-selected drivers, which is exactly the case the Factory pattern exists for.
