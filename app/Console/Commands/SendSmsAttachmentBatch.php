<?php

namespace App\Console\Commands;

use App\Http\Infrastructure\InterfaceRepository\AttachRequirementInterface;
use App\Jobs\SendSmsBatch;
use App\Models\Requirement;
use Illuminate\Console\Command;

class SendSmsAttachmentBatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms-attachment:batch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send sms batch for attachment service requirement response';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        (new SmsGenerate)->handle();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach (Requirement::get() as $requirement) {
            $attachment = app()->make(AttachRequirementInterface::class)->attachByRequirement($requirement->id);
            if (count($attachment)) {
                $user = $requirement->user()->first();
                SendSmsBatch::dispatch($user, " کاربر گرامی $user->firstname $user->lastname برای مشاهده سرویس های ارایه شده جهاد سازندگی برای نیازمندی شما پنل خود را چک بفرمایید ");
            }
        }
    }
}
