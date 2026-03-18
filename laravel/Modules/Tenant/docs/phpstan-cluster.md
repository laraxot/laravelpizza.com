# PHPStan Cluster - 2026-03-10

## Stato attuale

Il cluster `Tenant` e' piccolo ma netto: `DatabaseConfigFactory` punta a `Modules\Tenant\Models\DatabaseConfig`, mentre il modello non esiste nel modulo.

## Root cause

- Factory e resolver configurazione database si sono evoluti in modo divergente.
- Il namespace del modello e il file canonico mancano, quindi PHPStan segnala correttamente `class.notFound`.

## Regola operativa

- Se il concetto di `DatabaseConfig` e' ancora parte del modulo, il modello va reintrodotto come classe canonica.
- Se invece la factory e' legacy morta, va rimossa o riallineata a un modello esistente.

Decisione applicativa:

- nel modulo `Tenant` il concetto e' ancora vivo, perche' test e factory lo usano esplicitamente;
- quindi `DatabaseConfig` va ripristinato come modello canonico minimale sotto `app/Models/DatabaseConfig.php`.
