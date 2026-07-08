# Token Efficiency

## Fonti ufficiali studiate

- OpenAI Prompt Caching: https://platform.openai.com/docs/guides/prompt-caching
- OpenAI Latency Optimization: https://platform.openai.com/docs/guides/latency-optimization
- OpenAI Prompting Guide: https://platform.openai.com/docs/guides/prompting
- OpenAI GPT-5.1 model page: https://platform.openai.com/docs/models/gpt-5.1

## Regole operative

### 1. Massimizzare il prefisso condiviso

- mettere istruzioni statiche, esempi e tool definitions all'inizio
- mettere contenuto variabile, RAG, cronologia e input utente piu` tardi
- quando disponibile, usare `prompt_cache_key`

### 2. Generare meno token

- chiedere output brevi e con vincoli espliciti
- usare `max_output_tokens` o equivalente
- usare `stop` quando il formato lo consente
- preferire JSON compatto o formati piu` piccoli quando servono output strutturati

### 3. Usare meno input token

- evitare contesto ridondante
- non ripetere regole gia` stabilizzate se il sistema o il prompt object le contiene gia`
- ridurre HTML, boilerplate, log e dati rumorosi prima di inviarli al modello

### 4. Fare meno richieste

- unire step compatibili in una sola chiamata
- evitare catene seriali di prompt se il modello puo` restituire piu` campi in una risposta sola

### 5. Parallelizzare quando possibile

- separare sottotask indipendenti
- evitare attese sequenziali non necessarie

### 6. Non usare sempre un LLM

- per controlli deterministici usare codice, regex, SQL, parser, lookup locali
- per contenuti ripetitivi usare template o testo statico

### 7. Scegliere il livello di ragionamento minimo sufficiente

- usare `reasoning.effort: none/low` quando il task non richiede ricerca o ragionamento profondo
- usare `verbosity: low` quando serve solo il risultato
- aumentare effort o verbosity solo quando il compito lo richiede davvero

### 8. Riutilizzare prompt gestiti

- usare Prompt objects/versioning quando il prompt deve essere riusato spesso
- evitare di ricostruire ogni volta grandi prompt inline
