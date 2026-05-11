# GeoMapLit Dynamic Popup Pattern

## Overview
The `geo-map-lit` component now implements **dynamic popup loading** inspired by Farmshops.eu (direktvermarkter.js). When a marker is clicked, the component fetches detailed information via AJAX and displays it in the popup, providing a richer user experience with dynamic content.

## Implementation Details
The component uses a **"once" event listener** on each marker layer to load data on the first click:

```javascript
onEachFeature: (feature, layer) => {
    // Skip any feature without id or properties
    if (!feature.properties?.id) {
        // Fallback static popup
        layer.bindPopup(/* static content */);
        return;
    }

    // Click listener to fetch detailed data via AJAX (farmshops.eu pattern)
    layer.once('click', () => {
        fetch(`/api/ticket-details/${feature.properties.id}`)
            .then(response => response.json())
            .then(detailData => {
                // Create popup content from fetched data
                const popupContent = /* dynamic content */ 
                layer.openPopup();
                setTimeout(() => {
                    const popup = layer.getPopup();
                    if (popup) popup.setContent(popupContent);
                }, 0);
            })
            .catch(err => {
                // Error handling
            });
    });
}
```

## Key Features
- **AJAX-driven content**: Fetches detailed data from `/api/ticket-details/{id}` on marker click
- **Graceful fallback**: Uses static popup content if API call fails or feature lacks ID
- **Dynamic content**: Supports title, address, description, images, and custom attributes
- **Safe asynchronous handling**: Uses `once('click')` to prevent duplicate requests
- **Error handling**: Shows error message if data loading fails

## Popup Content Structure
The fetched data supports the following structure:
```javascript
{
    title: "Ticket title",
    address: "Full address",
    description: "Detailed description",
    images: ["url1.jpg", "url2.jpg"],
    attributes: {
        "Category": "Value",
        "Status": "Value"
    }
}
```

## Performance Considerations
- **Single fetch**: Each marker loads data only once
- **No race conditions**: `once('click')` prevents multiple concurrent requests
- **Graceful degradation**: Works with static content if API is unavailable
- **Memory efficient**: No data caching (can be added if needed)

## Migration from Static Popup
To migrate from static to dynamic popup:
1. Add an `id` property to your GeoJSON features
2. Implement the API endpoint `/api/ticket-details/{id}`
3. Replace static `bindPopup()` with the dynamic pattern above
4. Add error handling for API failures

## Related Rules
- **Map Interaction Transparency Rule** – ensures popup remains accessible and interactive
- **No CDN assets** – all assets are local to the module
- **Second Brain Discipline** – document usage patterns in wiki

## Test Coverage
- Update Playwright tests to verify:
  - Popup appears on marker click
  - Dynamic content loads correctly
  - Error handling works when API fails
  - Only one request per marker
