# Verifica Percorso Config Tenant - Reverse Domain Notation

**Status**: ✅ Verificato e Documentato
**Scopo**: Verificare e documentare il percorso corretto per i file di configurazione tenant

---

## 🎯 La Filosofia: Reverse Domain Notation

### Come Funziona

Il sistema usa **Reverse Domain Notation** (standard industry usato da Java, Android, iOS):

1. **Input**: Dominio `laravelpizza.local` (da `$_SERVER['SERVER_NAME']` o `APP_URL`)
2. **Split**: `['laravelpizza', 'local']`
3. **Reverse**: `['local', 'laravelpizza']` ← **Environment prima, Tenant dopo**
4. **Path**: `config/local/laravelpizza/`

### Perché Reverse?

**Gerarchia logica dal generale allo specifico**:
- `local/` = Environment (generale)
- `laravelpizza/` = Tenant (specifico)

Questo permette:
- ✅ Stesso tenant su più environment: `config/local/laravelpizza/`, `config/staging/laravelpizza/`, `config/production/laravelpizza/`
- ✅ Stesso environment con più tenant: `config/local/laravelpizza/`, `config/local/anothertenant/`
- ✅ Scalabilità perfetta

---

## ✅ Percorso CORRETTO

**Path da usare SEMPRE**: `config/local/laravelpizza/`

### Struttura Directory

```
config/
└── local/                          ← Environment: local development
    └── laravelpizza/               ← Tenant: laravelpizza site
        ├── app.php                 ← Config PHP
        ├── database.php
        ├── database/
        │   └── content/            ← Contenuti JSON
        │       ├── pages/
        │       │   ├── home.json
        │       │   ├── about.json  ✅ CORRETTO
        │       │   ├── contact.json ✅ CORRETTO
        │       │   └── events.json
        │       └── sections/
        └── lang/
            └── it/
```

---

## ❌ Percorso SBAGLIATO

**NON usare MAI**: `config/laravelpizza.local/`

**Perché è sbagliato**:
- ❌ Non segue reverse-domain notation
- ❌ Mescola environment con tenant name
- ❌ Non scala (come gestisci `laravelpizza.staging`, `laravelpizza.production`?)
- ❌ Non è implementato nel codice

---

## 🔍 Implementazione nel Codice

### GetTenantNameAction

```php
// Input: $_SERVER['SERVER_NAME'] = "laravelpizza.local"
$server_name = Str::of($server_name)->replace('www.', '')->toString();
// $server_name = "laravelpizza.local"

$parts = collect(explode('.', $server_name))
    ->map(fn (string $part): string => Str::slug($part))
    ->reverse()  // ← REVERSE!
    ->values();
// $parts = ['local', 'laravelpizza']

$config_file = config_path($parts->implode('/'));
// $config_file = "config/local/laravelpizza/"

if (file_exists($config_file)) {
    return $parts->implode('/');  // "local/laravelpizza"
}
```

### GetTenantFilePathAction

```php
$tenantName = app(GetTenantNameAction::class)->execute();
// $tenantName = "local/laravelpizza"

$path = base_path('config/'.$tenantName.'/'.$filename);
// $path = "config/local/laravelpizza/{filename}"
```

---

## ✅ Verifica File Creati

### File JSON Pagine

I file JSON per le pagine About e Contact sono stati creati nel percorso **CORRETTO**:

- ✅ `config/local/laravelpizza/database/content/pages/about.json`
- ✅ `config/local/laravelpizza/database/content/pages/contact.json`

**Confermato**: I file sono nel percorso corretto secondo la filosofia reverse-domain.

---

## 📚 Riferimenti

- [Tenant Config Path Philosophy Debate](../../modules/tenant/docs/tenant-config-path-philosophy-debate.md) - Dibattito completo sulla filosofia
- [Tenant Configuration](../../modules/tenant/docs/configuration.md) - Documentazione ufficiale
- [Configuration Logic Analysis](../../modules/tenant/docs/configuration-logic-analysis.md) - Analisi logica completa

---

## 🎯 Regola d'Oro

**SEMPRE usare**: `config/{environment}/{tenant}/`

**MAI usare**: `config/{tenant}.{environment}/`

---

**
**Versione**: 1.0.0
**Status**: ✅ Verificato e Documentato
