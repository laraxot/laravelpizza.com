# errore override metodo final in filament

questo documento è un collegamento alla documentazione completa disponibile nel modulo <nome progetto>:

[vai alla documentazione completa](/var/www/html/base_<nome progetto>/laravel/Modules/<nome progetto>/docs/errors/final_method_override_error.md)

## problema in breve

non è possibile sovrascrivere i metodi dichiarati come `final` nelle classi base di Filament, in particolare:

```php
Cannot override final method Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord::infolist()
```

## soluzione rapida

anziché sovrascrivere direttamente il metodo `infolist()`, implementare il metodo astratto `getInfolistSchema()` che viene richiamato internamente dal metodo `infolist()` della classe base.

```php
// ERRATO
public function infolist(Infolist $infolist): void {...}

// CORRETTO
protected function getInfolistSchema(): array {...}
```

per dettagli completi, consultare la [documentazione nel modulo <nome progetto>](/var/www/html/base_<nome progetto>/laravel/Modules/<nome progetto>/docs/errors/final_method_override_error.md).
