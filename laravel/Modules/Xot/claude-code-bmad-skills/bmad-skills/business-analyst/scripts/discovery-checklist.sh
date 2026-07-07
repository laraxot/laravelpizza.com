#!/bin/bash

# discovery-checklist.sh
# Interactive discovery checklist for product brief creation
# Outputs structured questions for business analysts to guide stakeholder interviews

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print section headers
print_section() {
    echo ""
    echo -e "${BLUE}========================================${NC}"
    echo -e "${BLUE}$1${NC}"
    echo -e "${BLUE}========================================${NC}"
    echo ""
}

# Function to print questions
print_question() {
    echo -e "${GREEN}$1${NC}"
}

# Function to print sub-questions
print_subquestion() {
    echo -e "${YELLOW}  - $1${NC}"
}

# Function to print notes
print_note() {
    echo -e "${NC}    → $1${NC}"
}

# Main script
clear
echo ""
echo -e "${BLUE}╔═══════════════════════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║                                                           ║${NC}"
echo -e "${BLUE}║         PRODUCT DISCOVERY CHECKLIST                       ║${NC}"
echo -e "${BLUE}║         Business Analyst Interview Guide                  ║${NC}"
echo -e "${BLUE}║                                                           ║${NC}"
echo -e "${BLUE}╚═══════════════════════════════════════════════════════════╝${NC}"
echo ""
echo "This checklist guides you through comprehensive product discovery."
echo "Use it during stakeholder interviews to ensure complete coverage."
echo ""
read -p "Press Enter to begin..."

# Section 1: Problem Discovery
print_section "SECTION 1: PROBLEM DISCOVERY"

print_question "Q1: What problem are you trying to solve?"
print_note "Look for: Specific pain point, not a feature request"
print_note "Probe: Ask 'Why?' 5 times to find root cause"
echo ""

print_question "Q2: Who experiences this problem?"
print_subquestion "What are the primary user segments?"
print_subquestion "What are the secondary user segments?"
print_subquestion "What roles or personas are affected?"
print_note "Look for: Specific roles, not generic 'users'"
echo ""

print_question "Q3: How do users currently handle this problem?"
print_subquestion "What workarounds exist?"
print_subquestion "What tools or processes do they use now?"
print_subquestion "What are the limitations of current solutions?"
print_note "Look for: Existing behaviors and pain points"
echo ""

print_question "Q4: What's the impact if this problem remains unsolved?"
print_subquestion "What does it cost in time?"
print_subquestion "What does it cost in money?"
print_subquestion "What does it cost in frustration or opportunity?"
print_note "Look for: Quantifiable impact metrics"
echo ""

print_question "Q5: Why solve this problem now?"
print_subquestion "What's changed recently?"
print_subquestion "Why hasn't it been solved before?"
print_subquestion "What's the urgency?"
print_note "Look for: Business case for timing"
echo ""

print_question "Q6: How often does this problem occur?"
print_subquestion "Daily? Weekly? Monthly?"
print_subquestion "For what percentage of users?"
print_subquestion "Under what conditions?"
print_note "Look for: Frequency data to prioritize"
echo ""

read -p "Press Enter to continue to Section 2..."

# Section 2: User Understanding
print_section "SECTION 2: USER UNDERSTANDING"

print_question "Q7: Who are the target users?"
print_subquestion "What are their roles and responsibilities?"
print_subquestion "What are their goals?"
print_subquestion "What are their pain points?"
print_subquestion "What's their technical proficiency?"
print_subquestion "What's their typical usage pattern?"
print_note "Look for: Detailed persona information"
echo ""

print_question "Q8: What are the must-have user needs?"
print_subquestion "What do users absolutely require?"
print_subquestion "What would they pay for?"
print_subquestion "What would make them switch solutions?"
print_note "Look for: Core value proposition"
echo ""

print_question "Q9: What are the should-have user needs?"
print_subquestion "What would significantly improve experience?"
print_subquestion "What competitive features matter?"
print_note "Look for: Differentiation opportunities"
echo ""

print_question "Q10: What are the nice-to-have user needs?"
print_subquestion "What would delight users but isn't essential?"
print_note "Look for: Future roadmap ideas"
echo ""

