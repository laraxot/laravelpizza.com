# compatibilità delle firme di metodi in php

questo documento è un collegamento alla documentazione completa disponibile nel modulo xot:

[vai alla documentazione completa](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/docs/errors/method_signature_compatibility.md)

## problema in breve

quando si estende una classe, è necessario mantenere la stessa firma dei metodi che si sovrascrivono:

- un metodo statico deve rimanere statico
- un metodo non statico deve rimanere non statico
- i tipi di ritorno devono essere compatibili
- i parametri devono essere compatibili
- la visibilità non può essere ristretta

## errore tipico

```
Cannot make non static method Filament\Pages\BasePage::getView() static in class Modules\Xot\Filament\Pages\XotBasePage
```

per dettagli completi e soluzioni, consultare la [documentazione nel modulo xot](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/docs/errors/method_signature_compatibility.md).
