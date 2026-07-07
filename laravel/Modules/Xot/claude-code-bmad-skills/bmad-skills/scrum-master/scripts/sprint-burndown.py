#!/usr/bin/env python3
"""
Sprint Burndown Chart Data Generator

Generates burndown chart data from sprint status YAML file.
Outputs data suitable for visualization or analysis.

Usage:
    python sprint-burndown.py <sprint-status-file> [sprint-number]
    python sprint-burndown.py .bmad/sprint-status.yaml
    python sprint-burndown.py .bmad/sprint-status.yaml 2

Output formats:
    - Text table (default)
    - CSV (with --csv flag)
    - JSON (with --json flag)
"""

import sys
import yaml
import json
from pathlib import Path
from typing import Dict, List, Optional
from datetime import datetime, timedelta


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


def get_sprint_data(data: Dict, sprint_number: Optional[int] = None) -> Optional[Dict]:
    """Get data for specified sprint or current sprint."""
    sprints = data.get('sprints', [])
    if not sprints:
        return None

    if sprint_number is None:
        sprint_number = data.get('current_sprint', 0)

    for sprint in sprints:
        if sprint.get('number') == sprint_number:
            return sprint

    return None


def calculate_ideal_burndown(total_points: int, sprint_days: int) -> List[float]:
    """
    Calculate ideal burndown line (linear decrease from total to 0).

    Args:
        total_points: Total story points in sprint
        sprint_days: Number of days in sprint

    Returns:
        List of ideal remaining points for each day
    """
    if sprint_days <= 0:
        return [total_points]

    ideal_line = []
    points_per_day = total_points / sprint_days

    for day in range(sprint_days + 1):
        remaining = total_points - (points_per_day * day)
        ideal_line.append(round(remaining, 1))

    return ideal_line


def parse_date(date_str: str) -> Optional[datetime]:
    """Parse date string to datetime object."""
    if not date_str:
        return None

    try:
        return datetime.strptime(date_str, "%Y-%m-%d")
    except ValueError:
        try:
            return datetime.strptime(date_str, "%Y-%m-%d %H:%M:%S")
        except ValueError:
            return None


def generate_burndown_data(sprint_data: Dict) -> Dict:
    """
    Generate burndown chart data from sprint information.

    Returns dict with:
        - dates: List of dates
        - actual: List of actual remaining points
        - ideal: List of ideal remaining points
        - completed: List of completed points
    """
    if not sprint_data:
        return {}

    # Get sprint dates
    start_date_str = sprint_data.get('start_date')
    end_date_str = sprint_data.get('end_date')

    if not start_date_str or not end_date_str:
        return {}

    start_date = parse_date(start_date_str)
    end_date = parse_date(end_date_str)

    if not start_date or not end_date:
        return {}

    # Calculate sprint duration
    sprint_duration = (end_date - start_date).days

    # Get total points
    total_points = sprint_data.get('capacity', 0)
    if total_points == 0:
        metrics = sprint_data.get('metrics', {})
        total_points = metrics.get('total_points', 0)

    # Calculate ideal burndown
    ideal_line = calculate_ideal_burndown(total_points, sprint_duration)

    # Get actual burndown data
    burndown_entries = sprint_data.get('burndown', [])

    # Build complete dataset
    dates = []
    actual = []
    completed = []
    ideal = []

    # Start with day 0
    current_date = start_date
    day_index = 0

    while current_date <= end_date:
        dates.append(current_date.strftime("%Y-%m-%d"))

        # Find actual data for this date
        actual_entry = None
        for entry in burndown_entries:
            entry_date = parse_date(entry.get('date', ''))
            if entry_date and entry_date.date() == current_date.date():
                actual_entry = entry
                break

        if actual_entry:
            actual.append(actual_entry.get('remaining_points', 0))
            completed.append(actual_entry.get('completed_points', 0))
        else:
            # No data for this day, use last known value or None
            if actual:
                actual.append(actual[-1])  # Carry forward last value
                completed.append(completed[-1])
            else:
                actual.append(total_points)  # Sprint not started
                completed.append(0)

        # Add ideal line value
        if day_index < len(ideal_line):
            ideal.append(ideal_line[day_index])
        else:
            ideal.append(0)

        current_date += timedelta(days=1)
        day_index += 1

    return {
        'dates': dates,
        'actual': actual,
        'ideal': ideal,
        'completed': completed,
        'total_points': total_points,
        'sprint_duration': sprint_duration
    }


