<?php

namespace App\Jobs;

use App\Services\ServiceCaller;
use App\Services\Sms\Tasks\Email;

class EmailJob extends Job
{
    public $tries = 5;

    private $content;

    private $to;

    private $subject;

    private $attachment;

    private $attachmentName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $text, string $to, string $subject, ?string $attachment = null, ?string $attachmentNmae = null)
    {
        $this->content = $text;
        $this->to = $to;
        $this->subject = $subject;
        $this->attachment = $attachment;
        $this->attachmentName = $attachmentNmae;
    }

    /**
     * Execute the job.
     *
     *
     * @return void
     */
    public function handle()
    {
        return ServiceCaller::call(ServiceCaller::TASK_SERVICE, new Email($this->content, $this->to, $this->subject, $this->attachment, $this->attachmentName));
    }
}
