# Meetup Schema.org Audit Skill

## Quando usarla

Usare questa skill quando una richiesta riguarda:

- `schema.org` nel modulo `Meetup`;
- rich snippets per eventi, speaker, sponsor o venue;
- JSON-LD per pagine evento o profilo;
- allineamento tra modelli Eloquent e structured data.

## Workflow

1. Identificare il tipo `schema.org` corretto per il modello pubblico.
2. Verificare se Google supporta quel tipo come rich result o come entita' utile nel grafo.
3. Verificare anche il tipo pagina:
   - `WebPage` come baseline;
   - sottotipi reali come `ProfilePage` solo quando la pagina pubblica lo giustifica.
4. Separare proprieta' in:
   - required;
   - recommended;
   - conditional.
5. Verificare che i dati esistano davvero nel modello o in relazioni affidabili.
6. Per relazioni many-to-many del dominio `Meetup`, leggere dati da `belongsToManyX()` e non introdurre `belongsToMany()` plain.
7. Preferire `toSchemaOrg()` sul modello pubblico o una resource dedicata, evitando logica JSON-LD sparsa nei Blade.
8. Rendere il tema responsabile del rendering JSON-LD, non della costruzione arbitraria dei dati.

## Anti-pattern

- aggiungere a tutti i modelli tutte le proprieta' possibili di `schema.org`;
- trattare i pivot come entita' pubbliche senza pagina o caso d'uso;
- emettere campi non mostrati o non verificabili;
- usare structured data incoerente con la UI reale.
- marcare pagine private o di edit come `ProfilePage`.

## Output atteso

- mappa modello -> tipo `schema.org`;
- checklist required/recommended;
- gap del dominio;
- issue/discussion GitHub collegata;
- piano implementativo per JSON-LD e test.
