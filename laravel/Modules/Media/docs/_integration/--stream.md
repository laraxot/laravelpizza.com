---
title: " stream"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: " stream"
issues: []
discussions: []
module: theme
topic: __stream
canonical: ../../../../Themes/docs/shared-components/.gitkeep-Modules
---
# __stream

See canonical documentation: ../../../../Themes/docs/shared-components/.gitkeep-Modules
title: "__stream"
module: "Media"
type: concept
tags: [, stream]
created: 2026-07-14
updated: 2026-07-14
qmd: " stream"
related:
  - "./webm.md"
---
# __stream

<!-- Contenuto migrato da _docs/__stream.txt -->

https://laravel-news.com/temporary-directory


-----------------------------------------------

use Illuminate\Support\Facades\Http;
use Spatie\TemporaryDirectory\TemporaryDirectory;
 
// Normalize the video and get the filename
$videoUrl = str($videoUrl)->replace(' ', '%20');
$tmpFile = $videoUrl->afterLast('/');
 
// Create a temporary directory and download a file to that path
$tmpDir = TemporaryDirectory::make();
$tmpPath = $tmpDir->path($tmpFile);
Http::sink($tmpPath)->throw()->get($videoUrl->toString());
 
// Process the file
 
// Cleanup the temporary file
$tmpFile->delete();

----------------------------------------------------------------------------
