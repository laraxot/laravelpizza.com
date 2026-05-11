---
Farmshops-Eu-Style-Clustering

1. Dynamic cluster sizing: 80px radius when zoom < 12, 45px otherwise
2. Type indicators only visible when zoom >= 8
3. Specific icons per type (hof.png, markt.png, etc.)
4. Count displayed in circle with type icons below
5. Markers clustered only when >= 2 markers

Implementation in GeoMapLit:
- Modified _createClusterIcon to match farmshops pattern
- Fixed cluster sizing rules
- Added type-specific icon rendering
- Updated onEachFeature to handle AJAX popups

Documentation: 
- Geo/docs/wiki/concepts/geo-map-cluster.md
- Geo/docs/wiki/patterns/farmshops-clustering-pattern.md
- QMD entry for 'geo-cluster-pattern'

Second Brain Update: 
- Added cluster rules to memory/geo-cluster.md
- Added to LLM Wiki index

Test Plan:
- Verify cluster rendering at zoom 7 and 9
- Test AJAX popup after marker click
- Check responsive behavior on mobile
