---
title: "XotBaseResource: Regole fondamentali"
type: note
status: draft
updated: 2026-10-18
tags: [docs, xot, consolidated]
qmd: "xotbaseresource: regole fondamentali xot"
---
# XotBaseResource: Regole fondamentali

## Principio di progettazione

La classe `XotBaseResource` è progettata per centralizzare e standardizzare l'implementazione delle risorse Filament nel progetto, seguendo i principi DRY (Don't Repeat Yourself) e riducendo la duplicazione del codice.

## ⚠️ Regole da rispettare SEMPRE

1. **Non implementare metodi standard già forniti dalla classe base**:

   ```php
   // ❌ ERRATO: Non implementare questi metodi nelle classi derivate
   public static function form(Form $form): Form { ... }
   public static function table(Table $table): Table { ... }
   ```

2. **Non implementare `getPages()` se contiene solo le route standard**:

   ```php
   // ❌ ERRATO: Non implementare questo metodo se restituisce solo le pagine standard
   public static function getPages(): array
   {
       return [
           'index' => Pages\ListRecords::route('/'),
           'create' => Pages\CreateRecord::route('/create'),
           'edit' => Pages\EditRecord::route('/{record}/edit'),
       ];
   }
   ```

3. **Non implementare `getRelations()` se restituisce un array vuoto**:

   ```php
   // ❌ ERRATO: Non implementare questo metodo se restituisce array vuoto
   public static function getRelations(): array
   {
       return [];
   }
   ```

## ✅ Pattern corretto

```php
class MyResource extends XotBaseResource
{
    protected static ?string $model = MyModel::class;

    // SOLO questo metodo è necessario
    public static function getFormSchema(): array
    {
        return [
            'title' => TextInput::make('title')->required(),
            'content' => RichEditor::make('content')->required(),
        ];
    }

    // Eventualmente questo per personalizzare la query
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('active', true);
    }
}
```

## 🔄 Casi in cui è legittimo sovrascrivere i metodi

È legittimo sovrascrivere questi metodi SOLO quando è necessario un comportamento personalizzato non standard:

1. `getPages()` - Solo se si aggiungono pagine personalizzate o si modifica il comportamento delle pagine standard
2. `getRelations()` - Solo se la risorsa ha relazioni da mostrare
3. `form()` / `table()` - Solo se è necessario un comportamento che non può essere ottenuto attraverso `getFormSchema()` o `getListTableColumns()`

## 🧠 Motivazione

Questa struttura garantisce:

1. **Coerenza**: Tutte le risorse seguono lo stesso pattern
2. **Manutenibilità**: Modifiche al comportamento base possono essere fatte in un unico punto
3. **Leggibilità**: Le classi derivate contengono solo il codice specifico per quella risorsa
4. **Estendibilità**: Nuove funzionalità possono essere aggiunte centralmente

## 🔍 Verifica automatica

Prima di ogni commit, verificare che le risorse Filament non contengano metodi non necessari:

```bash

# Cerca risorse che contengono form() o table() o getPages() standard
grep -r "public static function form" --include="*.php" /path/to/resources
grep -r "public static function table" --include="*.php" /path/to/resources
grep -r "public static function getPages" --include="*.php" /path/to/resources
```

## 🔄 Processo di refactoring

Se trovi questi metodi in una risorsa esistente:

1. Verifica se il comportamento è standard (uguale alla classe base)
2. Se è standard, rimuovi completamente il metodo
3. Se contiene personalizzazioni, estrai solo la logica personalizzata e rimuovi il resto
