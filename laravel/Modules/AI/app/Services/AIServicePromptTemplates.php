<?php

declare(strict_types=1);

namespace Modules\AI\Services;

class AIServicePromptTemplates
{
    public const ROUTING_JSON = <<<'JSON'
{
  "assignments": [
    {
      "ticket_id": 123,
      "agent_id": 456,
      "reason": "motivazione assegnazione",
      "estimated_completion": "2024-01-15",
      "confidence": 0.85
    }
  ],
  "unassigned_tickets": [789],
  "overload_warnings": ["agent1 ha troppi ticket"],
  "efficiency_score": 0.92
}
JSON;

    public const PATTERN_JSON = <<<'JSON'
{
  "temporal_trends": {
    "peak_hours": ["9-11", "14-16"],
    "peak_days": ["lunedì", "martedì"],
    "seasonal_patterns": {"estate": "+20%"}
  },
  "geographic_hotspots": [
    {"area": "centro", "count": 45, "trend": "increasing"}
  ],
  "category_insights": {
    "most_common": "infrastruttura",
    "growing": "ambiente",
    "declining": "trasporti"
  },
  "recommendations": [
    "Aumentare personale nelle ore di picco",
    "Focus su area centro"
  ]
}
JSON;

    public const IMPROVEMENTS_JSON = <<<'JSON'

Fornisci suggerimenti per:
- Processi operativi
- Tecnologie
- Formazione personale
- Comunicazione cittadini
- Metriche di performance

Rispondi in formato JSON:
{
  "process_improvements": [
    {
      "area": "assegnazione ticket",
      "suggestion": "Implementare sistema di priorità dinamica",
      "impact": "high",
      "effort": "medium"
    }
  ],
  "technology_upgrades": [
    {
      "technology": "AI routing",
      "description": "Sistema di assegnazione automatica",
      "benefits": ["efficienza", "soddisfazione"],
      "cost_estimate": "€50k"
    }
  ],
  "training_recommendations": [
    {
      "role": "operatori",
      "topics": ["comunicazione", "tecniche risoluzione"],
      "format": "workshop",
      "duration": "2 giorni"
    }
  ]
}
JSON;
}