def format_as_table(burndown_data: Dict, sprint_data: Dict) -> str:
    """Format burndown data as ASCII table."""
    if not burndown_data:
        return "No burndown data available."

    sprint_num = sprint_data.get('number', '?')
    sprint_goal = sprint_data.get('sprint_goal', 'N/A')
    total_points = burndown_data['total_points']

    lines = []
    lines.append("=" * 80)
    lines.append(f"SPRINT {sprint_num} BURNDOWN CHART")
    lines.append("=" * 80)
    lines.append(f"Sprint Goal: {sprint_goal}")
    lines.append(f"Total Points: {total_points}")
    lines.append("")

    # Table header
    lines.append(f"{'Date':<12} {'Day':<6} {'Completed':<12} {'Remaining':<12} {'Ideal':<10} {'Status':<10}")
    lines.append("-" * 80)

    # Table rows
    dates = burndown_data['dates']
    actual = burndown_data['actual']
    ideal = burndown_data['ideal']
    completed = burndown_data['completed']

    for i, date in enumerate(dates):
        day_num = i
        completed_pts = completed[i] if i < len(completed) else 0
        remaining_pts = actual[i] if i < len(actual) else 0
        ideal_pts = ideal[i] if i < len(ideal) else 0

        # Determine status
        if remaining_pts == 0:
            status = "COMPLETE"
        elif remaining_pts < ideal_pts:
            status = "AHEAD"
        elif remaining_pts > ideal_pts:
            status = "BEHIND"
        else:
            status = "ON TRACK"

        lines.append(f"{date:<12} {day_num:<6} {completed_pts:<12.1f} {remaining_pts:<12.1f} {ideal_pts:<10.1f} {status:<10}")

    lines.append("")
    lines.append("=" * 80)

    # Summary
    if actual:
        final_completed = completed[-1] if completed else 0
        final_remaining = actual[-1] if actual else total_points
        completion_pct = (final_completed / total_points * 100) if total_points > 0 else 0

        lines.append(f"Final Status: {final_completed:.1f} / {total_points} points completed ({completion_pct:.1f}%)")

        if final_remaining == 0:
            lines.append("Sprint completed successfully!")
        elif final_remaining > 0:
            lines.append(f"Sprint incomplete: {final_remaining:.1f} points remaining")

    lines.append("=" * 80)

    return "\n".join(lines)


def format_as_csv(burndown_data: Dict, sprint_data: Dict) -> str:
    """Format burndown data as CSV."""
    if not burndown_data:
        return ""

    lines = []
    lines.append("Date,Day,Completed,Remaining,Ideal,Status")

    dates = burndown_data['dates']
    actual = burndown_data['actual']
    ideal = burndown_data['ideal']
    completed = burndown_data['completed']

    for i, date in enumerate(dates):
        day_num = i
        completed_pts = completed[i] if i < len(completed) else 0
        remaining_pts = actual[i] if i < len(actual) else 0
        ideal_pts = ideal[i] if i < len(ideal) else 0

        # Determine status
        if remaining_pts == 0:
            status = "COMPLETE"
        elif remaining_pts < ideal_pts:
            status = "AHEAD"
        elif remaining_pts > ideal_pts:
            status = "BEHIND"
        else:
            status = "ON_TRACK"

        lines.append(f"{date},{day_num},{completed_pts:.1f},{remaining_pts:.1f},{ideal_pts:.1f},{status}")

    return "\n".join(lines)


def format_as_json(burndown_data: Dict, sprint_data: Dict) -> str:
    """Format burndown data as JSON."""
    if not burndown_data:
        return "{}"

    output = {
        'sprint': {
            'number': sprint_data.get('number'),
            'goal': sprint_data.get('sprint_goal'),
            'start_date': sprint_data.get('start_date'),
            'end_date': sprint_data.get('end_date'),
            'capacity': sprint_data.get('capacity'),
            'status': sprint_data.get('status')
        },
        'burndown': {
            'dates': burndown_data['dates'],
            'actual_remaining': burndown_data['actual'],
            'ideal_remaining': burndown_data['ideal'],
            'completed': burndown_data['completed'],
            'total_points': burndown_data['total_points'],
            'sprint_duration': burndown_data['sprint_duration']
        }
    }

    return json.dumps(output, indent=2)


def main():
    """Main execution function."""
    if len(sys.argv) < 2:
        print("Usage: python sprint-burndown.py <sprint-status-file> [sprint-number] [--csv|--json]")
        print("Example: python sprint-burndown.py .bmad/sprint-status.yaml")
        print("Example: python sprint-burndown.py .bmad/sprint-status.yaml 2")
        print("Example: python sprint-burndown.py .bmad/sprint-status.yaml --csv")
        sys.exit(1)

    file_path = sys.argv[1]

    # Parse optional sprint number and format
    sprint_number = None
    output_format = 'table'

    for arg in sys.argv[2:]:
        if arg == '--csv':
            output_format = 'csv'
        elif arg == '--json':
            output_format = 'json'
        elif arg.isdigit():
            sprint_number = int(arg)

    # Validate file exists
    if not Path(file_path).exists():
        print(f"Error: File not found: {file_path}")
        sys.exit(1)

    # Load sprint status data
    data = load_sprint_status(file_path)

    # Get sprint data
    sprint_data = get_sprint_data(data, sprint_number)
    if not sprint_data:
        if sprint_number:
            print(f"Error: Sprint {sprint_number} not found")
        else:
            print("Error: No current sprint found")
        sys.exit(1)

    # Generate burndown data
    burndown_data = generate_burndown_data(sprint_data)

    if not burndown_data:
        print("Error: Could not generate burndown data (missing dates or points)")
        sys.exit(1)

    # Format and output
    if output_format == 'csv':
        print(format_as_csv(burndown_data, sprint_data))
    elif output_format == 'json':
        print(format_as_json(burndown_data, sprint_data))
    else:
        print(format_as_table(burndown_data, sprint_data))


if __name__ == '__main__':
    main()
