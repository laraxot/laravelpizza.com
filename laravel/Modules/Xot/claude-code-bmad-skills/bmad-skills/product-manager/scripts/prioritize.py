#!/usr/bin/env python3
"""
RICE Score Calculator for Feature Prioritization

RICE = (Reach × Impact × Confidence) / Effort

Usage:
    python prioritize.py                    # Interactive mode
    python prioritize.py --batch features.csv  # Batch mode from CSV
    python prioritize.py --help             # Show help

Interactive mode will prompt for:
- Reach: Number of users affected per time period
- Impact: Value per user (0.25, 0.5, 1, 2, 3)
- Confidence: Certainty percentage (0-100%)
- Effort: Person-months of work

Batch mode expects CSV with columns: name,reach,impact,confidence,effort
"""

import sys
import csv
import argparse
from typing import List, Dict, Tuple


class Feature:
    """Represents a feature with RICE scoring components."""

    def __init__(self, name: str, reach: float, impact: float, confidence: float, effort: float):
        self.name = name
        self.reach = reach
        self.impact = impact
        self.confidence = confidence
        self.effort = effort
        self.rice_score = self.calculate_rice()

    def calculate_rice(self) -> float:
        """Calculate RICE score: (Reach × Impact × Confidence) / Effort"""
        if self.effort == 0:
            return 0
        return (self.reach * self.impact * (self.confidence / 100)) / self.effort

    def __repr__(self) -> str:
        return f"Feature(name='{self.name}', rice={self.rice_score:.2f})"


def validate_impact(value: float) -> bool:
    """Validate impact is one of the allowed values."""
    allowed = [0.25, 0.5, 1, 2, 3]
    return value in allowed


def validate_confidence(value: float) -> bool:
    """Validate confidence is between 0 and 100."""
    return 0 <= value <= 100


def validate_positive(value: float) -> bool:
    """Validate value is positive."""
    return value > 0


def get_float_input(prompt: str, validator=None, error_msg: str = "Invalid input") -> float:
    """Get validated float input from user."""
    while True:
        try:
            value = float(input(prompt))
            if validator is None or validator(value):
                return value
            print(f"Error: {error_msg}")
        except ValueError:
            print("Error: Please enter a valid number")
        except KeyboardInterrupt:
            print("\n\nOperation cancelled by user")
            sys.exit(0)


def get_string_input(prompt: str) -> str:
    """Get string input from user."""
    try:
        value = input(prompt).strip()
        if not value:
            print("Error: Input cannot be empty")
            return get_string_input(prompt)
        return value
    except KeyboardInterrupt:
        print("\n\nOperation cancelled by user")
        sys.exit(0)


def interactive_mode() -> List[Feature]:
    """Run interactive mode to collect feature data."""
    print("=" * 70)
    print("RICE Score Calculator - Interactive Mode")
    print("=" * 70)
    print("\nRICE = (Reach × Impact × Confidence) / Effort\n")
    print("Impact Scale:")
    print("  0.25 = Minimal impact")
    print("  0.5  = Low impact")
    print("  1    = Medium impact")
    print("  2    = High impact")
    print("  3    = Massive impact\n")
    print("Enter features one at a time. Type 'done' when finished.\n")

    features = []
    feature_num = 1

    while True:
        print(f"\n--- Feature {feature_num} ---")

        name = input("Feature name (or 'done' to finish): ").strip()
        if name.lower() == 'done':
            if features:
                break
            print("Please enter at least one feature")
            continue

        reach = get_float_input(
            "Reach (users affected per time period): ",
            validate_positive,
            "Reach must be greater than 0"
        )

        impact = get_float_input(
            "Impact (0.25, 0.5, 1, 2, or 3): ",
            validate_impact,
            "Impact must be 0.25, 0.5, 1, 2, or 3"
        )

        confidence = get_float_input(
            "Confidence (0-100%): ",
            validate_confidence,
            "Confidence must be between 0 and 100"
        )

        effort = get_float_input(
            "Effort (person-months): ",
            validate_positive,
            "Effort must be greater than 0"
        )

        feature = Feature(name, reach, impact, confidence, effort)
        features.append(feature)

        print(f"\n✓ Added: {name} (RICE Score: {feature.rice_score:.2f})")
        feature_num += 1

    return features


