# Regole per la Configurazione degli IDE

## Cartelle di Configurazione Critiche

Prima di implementare correzioni o nuove funzionalità, è fondamentale verificare e aggiornare le configurazioni degli IDE nei seguenti percorsi:

### 1. Regole dell'IDE

- `.windsurf/rules/`: Contiene regole specifiche per l'IDE Windsurf
- `.cursor/rules/`: Contiene regole specifiche per l'IDE Cursor

### 2. Memorie dell'IDE

- `.cursor/memories/`: Contiene memorie persistenti che guidano il comportamento dell'assistente AI

## Procedura di Aggiornamento

Quando si identificano errori ricorrenti o si implementano nuove best practices:

1. **Analizzare la Causa**: Comprendere perché si è verificato l'errore
2. **Documentare nel Modulo**: Aggiornare la documentazione nel modulo più vicino all'errore
3. **Aggiornare le Regole IDE**: Modificare i file in `.windsurf/rules/` e `.cursor/rules/`
4. **Creare Memorie**: Aggiungere memorie persistenti in `.cursor/memories/`
5. **Collegamenti Bidirezionali**: Creare/aggiornare i collegamenti nella documentazione centrale

## Regole Comuni da Configurare

- Utilizzo di percorsi relativi nella documentazione
- Namespace corretti per i moduli (es. `Modules\NomeModulo\Filament` e non `Modules\NomeModulo\App\Filament`)
- Convenzioni per le chiavi di traduzione
- Struttura dei componenti Filament

## Collegamenti Correlati

- [Percorsi Relativi nella Documentazione](./PERCORSI_RELATIVI_DOCUMENTAZIONE.md)
- [Sistema di Prompt](./PROMPTS_DOCUMENTATION_SYSTEM.md)
- [Collegamenti della Documentazione](../../docs/collegamenti-documentazione.md)
