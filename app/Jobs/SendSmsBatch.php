<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\SmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSmsBatch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    private $messageTemplate;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, string $messageTemplate)
    {
        $this->user = $user;
        $this->messageTemplate = $messageTemplate;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \App\Exceptions\ErrorException
     */
    public function handle()
    {
        SmsService::build($this->user->phoneNumber, $this->messageTemplate)->send();
    }
}