def batch_mode(csv_file: str) -> List[Feature]:
    """Load features from CSV file."""
    features = []

    try:
        with open(csv_file, 'r') as f:
            reader = csv.DictReader(f)
            required_columns = {'name', 'reach', 'impact', 'confidence', 'effort'}

            if not required_columns.issubset(set(reader.fieldnames)):
                print(f"Error: CSV must contain columns: {', '.join(required_columns)}")
                sys.exit(1)

            for row_num, row in enumerate(reader, start=2):
                try:
                    name = row['name'].strip()
                    reach = float(row['reach'])
                    impact = float(row['impact'])
                    confidence = float(row['confidence'])
                    effort = float(row['effort'])

                    # Validate
                    if not validate_positive(reach):
                        print(f"Warning: Row {row_num} - Reach must be positive, skipping")
                        continue
                    if not validate_impact(impact):
                        print(f"Warning: Row {row_num} - Impact must be 0.25, 0.5, 1, 2, or 3, skipping")
                        continue
                    if not validate_confidence(confidence):
                        print(f"Warning: Row {row_num} - Confidence must be 0-100, skipping")
                        continue
                    if not validate_positive(effort):
                        print(f"Warning: Row {row_num} - Effort must be positive, skipping")
                        continue

                    feature = Feature(name, reach, impact, confidence, effort)
                    features.append(feature)

                except (ValueError, KeyError) as e:
                    print(f"Warning: Row {row_num} - Invalid data, skipping ({e})")
                    continue

        if not features:
            print("Error: No valid features found in CSV")
            sys.exit(1)

    except FileNotFoundError:
        print(f"Error: File '{csv_file}' not found")
        sys.exit(1)
    except Exception as e:
        print(f"Error reading CSV: {e}")
        sys.exit(1)

    return features


def display_results(features: List[Feature]):
    """Display prioritized features in a formatted table."""
    # Sort by RICE score descending
    sorted_features = sorted(features, key=lambda f: f.rice_score, reverse=True)

    print("\n" + "=" * 100)
    print("PRIORITIZATION RESULTS (Ranked by RICE Score)")
    print("=" * 100)
    print(f"\n{'Rank':<6} {'Feature':<30} {'Reach':<10} {'Impact':<10} {'Confidence':<12} {'Effort':<10} {'RICE Score':<12}")
    print("-" * 100)

    for rank, feature in enumerate(sorted_features, start=1):
        print(f"{rank:<6} {feature.name:<30} {feature.reach:<10.0f} {feature.impact:<10.2f} "
              f"{feature.confidence:<12.0f}% {feature.effort:<10.2f} {feature.rice_score:<12.2f}")

    print("\n" + "=" * 100)
    print("INTERPRETATION:")
    print("  - Higher RICE scores indicate higher priority")
    print("  - Scores are relative; compare features against each other")
    print("  - Consider strategic alignment and dependencies alongside scores")
    print("=" * 100 + "\n")


def export_results(features: List[Feature], output_file: str):
    """Export results to CSV file."""
    sorted_features = sorted(features, key=lambda f: f.rice_score, reverse=True)

    try:
        with open(output_file, 'w', newline='') as f:
            fieldnames = ['rank', 'name', 'reach', 'impact', 'confidence', 'effort', 'rice_score']
            writer = csv.DictWriter(f, fieldnames=fieldnames)
            writer.writeheader()

            for rank, feature in enumerate(sorted_features, start=1):
                writer.writerow({
                    'rank': rank,
                    'name': feature.name,
                    'reach': feature.reach,
                    'impact': feature.impact,
                    'confidence': feature.confidence,
                    'effort': feature.effort,
                    'rice_score': round(feature.rice_score, 2)
                })

        print(f"\n✓ Results exported to: {output_file}")
    except Exception as e:
        print(f"Error exporting results: {e}")


def main():
    parser = argparse.ArgumentParser(
        description='RICE Score Calculator for Feature Prioritization',
        formatter_class=argparse.RawDescriptionHelpFormatter,
        epilog="""
Examples:
  python prioritize.py                      # Interactive mode
  python prioritize.py --batch features.csv # Batch mode
  python prioritize.py -b features.csv -o results.csv  # Batch with export

CSV Format (for batch mode):
  name,reach,impact,confidence,effort
  Feature A,1000,2,80,3
  Feature B,500,3,100,1.5

Impact Values:
  0.25 = Minimal
  0.5  = Low
  1    = Medium
  2    = High
  3    = Massive
        """
    )

    parser.add_argument(
        '-b', '--batch',
        metavar='FILE',
        help='Load features from CSV file (batch mode)'
    )

    parser.add_argument(
        '-o', '--output',
        metavar='FILE',
        help='Export results to CSV file'
    )

    args = parser.parse_args()

    # Determine mode and collect features
    if args.batch:
        features = batch_mode(args.batch)
    else:
        features = interactive_mode()

    # Display results
    display_results(features)

    # Export if requested
    if args.output:
        export_results(features, args.output)
    elif args.batch:
        # Auto-export in batch mode
        output_file = args.batch.rsplit('.', 1)[0] + '_results.csv'
        export_results(features, output_file)


if __name__ == '__main__':
    main()
