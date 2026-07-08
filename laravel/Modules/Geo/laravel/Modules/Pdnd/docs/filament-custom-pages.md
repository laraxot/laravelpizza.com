# Filament Custom Pages - Documentazione Modulo Pdnd

## Overview

Il modulo **Pdnd** implementa pagine Filament custom per l'integrazione con i servizi ANPR (Anagrafe Nazionale Popolazione Residente) via PDND (Piattaforma Digitale Nazionale Dati).

## Pattern Utilizzato

### XotBasePage + HasForms

Tutte le pagine Pdnd estendono `XotBasePage` e implementano `HasForms`:

```php
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Modules\Xot\Filament\Pages\XotBasePage;

class ServizioAccertamentoIdUnicoNazionalePage extends XotBasePage
{
    use InteractsWithForms;
    
    public array $pdndData = [];
    protected string $view = 'pdnd::filament.pages.C030-servizioAccertamentoIdUnicoNazionale-approvazione_autom';
    
    public function pdndForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('codiceFiscale')
                            ->required(),
                    ]),
            ])
            ->statePath('pdndData');
    }
}
```

## Pagine Disponibili

### 1. ServizioAccertamentoIdUnicoNazionalePage
- **Servizio ANPR**: C030 - Accertamento Id Unico Nazionale
- **View**: `pdnd::filament.pages.C030-servizioAccertamentoIdUnicoNazionale-approvazione_autom`

### 2. ServizioAccertamentoIdUnicoNazionalePagePROD
- **Ambiente**: Produzione
- **Servizio**: C030 PROD

### 3. ServizioVerificaDichEsistenzaVita
- **Servizio ANPR**: C007 - Verifica Dichiarazione Esistenza in Vita
- **View**: `pdnd::filament.pages.C007-servizioVerificaDichEsistenzaVita-approvazione_autom`

### 4. ServizioVerificaDichEsistenzaVitaPROD
- **Ambiente**: Produzione
- **Servizio**: C007 PROD

### 5. ServizioVerificaDichGeneralita
- **Servizio ANPR**: C003 - Verifica Dichiarazione Generalità
- **View**: `pdnd::filament.pages.C003-servizioVerificaDichGeneralita-approvazione_autom`

### 6. ServizioVerificaDichGeneralitaPROD
- **Ambiente**: Produzione
- **Servizio**: C003 PROD

### 7. CurlProxyPage (Test Cluster)
- **Namespace**: `Modules\Pdnd\Filament\Clusters\Test\Pages`
- **Uso**: Test proxy HTTP

### 8. GuzzleProxyPage (Test Cluster)
- **Uso**: Test proxy Guzzle HTTP client

## View Blade

Le view sono posizionate in:
```
Modules/Pdnd/resources/views/filament/pages/
├── C030-servizioAccertamentoIdUnicoNazionale-approvazione_autom.blade.php
├── C007-servizioVerificaDichEsistenzaVita-approvazione_autom.blade.php
└── C003-servizioVerificaDichGeneralita-approvazione_autom.blade.php
```

## Best Practices

1. **Sempre usare short array syntax `[]`** - mai `array()`
2. **Schema-based forms** (Filament 5) invece di Form
3. **State path** per isolare i dati del form
4. **Tipo codice fiscale** con validazione regex

## Collegamenti

- [Filament 5 Custom Pages](../../../../../docs/filament-5-custom-pages.md)
- [XotBasePage Documentation](../../Xot/docs/filament/xotbasepage.md)
- [ANPR Services Documentation](../docs/anpr-services.md)
