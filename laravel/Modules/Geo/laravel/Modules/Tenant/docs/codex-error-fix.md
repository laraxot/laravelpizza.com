# Codex Configuration Error Fixes

Questo documento descrive le correzioni applicate agli errori riscontrati durante l'avvio di `codex`.

## 1. Errori YAML negli SKILL.md

### Sintomo
`invalid YAML: mapping values are not allowed in this context` o `invalid YAML: name: invalid type: map`.

### Causa
Caratteri speciali come `:` o `{}` all'interno di valori non racchiusi tra virgolette nel frontmatter YAML.

### Soluzione
Racchiudere sempre i valori di `name` e `description` tra virgolette doppie nel frontmatter.

**Esempio Errato:**
```yaml
---
name: { my-skill-name }
description: Rule: always do X.
---
```

**Esempio Corretto:**
```yaml
---
name: "{ my-skill-name }"
description: "Rule: always do X."
---
```

---

## 2. Frontmatter Mancante

### Sintomo
`missing YAML frontmatter delimited by ---`.

### Causa
Il file `SKILL.md` inizia direttamente con il contenuto Markdown senza i metadati richiesti da `codex`.

### Soluzione
Aggiungere il blocco frontmatter all'inizio del file.

```yaml
---
name: Nome Skill
description: Breve descrizione.
version: 1.0.0
---
```

---

## 3. Fallimento Avvio MCP Server (php/artisan)

### Sintomo
`MCP client for php failed to start: No such file or directory`.

### Causa
Il comando `artisan` non viene trovato perché non è nel PATH o il percorso è relativo alla cartella sbagliata.

### Soluzione
Aggiornare la configurazione in `~/.codex/config.toml` o `.mcp.json` per usare `php` come comando e specificare il percorso corretto di `artisan` (es. `laravel/artisan`).

**Configurazione Corretta (~/.codex/config.toml):**
```toml
[mcp_servers.php]
command = "php"
args = ["laravel/artisan", "boost:mcp"]
```

**Configurazione Corretta (laravel/.mcp.json):**
```json
"laravel-boost": {
    "command": "php",
    "args": [
        "laravel/artisan",
        "boost:mcp"
    ]
}
```
