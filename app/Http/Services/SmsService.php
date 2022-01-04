<?php

namespace App\Http\Services;

use App\Exceptions\ErrorException;
use App\Http\Infrastructure\AbstractClass\AbstractSmsService;
use App\Models\SecureTokenSms;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\Boolean;

class SmsService extends AbstractSmsService
{
    private $messageTemplate;
    private $smsGenerate = false;

    /**
     * @return bool
     */
    public function isSmsGenerate(): bool
    {
        return $this->smsGenerate;
    }

    /**
     * @param bool $smsGenerate
     */
    public function setSmsGenerate(bool $smsGenerate): void
    {
        $this->smsGenerate = $smsGenerate;
    }

    public function __construct($phoneNumber, $lineNumber, $token, $messageTemplate)
    {
        parent::__construct($phoneNumber, $lineNumber, $token);
        $this->messageTemplate = $messageTemplate;
    }

    /**
     * @return mixed
     */
    public function getMessageTemplate()
    {
        return $this->messageTemplate;
    }

    /**
     * @param mixed $messageTemplate
     */
    public function setMessageTemplate($messageTemplate): SmsService
    {
        $this->messageTemplate = $messageTemplate;
        return $this;
    }

    /**
     * @throws ErrorException
     */
    public function send()
    {
        if (!$this->sendApi() && !$this->isSmsGenerate()) {
            Artisan::command('sms:generate', function () {
                Log::alert('sms generated');
                $this->setSmsGenerate(true);
            });
        } else {
            throw new ErrorException('Sms Send Failed', ['status' => false]);
        }
    }

    private function sendApi(): Boolean
    {
        $response = Http::accept('application/json')
            ->withHeaders([
                'Content-Type' => 'application/json',
                'x-sms-ir-secure-token' => SecureTokenSms::first()->token,
            ])->post(config('sms.tokenRequestApi'), [
                'Messages' => config('sms.UserApiKey'),
                'LineNumber' => config('sms.LineAttachmentNumber'),
                'MobileNumbers' => $this->getPhoneNumber(),
            ])->json();

        return Arr::get($response, 'IsSuccessful');
    }
}
