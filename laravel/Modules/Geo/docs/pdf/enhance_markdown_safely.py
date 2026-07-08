#!/usr/bin/env python3
import re
import sys
from pathlib import Path

def add_translations(content):
    # Aggiunge traduzioni solo al testo, evitando i blocchi di codice
    sections = content.split('```')
    
    # Traduci solo le sezioni di testo (indici pari)
    for i in range(0, len(sections), 2):
        # Traduzioni comuni
        translations = {
            'Event Sourcing in Laravel': 'Sourcing di Eventi in Laravel',
            'A Beyond CRUD strategy': 'Una strategia oltre il CRUD',
            'By Brent Roose': 'Di Brent Roose',
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
            'Conclusion': 'Conclusione',
            'See also': 'Vedi anche',
            'References': 'Riferimenti'
        }
        
        for eng, ita in translations.items():
            sections[i] = sections[i].replace(eng, ita)
    
    # Ricostruisci il contenuto mantenendo i blocchi di codice invariati
    return '```'.join(sections)

def add_diagrams(content):
    # Aggiunge diagrammi dopo le sezioni pertinenti
    sections = content.split('\n\n')
    enhanced_sections = []
    
    for section in sections:
        enhanced_sections.append(section)
        
        # Aggiungi diagrammi rilevanti
        if 'Event Sourcing' in section:
            diagram = """
### Diagramma: Architettura a Sourcing di Eventi
*(Terminologia tecnica in inglese)*
```mermaid
graph TD
    A[Comando] --> B[Aggregate Root]
    B --> C[Evento di Dominio]
    C --> D[Proiezione]
    D --> E[Vista di Lettura]
```
            """
            enhanced_sections.append(diagram.strip())
            
    return '\n\n'.join(enhanced_sections)

def add_examples(content):
    # Aggiunge esempi dopo le sezioni pertinenti
    sections = content.split('\n\n')
    enhanced_sections = []
    
    for section in sections:
        enhanced_sections.append(section)
        
        # Aggiungi esempi rilevanti
        if 'Aggregate Root' in section:
            example = """
### Esempio: Implementazione di un Aggregate Root (in inglese)

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
}
```
            """
            enhanced_sections.append(example.strip())
            
    return '\n\n'.join(enhanced_sections)

def main():
    if len(sys.argv) < 2:
        print("Usage: python enhance_markdown_safely.py <input_file.md> [output_file.md]")
        sys.exit(1)
    
    input_file = Path(sys.argv[1])
    output_file = sys.argv[2] if len(sys.argv) > 2 else f"{input_file.stem}_enhanced.md"
    
    try:
        with open(input_file, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Applica le modifiche in modo conservativo
        content = add_translations(content)
        content = add_diagrams(content)
        content = add_examples(content)
        
        with open(output_file, 'w', encoding='utf-8') as f:
            f.write(content)
            
        print(f"File migliorato salvato in: {output_file}")
        print("Il file originale non è stato modificato.")
        
    except Exception as e:
        print(f"Errore: {str(e)}")
        sys.exit(1)

if __name__ == "__main__":
    main()
