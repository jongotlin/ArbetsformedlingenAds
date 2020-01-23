<?php

declare(strict_types=1);

namespace JGI\ArbetsformedlingenAds\Model;

class Error
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var int|null
     */
    private $errorCode;

    /**
     * @param string $message
     * @param int|null $errorCode
     */
    public function __construct(string $message, ?int $errorCode = null)
    {
        $this->message = $message;
        $this->errorCode = $errorCode;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return int|null
     */
    public function getErrorCode(): ?int
    {
        return $this->errorCode;
    }
}
