<?php
namespace App\Jobs;

use App\Mail\SubmitEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $subject;
    public $view;
    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($subject, $view, $data)
    {
        $this->subject = $subject;
        $this->view    = $view;
        $this->data    = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emailData = new SubmitEmail($this->subject, $this->view, $this->data);
        if (isset($this->data['emails'])) {
            Mail::bcc($this->data['emails'])->send($emailData);
        } else {
            Mail::to($this->data['email'])->send($emailData);
        }
    }
}
