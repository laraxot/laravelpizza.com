Mail::send([], [], function($message) use ($data) {
    $message->from($data['from']);
    $message->to($data['to']);
    $message->subject($data['subject']);
    $message->setBody($data['content'], 'text/html');
});

public function build()
    {
        return $this->from('sender@example.com')
                    ->view('mails.demo')
                    ->text('mails.demo_plain')
                    ->with(
                      [
                            'testVarOne' => '1',
                            'testVarTwo' => '2',
                      ])
                      ->attach(public_path('/images').'/demo.jpg', [
                              'as' => 'demo.jpg',
                              'mime' => 'image/jpeg',
                      ]);
    }
}