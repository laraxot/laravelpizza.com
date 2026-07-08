# Utilizzo GroupColumn in ProgressioniResource

## Scopo
Il modulo Progressioni utilizza il componente `GroupColumn` per ottimizzare lo spazio nella tabella raggruppando valori correlati in colonne uniche.

## Implementazione Attuale

### Colonne Raggruppate
Nel file `ListProgressionis.php`, le seguenti colonne sono raggruppate:

#### 1. Gruppo "lavoratore"
```php
GroupColumn::make('lavoratore')->schema([
    TextColumn::make('matr')->searchable(),
    TextColumn::make('cognome')->searchable(),
    TextColumn::make('nome'),
    TextColumn::make('email'),
])
```

#### 2. Gruppo "criteri"
```php
GroupColumn::make('criteri')->schema([
    TextColumn::make('gg'),
    TextColumn::make('gg_no_asz'),
    TextColumn::make('gg_asz'),
    TextColumn::make('gg_cateco_no_posfun_no_asz'),
    TextColumn::make('eta'),
])
```

#### 3. Gruppo "qua" (qualifiche)
```php
GroupColumn::make('qua')->schema([
    TextColumn::make('propro'),
    TextColumn::make('posfun'),
    TextColumn::make('categoria_eco'),
    TextColumn::make('categoria_ecoval'),
    TextColumn::make('posfunval'),
    TextColumn::make('posiz'),
    TextColumn::make('posiz_txt'),
    TextColumn::make('disci1'),
    TextColumn::make('disci1_txt'),
])
```

#### 4. Gruppo "rep" (rapporti)
```php
GroupColumn::make('rep')->schema([
    TextColumn::make('stabi'),
    TextColumn::make('stabi_txt'),
    TextColumn::make('repar'),
    TextColumn::make('repar_txt'),
])
```

#### 5. Gruppo "periodo"
```php
GroupColumn::make('periodo')->schema([
    TextColumn::make('dal'),
    TextColumn::make('al'),
    TextColumn::make('anno'),
])
```

## Vantaggi
1. **Risparmio Spazio**: Più valori in una singola colonna
2. **Organizzazione Logica**: Raggruppamento di campi correlati
3. **Migliore UX**: Informazioni correlate visualizzate insieme
4. **Responsive**: Adattamento migliore su schermi piccoli

## Comportamento
- I valori vuoti vengono automaticamente saltati
- Ogni valore viene mostrato con la sua etichetta
- I valori sono visualizzati verticalmente (uno sotto l'altro)
- Supporto per la ricerca sui campi specificati

## Risoluzione Problemi
Per eventuali problemi con il GroupColumn, consultare:
- [GroupColumn Fix Documentation](../../UI/docs/group-column-fix.md)
- [Filament Tables Documentation](https://filamentphp.com/docs/3.x/tables/columns)

## Collegamenti
- [ProgressioniResource](./progressioni-resource.md)
- [UI Module GroupColumn Fix](../../UI/docs/group-column-fix.md)
- [CompilaScheda Fix](./compila-scheda-fix.md)
