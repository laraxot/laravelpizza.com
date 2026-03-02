# Dependency Debug Skills

## Skill 1: Composer Drift Detection

1. Usare i due “source of truth” e capire quale stai auditando:

   - Lock-based: [`docs/dependencies.md`](../dependencies.md)
   - Installed vendor (composer show): [`docs/packages/index.md`](../packages/index.md)

2. Eseguire `composer show -f json` e verificare drift rispetto a `composer.lock`.

3. Se c’è drift, considerare l’ambiente **non deterministico** per chaos testing finché non viene riallineato con `composer install`.

4. Validare pacchetti critici di runtime (Folio/Livewire/Volt/Filament/nwidart-modules/Sushi) direttamente nel catalogo `docs/packages/`.

## Skill 2: Blast Radius Mapping

1. Classificare il pacchetto in area: `admin-ui`, `reactive-ui`, `i18n-routing`, `json-backed-models`.
2. Mappare i moduli impattati usando i `dependency-intelligence.md` dei moduli.
3. Eseguire smoke test target su rendering pagina e widget del modulo impattato.

## Skill 3: Chaos Monkey Recovery by Dependency

1. Freeze di upgrade non necessari.
2. Fix locale sul modulo/tema rotto.
3. Aggiornamento docs: rules + memory + skill + dependency intelligence.

## Quick links

- Canonical dependencies (lock): [`docs/dependencies.md`](../dependencies.md)
- Installed packages (composer show): [`docs/packages/index.md`](../packages/index.md)
- Bug injection playbook: [`docs/bug-injection-recovery-playbook.md`](../bug-injection-recovery-playbook.md)
