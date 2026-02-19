# Folio Page Localization Rules

## Critical Rule

Folio does NOT automatically set locale from URL. You MUST add locale setting in every public/auth page.

## Implementation

Add this at the TOP of every Folio page (before any other code):

```php
<?php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Set locale from URL segment
$segments = request()->segments();
$locale = $segments[0] ?? 'it';
if (in_array($locale, ['it', 'en', 'es', 'de', 'fr', 'ru'], true)) {
    LaravelLocalization::setLocale($locale);
    app()->setLocale($locale);
}
?>
```

## Correct Translation Keys

Translation file structure determines the key:

```php
// File: Modules/Gdpr/lang/it/register.php
return [
    'title' => 'Unisciti alla Pizza Revolution',
    'subtitle' => 'Entra nella community...',
];
// Key is: gdpr::register.title (NOT gdpr::register.register.title)
```

## Testing

Always test BOTH languages:

```bash
# Check locale attribute
curl http://127.0.0.1:8000/en/auth/register | grep 'lang="'

# Check translation
curl http://127.0.0.1:8000/it/auth/register | grep "Pizza"
curl http://127.0.0.1:8000/en/auth/register | grep "Pizza"
```

## Common Errors

| Error | Cause | Fix |
|-------|-------|-----|
| `/en` shows `lang="it"` | Locale not set | Add locale code |
| Translation key shows | Key doesn't exist | Check file structure |
| Italian text on English page | Wrong key or locale not set | Verify both |

## Files Using This Pattern

- `Themes/Meetup/resources/views/pages/auth/register.blade.php`
- `Themes/Meetup/resources/views/pages/auth/login.blade.php`

## Related Docs
- [Translation Standards](./translation-rules.md)
- [Localization Best Practices](../lang/docs/laravel-localization-best-practices.md)
