# Skill: Creator ProfileContract Typing

## Trigger

Quando compaiono annotazioni model con `creator` tipizzato su un modello concreto (es. `Modules\\Meetup\\Models\\Profile`).

## Procedura

1. sostituire il tipo con `\Modules\Xot\Contracts\ProfileContract|null`;
2. applicare la stessa regola a `updater` e `deleter` se presenti;
3. eseguire quality gate PHP richiesti;
4. aggiornare Issue/Discussion con il delta.
