# Legal Pages JSON Rule

## Regola

Le pagine legali principali devono esistere come JSON page nel content repository locale:

- `config/local/laravelpizza/database/content/pages/privacy.json`
- `config/local/laravelpizza/database/content/pages/terms.json`

Con slug corrispondenti:

- `privacy`
- `terms`

## Motivazione

Nel frontoffice Laravel Pizza:

- il footer linka pagine legali;
- i flussi GDPR e i form fanno riferimento a privacy e termini;
- il renderer Folio `pages/[slug].blade.php` si aspetta pagine CMS risolvibili via slug.

Se i JSON mancano:

- `/it/privacy` e `/it/terms` non hanno contenuto valido;
- i link legali diventano rotti o inconsistenti;
- la compliance percepita del sito peggiora.

## Regola di implementazione

1. Prima creare o aggiornare i JSON.
2. Usare blocchi compatibili con il runtime CMS.
3. Verificare almeno:
   - route `GET /it/privacy`
   - route `GET /it/terms`
4. Aggiungere Pest coverage per i due slug quando si tocca questa area.
