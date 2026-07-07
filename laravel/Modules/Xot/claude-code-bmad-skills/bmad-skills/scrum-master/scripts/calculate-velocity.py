#!/usr/bin/env python3
"""
Velocity Calculator for Scrum Master Skill

Calculates sprint velocity metrics from sprint status YAML file.
Outputs:
- Current sprint velocity
- 3-sprint rolling average
- Velocity trend (increasing/decreasing/stable)
- Recommended capacity for next sprint

Usage:
    python calculate-velocity.py <sprint-status-file>
    python calculate-velocity.py .bmad/sprint-status.yaml
"""

import sys
import yaml
from pathlib import Path
from typing import Dict, List, Tuple


def load_sprint_status(file_path: str) -> Dict:
    """Load sprint status from YAML file."""
    try:
        with open(file_path, 'r') as f:
            return yaml.safe_load(f)
    except FileNotFoundError:
        print(f"Error: File not found: {file_path}")
        sys.exit(1)
    except yaml.YAMLError as e:
        print(f"Error: Invalid YAML format: {e}")
        sys.exit(1)


def calculate_current_sprint_velocity(sprint_data: Dict) -> int:
    """Calculate velocity for current sprint."""
    if not sprint_data or 'metrics' not in sprint_data:
        return 0
    return sprint_data['metrics'].get('completed_points', 0)


def calculate_three_sprint_average(velocity_history: List[Dict]) -> float:
    """Calculate 3-sprint rolling average velocity."""
    if not velocity_history:
        return 0.0

    # Get last 3 sprints
    recent_sprints = velocity_history[-3:]
    if not recent_sprints:
        return 0.0

    # Calculate average of completed points
    total = sum(sprint.get('completed', 0) for sprint in recent_sprints)
    average = total / len(recent_sprints)
    return round(average, 1)


def calculate_velocity_trend(velocity_history: List[Dict]) -> str:
    """
    Determine velocity trend from last 3 sprints.
    Returns: 'increasing', 'decreasing', or 'stable'
    """
    if len(velocity_history) < 3:
        return 'insufficient_data'

    recent = velocity_history[-3:]
    velocities = [s.get('completed', 0) for s in recent]

    # Calculate differences
    diff1 = velocities[1] - velocities[0]
    diff2 = velocities[2] - velocities[1]

    # Define threshold for stability (within 10%)
    avg = sum(velocities) / len(velocities)
    threshold = avg * 0.1

    if diff1 > threshold and diff2 > threshold:
        return 'increasing'
    elif diff1 < -threshold and diff2 < -threshold:
        return 'decreasing'
    elif abs(diff1) <= threshold and abs(diff2) <= threshold:
        return 'stable'
    else:
        return 'variable'


def get_completion_rates(velocity_history: List[Dict]) -> List[float]:
    """Calculate completion rates for each sprint."""
    rates = []
    for sprint in velocity_history:
        planned = sprint.get('planned', 0)
        completed = sprint.get('completed', 0)
        if planned > 0:
            rate = (completed / planned) * 100
            rates.append(round(rate, 1))
        else:
            rates.append(0.0)
    return rates


def recommend_next_sprint_capacity(
    velocity_history: List[Dict],
    three_sprint_avg: float,
    trend: str
) -> int:
    """
    Recommend capacity for next sprint based on velocity data.
    """
    if len(velocity_history) < 1:
        return 40  # Default conservative capacity

    if len(velocity_history) < 3:
        # Use last sprint velocity
        return velocity_history[-1].get('completed', 40)

    # Use 3-sprint average as base
    base_capacity = three_sprint_avg

    # Adjust based on trend
    if trend == 'increasing':
        # Team is improving, slightly increase capacity
        recommended = base_capacity * 1.05
    elif trend == 'decreasing':
        # Team is slowing, reduce capacity
        recommended = base_capacity * 0.95
    else:
        # Stable or variable, use average as-is
        recommended = base_capacity

    return round(recommended)


