---
title: "CreateUserAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\CreateUserAction"
qmd: "CreateUserAction creazione utente password hash validazione nome email log welcome stub"
---

# CreateUserAction

Crea un nuovo utente con nome, email e password hashata; include due passi che oggi sono solo log. Codice: `app/Actions/CreateUserAction.php` (namespace `Modules\User\Actions`), righe 22-77. Non è il `execute()` standard: l'entrypoint è `handle()`.

## Input

- Costruttore: `string $name`, `string $email`, `string $password`, `?array $data` (righe 29-34).

## Output

- `User` appena creato (`handle()`, riga 45).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `CREATE-USER-INV-1` | Nome e email non vuoti ed email valida, altrimenti `InvalidArgumentException` alla costruzione. | righe 36-42 | Test: riferimenti per nome in `tests/Unit/Actions/AdditionalActionsTest.php`, `tests/Unit/Actions/User/CreateUserActionTest.php`, `tests/Unit/QuickWins/UserQuickWinsCoverageTest.php`; non attribuiti con certezza a questa classe (esiste anche `User/CreateUserAction`). |
| `CREATE-USER-INV-2` | La password è salvata solo come hash `Hash::make`, salvo che `$data` contenga una chiave `password` che la sovrascrive (spread dopo). | righe 48-53 | come sopra |
| `CREATE-USER-INV-3` | `$data` può sovrascrivere anche `name` ed `email` già impostati. | riga 52 | come sopra |

## Effetti collaterali

Nell'ordine: INSERT in `users` tramite `User::create`; poi `Log::info` con l'indirizzo email (riga 69) e `Log::info` di audit (riga 75). Nessuna mail, nessun evento esplicito, nessuna transazione.

## Errori

- `InvalidArgumentException` dal costruttore per nome/email vuoti o email non valida.
- Errori del database si propagano.

## Non fa

- Non invia la mail di benvenuto: `sendWelcomeEmail` scrive solo un log.
- Non scrive un audit log: `createAuditLog` scrive solo un log.
- Problema: il log in riga 69 contiene l'email (dato personale) in chiaro.
- Non è richiamabile con `execute()` dal trait `QueueableAction`: va costruita e chiamata con `handle()`.
