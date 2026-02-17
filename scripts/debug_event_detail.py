from playwright.sync_api import sync_playwright

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)

    page = browser.new_page()
    page.set_viewport_size({"width": 1920, "height": 1080})
    page.goto("http://127.0.0.1:8000/it/events/laravel-11-release-pizza-party")
    page.wait_for_load_state("networkidle")

    # Take screenshot
    page.screenshot(path="/tmp/debug_event_detail.png", full_page=True)

    # Get HTML for debugging
    content = page.content()

    # Check for main sections
    has_about = "About this event" in content
    has_attendees = "Attendees" in content
    has_location = "Tech Hub" in content

    print(f"Has 'About this event': {has_about}")
    print(f"Has 'Attendees': {has_attendees}")
    print(f"Has 'Tech Hub': {has_location}")

    # Check if elements are visible
    about_visible = page.locator("text=About this event").is_visible()
    print(f"'About this event' visible: {about_visible}")

    browser.close()
