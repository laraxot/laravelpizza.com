# Gestione dei Permessi

## Panoramica
Il modulo User utilizza il pacchetto `spatie/laravel-permission` per gestire i permessi e i ruoli degli utenti.
## Permessi Disponibili
### Moderazione Medici
- `moderate_doctors`: Può moderare le registrazioni dei medici
- `view_doctors`: Può visualizzare i medici
- `create_doctors`: Può creare medici
- `edit_doctors`: Può modificare i medici
- `delete_doctors`: Può eliminare i medici
## Ruoli Disponibili
### Moderatore
Il ruolo `moderator` ha i seguenti permessi:
- `moderate_doctors`
- `view_doctors`
## Implementazione
### Seeder
I permessi e i ruoli vengono creati tramite il seeder `PermissionsSeeder`:
```php
class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Crea i permessi
        $permissions = [
            'moderate_doctors' => 'Può moderare le registrazioni dei medici',
            'view_doctors' => 'Può visualizzare i medici',
            'create_doctors' => 'Può creare medici',
            'edit_doctors' => 'Può modificare i medici',
            'delete_doctors' => 'Può eliminare i medici',
        ];
        foreach ($permissions as $name => $description) {
            Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web',
                'description' => $description,
            ]);
        }
        // Assegna i permessi ai ruoli
        $role = Role::firstOrCreate([
            'name' => 'moderator',
            'guard_name' => 'web',
        ]);
        $role->givePermissionTo([
            'moderate_doctors',
            'view_doctors',
    }
}
```
### Utilizzo
Per verificare se un utente ha un determinato permesso:
if ($user->hasPermissionTo('moderate_doctors')) {
    // L'utente può moderare i medici
Per verificare se un utente ha un determinato ruolo:
if ($user->hasRole('moderator')) {
    // L'utente è un moderatore
### Filament
I permessi vengono utilizzati nel modulo Patient per controllare l'accesso alle funzionalità di moderazione:
Forms\Components\View::make('patient::filament.doctor-moderation-summary')
    ->visible(fn () => Auth::user()->hasPermissionTo('moderate_doctors')),
Forms\Components\Textarea::make('moderation_notes')
    ->label('Note Moderazione')
    ->visible(fn () => Auth::user()->hasPermissionTo('moderate_doctors'))
## Migrazione
La tabella `permissions` include il campo `description` per una migliore documentazione dei permessi:
$table->id();
$table->string('name');
$table->string('guard_name');
$table->string('description')->nullable();
$table->timestamps();
## Interfaccia di Amministrazione
I permessi possono essere gestiti tramite l'interfaccia di amministrazione di Filament:
- Lista dei permessi: `/admin/permissions`
- Creazione permesso: `/admin/permissions/create`
- Modifica permesso: `/admin/permissions/{id}/edit`
## Vedi Anche
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- [Filament](https://filamentphp.com)
- [Doctor Registration Workflow](../Patient/docs/doctor-registration-workflow.md)
## Collegamenti tra versioni di permissions.md
* [permissions.md](../../Gdpr/docs/packages/permissions.md)
* [permissions.md](../../Patient/docs/permissions.md)
- [Spatie Laravel Permission](https://spatie.be/project_docs/laravel-permission)
- [Doctor Registration Workflow](../Patient/project_docs/doctor-registration-workflow.md)
* [permissions.md](../../Gdpr/project_docs/packages/permissions.md)
* [permissions.md](../../Patient/project_docs/permissions.md)
