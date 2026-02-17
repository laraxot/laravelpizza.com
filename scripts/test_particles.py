from playwright.sync_api import sync_playwright

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)
    page = browser.new_page()
    page.set_viewport_size({"width": 1920, "height": 1080})
    page.goto("http://127.0.0.1:8000/it/events/laravel-11-release-pizza-party")
    page.wait_for_load_state("networkidle")

    # Wait for particles to render
    page.wait_for_timeout(2000)

    page.screenshot(path="/tmp/event_particles.png", full_page=True)
    print("Screenshot saved")
    browser.close()
