# Filosofia dei Metodi Semantici

## Principio Fondamentale
I metodi devono riflettere il loro scopo semantico piuttosto che i dettagli di implementazione. Questo principio si basa su tre pilastri:

1. **Semantica vs Implementazione**
   - I nomi dei metodi devono descrivere COSA fanno, non COME lo fanno
   - Evitare nomi che espongono dettagli tecnici o posizioni
   - Preferire termini di dominio rispetto a termini tecnici

2. **Coerenza nel Branding**
   - Tutti i metodi relativi al brand devono iniziare con "getBrand"
   - Mantenere una nomenclatura coerente in tutto il sistema
   - Evitare mescolanze di stili di naming

3. **Astrazione dei Dettagli**
   - Nascondere i dettagli di implementazione
   - Fornire un'interfaccia pulita e intuitiva
   - Permettere cambiamenti interni senza impattare l'API

## Esempi di Trasformazione

### Da Implementazione a Semantica
```php
// ❌ ERRATO: Espone dettagli di implementazione
$metatag->getLogoHeader()      // Dove è il logo
$metatag->getLogoHeaderDark()  // Come è implementato
$metatag->getLogoHeight()      // Dettaglio tecnico

// ✅ CORRETTO: Riflette lo scopo semantico
$metatag->getBrandLogo()       // Cosa rappresenta
$metatag->getDarkModeBrandLogo() // Quando viene usato
$metatag->getBrandLogoHeight() // Proprietà del brand
```

### Da Proprietà a Metodi Semantici
```php
// ❌ ERRATO: Accesso diretto alle proprietà
$metatag->title
$metatag->sitename

// ✅ CORRETTO: Metodi semantici
$metatag->getBrandName()
$metatag->getBrandTitle()
```

## Vantaggi

1. **Manutenibilità**
   - Codice più facile da capire
   - Cambiamenti interni più semplici
   - Meno accoppiamento con l'implementazione

2. **Coerenza**
   - API più prevedibile
   - Pattern di naming uniformi
   - Migliore documentazione

3. **Flessibilità**
   - Possibilità di cambiare l'implementazione
   - Supporto per diverse strategie
   - Adattabilità a nuovi requisiti

## Best Practices

1. **Naming**
   - Usare prefissi semantici (getBrand, getDarkMode)
   - Evitare riferimenti a posizioni (header, footer)
   - Mantenere coerenza nei suffissi

2. **Implementazione**
   - Mantenere la logica di base in metodi tecnici
   - Creare wrapper semantici per l'API pubblica
   - Documentare la relazione tra metodi

3. **Documentazione**
   - Spiegare lo scopo semantico
   - Evitare riferimenti all'implementazione
   - Fornire esempi di utilizzo

## Esempio Completo

```php
class MetatagData
{
    // Implementazione di base (privata o protetta)
    protected function getLogoHeader(): string
    {
        // Logica di base
    }

    // API pubblica semantica
    public function getBrandLogo(): string
    {
        return $this->getLogoHeader();
    }

    public function getDarkModeBrandLogo(): string
    {
        return $this->getLogoHeaderDark();
    }

    public function getBrandLogoHeight(): string
    {
        return $this->getLogoHeight();
    }
}
```

## Collegamenti
- [MetatagData](../datas/metatag-data.md)
- [ApplyMetatagToPanelAction](../actions/applymetatagtopanelaction.md)
- [Best Practices](../best-practices.md) 
