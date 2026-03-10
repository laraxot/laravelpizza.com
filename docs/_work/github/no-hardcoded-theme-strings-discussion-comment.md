Sto consolidando il fix precedente in una regola piu' forte di progetto:

- nei temi non devono esserci stringhe UI hardcoded in nessuna lingua

non solo:

- niente italiano su `/de`

Perche' il problema vero non e' la singola lingua, ma il fatto che il tema resti localizzabile in modo sistematico.

Aggiornamenti fatti:

- nuova rule: `docs/rules/no-hardcoded-theme-strings-rule.md`
- nuova memory: `docs/memory/no-hardcoded-theme-strings-memory.md`
- nuova skill: `docs/skills/no-hardcoded-theme-strings-skill.md`
- update docs tema: `Themes/Meetup/docs/translations.md`

Decisione pratica:

- nel tema, testo UI diretto o `__('Testo letterale')` va considerato smell;
- le stringhe devono passare da chiavi di traduzione (`pub_theme::...` quando appartengono al tema);
- header, footer, CTA e blocchi pubblici vanno trattati tutti allo stesso modo, non solo i punti gia' segnalati da bug precedenti.