def format_velocity_report(data: Dict) -> str:
    """Format velocity metrics as readable report."""
    project = data.get('project', 'Unknown Project')
    current_sprint = data.get('current_sprint', 0)
    velocity_history = data.get('velocity_history', [])
    sprints_data = data.get('sprints', [])

    # Find current sprint data
    current_sprint_data = None
    for sprint in sprints_data:
        if sprint.get('number') == current_sprint:
            current_sprint_data = sprint
            break

    # Calculate metrics
    current_velocity = calculate_current_sprint_velocity(current_sprint_data) if current_sprint_data else 0
    three_sprint_avg = calculate_three_sprint_average(velocity_history)
    trend = calculate_velocity_trend(velocity_history)
    completion_rates = get_completion_rates(velocity_history)
    recommended_capacity = recommend_next_sprint_capacity(velocity_history, three_sprint_avg, trend)

    # Build report
    report = []
    report.append("=" * 60)
    report.append(f"VELOCITY REPORT: {project}")
    report.append("=" * 60)
    report.append("")

    # Current sprint info
    report.append(f"Current Sprint: {current_sprint}")
    if current_sprint_data:
        report.append(f"Sprint Goal: {current_sprint_data.get('sprint_goal', 'N/A')}")
        report.append(f"Capacity: {current_sprint_data.get('capacity', 0)} points")
        report.append(f"Completed: {current_velocity} points")
        if current_sprint_data.get('capacity', 0) > 0:
            pct = (current_velocity / current_sprint_data['capacity']) * 100
            report.append(f"Completion Rate: {pct:.1f}%")
    report.append("")

    # Velocity history
    report.append("VELOCITY HISTORY:")
    report.append("-" * 60)
    if velocity_history:
        report.append(f"{'Sprint':<10} {'Planned':<10} {'Completed':<12} {'Rate':<10}")
        report.append("-" * 60)
        for i, sprint in enumerate(velocity_history):
            sprint_num = sprint.get('sprint', i + 1)
            planned = sprint.get('planned', 0)
            completed = sprint.get('completed', 0)
            rate = completion_rates[i] if i < len(completion_rates) else 0.0
            report.append(f"{sprint_num:<10} {planned:<10} {completed:<12} {rate:<10.1f}%")
    else:
        report.append("No velocity history available.")
    report.append("")

    # Velocity metrics
    report.append("VELOCITY METRICS:")
    report.append("-" * 60)
    if len(velocity_history) >= 3:
        report.append(f"3-Sprint Rolling Average: {three_sprint_avg} points")
        report.append(f"Velocity Trend: {trend.upper().replace('_', ' ')}")
    elif len(velocity_history) >= 1:
        report.append(f"Single Sprint Velocity: {velocity_history[-1].get('completed', 0)} points")
        report.append(f"(Need 3 sprints for rolling average)")
    else:
        report.append("Insufficient data for velocity metrics.")
    report.append("")

    # Recommendation
    report.append("RECOMMENDATION:")
    report.append("-" * 60)
    report.append(f"Next Sprint Capacity: {recommended_capacity} points")

    if len(velocity_history) >= 3:
        if trend == 'increasing':
            report.append("Team velocity is increasing. Consider slight capacity increase.")
        elif trend == 'decreasing':
            report.append("Team velocity is decreasing. Investigate blockers/issues.")
        elif trend == 'stable':
            report.append("Team velocity is stable. Good predictability.")
        else:
            report.append("Team velocity is variable. Monitor for patterns.")
    elif len(velocity_history) >= 1:
        report.append("Using last sprint velocity as baseline.")
        report.append("Continue tracking for more accurate predictions.")
    else:
        report.append("No historical data. Using conservative default capacity.")

    report.append("")
    report.append("=" * 60)

    return "\n".join(report)


def main():
    """Main execution function."""
    if len(sys.argv) != 2:
        print("Usage: python calculate-velocity.py <sprint-status-file>")
        print("Example: python calculate-velocity.py .bmad/sprint-status.yaml")
        sys.exit(1)

    file_path = sys.argv[1]

    # Validate file exists
    if not Path(file_path).exists():
        print(f"Error: File not found: {file_path}")
        sys.exit(1)

    # Load sprint status data
    data = load_sprint_status(file_path)

    # Generate and print report
    report = format_velocity_report(data)
    print(report)


if __name__ == '__main__':
    main()
