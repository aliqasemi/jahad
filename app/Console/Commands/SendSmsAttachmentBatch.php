<?php

namespace App\Console\Commands;

use App\Http\Infrastructure\InterfaceRepository\AttachRequirementInterface;
use App\Http\Infrastructure\InterfaceRepository\AttachServiceInterface;
use App\Jobs\SendSmsBatch;
use App\Models\Requirement;
use App\Models\Service;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

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
        $usersRequirement = [];
        foreach (Requirement::get() as $requirement) {
            $attachment = app()->make(AttachRequirementInterface::class)->attachByRequirement($requirement->id);
            if (count($attachment)) {
                $usersRequirement = Arr::add($usersRequirement, $requirement->user()->first()->id, $requirement->user()->first());
            }
        }

        foreach ($usersRequirement as $user) {
            SendSmsBatch::dispatch($user, " کاربر گرامی $user->firstname $user->lastname برای مشاهده سرویس های ارایه شده جهاد سازندگی برای نیازمندی شما پنل خود را چک بفرمایید ");
        }

        $usersService = [];
        foreach (Service::get() as $service) {
            $attachment = app()->make(AttachServiceInterface::class)->attachByService($service->id);
            if (count($attachment)) {
                $usersService = Arr::add($usersService, $service->user()->first()->id, $service->user()->first());
            }
        }

        foreach ($usersService as $user) {
            SendSmsBatch::dispatch($user, " کاربر گرامی $user->firstname $user->lastname برای مشاهده نیازمندی های ارایه شده جهاد سازندگی برای خدمت شما پنل خود را چک بفرمایید ");
        }
    }
}
