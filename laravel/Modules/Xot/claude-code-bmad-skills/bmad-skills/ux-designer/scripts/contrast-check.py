#!/usr/bin/env python3
"""
Color Contrast Ratio Calculator
WCAG 2.1 compliance checker for color combinations

Usage:
    python contrast-check.py #000000 #ffffff
    python contrast-check.py 000000 ffffff
    python contrast-check.py "#333" "#fff"
"""

import sys
import re


def hex_to_rgb(hex_color):
    """Convert hex color to RGB tuple."""
    # Remove # if present
    hex_color = hex_color.lstrip('#')

    # Handle 3-character hex codes
    if len(hex_color) == 3:
        hex_color = ''.join([c*2 for c in hex_color])

    # Convert to RGB
    try:
        r = int(hex_color[0:2], 16)
        g = int(hex_color[2:4], 16)
        b = int(hex_color[4:6], 16)
        return (r, g, b)
    except (ValueError, IndexError):
        raise ValueError(f"Invalid hex color: #{hex_color}")


def relative_luminance(rgb):
    """
    Calculate relative luminance according to WCAG formula.
    https://www.w3.org/TR/WCAG21/#dfn-relative-luminance
    """
    r, g, b = rgb

    # Convert to 0-1 range
    r = r / 255.0
    g = g / 255.0
    b = b / 255.0

    # Apply gamma correction
    r = r / 12.92 if r <= 0.03928 else ((r + 0.055) / 1.055) ** 2.4
    g = g / 12.92 if g <= 0.03928 else ((g + 0.055) / 1.055) ** 2.4
    b = b / 12.92 if b <= 0.03928 else ((b + 0.055) / 1.055) ** 2.4

    # Calculate luminance
    return 0.2126 * r + 0.7152 * g + 0.0722 * b


def contrast_ratio(color1, color2):
    """
    Calculate contrast ratio between two colors.
    https://www.w3.org/TR/WCAG21/#dfn-contrast-ratio
    """
    lum1 = relative_luminance(hex_to_rgb(color1))
    lum2 = relative_luminance(hex_to_rgb(color2))

    # Ensure lighter color is in numerator
    lighter = max(lum1, lum2)
    darker = min(lum1, lum2)

    return (lighter + 0.05) / (darker + 0.05)


def check_wcag_compliance(ratio):
    """Check WCAG 2.1 compliance levels."""
    results = {
        'ratio': ratio,
        'aa_normal': ratio >= 4.5,      # Normal text (< 18px or < 14px bold)
        'aa_large': ratio >= 3.0,       # Large text (>= 18px or >= 14px bold)
        'aaa_normal': ratio >= 7.0,     # AAA normal text
        'aaa_large': ratio >= 4.5,      # AAA large text
        'ui_components': ratio >= 3.0,  # UI components and graphics
    }
    return results


