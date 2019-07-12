<?php
namespace App\Services\Sms\Tasks;

use Illuminate\Support\Facades\Mail;
use App\Services\TaskContract;

class Email implements TaskContract
{
    private $content;
    private $to;
    private $subject;
    private $attachment;
    private $attachmentName;

    public function __construct(?string $content, string $to, string $subject, ?string $attachment = null, ?string $attachmentName = null)
    {
        $this->content = $content;
        $this->to = $to;
        $this->subject = $subject;
        $this->attachment = $attachment;
        $this->attachmentName = $attachmentName;
    }

    public function run()
    {
        Mail::raw($this->content, function($message) {
            $message->to($this->to)->subject($this->subject);

            if ($this->attachment) {
                if ($this->attachmentName)
                    $message->attach($this->attachment,['as' => $this->attachmentName]);
                else
                    $message->attach($this->attachment);
            }
        });
    }
}