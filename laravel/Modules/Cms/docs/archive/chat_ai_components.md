# Componenti Chat AI

Questo documento descrive le componenti UI ispirate al template "ChatAI" di [Tailkit](https://tailkit.com/templates#chatai). Non si implementano qui, ma si documentano le componenti proposte e i motivi per cui sono utili.

## Panoramica Tailkit ChatAI

- UI di chat moderna basata su Tailwind CSS
- Versione Laravel 12 con pagine responsive e supporto dark mode
- Componenti: header, lista messaggi, bolle chat, area input, launcher

## Componenti proposti

- **ChatWindowComponent**  
  Contenitore principale della chat; gestisce la visibilità, il layout e lo stato di apertura/chiusura.

- **ChatHeaderComponent**  
  Sezione superiore con titolo, icona/avatar del bot, pulsanti di minimizzazione e chiusura.

- **ChatMessageListComponent**  
  Lista scrollabile di messaggi; gestisce grouping, scroll automatico e lazy loading di messaggi/storico.

- **ChatBubbleComponent**  
  Rappresentazione di un singolo messaggio; supporta stili differenti per utente e bot, timestamp e badge di stato.

- **ChatInputComponent**  
  Area di input con textarea, pulsante di invio, indicatori di digitazione e shortcut da tastiera.

- **ChatSidebarComponent** (opzionale)  
  Pannello laterale per liste di conversazioni salvate, contatti o opzioni avanzate.

- **ChatLauncherComponent**  
  Pulsante flottante (FAB) per aprire o chiudere la finestra di chat.

## Motivazioni per la documentazione

1. **Prioritizzazione**: definire con chiarezza i componenti prima di implementare.
2. **UX e validazione**: progettare flusso utente e raccogliere feedback iniziali.
3. **Modularità**: favorire sviluppo iterativo e separazione delle responsabilità.
4. **Coerenza**: uniformare stile e naming evitando componenti ad-hoc nella UI.

## Collegamenti

- [Template Tailkit ChatAI](https://tailkit.com/templates#chatai)  
- [Blocchi di Contenuto](blocks.md)  
- [Documentazione Root](../../../project_docs/README.md)
