<?php

declare(strict_types=1);

namespace JGI\ArbetsformedlingenAds\Event;

use JGI\ArbetsformedlingenAds\HRXMLDocument;
use JGI\ArbetsformedlingenAds\Model\Result;
use JGI\ArbetsformedlingenAds\Model\Transaction;
use Symfony\Contracts\EventDispatcher\Event;

class ResultEvent extends Event
{
    const NAME = 'arbetsformedlingen_ads.result';

    /**
     * @var Transaction
     */
    private $transaction;

    /**
     * @var Result
     */
    private $result;

    /**
     * @var HRXMLDocument
     */
    private $hrxmlDocument;

    /**
     * @var string
     */
    private $response;

    /**
     * @param Transaction $transaction
     * @param Result $result
     * @param HRXMLDocument $hrxmlDocument
     * @param string $response
     */
    public function __construct(Transaction $transaction, Result $result, HRXMLDocument $hrxmlDocument, string $response)
    {
        $this->transaction = $transaction;
        $this->result = $result;
        $this->hrxmlDocument = $hrxmlDocument;
        $this->response = $response;
    }

    /**
     * @return Transaction
     */
    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }

    /**
     * @return Result
     */
    public function getResult(): Result
    {
        return $this->result;
    }

    /**
     * @return HRXMLDocument
     */
    public function getHrxmlDocument(): HRXMLDocument
    {
        return $this->hrxmlDocument;
    }

    /**
     * @return string
     */
    public function getResponse(): string
    {
        return $this->response;
    }
}
