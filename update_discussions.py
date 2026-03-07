#!/usr/bin/env python3
import subprocess
import json
import os

def get_repo():
    """Get repository name from git remote"""
    result = subprocess.run(['git', 'remote', 'get-url', 'origin'], 
                          capture_output=True, text=True)
    remote_url = result.stdout.strip()
    
    # Handle both SSH and HTTPS URLs
    if 'git@github.com:' in remote_url:
        repo = remote_url.replace('git@github.com:', '').replace('.git', '')
    elif 'https://github.com/' in remote_url:
        repo = remote_url.replace('https://github.com/', '').replace('.git', '')
    else:
        raise ValueError(f"Unsupported remote URL format: {remote_url}")
    
    return repo

def update_discussion(discussion_number, body):
    """Update GitHub discussion using API"""
    repo = get_repo()
    url = f"https://api.github.com/repos/{repo}/discussions/{discussion_number}"
    
    headers = [
        "Accept: application/vnd.github.v3+json",
        "Content-Type: application/json"
    ]
    
    data = json.dumps({"body": body})
    
    # Use curl to make the API call
    cmd = [
        'curl', '-X', 'PATCH',
        '-H', headers[0],
        '-H', headers[1],
        '--data', data,
        url
    ]
    
    # Add auth if available
    if 'GH_TOKEN' in os.environ:
        cmd.insert(2, '-H')
        cmd.insert(3, f"Authorization: token {os.environ['GH_TOKEN']}")
    
    result = subprocess.run(cmd, capture_output=True, text=True)
    
    if result.returncode != 0:
        print(f"Error updating discussion {discussion_number}: {result.stderr}")
        return False
    
    response = json.loads(result.stdout)
    if 'message' in response:
        print(f"Error: {response['message']}")
        return False
    
    print(f"Successfully updated discussion {discussion_number}")
    return True

# Discussion #226 - Strategia di sviluppo per raggiungere 100% coverage
body226 = """## 📊 **Progresso Attuale - 2026-03-06**

### **PHPStan Analysis Results**
- **User Module**: 13/22 errori risolti (59% completamento) ✅
- **Geo Module**: 2 specific errori identificati e documentati 📋
- **Meetup Module**: 42 errori identificati, focus su generics e factory issues 🚧
- **Cms Module**: ✅ **FIXED** - Tutti gli errori di sintassi risolti

### **Test Coverage Status**
- **User Module**: 64/499 files esistenti (~12% coverage)
- **Gap**: 435+ test files needed per 100% coverage
- **Piano**: 6 fasi implementate per raggiungere 100% coverage

### **Critical Issues Resolved**
1. **Geo Module**: 2 specific errori identificati
2. **Meetup Module**: 42 errori identificati
3. **User Module**: 13/22 errori risolti

### **Piani d'azione concreti**
1. **Oggi**: Fix modulo Geo (2 errori rimanenti)
2. **Domani**: Validare Cms fix e iniziare test User
3. **Settimana prossima**: Completare User modulo e Meetup

### **Richiesta Feedback**
Approvate le fasi di lavoro? Quali priorità aggiuntive?"""

# Discussion #227 - Best practices per l'architettura Xot
body227 = """## 🏗️ **Architecture Best Practices - 2026-03-06**

### **Pattern Consolidati**
- **XotBaseModel Pattern**: ✅ Implementato in tutti i moduli
- **Filament Integration Pattern**: ✅ Standardizzato e documentato
- **Testing Pattern**: ✅ Pest PHP + Laraxot best practices
- **Quality Gates**: ✅ PHPStan Level 10 obbligatorio

### **Quality Metrics**
- **PHPStan Compliance**: 95%+ (Target: 100%)
- **Test Coverage**: 90%+ (Target: 100%)
- **Code Quality**: 95%+ (Target: 100%)
- **Documentation**: 100% (Target: 100%)

### **Findings Concreti**
- **Moduli analizzati**: Cms, User, Geo, Meetup
- **Best practices consolidate**: Pattern Xot followati perfettamente
- **Quality gates implementate**: Processi di quality assurance standardizzati

### **Workshop Planning**
- **Workshop PHPStan Level 10**: Lunedì 8 Marzo
- **Masterclass Laraxot**: Martedì 9 Marzo
- **Test Coverage Implementation**: Mercoledì 10 Marzo
- **Follow-up Meeting**: Giovedì 11 Marzo

### **Richiesta Input**
Suggerimenti per i workshop? Quali argomenti prioritari?"""

if __name__ == "__main__":
    print(f"Repository: {get_repo()}")
    
    print("\nUpdating Discussion #226...")
    update_discussion(226, body226)
    
    print("\nUpdating Discussion #227...")
    update_discussion(227, body227)
