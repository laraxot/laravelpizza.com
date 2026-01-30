# Bug Fixing Guidelines and Best Practices

## Core Principles
- Always analyze the root cause through thorough code and context analysis
- Follow a systematic approach to bug resolution
- Maintain documentation integrity throughout the process
- Respect module boundaries and responsibilities

## Documentation Process
1. **Before Making Changes**
   - Study the documentation in the module's `docs` folder (not the root `docs`)
   - Create bidirectional links between module and root documentation
   - Update relevant documentation before implementing fixes

## Code Organization
- **Namespace Structure**:
  - Use `Modules\<module>\` (NOT `Modules\<module>\App\`)
  - Filament components: `Modules\<module>\Filament`
  - Never extend Filament classes directly - use XotBase classes

## Translation Guidelines
- **Never** use `->label()` directly
- Use the LangServiceProvider for all translations
- Store translations in: `Modules/<module>/lang/<language>/`
- Follow the expanded translation structure

## Common Fix Patterns
1. **Resource Classes**:
   - Remove `getTableColumn`, `getTableFilters`, `getBulkActions` if empty
   - Remove `getPages` if it only returns default pages
   - Use associative arrays with string keys for all methods

2. **Form Handling**:
   - Convert array options to enums for type safety
   - Use proper validation rules
   - Implement proper error handling

## Implementation Strategy
1. **Analysis Phase**:
   - Understand the error context
   - Check related components
   - Review recent changes

2. **Documentation Update**:
   - Update module documentation
   - Create/update root documentation
   - Add bidirectional links

3. **Implementation**:
   - Follow DRY and KISS principles
   - Consider architectural implications
   - Maintain backward compatibility

4. **Testing**:
   - Test the fix
   - Check for regressions
   - Update tests if needed

## Quality Assurance
- Run PHPStan (level 10)
- Ensure PSR-12 compliance
- Verify type safety
- Check for security implications

## Best Practices
- Keep changes minimal and focused
- Document decisions and rationale
- Consider performance implications
- Follow the principle of least surprise

## Common Pitfalls to Avoid
- Direct Filament class extensions
- Hardcoded strings and labels
- Ignoring module boundaries
- Skipping documentation updates

## Review Process
- Self-review changes
- Check for similar issues in the codebase
- Update relevant documentation
- Consider creating automated tests

## ParseError - Metodi Orfani

### Causa
Un errore di tipo `ParseError: syntax error, unexpected token "protected", expecting end of file` si verifica quando una funzione viene dichiarata **fuori dal blocco della classe**. Questo accade spesso dopo una parentesi graffa di chiusura `}` della classe, lasciando il metodo "orfano".

### Soluzione
- Spostare sempre i metodi all'interno della classe corretta
- Verificare che la parentesi graffa di chiusura della classe sia l'ultima istruzione del file
- Se il metodo non serve più, eliminarlo

### Best Practice
- Ogni funzione/membro deve essere dichiarato **all'interno** della classe
- La chiusura della classe (`}`) deve essere l'ultima istruzione del file
- Dopo ogni refactor, controllare che non restino metodi orfani
- Usare sempre editor con linting attivo per prevenire errori di sintassi

### Esempio (corretto)
```php
class Example {
    public function foo() {}
    // ...
} // <--- questa DEVE essere l'ultima parentesi graffa
```

### Caso reale
- Errore su `Modules/User/app/Filament/Widgets/Auth/RegisterWidget.php` risolto spostando la funzione orfana all'interno della classe o eliminandola se non più necessaria

### Filosofia
- La coerenza strutturale del codice è fondamentale per la manutenibilità e la prevenzione di bug sistemici
- Ogni correzione va documentata nella cartella docs più vicina e nel knowledge base dei bugfix

## Collegamenti
- [User Module Bug Fixes](../../laravel/Modules/User/docs/bug-fixes/)
- [ParseError Fix Details](../../laravel/Modules/User/docs/bug-fixes/parse-error-orphan-methods-2025-01-27.md)
- [Widget Auth Best Practices](../../laravel/Modules/User/docs/filament/widgets/registration-widget.md)

## Ultimo aggiornamento
2025-01-27 - Documentazione ParseError e linee guida bug fixing 