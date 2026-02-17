from playwright.sync_api import sync_playwright

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)
    page = browser.new_page()

    # Capture console logs
    console_messages = []
    page.on("console", lambda msg: console_messages.append(f"{msg.type}: {msg.text}"))
    page.on("pageerror", lambda err: console_messages.append(f"ERROR: {err}"))

    page.set_viewport_size({"width": 1920, "height": 1080})
    page.goto("http://127.0.0.1:8000/it/events/laravel-11-release-pizza-party")
    page.wait_for_load_state("networkidle")
    page.wait_for_timeout(2000)

    print("=== Console Messages ===")
    for msg in console_messages:
        print(msg)

    browser.close()
