---
<<<<<<< .merge_file_v5PINa
<<<<<<< .merge_file_dBOmsp
=======
=======
>>>>>>> .merge_file_mjXAuN
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< .merge_file_v5PINa
>>>>>>> .merge_file_0Qc3PO
=======
>>>>>>> .merge_file_mjXAuN
issues: []
discussions: []
title: "Stream"
module: "Media"
type: concept
tags: [stream, 1]
created: 2026-07-14
updated: 2026-07-14
qmd: "stream"
related:
  - "./webm.md"
<<<<<<< .merge_file_v5PINa
<<<<<<< .merge_file_dBOmsp
=======
=======
>>>>>>> .merge_file_mjXAuN
---
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
=======
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
module: theme
topic: --stream
canonical: ../../../Themes/docs/shared-components/.gitkeep-Modules
<<<<<<< .merge_file_v5PINa
>>>>>>> .merge_file_0Qc3PO
=======
>>>>>>> .merge_file_mjXAuN
---
https://laravel-news.com/temporary-directory

<<<<<<< .merge_file_dBOmsp
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

<<<<<<< .merge_file_v5PINa
----------------------------------------------------------------------------
=======
=======
>>>>>>> .merge_file_mjXAuN
See canonical documentation: ../../../Themes/docs/shared-components/.gitkeep-Modules
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_v5PINa
>>>>>>> .merge_file_0Qc3PO
=======
>>>>>>> .merge_file_mjXAuN
