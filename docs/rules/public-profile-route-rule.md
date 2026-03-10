# Public Profile Route Rule

- la pagina profilo pubblica frontoffice deve usare una route Folio dedicata o un entrypoint univoco equivalente;
- `/{$locale}/profile/{id}` usa l'identificatore pubblico reale dell'utente, non assume `profiles.uuid`;
- il body della pagina non deve dipendere da fallback ambigui o da route duplicate in conflitto;
- il tema deve usare solo chiavi di traduzione `pub_theme::profile.*`;
- la pagina deve esporre `ProfilePage` con `mainEntity` `Person`.
