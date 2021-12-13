<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendEmailOderSuccessQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $from_name;
    protected $from_email;
    protected $to_email;
    protected $content_email;
    public function __construct($from_name, $from_email, $to_email, $content_email)
    {
        $this->from_name = $from_name;
        $this->from_email = $from_email;
        $this->to_email = $to_email;
        $this->content_email = $content_email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $from_name = $this->from_name;
        $from_email = $this->from_email;
        $to_email = $this->to_email;
        Mail::send('cart.sent_email', $this->content_email, function ($message) use ($from_name, $from_email, $to_email) { //view, array, function
            $message->to($to_email)->subject($from_name); //gửi đến email với tiêu đề chính
            $message->from($from_email, $from_name); //gửi từ
        });
    }
}
