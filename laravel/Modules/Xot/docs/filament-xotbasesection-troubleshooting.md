# XotBaseSection Troubleshooting

## BadMethodCallException: disableLiveUpdates does not exist

### Problema
Quando si estende `XotBaseSection` invece di `Filament\Schemas\Components\Section`, può verificarsi un errore:

```
BadMethodCallException - Internal Server Error
Method Modules\<nome progetto>\Filament\Forms\Components\CompanySection::disableLiveUpdates does not exist.
```

### Causa
L'errore si verifica quando `XotBaseSection` tenta di chiamare metodi che non esistono nella classe parent `Section`. Il metodo `disableLiveUpdates()` non è un metodo nativo di Filament Section.

### Soluzione
Rimuovere qualsiasi chiamata a metodi non esistenti nel metodo `setUp()` di `XotBaseSection`:

```php
protected function setUp(): void
{
    parent::setUp();
    // Common setup for all XotBaseSection components can be added here.
    // NOTE: do not call non-existent macros like disableLiveUpdates() to
    // avoid BadMethodCallException at runtime.
}
```

### Lezione appresa
1. **Verificare sempre l'esistenza dei metodi**: Prima di chiamare un metodo in una classe base, verificare che esista nella documentazione o nel codice sorgente.

2. **Testare dopo l'estensione**: Quando si crea una nuova classe base come `XotBaseSection`, testare immediatamente l'integrazione con le classi figlie.

3. **Seguire il principio DRY**: Invece di duplicare configurazioni in ogni classe figlia, centralizzarle nella classe base, ma solo per metodi che effettivamente esistono.

4. **Documentare i metodi disponibili**: Mantenere una lista dei metodi sicuri da usare nelle classi base per evitare errori futuri.

### Politica Laraxot
Secondo la politica, religione, filosofia e zen di Laraxot:
- Mai estendere direttamente `Filament\Schemas\Components\Section`
- Estendere sempre `Modules\Xot\Filament\Schemas\Components\XotBaseSection`
- Verificare che `XotBaseSection` non contenga chiamate a metodi inesistenti
