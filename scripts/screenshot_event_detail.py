from playwright.sync_api import sync_playwright

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)

    # Test local event detail page
    page = browser.new_page()
    page.set_viewport_size({"width": 1920, "height": 1080})

    # Local page
    page.goto("http://127.0.0.1:8000/it/events/laravel-11-release-pizza-party")
    page.wait_for_load_state("networkidle")
    page.screenshot(path="/tmp/local_event_detail_full.png", full_page=True)
    page.set_viewport_size({"width": 375, "height": 812})
    page.screenshot(path="/tmp/local_event_detail_mobile.png")

    # Production page
    page.set_viewport_size({"width": 1920, "height": 1080})
    page.goto("https://laravelpizza.com/events/1")
    page.wait_for_load_state("networkidle")
    page.screenshot(path="/tmp/prod_event_detail_full.png", full_page=True)
    page.set_viewport_size({"width": 375, "height": 812})
    page.screenshot(path="/tmp/prod_event_detail_mobile.png")

    print("Screenshots saved!")
    browser.close()
