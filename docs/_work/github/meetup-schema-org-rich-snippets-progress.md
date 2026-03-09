[Progress]

Ho concluso la fase di studio e ho tradotto il risultato in documentazione operativa.

Documenti aggiunti:

- `docs/rules/meetup-schema-org-completeness-rule.md`
- `docs/memory/meetup-schema-org-rich-snippets-memory.md`
- `docs/skills/meetup-schema-org-audit-skill.md`
- `laravel/Modules/Meetup/docs/schema-org-public-model-contract.md`
- `laravel/Themes/Meetup/docs/rich-snippets-ready-implementation-strategy.md`

Punti chiave emersi:

- `Event` e' gia' il modello piu' vicino a `schema.org/Event`, ma il JSON-LD corrente e' ancora incompleto;
- `Venue`, `Sponsor`, `Performer`, `Profile`, `Feedback` hanno dati utili ma nessun contratto uniforme di esportazione;
- i pivot model non devono essere trattati come rich-result entities autonome salvo caso d'uso pubblico reale;
- per `Event` il baseline corretto deve coprire soprattutto i campi minimi e raccomandati del rich result, non l'intera superficie teorica del tipo `schema.org/Event`.
- a livello pagina serve anche una baseline `WebPage`;
- `ProfilePage` vale solo per pagine profilo pubbliche reali, non per schermate di edit profilo autenticate.

Gap prioritari:

- completare `Event` con relazioni e nodi composti (`Place`, `Organization`, `Person`, `Offer`, `Review`);
- introdurre `toSchemaOrg()` uniforme sui modelli pubblici;
- aggiungere test sul JSON-LD renderizzato nelle pagine pubbliche.
