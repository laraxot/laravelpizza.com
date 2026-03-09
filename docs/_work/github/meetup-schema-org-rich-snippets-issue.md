[Context]

`Modules/Meetup` deve diventare davvero `schema.org` / rich-snippets ready, ma la regola corretta non e':

- "ogni modello deve avere tutte le proprieta' possibili del tipo schema.org"

Per `schema.org`, e soprattutto per Google rich results, serve invece:

- mapping corretto del modello pubblico al tipo canonico;
- copertura dei campi required / recommended realmente supportati;
- JSON-LD coerente con il contenuto pubblico mostrato;
- niente campi inventati o pivot model forzati come entita' SEO autonome.

[Research]

Studio incrociato su:

- `schema.org/Event`
- `schema.org/Person`
- `schema.org/Place`
- `schema.org/Organization`
- `schema.org/Review`
- Google Search Central: Event structured data
- Google Search Central: ProfilePage structured data

Conclusione:

- `Event` e' il punto critico per i rich results;
- `Venue`, `Sponsor`, `Performer`, `Profile`, `Feedback` hanno gia' dati utili ma manca una convenzione uniforme `toSchemaOrg()`;
- `EventSponsor`, `EventPerformer`, `EventUser` non vanno trattati come entita' rich-result autonome per default: devono soprattutto nutrire il grafo di `Event`.

[Model Mapping]

- `Event` -> `Event`
- `Venue` -> `Place` / `LocalBusiness`
- `Sponsor` -> `Organization`
- `Performer` -> `Person`
- `Profile` -> `Person` + `ProfilePage` a livello pagina
- `Feedback` -> `Review` solo se pubblico

[Page Layer]

Non basta il mapping modello -> entita'.

Per le pagine pubbliche serve anche:

- `WebPage` come baseline generale;
- `ProfilePage` solo per profili pubblici reali;
- niente `ProfilePage` per pagine autenticate o di edit profilo.

[Current Gaps]

- `Event::toSchemaOrg()` esiste ma oggi e' ancora incompleto:
  - `location` ha solo `name` e non un `Place` completo con address
  - mancano composizione strutturata di `performer`, `sponsor`, `review` / `aggregateRating`
  - mancano relazioni strutturali per comporre il grafo (`venue`, `performers`, `sponsors`, `feedback`, `superEvent`/`subEvents`)
- `Venue`, `Sponsor`, `Performer`, `Feedback` non hanno ancora un exporter canonico
- alcuni pivot model hanno anche incongruenze interne da correggere prima di usarli nel grafo

[Decision]

Creare una convenzione di progetto:

- ogni modello pubblico di `Meetup` deve dichiarare il proprio tipo `schema.org`;
- per ogni modello si definiscono:
  - core required
  - recommended
  - conditional / optional
- il tema deve limitarsi a renderizzare JSON-LD affidabile, non a ricostruire semantica arbitraria nei Blade

[Next Steps]

1. Rendere `Event` baseline-complete per rich result Google.
2. Aggiungere `toSchemaOrg()` a `Venue`, `Sponsor`, `Performer`, `Feedback`.
3. Usare i pivot model solo per popolare nodi annidati del grafo.
4. Aggiungere test su JSON-LD renderizzato nelle pagine pubbliche evento.
5. Definire una baseline `WebPage` per le pagine pubbliche e `ProfilePage` per i profili pubblici reali.
