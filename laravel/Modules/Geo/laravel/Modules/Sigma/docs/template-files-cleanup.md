# Cleanup File Template - Modulo Sigma

> **Versione**: 1.0  
> **Ultima modifica**: Vedi [CHANGELOG.md](./CHANGELOG.md)

**Problema**: File template `.php` venivano autoloaded da Composer  
**Severità**: 🟡 Bassa (warning, non blocco)

## Errore Originale

```
Class Modules\Sigma\Models\Traits\SchedaTrait 
located in ./Modules/Sigma/app/Models/Traits/SchedaTrait_FINAL_TEMPLATE.php 
does not comply with psr-4 autoloading standard
```

## Causa

File template con estensione `.php` venivano scansionati da autoloader:
- `SchedaTrait_FINAL_TEMPLATE.php`
- `SchedaTrait_CLEAN.php`

**Problema**: Composer cerca tutte le classi `.php`, trova questi file, ma nome file non matcha nome classe.

## Filosofia dei File Template

### Perché Esistono Template?

> "Il template è un maestro silenzioso. Insegna con l'esempio, non con l'esecuzione."

**Scopo**:
- Fornire esempi di implementazione corretta
- Documentare pattern best practices
- Servire come reference durante refactoring

**NON devono**:
- Essere eseguiti direttamente
- Essere autoloaded da Composer
- Confondere il classloader

## Fix Applicato

**Rinominati**: `.php` → `.template`

```bash
mv SchedaTrait_CLEAN.php SchedaTrait_CLEAN.php.template
mv SchedaTrait_FINAL_TEMPLATE.php SchedaTrait_FINAL_TEMPLATE.php.template
```

**Risultato**:
- ✅ Composer non li scansiona più
- ✅ Rimangono visibili come riferimento
- ✅ Chiaro che sono template (estensione)

## Convenzione Template Files

**Per tutti i moduli**:

```
✅ CORRETTO:
MyClass.php.template
MyTrait.example.php
pattern-example.php.bak

❌ ERRATO:
MyClass_TEMPLATE.php  # Confonde autoloader
MyClass_EXAMPLE.php   # Idem
```

## Alternative Considerate

1. **Spostare in docs/**: ❌ PHP code fuori da docs/ (convenzione)
2. **Usare .txt**: ❌ Perde syntax highlighting IDE
3. **Commentare `declare class`**: ❌ Complica template
4. **Aggiungere a .gitignore**: ❌ I template VANNO versionati
5. **Estensione .template**: ✅ MIGLIORE (chiara + no autoload)

## Collegamenti

- [SchedaTrait.php](../app/Models/Traits/SchedaTrait.php) - Implementazione attiva
- [Template Clean](../app/Models/Traits/SchedaTrait_CLEAN.php.template) - Template minimale
- [Template Final](../app/Models/Traits/SchedaTrait_FINAL_TEMPLATE.php.template) - Template completo

**Status**: ✅ RISOLTO  
**Pattern**: Estensione `.template` per file non-eseguibili

