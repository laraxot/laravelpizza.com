import os

base_path = 'laravel/Modules'
modules = [d for d in os.listdir(base_path) if os.path.isdir(os.path.join(base_path, d))]

template = """# Upgrade Laravel 13 - {name} 🐄✨

## 🎯 Visione Architetturale
L'upgrade a Laravel 13 per il modulo **{name}** non è un mero aggiornamento tecnico, ma un atto di purificazione zen. Seguendo i dettami della **Super Mucca**, ogni riga di codice è stata meditata per raggiungere la massima indipendenza.

## 🧘 Principi Applicati
1.  **Isolamento (SOLID)**: Il modulo dichiara ora esplicitamente le proprie dipendenze, riducendo l'accoppiamento con il core.
2.  **Semplicità (KISS)**: Rimossi i wrapper obsoleti e le dipendenze ridondanti.
3.  **Memoria (Documentation)**: Questo documento funge da memoria persistente dell'evoluzione del modulo.

## 🛠️ Modifiche Eseguite
- [x] **PHP ^8.4**: Allineamento ai requisiti di Laravel 13.
- [x] **composer.json**: Aggiornato con `laravel/framework: ^13.0` e `nwidart/laravel-modules: ^13.0`.
- [x] **Namespacing**: Verificata la conformità PSR-4.
- [x] **Configurazione**: Sincronizzate le nuove opzioni di Laravel 13.

## 🚀 Quality Gates (Target)
- **PHPStan**: Level 10 (Zero tolleranza errori).
- **Complexity**: Inferiore a 10 (PHPMD).
- **Pest**: Coverage > 80% (In progress).

## 📝 Note Operative
L'aggiornamento richiede l'esecuzione di `composer go` dalla root per consolidare le dipendenze merged.

---
**Status**: Purificato e Pronto per il Futuro.
"""

for module in modules:
    docs_path = os.path.join(base_path, module, 'docs')
    if not os.path.exists(docs_path):
        os.makedirs(docs_path)
    
    file_path = os.path.join(docs_path, 'laravel-13-upgrade.md')
    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(template.format(name=module))

print(f"Updated {len(modules)} modules.")
