from playwright.sync_api import sync_playwright
import json

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)

    # Test local version
    page_local = browser.new_page()
    page_local.goto("http://127.0.0.1:8000/it/events")
    page_local.wait_for_load_state("networkidle")

    local_html = page_local.content()
    local_screenshot = page_local.screenshot(
        path="/tmp/local_events.png", full_page=True
    )

    # Get page title
    local_title = page_local.title()
    local_h1 = (
        page_local.locator("h1").first.inner_text()
        if page_local.locator("h1").count() > 0
        else "NO H1"
    )

    # Get events count
    event_cards = page_local.locator('[class*="event"]').count()

    print(f"=== LOCAL (127.0.0.1:8000) ===")
    print(f"Title: {local_title}")
    print(f"H1: {local_h1}")
    print(f"Event cards found: {event_cards}")

    # Test production version
    page_prod = browser.new_page()
    page_prod.goto("https://laravelpizza.com/events")
    page_prod.wait_for_load_state("networkidle")

    prod_html = page_prod.content()
    prod_screenshot = page_prod.screenshot(path="/tmp/prod_events.png", full_page=True)

    prod_title = page_prod.title()
    prod_h1 = (
        page_prod.locator("h1").first.inner_text()
        if page_prod.locator("h1").count() > 0
        else "NO H1"
    )
    prod_event_cards = page_prod.locator('[class*="event"]').count()

    print(f"\n=== PRODUCTION (laravelpizza.com) ===")
    print(f"Title: {prod_title}")
    print(f"H1: {prod_h1}")
    print(f"Event cards found: {prod_event_cards}")

    # Analyze HTML structure
    print(f"\n=== HTML ANALYSIS ===")
    print(f"Local HTML length: {len(local_html)} chars")
    print(f"Production HTML length: {len(prod_html)} chars")

    # Check for key elements
    local_has_upcoming = "upcoming" in local_html.lower()
    prod_has_upcoming = "upcoming" in prod_html.lower()
    print(
        f"\nHas 'upcoming' text - Local: {local_has_upcoming}, Prod: {prod_has_upcoming}"
    )

    # Check for dynamic data indicators
    print(f"\n=== DATA SOURCE ANALYSIS ===")
    # Check if there are PHP/Eloquent indicators
    local_has_php_vars = "{{" in local_html or "<?" in local_html
    prod_has_php_vars = "{{" in prod_html or "<?" in prod_html
    print(f"Has PHP variables: Local: {local_has_php_vars}, Prod: {prod_has_php_vars}")

    browser.close()

print("\nScreenshots saved to /tmp/local_events.png and /tmp/prod_events.png")