read -p "Press Enter to continue to Section 3..."

# Section 3: Solution Exploration
print_section "SECTION 3: SOLUTION EXPLORATION"

print_question "Q11: What's the proposed solution?"
print_subquestion "What are the key capabilities?"
print_subquestion "What's the core value proposition?"
print_subquestion "How does it solve the problem?"
print_note "Look for: Clear solution description"
echo ""

print_question "Q12: What makes this solution different?"
print_subquestion "What's unique about this approach?"
print_subquestion "How is it better than alternatives?"
print_subquestion "What's the competitive advantage?"
print_note "Look for: Unique value proposition"
echo ""

print_question "Q13: What's the minimum viable solution?"
print_subquestion "What's the core functionality needed for MVP?"
print_subquestion "What can be deferred to later phases?"
print_subquestion "What's the simplest thing that would work?"
print_note "Look for: Scope boundaries for Phase 1"
echo ""

print_question "Q14: What alternatives did you consider?"
print_subquestion "What other approaches were evaluated?"
print_subquestion "Why was this approach chosen?"
print_subquestion "What trade-offs were made?"
print_note "Look for: Decision rationale"
echo ""

read -p "Press Enter to continue to Section 4..."

# Section 4: Success Definition
print_section "SECTION 4: SUCCESS DEFINITION"

print_question "Q15: How will you measure success?"
print_subquestion "What are the key performance metrics?"
print_subquestion "What's the baseline (current state)?"
print_subquestion "What's the target (desired state)?"
print_subquestion "What's the timeline?"
print_note "Look for: SMART goals (Specific, Measurable, Achievable, Relevant, Time-bound)"
echo ""

print_question "Q16: What does success look like?"
print_subquestion "In 3 months?"
print_subquestion "In 6 months?"
print_subquestion "In 12 months?"
print_note "Look for: Vision and milestones"
echo ""

print_question "Q17: What are the success criteria?"
print_subquestion "What must be achieved? (Must-have)"
print_subquestion "What should be achieved? (Should-have)"
print_subquestion "What would be nice to achieve? (Could-have)"
print_note "Look for: MoSCoW prioritization"
echo ""

read -p "Press Enter to continue to Section 5..."

# Section 5: Market & Competition
print_section "SECTION 5: MARKET & COMPETITION"

print_question "Q18: What's the market context?"
print_subquestion "What's the market size?"
print_subquestion "What are the key market trends?"
print_subquestion "What's the target market segment?"
print_note "Look for: Market opportunity validation"
echo ""

print_question "Q19: Who are the main competitors?"
print_subquestion "What are their strengths?"
print_subquestion "What are their weaknesses?"
print_subquestion "What's their pricing?"
print_subquestion "What's their market position?"
print_note "Look for: At least 3-5 competitors analyzed"
echo ""

print_question "Q20: What are your competitive advantages?"
print_subquestion "What do you do better than competitors?"
print_subquestion "What gaps exist in the market?"
print_subquestion "What gaps do you need to close?"
print_note "Look for: Differentiation strategy"
echo ""

read -p "Press Enter to continue to Section 6..."

# Section 6: Business Model
print_section "SECTION 6: BUSINESS MODEL"

print_question "Q21: What's the revenue model?"
print_subquestion "How will this generate revenue?"
print_subquestion "What's the pricing strategy?"
print_subquestion "What are the price points?"
print_note "Look for: Business viability"
echo ""

print_question "Q22: What are the acquisition channels?"
print_subquestion "How will you reach customers?"
print_subquestion "What's the customer acquisition cost (CAC)?"
print_subquestion "What's the lifetime value (LTV)?"
print_note "Look for: Go-to-market strategy"
echo ""

read -p "Press Enter to continue to Section 7..."

# Section 7: Technical Considerations
print_section "SECTION 7: TECHNICAL CONSIDERATIONS"

print_question "Q23: What are the technical requirements?"
print_subquestion "What platform(s) are needed?"
print_subquestion "What integrations are required?"
print_subquestion "What are the technical constraints?"
print_note "Look for: Technical feasibility"
echo ""

