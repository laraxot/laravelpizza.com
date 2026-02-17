from playwright.sync_api import sync_playwright

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)

    # Test local page
    page = browser.new_page()
    page.set_viewport_size({"width": 1920, "height": 1080})
    page.goto("http://127.0.0.1:8000/it/events")
    page.wait_for_load_state("networkidle")

    # Full page screenshot
    page.screenshot(path="/tmp/local_events_full.png", full_page=True)

    # Mobile viewport
    page.set_viewport_size({"width": 375, "height": 812})
    page.screenshot(path="/tmp/local_events_mobile.png")

    print("Screenshots saved!")
    browser.close()
