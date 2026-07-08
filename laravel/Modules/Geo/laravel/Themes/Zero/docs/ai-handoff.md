# ai handoff

## regole non negoziabili

- tests solo pest
- nei tests MAI RefreshDatabase
- i tests devono leggere `.env.testing`

## stato lavori (ultimo)

- `laravel/.env.testing` è il file autoritativo per la config di test
- il bootstrap carica `.env.testing` via `Modules/Xot/tests/CreatesApplication.php`
- `laravel/tests/TestCase.php` usa `Modules\\Xot\\Tests\\CreatesApplication`

## dove scambiarci le informazioni

- questo file (`Themes/Zero/docs/ai-handoff.md`) contiene handoff cross-agente lato tema
- per lo stato tecnico e regole dettagliate, vedere:
  - `../../Modules/Xot/docs/ai-handoff.md`

## cosa va scritto prima di lavorare

- il perche' del task
- lo scopo atteso
- la ragione tecnica o di business
- la policy/gov governance coinvolta
- la visione UX/prodotto
- la filosofia della soluzione adottata

Se questi punti mancano, il rischio e' che agenti diversi facciano implementazioni coerenti nel codice ma incoerenti nell'intenzione.

## quality gates e coordinamento

- se il task tema tocca file PHP, il quality gate include `phpstan`, `PHPMD` e `phpinsights`
- `PHPMD` va eseguito come `.phar` standalone, non come package Composer del repo
- per cambiamenti di governance o workflow, aggiornare anche issue/discussion GitHub gia' esistenti dopo `git remote -v`
- anche nei task tema, se servono cast o normalizzazioni di supporto non creare helper ad hoc senza prima verificare le action condivise in `Modules/Xot/app/Actions/Cast/`
- anche nei task tema, se servono cast o normalizzazioni di supporto non creare helper ad hoc senza prima verificare le action condivise in `Modules/Xot/app/Actions/Cast/`
- se un bug e' visibile su una URL reale del progetto, non considerare sufficiente un test che legge solo il source; serve una verifica runtime o una riproduzione fedele della stessa pipeline
- nei componenti Filament/Livewire coinvolti dal tema, preferire proprieta' pubbliche serializzabili; array di oggetti custom non serializzabili tendono a rompere l'hydration
