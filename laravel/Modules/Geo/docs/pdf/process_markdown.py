#!/usr/bin/env python3
import re
import sys
import os
from pathlib import Path

def translate_to_italian(text):
    # Simple translation dictionary - in a real scenario, you might want to use a translation API
    translations = {
        # Common terms
        'Event Sourcing': 'Sourcing di Eventi',
        'Laravel': 'Laravel',  # Proper name
        'Introduction': 'Introduzione',
        'Table of Contents': 'Indice',
        'Chapter': 'Capitolo',
        'Example': 'Esempio',
        'Note': 'Nota',
        'Warning': 'Attenzione',
        'Tip': 'Suggerimento',
        'Code': 'Codice',
        'Diagram': 'Diagramma',
        'Figure': 'Figura',
        # Add more translations as needed
    }
    
    # Simple word replacement
    for eng, ita in translations.items():
        text = text.replace(eng, ita)
    
    return text

def add_svg_diagram(section_title):
    # Map section titles to appropriate SVGs
    svg_map = {
        'Event Sourcing': """
```mermaid
graph TD
    A[Comando] --> B[Aggregate Root]
    B --> C[Evento di Dominio]
    C --> D[Proiezione]
    D --> E[Vista di Lettura]
```
        """,
        'Aggregate Root': """
```mermaid
classDiagram
    class Carrello {
        +uuid: string
        +stato: string
        +articoli: array
        +aggiungiArticolo()
        +rimuoviArticolo()
        +checkout()
    }
```
        """,
        'CQRS': """
```mermaid
flowchart LR
    A[Comando] --> B[Command Handler]
    B --> C[Aggregate Root]
    C --> D[Evento]
    D --> E[Event Handler]
    E --> F[Proiezione]
    F --> G[Query]
```
        """
    }
    
    for key in svg_map:
        if key.lower() in section_title.lower():
            return f"\n### Diagramma: {key}\n{svg_map[key]}\n"
    
    return ""

def add_example(section_title):
    # Map section titles to examples
    example_map = {
        'Event Sourcing': """
### Esempio: Registrazione di un Evento

```php
// Creazione di un nuovo evento
$evento = new ArticoloAggiuntoAlCarrello(
    idCarrello: '123',
    idArticolo: '456',
    quantita: 2,
    prezzoUnitario: 29.99
);

// Registrazione dell'evento
$carrello->registraEvento($evento);
```
        """,
        'Aggregate Root': """
### Esempio: Implementazione di un Aggregate Root

```php
class Carrello extends AggregateRoot
{
    private string $idCarrello;
    private array $articoli = [];
    
    public static function crea(string $idCarrello, string $idUtente): self
    {
        $carrello = new self($idCarrello);
        $carrello->registraEvento(new CarrelloCreato($idCarrello, $idUtente));
        return $carrello;
    }
    
    public function aggiungiArticolo(string $idArticolo, int $quantita, float $prezzo): void
    {
        $this->registraEvento(new ArticoloAggiunto(
            $this->idCarrello,
            $idArticolo,
            $quantita,
            $prezzo
        ));
    }
}
```
        """
    }
    
    for key in example_map:
        if key.lower() in section_title.lower():
            return example_map[key]
    
    return ""

def process_markdown(content):
    # Remove page references
    content = re.sub(r'# Pagina \d+', '', content)
    
    # Split into sections
    sections = re.split(r'(?m)^---$', content)
    processed_sections = []
    
    for section in sections:
        section = section.strip()
        if not section:
            continue
            
        # Translate section to Italian
        section = translate_to_italian(section)
        
        # Add section to processed sections
        processed_sections.append(section)
        
        # Add SVG diagram if applicable
        svg_diagram = add_svg_diagram(section)
        if svg_diagram:
            processed_sections.append(svg_diagram)
            
        # Add example if applicable
        example = add_example(section)
        if example:
            processed_sections.append(example)
    
    # Join sections with horizontal rules
    return '\n\n---\n\n'.join(processed_sections)

def main():
    if len(sys.argv) < 2:
        print("Usage: python process_markdown.py <input_file.md> [output_file.md]")
        sys.exit(1)
    
    input_file = Path(sys.argv[1])
    output_file = sys.argv[2] if len(sys.argv) > 2 else f"{input_file.stem}_processed.md"
    
    try:
        with open(input_file, 'r', encoding='utf-8') as f:
            content = f.read()
        
        processed_content = process_markdown(content)
        
        with open(output_file, 'w', encoding='utf-8') as f:
            f.write(processed_content)
            
        print(f"File elaborato con successo. Output salvato in {output_file}")
        
    except Exception as e:
        print(f"Errore: {str(e)}")
        sys.exit(1)

if __name__ == "__main__":
    main()
