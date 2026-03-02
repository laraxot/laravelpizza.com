# Traduzioni

## Pacchetti Utilizzati

### Core
- [spatie/laravel-translatable](https://github.com/spatie/laravel-translatable)
  - Gestione modelli tradotti
  - Supporto multilingua
  - Query builder

## Implementazione

### Modello Tradotto
```php
use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    use HasTranslations;

    public $translatable = ['title', 'content'];

    public function toArray()
    {
        $attributes = parent::toArray();

        foreach ($this->getTranslatableAttributes() as $field) {
            $attributes[$field] = $this->getTranslation($field, app()->getLocale());
        }

        return $attributes;
    }
}
```

### Utilizzo
```php
$post = Post::create([
    'title' => [
        'en' => 'Hello World',
        'it' => 'Ciao Mondo'
    ],
    'content' => [
        'en' => 'This is a post',
        'it' => 'Questo è un post'
    ]
]);

echo $post->getTranslation('title', 'it'); // Ciao Mondo
```

## Best Practices

### Database
1. Utilizzare JSON per campi tradotti
2. Implementare indici appropriati
3. Gestire fallback language

### Cache
1. Implementare cache traduzioni
2. Gestire invalidazione cache
3. Ottimizzare query

## Performance

### Ottimizzazioni
- Utilizzare eager loading
- Implementare cache query
- Ottimizzare indici

### Monitoring
- Tracciare query lente
- Monitorare utilizzo memoria
- Analizzare performance

## Tools

### Sviluppo
- Laravel Debugbar
- Laravel Telescope
- Query Monitor

### Testing
- Test traduzioni mancanti
- Test fallback language
- Test performance

## Collegamenti

- [Torna a packages.md](../packages.md)
- [Localizzazione](localization.md)
- [Performance](performance.md)
### Versione HEAD

## Collegamenti tra versioni di translations.md
* [translations.md](../../../chart/docs/translations.md)
* [translations.md](../../../reporting/docs/translations.md)
* [translations.md](../../../gdpr/docs/translations.md)
* [translations.md](../../../notify/docs/translations.md)
* [translations.md](../../../xot/docs/roadmap/lang/translations.md)
* [translations.md](../../../xot/docs/translations.md)
* [translations.md](../../../dental/docs/translations.md)
* [translations.md](../../../user/docs/translations.md)
* [translations.md](../../../ui/docs/translations.md)
* [translations.md](../../../lang/docs/packages/translations.md)
* [translations.md](../../../lang/docs/translations.md)
* [translations.md](../../../job/docs/translations.md)
* [translations.md](../../../media/docs/translations.md)
* [translations.md](../../../tenant/docs/translations.md)
* [translations.md](../../../activity/docs/translations.md)
* [translations.md](../../../patient/docs/translations.md)
* [translations.md](../../../cms/docs/translations.md)

### Versione Incoming

---