print_question "Q24: What are the scale requirements?"
print_subquestion "How many users?"
print_subquestion "What transaction volume?"
print_subquestion "What data volume?"
print_subquestion "What performance requirements exist?"
print_note "Look for: Non-functional requirements"
echo ""

print_question "Q25: What are the security & compliance requirements?"
print_subquestion "What security measures are needed?"
print_subquestion "What compliance regulations apply?"
print_subquestion "What data privacy requirements exist?"
print_note "Look for: Regulatory and security constraints"
echo ""

read -p "Press Enter to continue to Section 8..."

# Section 8: Risks & Dependencies
print_section "SECTION 8: RISKS & DEPENDENCIES"

print_question "Q26: What are the high-priority risks?"
print_subquestion "What could go wrong?"
print_subquestion "What's the probability and impact?"
print_subquestion "What's the mitigation strategy?"
print_subquestion "Who owns each risk?"
print_note "Look for: At least top 3-5 risks documented"
echo ""

print_question "Q27: What assumptions are you making?"
print_subquestion "What do you assume about users?"
print_subquestion "What do you assume about technology?"
print_subquestion "What do you assume about the market?"
print_subquestion "How will you validate these assumptions?"
print_note "Look for: Critical assumptions that need validation"
echo ""

print_question "Q28: What are the dependencies?"
print_subquestion "What internal dependencies exist?"
print_subquestion "What external dependencies exist?"
print_subquestion "What are the current blockers?"
print_subquestion "What's the resolution plan?"
print_note "Look for: Dependencies that could delay delivery"
echo ""

read -p "Press Enter to continue to Section 9..."

# Section 9: Resources & Timeline
print_section "SECTION 9: RESOURCES & TIMELINE"

print_question "Q29: What team resources are needed?"
print_subquestion "What roles are required?"
print_subquestion "What's the allocation for each role?"
print_subquestion "What skills are needed?"
print_note "Look for: Realistic resource plan"
echo ""

print_question "Q30: What's the timeline estimate?"
print_subquestion "How long for discovery & planning?"
print_subquestion "How long for design?"
print_subquestion "How long for development?"
print_subquestion "How long for testing?"
print_subquestion "When is the target launch?"
print_note "Look for: High-level timeline with phases"
echo ""

print_question "Q31: What's the budget estimate?"
print_subquestion "What are the development costs?"
print_subquestion "What are the infrastructure costs?"
print_subquestion "What are other costs?"
print_note "Look for: Rough order of magnitude (ROM) estimate"
echo ""

read -p "Press Enter to continue to Section 10..."

# Section 10: Next Steps
print_section "SECTION 10: NEXT STEPS"

print_question "Q32: What are the immediate next steps?"
print_subquestion "What needs to happen first?"
print_subquestion "Who's responsible for each action?"
print_subquestion "What are the deadlines?"
print_note "Look for: Clear action items"
echo ""

print_question "Q33: What's required before moving forward?"
print_subquestion "What approvals are needed?"
print_subquestion "What research needs to be completed?"
print_subquestion "What decisions need to be made?"
print_note "Look for: Prerequisites and blockers"
echo ""

print_question "Q34: Who should this be handed off to?"
print_subquestion "Product Manager for PRD creation?"
print_subquestion "UX Designer for design work?"
print_subquestion "Tech Lead for technical planning?"
print_note "Look for: Clear handoff plan"
echo ""

# Completion
print_section "DISCOVERY CHECKLIST COMPLETE"

echo -e "${GREEN}You've completed the discovery checklist!${NC}"
echo ""
echo "Next steps:"
echo "  1. Review your notes and fill in any gaps"
echo "  2. Organize findings into a product brief"
echo "  3. Validate assumptions with stakeholders"
echo "  4. Use validate-brief.sh to check completeness"
echo "  5. Hand off to Product Manager for PRD creation"
echo ""
echo -e "${YELLOW}Templates available:${NC}"
echo "  - templates/product-brief.template.md"
echo "  - templates/research-report.template.md"
echo ""
echo -e "${YELLOW}Reference materials:${NC}"
echo "  - REFERENCE.md - Interview frameworks and techniques"
echo "  - resources/interview-frameworks.md - Detailed frameworks"
echo ""
echo -e "${GREEN}Happy discovering!${NC}"
echo ""
