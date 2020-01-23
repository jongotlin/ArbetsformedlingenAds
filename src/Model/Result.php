<?php

declare(strict_types=1);

namespace JGI\ArbetsformedlingenAds\Model;

class Result
{
    /**
     * @var Error[]
     */
    private $errors;

    /**
     * @param Error[] $errors
     */
    public function __construct(iterable $errors = [])
    {
        $this->errors = $errors;
    }

    public function isSuccess(): bool
    {
        return count($this->errors) == 0;
    }

    /**
     * @return Error[]
     */
    public function getErrors(): iterable
    {
        return $this->errors;
    }


}
