<?php

namespace App\Console\Commands;

use App\Models\SecureTokenSms;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class SmsGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate secure token';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response = Http::accept('application/json')
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])->post(config('sms.tokenRequestApi'), [
                'UserApiKey' => config('sms.UserApiKey'),
                'SecretKey' => config('sms.SecretKey'),
            ])->json();

        if (Arr::get($response, 'IsSuccessful')) {
            SecureTokenSms::updateOrCreate(
                [
                    'id' => SecureTokenSms::first()->id,
                ],
                [
                    'token' => Arr::get($response, 'TokenKey')
                ]
            );
        }
    }
}
