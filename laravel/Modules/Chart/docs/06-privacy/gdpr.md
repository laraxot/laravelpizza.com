# Conformità GDPR per il progetto

## Panoramica

Il progetto il progetto tratta dati personali e sanitari di gestanti in condizioni di vulnerabilità socio-economica, pertanto la conformità al GDPR è un requisito fondamentale. Questo documento descrive le misure implementate per garantire la conformità normativa.

## Principi di Privacy by Design

### 1. Minimizzazione dei Dati
- Raccolta solo dei dati strettamente necessari
- Eliminazione automatica dei dati non più necessari
- Anonimizzazione dei dati per scopi statistici

### 2. Protezione dei Dati per Impostazione Predefinita
- Crittografia dei dati sensibili
- Accesso limitato in base al ruolo
- Logging delle attività di accesso ai dati

### 3. Trasparenza
- Informative privacy chiare e comprensibili
- Consenso esplicito per il trattamento dei dati
- Documentazione dei processi di trattamento

## Implementazione Tecnica

### Modulo GDPR
Il modulo `module_gdpr_fila3` implementa le seguenti funzionalità:

```php
// Esempio di implementazione della crittografia dei dati sensibili
class PatientRepository implements PatientRepositoryInterface
{
    public function store(PatientData $data): Patient
    {
        return Patient::create([
            'first_name' => $data->firstName,
            'last_name' => $data->lastName,
            'tax_code' => Crypt::encrypt($data->taxCode), // Crittografia
            'health_data' => Crypt::encrypt($data->healthData), // Crittografia
        ]);
    }
    
    public function find(int $id): ?Patient
    {
        $patient = Patient::find($id);
        
        if ($patient) {
            // Decrittografia automatica
            $patient->tax_code = Crypt::decrypt($patient->tax_code);
            $patient->health_data = Crypt::decrypt($patient->health_data);
        }
        
        return $patient;
    }
}
```

### Gestione del Consenso
- Registrazione del consenso con timestamp
- Possibilità di revoca del consenso
- Tracciamento delle modifiche al consenso

### Diritti degli Interessati
Implementazione delle funzionalità per:
- Accesso ai propri dati
- Rettifica dei dati
- Cancellazione (diritto all'oblio)
- Limitazione del trattamento
- Portabilità dei dati

## Ruoli e Responsabilità

### Titolari del Trattamento
- **Fondazione ANDI E.T.S.**: Titolare dei dati raccolti dal dentista
- **INMP**: Titolare dei dati relativi allo stato di gestazione e ISEE

### Responsabili del Trattamento
- Sviluppatori e manutentori della piattaforma
- Fornitori di servizi cloud (se applicabile)

### DPO (Data Protection Officer)
- Supervisione della conformità GDPR
- Punto di contatto per le autorità di controllo
- Consulenza su valutazioni d'impatto sulla protezione dei dati

## Misure di Sicurezza

### Sicurezza Tecnica
- Crittografia dei dati a riposo e in transito
- Autenticazione multi-fattore
- Aggiornamenti regolari di sicurezza

### Sicurezza Organizzativa
- Formazione del personale
- Politiche di accesso ai dati
- Procedure di gestione degli incidenti

## Valutazione d'Impatto sulla Protezione dei Dati (DPIA)

Una DPIA completa è stata condotta per il progetto il progetto, identificando:
- Rischi per i diritti e le libertà degli interessati
- Misure di mitigazione implementate
- Valutazione della proporzionalità del trattamento

Per i dettagli completi della DPIA, consultare il documento [DPIA](./dpia.md).
