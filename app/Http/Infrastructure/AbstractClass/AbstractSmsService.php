<?php

namespace App\Http\Infrastructure\AbstractClass;

abstract class AbstractSmsService
{
    protected $phoneNumber;
    protected $lineNumber;
    protected $token;

    /**
     * @param $phoneNumber
     * @param $lineNumber
     * @param $token
     */
    public function __construct($phoneNumber, $lineNumber, $token)
    {
        $this->phoneNumber = $phoneNumber;
        $this->lineNumber = $lineNumber;
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return mixed
     */
    public function getLineNumber()
    {
        return $this->lineNumber;
    }

    /**
     * @param mixed $lineNumber
     */
    public function setLineNumber($lineNumber): void
    {
        $this->lineNumber = $lineNumber;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }

    abstract function send();

}
