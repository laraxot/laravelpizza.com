---
title: "IDE Helper Models Wave"
type: concept
tags: [ide, helper, models, wave]
created: 2026-07-14
updated: 2026-07-14
qmd: "ide-helper-models-wave ide helper models wave"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

# IDE Helper Models Wave

## Wave 2026-03-10

### Contesto

```bash
cd laravel && php artisan ide-helper:models -W
```

Il primo run nel sandbox mostrava errori di connessione per model multi-connessione come `Modules\Activity\Models\Activity` e `Modules\Xot\Models\Session`.

### Diagnosi corretta

Il problema iniziale non era nel codice dei model ma nell'accesso al database locale dal sandbox.

Dopo il rerun con accesso DB reale, la wave `ide-helper` ha completato la rigenerazione dei PHPDoc senza classi `Could not analyze`.

### Impatto

- i wrapper Passport e i model Sushi del modulo `User` restano compatibili con `ide-helper`;
- i PHPDoc dei model `User` sono stati riallineati al database corrente;
- la procedura corretta da ricordare e': prima distinguere errore ambientale da errore del model, poi correggere solo i casi reali.

---

## Wave 2026-07-15

### Comando

```bash
cd laravel && php artisan ide-helper:models --no-interaction
```

### Segnalazioni User (scopo, non sintomo)

| Model | Errore | Scopo business |
|-------|--------|----------------|
| `OauthAccessToken` | `user()` → provider on null | Token API collegati a utente/guard del client OAuth |
| `OauthToken` | idem | Model **canonico** Eloquent Passport nel modulo User |

Passport risolve `user()` così (`vendor/laravel/passport/src/Token.php`):

```php
$provider = $this->client->provider ?: config('auth.guards.api.provider');
$model = config('auth.providers.'.$provider.'.model');
return $this->belongsTo($model, ...);
```

ide-helper, per inferire il tipo di ritorno della relazione, invoca la risoluzione in assenza di `client` loaded → `$this->client` è null.

### Filosofia

- **Politica User:** wrapper locali allineati a Passport Eloquent; no relazioni fallback ad hoc ([fix-ide-helper-relation-errors](./fix-ide-helper-relation-errors.md)).
- **Religione:** il tipo utente deve venire da `auth.providers.*.model`, non da guess nel tema.
- **Zen:** il warning non invalida OAuth runtime (client esiste su token reali); segnala che il wrapper deve essere **analizzabile in isolamento**.

### Doc di riferimento

- [oauth-token-relations-ide-helper](./oauth-token-relations-ide-helper.md)
- [ide-helper-philosophy](../Xot/docs/ide-helper-philosophy.md)
- [passport-model-wrappers](./passport-model-wrappers.md)
