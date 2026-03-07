#!/bin/bash
# scripts/coverage-monitor.sh

echo "🚀 Monitoraggio Coverage Globale - $(date)"

# Esegui tutti i moduli in parallelo
echo "🔄 Analisi in parallelo..."
./scripts/coverage-user.sh &
./scripts/coverage-geo.sh &
./scripts/coverage-meetup.sh &
./scripts/coverage-activity.sh &
./scripts/coverage-cms.sh &

# Attendi completamento
wait

# Verifica stato finale
echo "📊 Stato Finale:"
gh issue view 241 | grep -A 5 "Progresso Attuale"
gh issue view 242 | grep -A 5 "Progresso Attuale"
gh issue view 243 | grep -A 5 "Progresso Attuale"
gh issue view 244 | grep -A 5 "Progresso Attuale"
gh issue view 247 | grep -A 5 "Progresso Attuale"

# Report completo
echo "📋 Report Completo:"
echo "1. User modulo: $(gh issue view 241 | grep 'Coverage Attuale')"
echo "2. Geo modulo: $(gh issue view 242 | grep 'Coverage Attuale')"
echo "3. Meetup modulo: $(gh issue view 243 | grep 'Coverage Attuale')"
echo "4. Activity modulo: $(gh issue view 244 | grep 'Coverage Attuale')"
echo "5. Cms modulo: $(gh issue view 247 | grep 'Coverage Attuale')"