#!/usr/bin/env python3
import re
import sys
from pathlib import Path

def enhance_markdown(content):
    # Fix common OCR errors and formatting issues
    replacements = [
        (r'ﬁ', 'fi'),
        (r'ﬂ', 'fl'),
        (r'’', "'"),
        (r'“', '"'),
        (r'”', '"'),
        (r'—', '--'),
        (r'–', '-'),
        (r'…', '...'),
        (r'»', '>>'),
        (r'«', '<<'),
        (r'•', '*'),
        (r'®', '(R)'),
        (r'©', '(C)'),
        (r'™', '(TM)'),
        (r'\s+\n', '\n'),
        (r'\n{3,}', '\n\n'),
        (r'\s+', ' '),
        (r'## Page \d+\n+', '---\n\n'),
        (r'^([A-Z][A-Z\s]+)$', r'## \1'),
        (r'^\s*[•-]\s+', '* '),
    ]
    
    for pattern, repl in replacements:
        content = re.sub(pattern, repl, content, flags=re.MULTILINE)
    
    # Fix code blocks
    code_block_pattern = r'```(.*?)```'
    def fix_code_blocks(match):
        code = match.group(1).strip()
        return f'```php\n{code}\n```\n'
    
    content = re.sub(code_block_pattern, fix_code_blocks, content, flags=re.DOTALL)
    
    # Fix quotes
    content = re.sub(r'"(.*?)"', r'"\1"', content)
    
    # Fix headings
    content = re.sub(r'^([A-Z][A-Z\s]+)$', r'## \1', content, flags=re.MULTILINE)
    
    # Remove excessive line breaks
    content = re.sub(r'\n{3,}', '\n\n', content)
    
    return content

def main():
    if len(sys.argv) < 2:
        print("Usage: python enhance_markdown.py <input_file.md> [output_file.md]")
        sys.exit(1)
    
    input_file = Path(sys.argv[1])
    output_file = sys.argv[2] if len(sys.argv) > 2 else f"{input_file.stem}_enhanced.md"
    
    try:
        with open(input_file, 'r', encoding='utf-8') as f:
            content = f.read()
        
        enhanced_content = enhance_markdown(content)
        
        with open(output_file, 'w', encoding='utf-8') as f:
            f.write(enhanced_content)
            
        print(f"Successfully enhanced Markdown. Output saved to {output_file}")
        
    except Exception as e:
        print(f"Error: {str(e)}")
        sys.exit(1)

if __name__ == "__main__":
    main()
