# Skill Operativa: Header Auth CTA UX

## Quando usarla

Usare questa skill quando il task riguarda:

- bottoni login/register del nav pubblico;
- regressioni lingua nell'header;
- miglioramenti UI/UX dei CTA auth del tema.

## Workflow

1. Studiare docs locali del tema su header/auth/localization.
2. Verificare che il Blade usi chiavi di traduzione tema e non stringhe hardcoded.
3. Dare gerarchia chiara:
   - login secondario
   - register primario
4. Verificare desktop e mobile.
5. Aggiungere Pest test sulla pagina localizzata reale.
6. Se si toccano file PHP di test, eseguire quality gate completo e registrare eventuali limiti infrastrutturali.
