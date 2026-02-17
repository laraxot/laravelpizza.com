from playwright.sync_api import sync_playwright
import json

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)

    # Get local page HTML
    page = browser.new_page()
    page.goto("http://127.0.0.1:8000/it/events")
    page.wait_for_load_state("networkidle")

    # Check for the events section
    html = page.content()

    # Find events data in the HTML
    print("=== Checking page for events data ===")

    # Check if events are in the page
    if "Laravel 11 Release Pizza Party" in html:
        print("✓ Found event title in HTML")
    else:
        print("✗ Event title NOT found in HTML")

    if "Upcoming Events" in html:
        print("✓ Found 'Upcoming Events' header")

    # Look for any data-attributes or JSON
    import re

    # Find any JSON-like data in the page
    json_matches = re.findall(r'data\-.+?=["\'](.+?)["\']', html)
    print(f"\nFound {len(json_matches)} data attributes")

    # Get body content around events section
    body_text = page.locator("body").inner_text()
    print(f"\n=== Page text preview (first 500 chars) ===")
    print(body_text[:500])

    # Screenshot
    page.screenshot(path="/tmp/debug_events.png", full_page=True)

    browser.close()

print("\nDebug screenshot saved to /tmp/debug_events.png")
