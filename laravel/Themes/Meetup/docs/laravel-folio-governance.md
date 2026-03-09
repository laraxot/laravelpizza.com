# Theme Meetup Folio Governance

## Obiettivo

Nel tema `Meetup` le pagine pubbliche devono seguire il contratto nativo di Laravel Folio invece di introdurre routing parallelo o parsing manuale superfluo.

## Regole pratiche

- Usare la gerarchia file/cartelle come fonte primaria della route pubblica.
- Usare `index.blade.php` per il root di sezione e filename dinamici per i segmenti reali.
- Se la pagina richiede middleware condivisi con altre pagine della stessa area, spostarli nel mount Folio del provider invece che replicarli nel Blade.
- Se il path incorpora locale o altre concern trasversali, la pagina non deve ricostruire da sola l'intero contesto se quel contesto puo' essere risolto nel mount o in middleware.
- `render()` va riservato a esigenze di response/view composition, non a orchestrazione opaca del routing.

## Effetto sui test

- Testare URL reali del tema, non solo componenti renderizzati isolatamente.
- Verificare route precedence, middleware effettivi e segnali finali del documento quando il tema dipende da locale o auth.

## Fonte

- Laravel Folio docs: https://laravel.com/docs/12.x/folio
- Repository: https://github.com/laravel/folio
