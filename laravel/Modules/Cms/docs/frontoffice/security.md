# Sicurezza Frontend

## Introduzione

Questa sezione descrive le best practices e le tecniche per garantire la sicurezza del frontend del CMS.

## Protezione CSRF

### Configurazione Laravel
```php
// config/csrf.php
return [
    'except' => [
        'stripe/*',
        'http://example.com/foo/bar',
    ],
];
```

### Token CSRF in JavaScript
```javascript
// resources/js/app.js
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
```

## Sanitizzazione Input

### Sanitizzazione in Vue
```vue
<template>
    <div v-html="sanitizedContent"></div>
</template>

<script>
import DOMPurify from 'dompurify';

export default {
    computed: {
        sanitizedContent() {
            return DOMPurify.sanitize(this.content);
        }
    }
}
</script>
```

### Sanitizzazione in React
```jsx
import DOMPurify from 'dompurify';

function SanitizedContent({ content }) {
    return <div dangerouslySetInnerHTML={{ __html: DOMPurify.sanitize(content) }} />;
}
```

## Protezione XSS

### Headers di Sicurezza
```php
// app/Http/Middleware/SecurityHeaders.php
public function handle($request, Closure $next)
{
    $response = $next($request);
    
    $response->headers->set('X-XSS-Protection', '1; mode=block');
    $response->headers->set('X-Content-Type-Options', 'nosniff');
    $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
    $response->headers->set('Content-Security-Policy', "default-src 'self'");
    
    return $response;
}
```

## Validazione Input

### Validazione in JavaScript
```javascript
// resources/js/validation.js
export function validateForm(data) {
    const errors = {};
    
    if (!data.email || !isValidEmail(data.email)) {
        errors.email = 'Email non valida';
    }
    
    if (!data.password || data.password.length < 8) {
        errors.password = 'Password troppo corta';
    }
    
    return errors;
}
```

## Best Practices

1. **Validazione**
   - Validare sia lato client che server
   - Utilizzare librerie di validazione affidabili
   - Sanitizzare tutti gli input

2. **Sicurezza**
   - Implementare CSP
   - Utilizzare HTTPS
   - Proteggere le API

3. **Monitoraggio**
   - Log degli errori
   - Monitoraggio delle intrusioni
   - Audit regolari

## Risorse Utili

- [OWASP Security Guidelines](https://owasp.org/www-project-top-ten/)
- [Laravel Security Documentation](https://laravel.com/docs/12.x/security)
- [Content Security Policy Guide](https://content-security-policy.com/)

## Troubleshooting

### Errori Comuni

1. **Problemi CSRF**
   - Verificare i token
   - Controllare le configurazioni
   - Aggiornare le dipendenze

2. **Problemi XSS**
   - Sanitizzare l'output
   - Implementare CSP
   - Monitorare gli attacchi

3. **Problemi di Validazione**
   - Verificare le regole
   - Controllare i messaggi
   - Testare gli input 

## Collegamenti tra versioni di security.md
* [security.md](laravel/Modules/Gdpr/docs/packages/security.md)
* [security.md](laravel/Modules/Cms/docs/frontoffice/security.md)
* [security.md](laravel/Themes/One/docs/security.md)