def print_results(color1, color2, results):
    """Print formatted results."""
    ratio = results['ratio']

    print("\n" + "="*70)
    print("                    COLOR CONTRAST CHECKER")
    print("="*70)
    print(f"\nForeground: {color1.upper()}")
    print(f"Background: {color2.upper()}")
    print(f"\nContrast Ratio: {ratio:.2f}:1")
    print("\n" + "-"*70)
    print("WCAG 2.1 COMPLIANCE:")
    print("-"*70)

    # AA Level
    print("\nLevel AA:")
    print(f"  Normal text (< 18px):      {'✓ PASS' if results['aa_normal'] else '✗ FAIL'} (requires 4.5:1)")
    print(f"  Large text (≥ 18px):       {'✓ PASS' if results['aa_large'] else '✗ FAIL'} (requires 3.0:1)")
    print(f"  UI Components:             {'✓ PASS' if results['ui_components'] else '✗ FAIL'} (requires 3.0:1)")

    # AAA Level
    print("\nLevel AAA:")
    print(f"  Normal text (< 18px):      {'✓ PASS' if results['aaa_normal'] else '✗ FAIL'} (requires 7.0:1)")
    print(f"  Large text (≥ 18px):       {'✓ PASS' if results['aaa_large'] else '✗ FAIL'} (requires 4.5:1)")

    print("\n" + "-"*70)
    print("RECOMMENDATIONS:")
    print("-"*70)

    if results['aa_normal']:
        print("✓ This color combination meets WCAG 2.1 AA for all text sizes.")
    elif results['aa_large']:
        print("⚠ This combination only passes for LARGE text (18px+ or 14px+ bold).")
        print("  Use larger text or adjust colors for normal-sized text.")
    elif results['ui_components']:
        print("⚠ This combination only passes for UI components.")
        print("  DO NOT use for text. Adjust colors for better contrast.")
    else:
        print("✗ This color combination FAILS WCAG 2.1 AA requirements.")
        print("  You must adjust the colors for accessibility compliance.")

    if results['aaa_normal']:
        print("★ This combination meets WCAG 2.1 AAA (enhanced contrast).")

    print("\n" + "-"*70)
    print("TEXT SIZE REFERENCE:")
    print("-"*70)
    print("  Normal text:  < 18px (or < 14px bold)")
    print("  Large text:   ≥ 18px (or ≥ 14px bold)")
    print("\n" + "="*70 + "\n")


def suggest_improvements(color1, color2, results):
    """Suggest color adjustments if contrast is insufficient."""
    if results['aa_normal']:
        return  # Already compliant

    ratio = results['ratio']
    target = 4.5  # AA normal text requirement

    print("SUGGESTIONS FOR IMPROVEMENT:")
    print("-"*70)

    if ratio < 3.0:
        print("⚠ Contrast is very low. Consider these approaches:")
        print("  1. Use a much darker foreground with this background")
        print("  2. Use a much lighter background with this foreground")
        print("  3. Add a contrasting border or outline")
        print("  4. Use a completely different color palette")
    elif ratio < 4.5:
        print("⚠ Close to compliance. Small adjustments may help:")
        print("  1. Darken the foreground color slightly")
        print("  2. Lighten the background color slightly")
        print("  3. Or adjust both for better contrast")

    print("\nCommon approaches:")
    print("  • Dark text on light background (e.g., #333 on #fff)")
    print("  • Light text on dark background (e.g., #fff on #333)")
    print("  • High saturation differences")
    print("  • Test with python scripts/contrast-check.py after adjustments")
    print()


def main():
    if len(sys.argv) != 3:
        print("\n" + "="*70)
        print("                    COLOR CONTRAST CHECKER")
        print("="*70)
        print("\nUsage:")
        print("  python contrast-check.py <foreground> <background>")
        print("\nExamples:")
        print("  python contrast-check.py #000000 #ffffff")
        print("  python contrast-check.py 333 fff")
        print("  python contrast-check.py \"#1a1a1a\" \"#f5f5f5\"")
        print("\nNote: Both 3-digit and 6-digit hex codes are supported.")
        print("      The # symbol is optional.")
        print("\n" + "="*70 + "\n")
        sys.exit(1)

    color1 = sys.argv[1]
    color2 = sys.argv[2]

    try:
        # Validate hex colors
        hex_to_rgb(color1)
        hex_to_rgb(color2)

        # Calculate contrast
        ratio = contrast_ratio(color1, color2)
        results = check_wcag_compliance(ratio)

        # Print results
        print_results(color1, color2, results)
        suggest_improvements(color1, color2, results)

        # Exit code: 0 if AA compliant, 1 if not
        sys.exit(0 if results['aa_normal'] else 1)

    except ValueError as e:
        print(f"\nError: {e}", file=sys.stderr)
        print("Please provide valid hex colors (e.g., #000000 or 000 or #fff)\n", file=sys.stderr)
        sys.exit(2)


if __name__ == '__main__':
    main()
