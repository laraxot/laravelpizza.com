# Skill: rimozione controller HTTP orfani

## Quando applicarla

- quando trovi controller senza route;
- quando un modulo contiene file `Http/Controllers` non integrati;
- quando la logica del file e' dominio puro o legacy morto.

## Procedura

1. cercare route e riferimenti reali;
2. aggiornare docs del modulo e le regole globali;
3. rimuovere il controller se orfano;
4. rieseguire quality gate sul perimetro coinvolto.
