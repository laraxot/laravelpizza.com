#!/bin/bash

###############################################################################
# FixCity Performance Benchmark Script
# 
# Esegue test di performance per validare gli obiettivi di risposta
###############################################################################

set -e

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Configuration
API_URL="${API_URL:-http://localhost/api/fixcity}"
ITERATIONS=100
TARGET_RESPONSE_TIME=200 # ms

echo "🚀 FixCity Performance Benchmark"
echo "================================"
echo ""

# Function to make request and measure time
benchmark_endpoint() {
    local endpoint=$1
    local name=$2
    
    echo -n "Testing $name... "
    
    local total_time=0
    local success_count=0
    
    for i in $(seq 1 $ITERATIONS); do
        response_time=$(curl -s -o /dev/null -w "%{time_total}" "$API_URL$endpoint" 2>/dev/null || echo "0")
        response_time_ms=$(echo "$response_time * 1000" | bc)
        
        if [ $(echo "$response_time_ms > 0" | bc) -eq 1 ]; then
            total_time=$(echo "$total_time + $response_time_ms" | bc)
            ((success_count++))
        fi
    done
    
    if [ $success_count -gt 0 ]; then
        avg_time=$(echo "scale=2; $total_time / $success_count" | bc)
        
        if [ $(echo "$avg_time < $TARGET_RESPONSE_TIME" | bc) -eq 1 ]; then
            echo -e "${GREEN}✓${NC} ${avg_time}ms (target: <${TARGET_RESPONSE_TIME}ms)"
        else
            echo -e "${RED}✗${NC} ${avg_time}ms (target: <${TARGET_RESPONSE_TIME}ms)"
        fi
    else
        echo -e "${RED}✗ FAILED${NC}"
    fi
}

# Health Check
echo "📊 API Health Checks"
echo "-------------------"
benchmark_endpoint "/health" "Health Check"
echo ""

# Tickets Endpoints
echo "🎫 Tickets Endpoints"
echo "-------------------"
benchmark_endpoint "/tickets" "List Tickets"
benchmark_endpoint "/tickets/1" "Get Ticket"
echo ""

# Cache Performance
echo "💾 Cache Performance"
echo "-------------------"
echo "Testing cache hit ratio..."

# First request (cache miss)
time1=$(curl -s -o /dev/null -w "%{time_total}" "$API_URL/tickets" 2>/dev/null)
time1_ms=$(echo "$time1 * 1000" | bc)

# Second request (cache hit)
time2=$(curl -s -o /dev/null -w "%{time_total}" "$API_URL/tickets" 2>/dev/null)
time2_ms=$(echo "$time2 * 1000" | bc)

improvement=$(echo "scale=2; (($time1_ms - $time2_ms) / $time1_ms) * 100" | bc)

echo "Cache miss: ${time1_ms}ms"
echo "Cache hit: ${time2_ms}ms"
echo "Improvement: ${improvement}%"
echo ""

# Database Performance
echo "🗄️ Database Performance"
echo "----------------------"
echo "Running database query benchmark..."

php artisan tinker --execute="
\$start = microtime(true);
Modules\\Fixcity\\Models\\Ticket::with(['user', 'profile'])->limit(100)->get();
\$time = round((microtime(true) - \$start) * 1000, 2);
echo \"Query with relationships: {\$time}ms\\n\";
"

echo ""

# Summary
echo "✅ Benchmark Complete"
echo "===================="
echo ""
echo "Target Response Time: <${TARGET_RESPONSE_TIME}ms"
echo "Iterations per test: ${ITERATIONS}"
echo ""
echo "💡 Tips for optimization:"
echo "  - Enable OPcache in production"
echo "  - Configure Redis for cache"
echo "  - Optimize database indexes"
echo "  - Use CDN for static assets"
echo ""
