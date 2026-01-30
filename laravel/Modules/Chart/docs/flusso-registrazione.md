# Flusso di Registrazione in il progetto

## Panoramica

Questo documento descrive il flusso completo di registrazione utente nell'applicazione il progetto, implementato come un wizard multi-step in Filament. Il processo è progettato per raccogliere tutte le informazioni necessarie in modo graduale e user-friendly.

## Implementazione Tecnica

Il flusso di registrazione è implementato nella classe `PatientResource` del modulo Patient, utilizzando il componente `Wizard` di Filament. Ogni step del wizard è definito come un metodo separato che restituisce un oggetto `Forms\Components\Wizard\Step`.

```php
Forms\Components\Wizard::make([
    self::getPersonalDataStep(),
    self::getContactStep(),
    self::getDocumentsStep(),
    self::getCredentialsStep(),
    self::getPrivacyStep(),
])
->skippable(false)
->submitAction(self::getSubmitButton())
```

## Step del Wizard

### Step 1: Dati Personali

**Metodo**: `getPersonalDataStep()`

**Campi**:
- `first_name` (Nome)
- `last_name` (Cognome)
- `fiscal_code` (Codice Fiscale)

**Implementazione**:
```php
Forms\Components\TextInput::make('first_name')
    ->label('Nome')
    ->placeholder('Inserisci il tuo nome')
    ->maxLength(255)
    ->prefixIcon('heroicon-o-user')
```

**Note**:
- Seguire sempre la convenzione di naming `first_name`/`last_name` invece di `name`/`surname`
- Utilizzare icone appropriate per migliorare l'esperienza utente

### Step 2: Documenti

**Metodo**: `getDocumentsStep()`

**Campi**:
- `health_card` (Tessera sanitaria, STP o ENI)
- `isee_certificate` (Autocertificazione livello ISEE)
- `pregnancy_certificate` (Attestazione di gravidanza)

**Implementazione**:
```php
Forms\Components\FileUpload::make('health_card')
    ->label('Tessera sanitaria, STP o ENI')
    ->disk('public')
    ->directory('documents/health-cards')
    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
    ->maxSize(5120)
    ->downloadable()
    ->previewable()
    ->imagePreviewHeight('100')
    ->loadingIndicatorPosition('left')
    ->removeUploadedFileButtonPosition('right')
    ->uploadButtonPosition('left')
    ->uploadProgressIndicatorPosition('left')
    ->columnSpanFull()
```

**Note**:
- ⚠️ **IMPORTANTE**: I componenti `FileUpload` **NON** supportano i metodi `prefixIcon()`, `suffixIcon()` o `removeButtonPosition()`
- Utilizzare `removeUploadedFileButtonPosition()` invece di `removeButtonPosition()`
- Specificare sempre i tipi di file accettati e la dimensione massima

### Step 3: Contatti

**Metodo**: `getContactStep()`

**Campi**:
- `address` (Indirizzo)
- `city` (Città)
- `phone` (Telefono)
- `email` (Email)

**Implementazione**:
```php
Forms\Components\TextInput::make('address')
    ->label('Indirizzo')
    ->placeholder('Inserisci il tuo indirizzo')
    ->maxLength(255)
    ->prefixIcon('heroicon-o-home-modern')
```

**Note**:
- Utilizzare il tipo di input appropriato per ogni campo (tel, email)
- Validare il formato dell'email e del numero di telefono

### Step 4: Informazioni Preventive alla Visita

**Metodo**: `getPreVisitStep()`

**Campi**:
- `ultima_visita` (Ultima visita dal dentista)
- `motivo_visita` (Motivo della visita)
- `allergie` (Eventuali allergie)

**Implementazione**:
```php
Forms\Components\Select::make('ultima_visita')
    ->label('Qual è l\'ultima volta che è andata dal dentista?')
    ->options([
        'mai' => 'Mai',
        'ultimi_6_mesi' => 'Negli ultimi 6 mesi',
        'piu_6_mesi' => 'Più di 6 mesi fa',
        'piu_1_anno' => 'Più di 1 anno fa',
        'piu_2_anni' => 'Più di 2 anni fa',
    ])
    ->required()
```

**Note**:
- Utilizzare componenti Select per opzioni predefinite
- Offrire la possibilità di inserire date specifiche quando necessario
- Raccogliere solo le informazioni essenziali per la prima visita

### Step 5: Credenziali

**Metodo**: `getCredentialsStep()`

**Campi**:
- `password` (Password)
- `password_confirmation` (Conferma Password)

**Implementazione**:
```php
Forms\Components\TextInput::make('password')
    ->label('Password')
    ->placeholder('Minimo 8 caratteri')
    ->password()
    ->required()
    ->minLength(8)
    ->same('password_confirmation')
    ->prefixIcon('heroicon-o-lock-closed')
```

**Note**:
- Implementare validazioni di sicurezza per la password
- Verificare che le due password corrispondano
- Utilizzare regole di complessità per garantire password sicure

### Step 6: Privacy

**Metodo**: `getPrivacyStep()`

**Campi**:
- `privacy_policy` (Accettazione Privacy Policy)
- `terms_of_service` (Accettazione Termini di Servizio)
- `marketing_consent` (Consenso Marketing - opzionale)

