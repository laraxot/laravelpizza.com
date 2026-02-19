# Best Practices per Risorse Filament in Laraxot

Questo documento riassume le migliori pratiche per la creazione e gestione delle risorse Filament all'interno dell'ecosistema Laraxot. Seguire queste linee guida garantirà compatibilità e coerenza in tutto il progetto.

## Estensione delle Classi Base

### Risorse

1. **SEMPRE** estendere `Modules\Xot\Filament\Resources\XotBaseResource`:
   ```php
   // CORRETTO ✅
   class ClienteResource extends XotBaseResource

   // ERRATO ❌
   class ClienteResource extends Resource
   ```

2. **SEMPRE** impostare correttamente le proprietà statiche:
   ```php
   protected static ?string $model = Cliente::class;
   protected static ?string $navigationIcon = 'heroicon-o-users';
   protected static ?string $cluster = ClienteCluster::class; // Se applicabile
   ```

### Pagine

1. Per le pagine di **creazione**:
   ```php
   // CORRETTO ✅
   class CreateCliente extends XotBaseCreateRecord

   // ERRATO ❌
   class CreateCliente extends CreateRecord
   ```

2. Per le pagine di **modifica**:
   ```php
   // CORRETTO ✅
   class EditCliente extends XotBaseEditRecord

   // ERRATO ❌
   class EditCliente extends EditRecord
   ```

3. Per le pagine di **elenco**:
   ```php
   // CORRETTO ✅
   class ListClienti extends XotBaseListRecords

   // ERRATO ❌
   class ListClienti extends ListRecords
   ```

## Definizione dei Form

1. **SEMPRE** utilizzare `getFormSchema()` invece di `form()`:
   ```php
   // CORRETTO ✅
   public static function getFormSchema(): array
   {
       return [
           TextInput::make('nome'),
           // altri componenti...
       ];
   }

   // ERRATO ❌
   public static function form(Form $form): Form
   {
       return $form->schema([...]);
   }
   ```

2. **MAI** avvolgere i componenti in una chiamata `schema()` nel metodo `getFormSchema()`:
   ```php
   // CORRETTO ✅
   return [
       TextInput::make('nome'),
       // altri componenti...
   ];

   // ERRATO ❌
   return $form->schema([
       TextInput::make('nome'),
   ]);
   ```

## Localizzazione e Label

1. **MAI** utilizzare il metodo `->label()` sui campi o colonne:
   ```php
   // CORRETTO ✅
   TextInput::make('nome')

   // ERRATO ❌
   TextInput::make('nome')->label('Nome Cliente')
   ```

2. **SEMPRE** aggiungere le traduzioni nei file di lingua appropriati:
   ```php
   // Nel file lang/it/resource.php
   return [
       'fields' => [
           'nome' => [
               'label' => 'Nome Cliente'
           ]
       ]
   ];
   ```

## Ciclo di Vita dei Componenti

1. **SEMPRE** implementare il metodo `fillForm()` nelle pagine di modifica, anche se vuoto:
   ```php
   /**
    * Metodo fillForm per rispettare il ciclo di vita dei componenti Filament
    */
   public function fillForm(): void
   {
       // Può essere vuoto, ma deve essere presente
   }
   ```

2. **SEMPRE** utilizzare il metodo `mount()` appropriato:
   ```php
   public function mount(): void
   {
       parent::mount();
       // Inizializzazione specifica
   }
   ```

## Relazioni con Database

### Differenze tra Brain e Orisbroker

1. **ATTENZIONE** alle differenze strutturali tra database:
   - In **braindb**:
     - Le tabelle geografiche hanno il campo `nome` ma NON `descrizione`
     - Esempio: `nazione`, `regione`, `provincia`, `comune`

   - In **orisbroker**:
     - Le stesse tabelle hanno sia `nome` che `descrizione`

2. **SEMPRE** usare il campo corretto basato sul database:
   ```php
   // Per modelli Brain (CORRETTO ✅)
   ->relationship('nazione_nascita', 'nome')

   // Per modelli Orisbroker (CORRETTO ✅)
   ->relationship('nazione', 'descrizione')
   ```

3. **CONSIDERARE** l'uso di accessor per uniformare l'interfaccia:
   ```php
   // Nel modello Brain\Models\Nazione
   public function getDescrizioneAttribute(): string
   {
       return $this->nome;
   }
   ```

## Debug e Sviluppo

1. **MAI** lasciare funzioni di debug nel codice di produzione:
   ```php
   // DA RIMUOVERE PRIMA DEL COMMIT ❌
   dddx($record);
   dd($data);
   ```

2. **SEMPRE** verificare le strutture del database prima di implementare relazioni

## Creazione di ClienteFromBrain

1. **ESATTA SEQUENZA** di campi da mantenere:
   - **Dati anagrafici**: titolo_id, nome, cognome, sesso, data_nascita, etc.
   - **Classificazione professionale**: tipologia_cliente_id, stato_id, etc.
   - **Informazioni professionali**: data_iscrizione_albo, is_socio_andi, etc.
   - **Indirizzo e contatti**: via, cap, regione_id, provincia_id, etc.
   - **Dati bancari**: iban, intestatario, banca, filiale
   - **Modalità di ricezione**: Lista di modalità selezionabili

## Collegamenti tra versioni di FILAMENT_BEST_PRACTICES.md
* [FILAMENT_BEST_PRACTICES.md](../../../xot/docs/filament/filament_best_practices.md)
* [FILAMENT_BEST_PRACTICES.md](../../../xot/docs/filament_best_practices.md)
* [FILAMENT_BEST_PRACTICES.md](../../../user/docs/filament_best_practices.md)
* [FILAMENT_BEST_PRACTICES.md](../../../job/docs/filament_best_practices.md)

## Collegamenti tra versioni di filament_best_practices.md
* [filament_best_practices.md](../../../../../docs/rules/filament_best_practices.md)
* [filament_best_practices.md](../filament_best_practices.md)
* [filament_best_practices.md](../../../user/docs/filament_best_practices.md)
* [filament_best_practices.md](../../../job/docs/filament_best_practices.md)
