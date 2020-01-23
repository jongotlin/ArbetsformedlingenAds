<?php

declare(strict_types=1);

namespace JGI\ArbetsformedlingenAds\Model;

class Transaction
{
    /**
     * @var string
     */
    private $senderId;

    /**
     * @var string
     */
    private $senderEmail;

    /**
     * @var \DateTimeInterface|null
     */
    private $transactionDate;

    /**
     * @var string|null
     */
    private $transactionId;

    /**
     * @var ArbetsformedlingenJob[]
     */
    private $arbetsformedlingenJobs;

    /**
     * @param string $senderId
     * @param string $senderEmail
     * @param string $transactionId
     * @param iterable $arbetsformedlingenJobs
     */
    public function __construct(
        string $senderId,
        string $senderEmail,
        string $transactionId,
        iterable $arbetsformedlingenJobs
    )
    {
        $this->senderId = $senderId;
        $this->senderEmail = $senderEmail;
        $this->transactionId = $transactionId;
        $this->transactionDate = new \DateTimeImmutable();
        $this->arbetsformedlingenJobs = $arbetsformedlingenJobs;
    }

    /**
     * @return string
     */
    public function getSenderId(): string
    {
        return $this->senderId;
    }

    /**
     * @return string
     */
    public function getSenderEmail(): string
    {
        return $this->senderEmail;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getTransactionDate(): ?\DateTimeImmutable
    {
        return $this->transactionDate;
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @return ArbetsformedlingenJob[]
     */
    public function getArbetsformedlingenJobs(): array
    {
        return $this->arbetsformedlingenJobs;
    }
}
