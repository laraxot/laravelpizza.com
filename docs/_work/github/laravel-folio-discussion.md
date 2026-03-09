Ho studiato Laravel Folio dalla documentazione ufficiale e dalla repo `laravel/folio` per allineare le nostre regole locali.

I punti chiave che dobbiamo trattare come canonici nel progetto sono questi:

- `Folio::path()->uri()` per montare alberi di pagine;
- `domain()->path()` per routing per subdomain;
- route params da filename (`[id]`);
- catch-all params (`[...segments]`);
- implicit model binding da filename;
- `name()` per named routes;
- `middleware()` sia a livello pagina sia a livello mount;
- `render()` per personalizzare la response;
- route cache come pratica normale anche con Folio.

Decisione pratica per LaravelPizza:

1. il frontoffice CMS/theme resta Folio-first;
2. il mount Folio e' il posto giusto per middleware condivisi;
3. i Blade non devono sostituire routing o middleware;
4. se un pattern URL e' esprimibile nel filename Folio, non va reimplementato con parsing manuale;
5. `render()` e `name()` vanno usati con disciplina, non come scusa per piegare Folio a un mini-framework ad hoc.

Questo studio rafforza il principio gia' emerso con il bug locale `/de`: se la logica di routing sta nel posto sbagliato, i test diventano deboli e il comportamento reale diverge.
