# Regole Critiche

Summary obbligatorio per tutti gli agenti. Vedi [index](index.md) per navigazione completa.

1. **phpstan.neon IMMUTABILE**: `laravel/phpstan.neon` è l'unico file di config PHPStan. NON modificarlo. NON creare altri file phpstan.neon* (phpstan.neon.dist, ecc.). Vedi `.cursor/rules/phpstan-neon-immutable.mdc`
2. **PHPStan Level 10**: Zero errors tolerated
3. **Strict Typing**: `declare(strict_types=1)` in all files
4. **No Mixed Types**: Forbidden in any form
5. **Module Base Classes**: Must extend XotBase* classes
6. **Filament array keys**: MAI `array_values()` su getHeaderActions/getTableActions/getTableColumns/getFormSchema — le chiavi string sono obbligatorie. **getTableColumns() DEVE SEMPRE** restituire `array<string, Column>` con chiavi string. Vedi `.cursor/rules/gettablecolumns-string-keys.mdc`
7. **NO table() override**: In Filament 5 il metodo `table()` è `final`. NON overridare `table()` in nessuna classe (RelationManager, ManageRelatedRecords, TableWidget, Page). Usare `getTableColumns()`, `getTableHeaderActions()`, `getTableActions()`, `getTableBulkActions()`, `getTableFilters()`. Questa è una regola CRITICA - genera errore PHP "Cannot override final method".
8. **Chart Widget Pattern**: getOptions() può restituire array o RawJs (Filament accetta entrambi); RawJs obbligatorio quando options via @js() con formatter
9. **No Widget Constructors**: Livewire factory pattern - NO __construct() methods
10. **form() DEVE essere final**: Il metodo `form()` in `HasXotForm` e `XotBaseRelationManager` DEVE restare `final`. Sono le classi figlie che si adattano implementando `getFormSchema()`, mai facendo override di `form()`.
11. **table() DEVE essere final**: Il metodo `table()` in `HasXotTable` trait DEVE restare `final`. Sono le classi figlie che si adattano implementando `getTableColumns()`, `getTableHeaderActions()`, `getTableActions()`, `getTableBulkActions()`, `getTableFilters()`, mai facendo override di `table()`.
12. **No HasFactory ridondante**: Modelli che estendono `BaseModel` del modulo hanno già la factory via `XotBaseModel → HasXotFactory`. NON aggiungere `use HasFactory` o `use HasXotFactory` — è ridondante. Es: `Team extends BaseTeam → BaseModel → XotBaseModel`.
13. **Italian Localization**: Use `toLocaleString("it-IT")` for display
14. **Test Coverage**: Every feature must have tests
15. **Documentation First**: Write docs before code
16. **Composer module deps**: Package specifici (Firebase, FCM, OAuth) vanno nel `composer.json` del modulo che li usa, mai nel root. Vedi `.cursor/rules/composer-module-dependencies.mdc`
17. **Nested Resources $relatedResource**: Quando si usa `XotBaseManageRelatedRecords` con `$relatedResource`, le pagine Edit/View devono essere raggiungibili tramite la relatedResource, non tramite la parent. L'URL `/parent/{id}/relationship/{id}/edit` potrebbe non funzionare se le rotte non sono configurate correttamente.
18. **database/* folders (lowercase)**: Tutte le cartelle in `database/` DEVONO essere in minuscolo. 
    - ✅ `database/migrations`, `database/factories`, `database/seeders`, `database/seeds`
    - ❌ `database/Migrations`, `database/Factories`, `Database/Seeders`
    - Questo e un errore case-sensitive su filesystem Linux.
19. **casts() method, NOT $casts property**: I modelli DEVONO usare il metodo `casts()` invece della proprietà `$casts`. Il metodo e piu moderno e supportato da PHPStan.
    - ✅ `protected function casts(): array { return ['is_active' => 'boolean']; }`
    - ❌ `protected $casts = ['is_active' => 'boolean'];`
20. **MAI property_exists() con Eloquent**: Non usare MAI `property_exists()` su modelli Eloquent - restituisce sempre false per attributi magici. Usare `isset()`.
    - ❌ `property_exists($model, 'email')` - sempre false!
    - ✅ `isset($model->email)` - corretto
21. **Actions over Services**: Laraxot usa Actions per la logica di business, non Service classes. Vedi `.ai/guidelines/action-pattern.md`
22. **Translation files**: I file di traduzione DEVONO essere in `resources/lang/{locale}/` del modulo con chiavi in inglese. Mai hardcodare stringhe nelle view.
23. **Module docs structure**: Ogni modulo deve avere `docs/README.md` con struttura standard. Vedi `.ai/guidelines/LARAXOT-CORE.md`
24. **NO direct Filament extends**: Mai estendere classi Filament direttamente. Usare sempre XotBase* wrappers.

## Riferimenti

- [index](index.md) - Torna all'indice
- [project-rules](project-rules.md)
- [memories](memories.md)
- [LARAXOT-CORE](../.ai/guidelines/LARAXOT-CORE.md) - Core guidelines
- [database-migrations-rules](../.ai/guidelines/database-migrations-rules.md) - Migration rules
