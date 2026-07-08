#!/bin/bash

# Script per analizzare funzioni specifiche nei moduli
# - getTableColumns
# - getTableActions
# - getTableBulkActions
# - funzioni di MetatagData

cd $(dirname $0)/../..

echo "Iniziando l'analisi di funzioni specifiche..."

# Assicuriamoci che la directory docs/phpstan esista
mkdir -p docs/phpstan

# File di output per l'analisi
OUTPUT_FILE="docs/phpstan/specific_functions_analysis.md"

# Intestazione del file di analisi
cat > $OUTPUT_FILE << EOL
# Analisi di funzioni specifiche nei moduli

Data: $(date +"%Y-%m-%d %H:%M:%S")

Questo documento contiene un'analisi dettagliata di funzioni specifiche presenti nei moduli.

## 1. Funzioni getTableColumns, getTableActions e getTableBulkActions

Queste funzioni devono restituire array con chiavi stringa. Di seguito sono riportati i risultati dell'analisi.

### getTableColumns

\`\`\`
$(grep -r "function getTableColumns" laravel/Modules --include="*.php" | sort)
\`\`\`

#### Implementazioni che potrebbero non restituire array con chiavi stringa:

\`\`\`
$(grep -rA 10 "function getTableColumns" laravel/Modules --include="*.php" | grep -v "string" | grep "=>")
\`\`\`

### getTableActions

\`\`\`
$(grep -r "function getTableActions" laravel/Modules --include="*.php" | sort)
\`\`\`

#### Implementazioni che potrebbero non restituire array con chiavi stringa:

\`\`\`
$(grep -rA 10 "function getTableActions" laravel/Modules --include="*.php" | grep -v "string" | grep "=>")
\`\`\`

### getTableBulkActions

\`\`\`
$(grep -r "function getTableBulkActions" laravel/Modules --include="*.php" | sort)
\`\`\`

#### Implementazioni che potrebbero non restituire array con chiavi stringa:

\`\`\`
$(grep -rA 10 "function getTableBulkActions" laravel/Modules --include="*.php" | grep -v "string" | grep "=>")
\`\`\`

## 2. Classe MetatagData e funzioni correlate

Analisi della classe MetatagData e metodi associati che dovrebbero esistere per supportare chiamate di tipo ->colors() e simili.

### Definizione della classe MetatagData

\`\`\`
$(grep -r "class MetatagData" laravel/Modules --include="*.php")
\`\`\`

### Metodi esistenti in MetatagData

\`\`\`
$(grep -r "function get[A-Z]" laravel/Modules --include="*MetatagData.php" | sort)
\`\`\`

### Metodi chiamati ma potenzialmente mancanti

\`\`\`
$(grep -r "colors(" laravel/Modules --include="*.php" | grep -v "MetatagData\|function colors")
$(grep -r "get[A-Z][a-zA-Z]*(" laravel/Modules --include="*.php" | grep "metatag" | grep -v "MetatagData\|function get")
\`\`\`

## Raccomandazioni

### Per le funzioni getTableColumns, getTableActions, getTableBulkActions:

1. Assicurarsi che tutte le implementazioni restituiscano array con chiavi stringa
2. Aggiungere annotazioni PHPDoc per specificare i tipi di ritorno
3. Considerare la creazione di interfacce che definiscano questi metodi con tipi appropriati

### Per MetatagData:

1. Implementare tutti i metodi getter necessari nella classe MetatagData
2. Documentare quali getter sono disponibili e quali parametri accettano
3. Considerare l'uso di metodi magici o trait per gestire getter dinamici

## Implementazioni mancanti

Le seguenti implementazioni sono necessarie per garantire la piena funzionalità:

$(for FUNC in $(grep -r "get[A-Z][a-zA-Z]*(" laravel/Modules --include="*.php" | grep "metatag" | grep -v "MetatagData\|function get" | sed -r "s/.*get([A-Za-z]+)\(.*/\1/" | sort | uniq); do
  echo "- get$FUNC() - Mancante nella classe MetatagData"
done)

EOL

echo "Analisi delle funzioni specifiche completata. Il report è disponibile in $OUTPUT_FILE"

# Analisi dettagliata per MetatagData, creando file di documentazione per implementazione
METATAG_DOC="docs/phpstan/metatag_implementation.md"

cat > $METATAG_DOC << EOL
# Implementazione MetatagData

Data: $(date +"%Y-%m-%d %H:%M:%S")

## Metodi che devono essere implementati

Di seguito è riportato un elenco dei metodi che devono essere implementati nella classe MetatagData:

$(for FUNC in $(grep -r "get[A-Z][a-zA-Z]*(" laravel/Modules --include="*.php" | grep "metatag" | grep -v "MetatagData\|function get" | sed -r "s/.*get([A-Za-z]+)\(.*/\1/" | sort | uniq); do
  echo "### get$FUNC()"
  echo ""
  echo "Questo metodo deve essere implementato per supportare chiamate del tipo \`->get$FUNC()\` nei template."
  echo ""
  echo "\`\`\`php"
  echo "/**"
  echo " * Get the $FUNC value."
  echo " *"
  echo " * @return string|array<string,mixed>"
  echo " */"
  echo "public function get$FUNC() {"
  echo "    // Implementazione da completare"
  echo "    return \$this->data['$FUNC'] ?? '';"
  echo "}"
  echo "\`\`\`"
  echo ""
done)

## Modulo consigliato per l'implementazione

Il modulo più appropriato per l'implementazione di questi metodi è quello che già contiene la classe MetatagData.
In assenza di una chiara localizzazione, si consiglia di implementarli nel modulo Seo o in un modulo dedicato alla gestione dei metatag.

## Raccomandazioni per la struttura

1. Utilizzare un'interfaccia che definisca tutti i metodi getter richiesti
2. Implementare la classe concreta con tutti i metodi necessari
3. Utilizzare un trait per funzionalità comuni se necessario
4. Documentare adeguatamente ogni metodo con PHPDoc

EOL

echo "Documentazione per l'implementazione di MetatagData creata in $METATAG_DOC" 