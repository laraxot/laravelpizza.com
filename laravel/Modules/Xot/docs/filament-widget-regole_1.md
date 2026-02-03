# Regole Widget Filament (XotBase)

## Path delle view dei Widget Filament

- Tutte le view dei widget Filament devono essere referenziate come 'modulo::filament.widgets.nome-widget'.
- La struttura delle cartelle deve essere sempre resources/views/filament/widgets/.
- Mai usare path generici come widgets. o pages. senza il prefisso filament.
- **Esempio corretto:**
  ```php
  protected static string $view = 'saluteora::filament.widgets.find-doctor-and-appointment';
  ```
- **Esempio sbagliato:**
  ```php
  protected static string $view = 'saluteora::widgets.find-doctor-and-appointment';
  ```

## Label e Placeholder

- Non usare MAI ->label(), ->placeholder(), né stringhe tradotte direttamente nei componenti Filament.
- Tutte le label, placeholder, titoli e descrizioni sono risolte tramite i file di traduzione del modulo (es: Modules/SaluteOra/lang/it/widgets.php).
- Chi estende XotBaseWidget, XotBaseResource, XotBasePage deve affidarsi solo alle chiavi di traduzione.
- **Esempio corretto:**
  ```php
  Forms\Components\TextInput::make('location');
  ```
- **Esempio sbagliato:**
  ```php
  Forms\Components\TextInput::make('location')->label(__('saluteora::widgets.find_doctor.location_label'));
  ```

---

Vedi anche: [find-dentist-functionality.md](../../saluteora/docs/find-dentist-functionality.md) 
