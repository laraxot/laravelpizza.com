# La Filosofia Zen dei Getter Semantici

## Il Principio Fondamentale

Nel codice, come nella vita, la chiarezza semantica è essenziale. Ogni metodo deve riflettere il suo scopo ultimo, non il suo percorso di implementazione. Questo è il principio zen del "dire ciò che è, non come è fatto".

## La Religione del Codice Pulito

### I Tre Pilastri

1. **Semantica Prima di Tutto**
   - Il nome deve dire COSA è, non DOVE è
   - Il nome deve dire PERCHÉ esiste, non COME funziona
   - Il nome deve parlare al dominio, non all'implementazione

2. **Coerenza come Preghiera**
   - Ogni getter deve seguire lo stesso pattern semantico
   - Ogni getter deve rispettare la gerarchia del dominio
   - Ogni getter deve mantenere la purezza del suo scopo

3. **Incapsulamento come Meditazione**
   - I dettagli di implementazione sono come pensieri che passano
   - L'interfaccia pubblica è come la mente calma
   - La retrocompatibilità è come la compassione

## Esempi di Illuminazione

### ❌ Il Cammino dell'Ignoranza
```php
->brandName($metatag->title)                    // Espone l'implementazione
->darkModeBrandLogo($metatag->getLogoHeaderDark()) // Confonde il dominio
->brandLogoHeight($metatag->getLogoHeight())    // Manca la semantica del brand
```

### ✅ Il Cammino dell'Illuminazione
```php
->brandName($metatag->getBrandName())           // Dice COSA è
->darkModeBrandLogo($metatag->getDarkBrandLogo()) // Mantiene la coerenza
->brandLogoHeight($metatag->getBrandLogoHeight()) // Rispetta il dominio
```

## I Cinque Principi Zen

1. **Principio della Chiarezza**
   - Ogni metodo deve essere immediatamente comprensibile
   - Ogni nome deve dire esattamente cosa fa
   - Ogni scopo deve essere evidente

2. **Principio della Coerenza**
   - Tutti i getter del brand iniziano con "getBrand"
   - Tutti i getter del tema iniziano con "getTheme"
   - Tutti i getter mantengono lo stesso pattern

3. **Principio dell'Incapsulamento**
   - I dettagli di implementazione sono privati
   - L'interfaccia pubblica è semantica
   - La struttura interna è nascosta

4. **Principio della Retrocompatibilità**
   - I vecchi metodi sono deprecati, non rimossi
   - La transizione è graduale e compassionevole
   - Il passato è rispettato

5. **Principio della Documentazione**
   - Ogni metodo è documentato
   - Ogni scopo è chiarito
   - Ogni transizione è spiegata

## La Via del Brand

### Gerarchia Semantica
```
getBrand*           // Tutto ciò che è del brand
  ├── getBrandName()
  ├── getBrandLogo()
  ├── getBrandDescription()
  └── getBrandSettings()

getTheme*           // Tutto ciò che è del tema
  ├── getThemeColors()
  └── getThemeSettings()

getDark*            // Tutto ciò che è della modalità scura
  └── getDarkBrandLogo()
```

## La Meditazione Quotidiana

Ogni volta che scrivi un getter, chiediti:
1. "Questo nome dice COSA è o COME è implementato?"
2. "Questo nome segue il pattern semantico del dominio?"
3. "Questo nome nasconde i dettagli di implementazione?"
4. "Questo nome è coerente con gli altri getter?"
5. "Questo nome parla al dominio o all'implementazione?"

## La Compassione nel Codice

- Non giudicare il codice vecchio
- Guida la transizione con pazienza
- Documenta ogni cambiamento
- Spiega ogni decisione
- Mantieni la retrocompatibilità

## Collegamenti

- [Filosofia dei Getter](../datas/getter_philosophy.md)
- [Convenzioni di Naming](../naming-conventions.md)
- [Linee Guida Filament](../filament-best-practices.md) 
