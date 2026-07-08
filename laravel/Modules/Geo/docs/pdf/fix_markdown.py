#!/usr/bin/env python3
import re
import sys
from pathlib import Path

def fix_markdown(content):
    # Fix page breaks
    content = re.sub(r'## Page \d+\n+', '---\n\n', content)
    
    # Fix code blocks
    content = re.sub(r'```(.*?)```', lambda m: f'```php\n{m.group(1).strip()}\n```\n', content, flags=re.DOTALL)
    
    # Fix headings
    content = re.sub(r'^([A-Z][A-Z\s]+)$', r'## \1', content, flags=re.MULTILINE)
    
    # Fix lists
    content = re.sub(r'^\s*[•-]\s+', '* ', content, flags=re.MULTILINE)
    
    # Fix common OCR errors
    replacements = {
        r'ﬁ': 'fi',
        r'ﬂ': 'fl',
        r'’': "'",
        r'“': '"',
        r'”': '"',
        r'—': '--',
        r'–': '-',
        r'…': '...',
        r'»': '>>',
        r'«': '<<',
        r'•': '*',
        r'®': '(R)',
        r'©': '(C)',
        r'™': '(TM)',
        r'\s+\n': '\n',
        r'\n{3,}': '\n\n',
        r'\s+': ' ',
    }
    
    for old, new in replacements.items():
        content = re.sub(old, new, content)
    
    # Fix quotes
    content = re.sub(r'"(.*?)"', r'"\1"', content)
    
    # Remove excessive line breaks
    content = re.sub(r'\n{3,}', '\n\n', content)
    
    # Fix code blocks formatting
    def fix_code_blocks(match):
        code = match.group(1).strip()
        return f'```php\n{code}\n```\n\n'
    
    content = re.sub(r'```(.*?)```', fix_code_blocks, content, flags=re.DOTALL)
    
    return content

def main():
    if len(sys.argv) < 2:
        print("Usage: python fix_markdown.py <input_file.md> [output_file.md]")
        sys.exit(1)
    
    input_file = Path(sys.argv[1])
    output_file = sys.argv[2] if len(sys.argv) > 2 else f"{input_file.stem}_fixed.md"
    
    try:
        with open(input_file, 'r', encoding='utf-8') as f:
            content = f.read()
        
        fixed_content = fix_markdown(content)
        
        with open(output_file, 'w', encoding='utf-8') as f:
            f.write(fixed_content)
            
        print(f"Successfully fixed Markdown. Output saved to {output_file}")
        
    except Exception as e:
        print(f"Error: {str(e)}")
        sys.exit(1)

if __name__ == "__main__":
    main()
