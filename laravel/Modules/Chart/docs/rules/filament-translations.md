# Traduzioni nei Form Filament

## Principi Fondamentali

1. **NO Label Dirette**
   ```php
   // ❌ Errato: Label hardcoded
   TextInput::make('email')
       ->label('Email')
       ->placeholder('Inserisci email')
       ->helperText('La tua email personale');

   // ✅ Corretto: Usa traduzioni
   TextInput::make('email')
   ```

2. **Struttura File Traduzioni**
   ```
   resources/lang/
   ├── it/
   │   └── mail-template.php
   └── en/
       └── mail-template.php
   ```

## File di Traduzione

1. **Formato Corretto**
   ```php
   // lang/it/mail-template.php
   return [
       'fields' => [
           'email' => [
               'label' => 'Email',
               'placeholder' => 'Inserisci email',
               'helper_text' => 'La tua email personale',
           ],
       ],
   ];
   ```

2. **Uso in Form**
   ```php
   // ✅ Corretto: Le traduzioni sono gestite automaticamente
   protected function getFormSchema(): array
   {
       return [
           TextInput::make('email'),
           TextInput::make('subject'),
           RichEditor::make('content'),
       ];
   }
   ```

## Errori Comuni

1. ❌ **Label Dirette**
   ```php
   ->label('Nome')
   ->placeholder('Inserisci il nome')
   ->helperText('Il tuo nome completo')
   ```

2. ❌ **TransTrait Ridondante**
   ```php
   use TransTrait; // Non necessario se estendi XotBaseResource
   ```

3. ❌ **Traduzioni Incomplete**
   ```php
   // Mancano placeholder e helper_text
   'email' => [
       'label' => 'Email',
   ],
   ```

## Best Practices

1. **Struttura Traduzioni**
   ```php
   // module-name.php
   return [
       'fields' => [
           'field_name' => [
               'label' => 'Label',
               'placeholder' => 'Placeholder',
               'helper_text' => 'Helper text',
           ],
       ],
       'buttons' => [...],
       'messages' => [...],
   ];
   ```

2. **Fallback Lingua**
   ```php
   // config/app.php
   'fallback_locale' => 'en',
   ```

3. **Validazione Traduzioni**
   ```php
   // Verifica presenza traduzioni
   php artisan lang:missing
   ```

## Checklist

Prima di creare/modificare un form:
- [ ] Rimosse tutte le label hardcoded?
- [ ] File di traduzione creati per tutte le lingue?
- [ ] Struttura traduzioni corretta?
- [ ] Nessun uso di TransTrait se non necessario?

## Documentazione Correlata
- [Laravel Localization](https://laravel.com/docs/10.x/localization)
- [Filament Translations](https://filamentphp.com/docs/3.x/support/translation)
- [Best Practices](https://filamentphp.com/docs/3.x/forms/advanced) 