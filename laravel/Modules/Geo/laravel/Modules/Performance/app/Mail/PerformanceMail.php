<?php

declare(strict_types=1);

namespace Modules\Performance\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PerformanceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var mixed
     */
    public $row;

    /**
     * Create a new message instance.
     *
     * @param  mixed  $row
     */
    public function __construct($row)
    {
        $this->row = $row;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $msg = null;
        if (is_object($this->row) && method_exists($this->row, 'getAttribute') && $this->row->getAttribute('messages') !== null) {
            // Type narrowing: ensure row has messages property
            $messages = isset($this->row->messages) ? $this->row->messages : null;
            if (is_object($messages) && method_exists($messages, 'keyBy')) {
                $msg = $messages->keyBy('type');
            }
        }

        return $this->subject('Performance')
            // @phpstan-ignore-next-line
            ->view('performance::emails.performance')
            ->with([
                'row' => $this->row,
                'msg' => $msg,
            ]);
    }
}
