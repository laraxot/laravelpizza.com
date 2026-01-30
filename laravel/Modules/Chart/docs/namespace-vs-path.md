# convenzioni namespace vs percorso fisico

questo documento è un collegamento alla documentazione completa disponibile nel modulo Xot:

[vai alla documentazione completa](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/docs/module_namespace_path_convention.md)

## regola fondamentale

nei moduli laravel, c'è una discrepanza tra namespace e percorso fisico:

- percorso fisico: contiene la directory `app/`
  ```
  /Modules/NomeModulo/app/Tipo/...
  ```

- namespace: non contiene `app`
  ```php
  namespace Modules\NomeModulo\Tipo\...;
  ```

## errore comune

cercare file nel percorso:
```
/Modules/NomeModulo/Tipo/...  // ERRATO: manca /app/
```

per maggiori dettagli, vedere la [documentazione completa](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/docs/module_namespace_path_convention.md).
