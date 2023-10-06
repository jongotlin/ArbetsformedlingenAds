<?php

declare(strict_types=1);

namespace JGI\ArbetsformedlingenAds\Exception;

class InvalidResultException extends \RuntimeException
{
    public function __construct($message = 'Provided result data is invalid')
    {
        parent::__construct($message);
    }
}
