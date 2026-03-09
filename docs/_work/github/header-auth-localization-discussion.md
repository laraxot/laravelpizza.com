Sto fissando una regola molto semplice ma che finora non era garantita:

- se la locale del frontoffice non e' italiana, l'header non puo' mostrare CTA auth in italiano.

Nel tema Meetup il problema non era solo visivo:

- c'erano label italiane hardcoded o comunque non garantite dal sistema di traduzione;
- nella navigation guest i link auth puntavano a path incoerenti con le route pubbliche reali.

Intervento fatto:

1. CTA auth allineate alle chiavi `pub_theme::navigation.auth.*`
2. link guest corretti a `/auth/login` e `/auth/register`
3. mantenuta una gerarchia UI piu' chiara:
   - login come azione secondaria
   - register come primaria
4. test Pest che controlla davvero `/it` e `/de`

Questo chiude un bug di localizzazione reale e alza il livello dei test: non basta piu' che `/de` risponda, deve anche rendere un header coerente con il tedesco.
