<?php

namespace App\Services\Sms;

use App\Exceptions\ErrorException;
use App\Infrastructure\AbstractClass\AbstractSmsService;
use App\Models\SecureTokenSms;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use function config;


class SmsService extends AbstractSmsService
{
    private $messageTemplate;
    private $smsGenerate = false;

    public function __construct($phoneNumber, $lineNumber, $token, $messageTemplate)
    {
        parent::__construct($phoneNumber, $lineNumber, $token);
        $this->messageTemplate = $messageTemplate;
    }

    public static function build($phoneNumber, $messageTemplate): SmsService
    {
        return (new SmsService($phoneNumber, config('sms.LineAttachmentNumber'), SecureTokenSms::first()->token, $messageTemplate));
    }

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
        if (!($this->sendApi())) {
            throw new ErrorException('Sms Send Failed', ['status' => false]);
        }
    }

    private function sendApi()
    {
        $response = Http::accept('application/json')
            ->withHeaders([
                'Content-Type' => 'application/json',
                'x-sms-ir-secure-token' => $this->getToken(),
            ])->post(config('sms.sendSmsRequestApi'), [
                'Messages' => [$this->getMessageTemplate()],
                'LineNumber' => $this->getLineNumber(),
                'MobileNumbers' => [$this->getPhoneNumber()],
            ])->json();

        return Arr::get($response, 'IsSuccessful');
    }
}
