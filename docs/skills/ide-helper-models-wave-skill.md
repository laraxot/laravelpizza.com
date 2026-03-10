# Skill: IDE Helper Models Wave

## Trigger

Quando il task richiede `php artisan ide-helper:models -W` o la correzione di segnalazioni emerse da quel comando.

## Procedura

1. aggiornare prima docs globali (`rules`, `memory`, `skills`);
2. aggiornare doc del modulo/tema coinvolto;
3. aprire/aggiornare issue GitHub della wave e commentare una discussion;
4. eseguire `php artisan ide-helper:models -W` dalla cartella `laravel/`;
5. correggere tutte le segnalazioni;
6. chiudere con `phpstan`, `phpmd`, `phpinsights` e Pest per parti testabili.

## Guardrail

- solo forward-only con git;
- non introdurre workaround opachi: preferire fix esplicite su model/relation/config;
- riportare in issue/discussion sia root cause sia fix applicata.