**Implementazione**:
```php
Forms\Components\RichEditor::make('privacy_text')
    ->label('Testo Informativa Privacy')
    ->default('Ai sensi del Regolamento (UE) 2016/679...')
    ->disabled()
    ->dehydrated(false)
    ->columnSpanFull(),

Forms\Components\Checkbox::make('privacy_accepted')
    ->label('Ho letto e accetto l\'informativa sulla privacy')
    ->required()
    ->columnSpanFull()
```

**Note**:
- Includere il testo completo dell'informativa privacy
- Registrare data, ora e IP dell'accettazione
- Separare i consensi obbligatori da quelli opzionali

## Pagina di Ringraziamento

Dopo la registrazione, l'utente viene reindirizzato a una pagina di ringraziamento che conferma il completamento della registrazione e fornisce istruzioni sui passaggi successivi. Questa pagina è implementata come route separata (`registration.thank-you`) specificata nel metodo `getFormSchemaWidget()` tramite `->successRedirectUrl(route('registration.thank-you'))`.

**Elementi chiave**:
- **Header**: Barra di navigazione con logo "Salute Orale" e menu hamburger
- **Messaggio principale**: "Ti ringraziamo per esserti iscritt* al portale Salute Ora"
- **Testo informativo**: Spiegazione del processo di verifica dei dati e documenti
- **Prossimi passi**: Informazioni su cosa aspettarsi dopo la registrazione
- **Background animato**: SVG animati che aggiungono interesse visivo senza distrarre

**Versione mobile vs desktop**:
- **Mobile**: Layout a singola colonna con pulsante fisso in basso per tornare alla homepage
- **Desktop**: Pannello informativo aggiuntivo con maggiori dettagli sui passaggi successivi

**Implementazione con Folio + Volt**:
```php
// Nel metodo getFormSchemaWidget() di PatientResource
->successRedirectUrl('/registration/thank-you')

// File: resources/views/pages/registration/thank-you.blade.php
<x-layouts.app>
    <div class="container mx-auto p-4">
        <h1>Ti ringraziamo per esserti iscritt* al portale Salute Ora</h1>
        <!-- Contenuto della pagina di ringraziamento -->
    </div>
</x-layouts.app>

@php
// Logica Volt integrata direttamente nella vista
class {
    public function mount()
    {
        // Logica di inizializzazione
    }
}
@endphp
```

**Nota importante**: Con Laravel Folio, non è necessario definire rotte esplicite in `routes/web.php`. Le pagine vengono automaticamente mappate in base alla loro posizione nella directory `resources/views/pages`. Questo approccio è più coerente con l'architettura del frontoffice basata su Folio + Volt.

**Miglioramenti suggeriti**:
- Promemoria per verificare l'email (inclusa la cartella spam)
- Indicazione dei tempi previsti per il completamento del processo di verifica
- Opzioni per salvare l'appuntamento o il promemoria nel calendario
- Personalizzazione del messaggio con il nome dell'utente

## Best Practice

1. **Validazione**: Implementare validazione lato client e server per tutti i campi
2. **Feedback**: Fornire feedback immediato all'utente durante la compilazione
3. **Persistenza**: Salvare i dati parziali per evitare perdite in caso di interruzione
4. **Accessibilità**: Garantire che tutti i campi siano accessibili e utilizzabili con tastiera
5. **Responsive**: Ottimizzare l'interfaccia per dispositivi mobili e desktop
6. **Convenzioni di naming**: Utilizzare `first_name`/`last_name` invece di `name`/`surname`

## Collegamenti Bidirezionali

- [Documentazione Filament Forms](https://filamentphp.com/docs/3.x/forms/fields/wizard)
- [Componenti FileUpload](./filament/file-upload-components.md)
- [Convenzioni di Naming](./convenzioni-naming-campi.md)
- [Gestione Upload](./upload-management.md)
- [Mockup Interfaccia - Step 1](./images/4.md)
- [Mockup Interfaccia - Step 2](./images/5.md)
- [Mockup Interfaccia - Step 3](./images/6.md)
- [Mockup Interfaccia - Step 4](./images/7.md)
- [Mockup Interfaccia - Ringraziamento](./images/8.md)

## Note Importanti
- Le traduzioni sono gestite tramite LangServiceProvider
- NON usare ->label(), ->placeholder(), ->helperText()
- Definire le traduzioni nei file di lingua del modulo

## Struttura Form
```php
// ❌ NON FARE:
->label('Nome')
->placeholder('Inserisci il tuo nome')

// ✅ FARE:
// Le traduzioni sono gestite automaticamente tramite LangServiceProvider
// Definire nei file di lingua:
// resources/lang/it/registration.php
return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il tuo nome',
        ],
        // ... altri campi
    ],
];
```

## Campi del Form
1. **Dati Personali**
   - Nome
   - Cognome
   - Data di nascita
   - Codice fiscale

2. **Documenti**
   - Tessera sanitaria
   - STP
   - ENI

3. **Indirizzo**
   - Via
   - Città
   - CAP
   - Provincia

4. **Anamnesi**
   - Ultima visita dentistica
   - Problemi dentali
   - Allergie

5. **Account**
   - Email
   - Password
   - Conferma password

6. **Privacy**
   - Informativa privacy
   - Consenso trattamento dati

## Note Tecniche
- Tutte le traduzioni sono gestite tramite LangServiceProvider
- Definire le traduzioni nei file di lingua del modulo
- NON usare metodi di traduzione diretti nei componenti
