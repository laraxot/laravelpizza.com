# Convenzioni di Nomenclatura in <nome progetto>

Questo documento definisce le convenzioni ufficiali di nomenclatura da utilizzare in tutto il progetto <nome progetto>.

## Convenzioni Generali

### Formato Case

- **PascalCase**: Prima lettera maiuscola, senza spazi o separatori (es. `UserProfile`)
  - Usato per: Nomi di classi, interfacce, enumerazioni, nomi dei moduli
  
- **camelCase**: Prima lettera minuscola, senza spazi o separatori (es. `getUserProfile`)
  - Usato per: Metodi, funzioni, proprietà non statiche
  
- **snake_case**: Tutte le lettere minuscole, parole separate da underscore (es. `user_profile`)
  - Usato per: Variabili, costanti di classe (non globali), nomi di file delle viste, tabelle del database, colonne del database
  
- **UPPER_SNAKE_CASE**: Tutte le lettere maiuscole, parole separate da underscore (es. `MAX_LOGIN_ATTEMPTS`)
  - Usato per: Costanti globali, enums

## Moduli

### Nome del Modulo

Il nome del modulo deve essere in formato **PascalCase** con la prima lettera maiuscola.

- ✅ CORRETTO: `Blog`, `UserProfile`, `MobilitaVolontaria`
- ❌ ERRATO: `blog`, `userProfile`, `mobilitavolontaria`, `Mobilita_Volontaria`

### Namespace del Modulo

I namespace dei moduli devono seguire il formato:

```php
namespace Modules\NomeModulo;
```

### Service Provider

Il service provider principale di un modulo deve:

1. Avere il nome che termina con `ServiceProvider` 
2. Estendere `XotBaseServiceProvider`
3. Definire una proprietà `$name` con il nome del modulo in **PascalCase**

```php
class BlogServiceProvider extends XotBaseServiceProvider {
    public string $name = 'Blog';
    // ...
}
```

## Database

### Tabelle

I nomi delle tabelle devono essere in **snake_case** e al plurale:

- ✅ CORRETTO: `users`, `blog_posts`, `user_profiles`
- ❌ ERRATO: `User`, `BlogPost`, `user_profile`

### Colonne

I nomi delle colonne devono essere in **snake_case**:

- ✅ CORRETTO: `first_name`, `created_at`, `user_id`
- ❌ ERRATO: `firstName`, `CreatedAt`, `UserID`

### Chiavi Primarie

Usare `id` come nome della chiave primaria.

### Chiavi Esterne

Usare `table_name_singular_id` come formato per le chiavi esterne:

- ✅ CORRETTO: `user_id`, `blog_post_id`
- ❌ ERRATO: `userID`, `blogPostId`, `user`

## Filament

### Nomi delle Risorse

I nomi delle risorse Filament devono essere in **PascalCase** e terminare con `Resource`:

- ✅ CORRETTO: `UserResource`, `BlogPostResource`
- ❌ ERRATO: `Users`, `blogPost`, `Blog_Post_Resource`

### Metodi per le azioni

I metodi per le azioni delle tabelle devono essere **pubblici**:

```php
// ✅ CORRETTO
public function getTableHeaderActions(): array
{
    // ...
}

// ❌ ERRATO
protected function getTableHeaderActions(): array
{
    // ...
}
```

## Traduzioni

### Chiavi di Traduzione

Le chiavi di traduzione devono essere in **snake_case**:

```php
// File di traduzione
return [
    'user_profile' => [
        'title' => 'Profilo Utente',
        'fields' => [
            'first_name' => 'Nome',
            'last_name' => 'Cognome',
        ],
    ],
];
```

## Repository Git

### Nomi dei Branch

- **feature/nome-feature**: Per nuove funzionalità
- **bugfix/descrizione-bug**: Per correzioni di bug
- **hotfix/descrizione-hotfix**: Per correzioni urgenti
- **release/versione**: Per preparare release

### Commit Message

Formato consigliato:
```
type(scope): descrizione breve

Descrizione dettagliata se necessaria
```

Tipi: `feat`, `fix`, `docs`, `style`, `refactor`, `test`, `chore`
