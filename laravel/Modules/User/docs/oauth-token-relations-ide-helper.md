---
name: oauth-token-relations-ide-helper
description: |
  Perché OauthAccessToken e OauthToken falliscono durante ide-helper.
  Problema di relazioni nullable in Passport, soluzioni architetturali.
metadata:
  module: User
  type: architecture
  severity: medium
  status: implemented
  last_run: 2026-07-15
  relates_to: passport, oauth
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
title: "OAuth Token: Relazioni Nullable e IDE Helper"
type: note
status: draft
updated: 2026-10-07
tags: [docs, user]
qmd: "oauth token: relazioni nullable e ide helper user"
---

# OAuth Token: Relazioni Nullable e IDE Helper

## Problema

Durante `php artisan ide-helper:models`:

```
Error resolving relation model of Modules\User\Models\OauthAccessToken:user() : 
  Attempt to read property "provider" on null
  
Error resolving relation model of Modules\User\Models\OauthToken:user() : 
  Attempt to read property "provider" on null
```

Entrambi i modelli ereditano da `Laravel\Passport\Token`.

## Root Cause: relazione `user()` assume client populated

**In Passport** (`vendor/laravel/passport/src/Token.php`):

```php
public function user(): BelongsTo
{
    $provider = $this->client->provider ?: config('auth.guards.api.provider');
    // ...
}
```

**Cosa succede durante IDE Helper (confermato 2026-07-15):**

1. ide-helper analizza `OauthAccessToken` / `OauthToken`
2. Per PHPDoc relazione `user()`, risolve il model di ritorno
3. Esecuzione logica `user()` con `$this->client === null`
4. `null->provider` → `Error resolving relation model`

Nota: il messaggio cita `user()`: non è obbligatoriamente il `__construct` parent; è la **risoluzione della relazione** durante analisi.

## Filosofia: Relazioni Lazy vs. Eager

### Il Principio

Eloquent Models devono essere **costruibili in isolamento**, senza richiedere relazioni populate.

**Corretto:**
```php
// ✅ Il modello sa gestire relazioni mancanti
protected function getUserProvider(): string {
    if ($this->relationLoaded('client') && $this->client) {
        return $this->client->provider;
    }
    return config('auth.guards.api.provider');
}
```

**Sbagliato:**
```php
// ❌ Assume sempre che $this->client esista e sia populated
$provider = $this->client->provider;  // Fail se null!
```

## Soluzioni

### Soluzione implementata (2026-07-15)

Trait `Modules\User\Traits\ResolvesPassportTokenUserRelation`:

- `$this->client?->provider` con fallback su `config('auth.guards.api.provider')`
- stessa semantica Passport, null-safe per ide-helper e edge runtime
- usato da `OauthToken` e `OauthAccessToken`
- **rimosso** bypass `__construct` (Passport Token non ha construct custom; l'errore era su `user()`)

Verifica: `php artisan ide-helper:models --no-interaction` → zero segnalazioni.

### Soluzione 2: Trait Helper per Entrambi

Crea un trait condiviso:

```php
// Modules/User/app/Traits/IdeHelperSafeModel.php
namespace Modules\User\Traits;

trait IdeHelperSafeModel {
    protected function isRunningIdeHelper(): bool {
        return in_array('ide-helper:models', $_SERVER['argv'] ?? [], true)
            || defined('PHPSTAN_RUNNING');
    }
}

// Modules/User/app/Models/OauthAccessToken.php
class OauthAccessToken extends PassportToken {
    use IdeHelperSafeModel;
    
    public function __construct(array $attributes = []) {
        if ($this->isRunningIdeHelper()) {
            // Costruzione minima, evita Passport's construct
            Model::__construct($attributes);
            return;
        }
        parent::__construct($attributes);
    }
}

// Modules/User/app/Models/OauthToken.php
class OauthToken extends PassportToken {
    use IdeHelperSafeModel;
    
    public function __construct(array $attributes = []) {
        if ($this->isRunningIdeHelper()) {
            Model::__construct($attributes);
            return;
        }
        parent::__construct($attributes);
    }
}
```

**Pro:**
- DRY: logica in un'unico posto
- Riutilizzabile per altri moduli

### Soluzione 3: Escludere da IDE Helper

Se le soluzioni 1-2 sono complesse, escludere dal processo:

```bash
# In un file di configurazione o nella skill ide-helper
php artisan ide-helper:models --exclude="OauthAccessToken,OauthToken"
```

**Pro:**
- Zero impatto su codice
- Semplice

**Contro:**
- Perde autocompletamento per questi modelli
- Non risolve il problema, lo evita

## Architettura: Quando Usare Relazioni

### Modelli dovrebbero comportarsi così:

1. **Costruzione minima**: `new Model()` non accede a relazioni
2. **Relazioni lazy-loaded**: `$model->relation` carica solo se necessario
3. **Relazioni fallible**: Se non populated, ritorna default o null
4. **Guard espliciti**: `if ($this->relationLoaded('relation'))` prima di accedere

### Passport viola questi principi

Passport accede a relazioni durante `__construct()`. I nostri modelli ereditano questo comportamento.

## Implementazione Raccomandata

**Passo 1:** Crea il trait
```bash
# Modules/User/app/Traits/IdeHelperSafeModel.php
```

**Passo 2:** Aggiorna OauthAccessToken
```bash
# Modules/User/app/Models/OauthAccessToken.php
```

**Passo 3:** Aggiorna OauthToken
```bash
# Modules/User/app/Models/OauthToken.php
```

**Passo 4:** Test
```bash
cd laravel && php artisan ide-helper:models --verbose
```

Dovrebbe passare senza errori e generare `_ide_helper_models.php`.

---

**Vedi anche:**
- [ide-helper-philosophy](../Xot/docs/ide-helper-philosophy.md): Filosofia generale
- [fix-ide-helper-relation-errors](./fix-ide-helper-relation-errors.md): Regole fix User
- [user-module-architecture](./passport-model-wrappers.md): Wrapper Passport
