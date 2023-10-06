<?php

declare(strict_types=1);

namespace JGI\ArbetsformedlingenAds\Model;

class Result
{
    /**
     * @var Error[]
     */
    private $errors = [];

    /**
     * @var Response[]
     */
    private $response;

    /**
     * @param Error[] $errors
     */
    public function __construct(iterable | null $errors = [], array | null $response = null)
    {
        if(!empty($errors))
        {
            $this->errors = $errors;
        }
        elseif(!empty($response))
        {
            $this->response = $response;
        }
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

    /**
     * @return Response[]
     */
    public function getResponse(): array
    {
        return $this->response;
    }
}
