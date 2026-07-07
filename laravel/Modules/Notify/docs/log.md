# Wiki Log

Registro cronologico delle operazioni sulla wiki.
Formato: `## [YYYY-MM-DD] tipo | Descrizione`

## Convenzioni

- **ingest**: Aggiunta di nuovi sorgenti o creazione di pagine
- **query**: Domande e risposte salvate
- **lint**: Controllo salute e manutenzione
- **update**: Aggiornamento di pagine esistenti
- **refactor**: Ristrutturazione della wiki

## Istruzioni per l'LLM

Quando esegui un'operazione:
1. Appendi un entry in questo formato
2. Usa timestamp ISO 8601
3. Includi link alle pagine create/aggiornate

---

## [2026-04-15] bootstrap | Initial Wiki Setup

- Creato schema [[.schema/WIKI_SCHEMA.md]]
- Creato [[wiki/index.md]] con struttura
- Create cartelle `wiki/` e `raw/` per:
  - Root `docs/`
  - Tutti i moduli in `laravel/Modules/*/docs/`
  - Tutti i temi in `laravel/Themes/*/docs/`

---

<!-- Aggiungi nuove entries qui -->

## [2026-04-16] update | PHPStan module workflow governance

- Aggiunto [[wiki/concepts/phpstan-central-config-rule.md]]
- Aggiornato [[wiki/index.md]]
- Registrata la regola operativa: usare sempre `cd laravel && ./vendor/bin/phpstan analyse Modules/<ModuleName>` con config centrale `laravel/phpstan.neon`

## [2026-04-16] update | PHPStan full-project-first rule

- Aggiornato [[wiki/concepts/phpstan-central-config-rule.md]]
- Registrata la regola operativa: validare prima l'intero progetto con `cd laravel && ./vendor/bin/phpstan analyse`
- Solo se il rumore è troppo alto, scendere a validazione modulo per modulo
