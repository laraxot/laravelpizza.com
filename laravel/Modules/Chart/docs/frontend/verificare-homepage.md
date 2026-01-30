# Guida alla Verifica dell'Homepage di il progetto

Questo documento fornisce istruzioni dettagliate su come verificare che l'homepage di il progetto implementi correttamente i contenuti specificati nei requisiti ufficiali.

## Metodi di Verifica

Esistono diversi approcci per verificare la corrispondenza dell'homepage con le specifiche ufficiali:

### 1. Verifica Manuale

La verifica manuale consiste nel confrontare visivamente l'homepage con le specifiche:

1. Apri il browser e naviga a `http://<nome progetto>.local/`
2. Apri il documento di specifiche `docs/images/2.md` e la documentazione correlata
3. Confronta elemento per elemento:
   - Verifica il titolo: "Benvenuta su Salute Orale,"
   - Verifica il testo principale 
   - Verifica il testo dei requisiti
   - Verifica il testo del pulsante CTA
   - Controlla la presenza dei loghi dei partner

### 2. Verifica Automatizzata con Script PHP

Per un'analisi più sistematica, è stato creato uno script di verifica in `laravel/tests/HomepageUrlCheck.php`:

```bash

# Dalla radice del progetto
php laravel/tests/HomepageUrlCheck.php
```

Lo script utilizza cURL per verificare che tutti gli elementi previsti siano presenti nell'homepage.

**Nota:** In caso di errore HTTP 500, verifica che:
- Il server locale sia attivo e funzionante
- L'URL `http://<nome progetto>.local/` sia configurato correttamente in `/etc/hosts`
- Controlla i log PHP per identificare problemi di configurazione o errori

### 3. Verifica con Test di Integrazione

Per verifiche più approfondite in un processo di CI/CD, sono disponibili test di integrazione:

```bash

# Test Pest per l'homepage
cd laravel
php artisan test tests/Feature/HomepageContentTest.php
```

**Nota:** Questi test richiedono un ambiente funzionante con tutte le dipendenze configurate correttamente.

### 4. Verifica Tecnica del File JSON

Verificare che il file di configurazione dell'homepage contenga le stringhe corrette:

```bash

# Usando grep per verificare la presenza delle stringhe chiave
grep "Benvenuta su Salute Orale" laravel/config/local/<nome progetto>/database/content/pages/1.json
grep "pazienti vulnerabili in stato di gravidanza" laravel/config/local/<nome progetto>/database/content/pages/1.json
grep "INIZIA ORA" laravel/config/local/<nome progetto>/database/content/pages/1.json
```

## Elenco Completo degli Elementi da Verificare

### Contenuto Testuale
| Elemento | Testo Esatto | Localizzazione Tipica |
|----------|--------------|------------------------|
| Titolo | "Benvenuta su Salute Orale," | Hero section |
| Sottotitolo | "il portale che vuole garantire alle pazienti vulnerabili in stato di gravidanza la possibilità di accedere a servizi odontoiatrici di prevenzione a titolo completamente gratuito." | Hero section |
| Requisiti | "Se sei una donna in stato di gravidanza residente in Italia o in attesa di permesso di soggiorno, con un valore ISEE pari a euro 20,000 o inferiore, e vuoi partecipare a questa iniziativa clicca il pulsante qui sotto:" | Paragraph section |
| CTA | "INIZIA ORA" | Pulsante principale |

### Elementi Visivi
| Elemento | Descrizione | Localizzazione |
|----------|-------------|----------------|
| Logo | Logo "Salute Orale" con "O" stilizzata | Header |
| Selettore lingua | Opzioni IT/EN | Header (lato destro) |
| Sfondo sezione centrale | Blu navy | Body centrale |
| Loghi partner | COI, INMP/NIHMP, Fondazione ANDI | Footer |

## Risoluzione Problemi Comuni

Se l'homepage non corrisponde alle specifiche:

1. **Problema**: Contenuto testuale errato o mancante
   **Soluzione**: Verificare e correggere `laravel/config/local/<nome progetto>/database/content/pages/1.json`

2. **Problema**: Layout o stile non corrispondente  
   **Soluzione**: Verificare i file CSS nel tema `laravel/Themes/One/resources/css`

3. **Problema**: Immagini o loghi mancanti  
   **Soluzione**: Verificare che le immagini siano presenti in `public_html/themes/One/assets`

4. **Problema**: Errore nel rendering dei blocchi  
   **Soluzione**: Verificare il file `laravel/Modules/Cms/app/View/Composers/ThemeComposer.php`

## Conclusione

La verifica regolare dell'homepage è fondamentale per garantire che il portale il progetto comunichi correttamente il suo scopo e i requisiti di partecipazione alle potenziali beneficiarie. Utilizzando una combinazione di verifiche manuali e automatizzate, è possibile mantenere l'aderenza alle specifiche ufficiali in modo efficiente e affidabile. 
