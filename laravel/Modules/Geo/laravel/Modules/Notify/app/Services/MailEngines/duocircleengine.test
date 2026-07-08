<?php
/**
 * @see https://smsvi-docs.web.app/docs/restful/send-batch/
 */

declare(strict_types=1);

namespace Modules\Notify\Services\MailEngines;

use Exception;
use GuzzleHttp\Client;

// ---------CSS------------

/**
 * Class SmsService.
 */
class DuocircleEngine {
    private static ?self $instance = null;
    public ?string $from;
    public string $to;
    public string $driver;
    public ?string $body;

    public function __construct() {
    }

    public static function getInstance(): self {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function make(): self {
        return static::getInstance();
    }

    public function setLocalVars(array $vars): self {
        foreach ($vars as $k => $v) {
            $this->{$k} = $v;
        }

        return $this;
    }

    public function send(): self {
        dddx('WIP');

        return $this;
    }

    public function try(): self {
        /*
        $url = 'http://api.duocircle.com';
        $url1 = '/v1/account';
        //$headers=X-AUTH-TOKEN
        $client = new Client();
        $request = $client->request('GET', $url.$url1, [
            'headers' => [
                'X-AUTH-TOKEN' => 'Mail.2020',
            ],
        ]);
        //$request->addHeader('X-Authorization', 'OAuth realm=<OAUTH STUFF HERE>');
        //$request->addHeader('X-AUTH-TOKEN', 'Mail.2020');
        //$resp = $client->send($request);

        dddx($request);
        */
        if (! class_exists(\Webklex\PHPIMAP\Client::class)) {
            throw new Exception('class [Webklex\\PHPIMAP\\Client] not exists ['.__LINE__.']['.class_basename(__CLASS__).']');
        }
        if (! class_exists(\Webklex\IMAP\Facades\Client::class)) {
            throw new Exception('class [Webklex\IMAP\Facades\\Client] not exists ['.__LINE__.']['.class_basename(__CLASS__).']');
        }

        /** @var \Webklex\PHPIMAP\Client $client */
        $client = \Webklex\IMAP\Facades\Client::account('default');

        // Connect to the IMAP Server
        $client->connect();

        /**
         * Get all Mailboxes.
         *
         * @var \Webklex\PHPIMAP\Support\FolderCollection $folders
         */
        $folders = $client->getFolders();

        // Loop through every Mailbox
        /** @var \Webklex\PHPIMAP\Folder $folder */
        foreach ($folders as $folder) {
            /**
             * Get all Messages of the current Mailbox $folder.
             *
             * @var \Webklex\PHPIMAP\Support\MessageCollection $messages
             */
            $messages = $folder->messages()->all()->get();

            // / @var \Webklex\PHPIMAP\Message $message
            foreach ($messages as $message) {
                echo $message->getSubject().'<br />';
                echo 'Attachments: '.$message->getAttachments()->count().'<br />';
                echo $message->getHTMLBody();

                // Move the current Message to 'INBOX.read'
                if (true === $message->move('INBOX.read')) {
                    echo 'Message has ben moved';
                } else {
                    echo 'Message could not be moved';
                }
            }
        }

        return $this;
    }
}
