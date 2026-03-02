# Dependency Debug Skills

## Skill 1: Composer Drift Detection

1. Eseguire `composer show` e confrontare con vincoli di `Modules/*/composer.json`.
2. Segnalare pacchetti dichiarati ma non presenti nel lock.
3. Validare pacchetti critici di runtime (Folio/Livewire/Filament/localization/Sushi).

## Skill 2: Blast Radius Mapping

1. Classificare il pacchetto in area: `admin-ui`, `reactive-ui`, `i18n-routing`, `json-backed-models`.
2. Mappare i moduli impattati usando i nuovi `dependency-intelligence.md`.
3. Eseguire smoke test target su rendering pagina e widget del modulo impattato.

## Skill 3: Chaos Monkey Recovery by Dependency

1. Freeze di upgrade non necessari.
2. Fix locale sul modulo/tema rotto.
3. Aggiornamento docs: rules + memory + skill + dependency intelligence.
