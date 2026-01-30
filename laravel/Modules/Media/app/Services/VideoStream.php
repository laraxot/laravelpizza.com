<?php

declare(strict_types=1);

namespace Modules\Media\Services;

use Exception;
use Illuminate\Support\Facades\Storage;
use Webmozart\Assert\Assert;

use function is_string;
use function Safe\fclose;
use function Safe\fread;
use function Safe\ob_end_clean;
use function Safe\set_time_limit;

/**
 * Handles video streaming from a given path.
 */
class VideoStream
{
    private int $bufferSize = 102400; // Buffer size for streaming

    private int $start = 0; // Start position for streaming

    private int $end = 0; // End position for streaming

    private int $size = 0; // Total size of the video

    private ?string $mime = null; // MIME type of the video

    private ?int $fileModifiedTime = null; // Last modified time of the video file

    /** @var resource|null */
    private $stream = null; // File stream resource

    /**
     * Initialize the video stream.
     *
     * @param  string  $disk  The disk storage name
     * @param  string  $path  The path to the video file
     *
     * @throws Exception If the file does not exist or other errors
     */
    public function __construct(string $disk, string $path)
    {
        $filesystem = Storage::disk($disk);

        if (! $filesystem->exists($path)) {
            throw new Exception("File does not exist at path: {$path}");
        }

        $mime = $filesystem->mimeType($path);
        if ($mime === false) {
            throw new Exception('Unable to determine MIME type.');
        }
        $this->stream = $filesystem->readStream($path);
        $this->mime = $mime;
        $this->fileModifiedTime = $filesystem->lastModified($path);
        $this->size = $filesystem->size($path);

        if (! is_string($this->mime)) {
            throw new Exception('Unable to determine MIME type.');
        }
    }

    /**
     * Start streaming the video.
     */
    public function start(): void
    {
        $this->setHeaders();
        $this->streamContent();
        $this->closeStream();
    }

    /**
     * Set HTTP headers for video streaming.
     */
    private function setHeaders(): void
    {
        ob_end_clean(); // Clean any previous output
        header('Content-Type: '.$this->mime);
        header('Cache-Control: max-age=2592000, public'); // 30 days cache
        header('Expires: '.gmdate('D, d M Y H:i:s', time() + 2592000).' GMT'); // 30 days in the future
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', $this->fileModifiedTime).' GMT');

        $this->end = $this->size - 1;
        header('Accept-Ranges: bytes');

        Assert::nullOrString($rangeHeader = $_SERVER['HTTP_RANGE'] ?? null);
        if ($rangeHeader !== null) {
            $this->processRangeHeader($rangeHeader);
        } else {
            header('Content-Length: '.$this->size);
        }
    }

    /**
     * Process the range header for partial content requests.
     */
    private function processRangeHeader(string $rangeHeader): void
    {
        [$unit, $range] = explode('=', $rangeHeader, 2);

        if ($unit !== 'bytes') {
            header('HTTP/1.1 416 Requested Range Not Satisfiable');
            header(sprintf('Content-Range: bytes %d-%d/%d', $this->start, $this->end, $this->size));
            exit;
        }

        $rangeParts = explode('-', $range);
        $start = (int) $rangeParts[0];
        $end = isset($rangeParts[1]) ? ((int) $rangeParts[1]) : $this->end;

        if ($start > $end || $start >= $this->size || $end >= $this->size) {
            header('HTTP/1.1 416 Requested Range Not Satisfiable');
            header(sprintf('Content-Range: bytes %d-%d/%d', $this->start, $this->end, $this->size));
            exit;
        }

        $this->start = $start;
        $this->end = $end;

        $length = $this->end - $this->start + 1;
        header('HTTP/1.1 206 Partial Content');
        header('Content-Length: '.$length);
        header(sprintf('Content-Range: bytes %d-%d/%d', $this->start, $this->end, $this->size));
    }

    /**
     * Stream the video content to the client.
     */
    private function streamContent(): void
    {
        set_time_limit(0); // Disable time limit for streaming

        if (! is_resource($this->stream)) {
            throw new Exception('Stream resource is not valid.');
        }

        fseek($this->stream, $this->start);
        while (! feof($this->stream) && $this->start <= $this->end) {
            $bytesToRead = min($this->bufferSize, $this->end - $this->start + 1);
            if ($bytesToRead > 0) {
                $data = fread($this->stream, $bytesToRead);
                echo $data;
                flush();
                $this->start += $bytesToRead;
            } else {
                break; // Evita loop infiniti se $bytesToRead <= 0
            }
        }
    }

    /**
     * Close the file stream and terminate the script.
     */
    private function closeStream(): void
    {
        if (is_resource($this->stream)) {
            fclose($this->stream);
        }

        exit;
    }
}
